// Service Worker optimisé pour Digital Solution Pro
const CACHE_NAME = "dsp-cache-v4";
const STATIC_CACHE = "dsp-static-v4";
const DYNAMIC_CACHE = "dsp-dynamic-v4";
const CDN_CACHE = "dsp-cdn-v4";

// Ressources critiques à mettre en cache (toutes doivent exister)
const CRITICAL_ASSETS = [
    '/',
    '/offline.html',
    '/manifest.json',
    '/logo.jpg',
    '/js/pwa.js'
];

// CDN externes critiques pour le style
const CDN_ASSETS = [
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
    'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css'
];
// Installation
self.addEventListener('install', (event) => {
    console.log('🔧 Service Worker: Installation...');
    
    event.waitUntil(
        (async () => {
            try {
                const staticCache = await caches.open(STATIC_CACHE);
                const cdnCache = await caches.open(CDN_CACHE);

                // Précharger assets locaux sans échouer l'installation si l'un manque
                await Promise.allSettled(
                    CRITICAL_ASSETS.map(url => staticCache.add(url).catch(() => null))
                );

                // Précharger CDN sans bloquer l'installation
                await Promise.allSettled(
                    CDN_ASSETS.map(url => cdnCache.add(url).catch(() => null))
                );

                console.log('✅ Service Worker: Installation terminée');
                return self.skipWaiting();
            } catch (e) {
                console.warn('⚠️ Installation SW: certaines ressources n’ont pas été mises en cache:', e);
                return self.skipWaiting();
            }
        })()
    );
});

// Activation
self.addEventListener('activate', (event) => {
    console.log('🚀 Service Worker: Activation...');
    
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (![STATIC_CACHE, DYNAMIC_CACHE, CDN_CACHE].includes(cacheName)) {
                        console.log('🗑️ Suppression ancien cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => {
            console.log('✅ Service Worker: Activation terminée');
            return self.clients.claim();
        })
    );
});

// Stratégie de cache intelligente
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);
    
    // Stratégie pour les ressources CDN (Bootstrap, FontAwesome, etc.)
    if (isCDNRequest(request)) {
        event.respondWith(cacheFirstWithNetworkFallback(request));
    }
    // Stratégie pour les ressources statiques
    else if (isStaticAsset(request)) {
        event.respondWith(cacheFirst(request));
    }
    // Stratégie pour les pages HTML
    else if (isHTMLRequest(request)) {
        event.respondWith(networkFirstWithFallback(request));
    }
    // Stratégie pour les API
    else if (isAPIRequest(request)) {
        event.respondWith(networkFirst(request));
    }
    // Stratégie par défaut
    else {
        event.respondWith(staleWhileRevalidate(request));
    }
});

// Cache First avec fallback réseau - pour les ressources CDN
async function cacheFirstWithNetworkFallback(request) {
    try {
        // Essayer d'abord le cache
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        
        // Si pas en cache, essayer le réseau
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(CDN_CACHE);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        console.log('Réseau indisponible pour CDN, recherche dans le cache...');
        // En cas d'erreur réseau, retourner ce qui est en cache
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        
        // Si rien en cache, retourner une réponse d'erreur appropriée
        return new Response('Ressource CDN non disponible', { 
            status: 503,
            headers: { 'Content-Type': 'text/plain' }
        });
    }
}

// Cache First - pour les ressources statiques
async function cacheFirst(request) {
    try {
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(STATIC_CACHE);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        console.error('Erreur Cache First:', error);
        return new Response('Ressource non disponible', { status: 404 });
    }
}

// Network First avec fallback - pour les pages HTML
async function networkFirstWithFallback(request) {
    try {
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        console.log('Réseau indisponible, recherche dans le cache...');
        const cachedResponse = await caches.match(request);
        
        if (cachedResponse) {
            return cachedResponse;
        }
        
        // Fallback vers la page offline stylée
        return caches.match('/offline.html');
    }
}

// Network First - pour les API
async function networkFirst(request) {
    try {
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        const cachedResponse = await caches.match(request);
        return cachedResponse || new Response('API non disponible', { status: 503 });
    }
}

// Stale While Revalidate - pour les autres ressources
async function staleWhileRevalidate(request) {
    const cache = await caches.open(DYNAMIC_CACHE);
    const cachedResponse = await cache.match(request);
    
    const fetchPromise = fetch(request).then(networkResponse => {
        if (networkResponse.ok) {
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    }).catch(() => cachedResponse);
    
    return cachedResponse || fetchPromise;
}

// Fonctions utilitaires
function isCDNRequest(request) {
    const url = new URL(request.url);
    return url.hostname.includes('cdn.jsdelivr.net') || 
           url.hostname.includes('cdnjs.cloudflare.com') ||
           url.hostname.includes('fonts.googleapis.com') ||
           url.hostname.includes('fonts.gstatic.com');
}

function isStaticAsset(request) {
    const url = new URL(request.url);
    return url.pathname.match(/\.(css|js|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf|eot)$/);
}

function isHTMLRequest(request) {
    return request.headers.get('accept')?.includes('text/html');
}

function isAPIRequest(request) {
    const url = new URL(request.url);
    return url.pathname.startsWith('/api/') || url.pathname.startsWith('/ajax/');
}

// Gestion des messages
self.addEventListener('message', (event) => {
    if (event.data?.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
    
    if (event.data?.type === 'GET_VERSION') {
        event.ports[0].postMessage({ version: CACHE_NAME });
    }
});

console.log('📱 Service Worker optimisé chargé');