// ═══════════════════════════════════════════════════════════
//  WimoStock Service Worker
// ═══════════════════════════════════════════════════════════
const CACHE_VERSION = 'v6';
const STATIC_CACHE  = `wimostock-static-${CACHE_VERSION}`;
const DYNAMIC_CACHE = `wimostock-dynamic-${CACHE_VERSION}`;
const CDN_CACHE     = `wimostock-cdn-${CACHE_VERSION}`;

// Fichiers mis en cache à l'installation
const STATIC_ASSETS = [
    '/offline.html',
    '/manifest.json',
    '/icons/wimo-192x192.png',
    '/icons/wimo-512x512.png',
    '/wim.png'
];

const CDN_ASSETS = [
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
    'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'
];

// ── Install ──────────────────────────────────────────────────────────────────
self.addEventListener('install', event => {
    event.waitUntil((async () => {
        const [staticCache, cdnCache] = await Promise.all([
            caches.open(STATIC_CACHE),
            caches.open(CDN_CACHE)
        ]);
        await Promise.allSettled(STATIC_ASSETS.map(url => staticCache.add(url).catch(() => {})));
        await Promise.allSettled(CDN_ASSETS.map(url => cdnCache.add(url).catch(() => {})));
        return self.skipWaiting();
    })());
});

// ── Activate ─────────────────────────────────────────────────────────────────
self.addEventListener('activate', event => {
    const VALID_CACHES = [STATIC_CACHE, DYNAMIC_CACHE, CDN_CACHE];
    event.waitUntil(
        caches.keys()
            .then(keys => Promise.all(
                keys.filter(k => !VALID_CACHES.includes(k)).map(k => caches.delete(k))
            ))
            .then(() => self.clients.claim())
    );
});

// ── Fetch ─────────────────────────────────────────────────────────────────────
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    // Ignorer les non-GET, chrome-extension, et requêtes avec credentials complexes
    if (request.method !== 'GET') return;
    if (url.protocol === 'chrome-extension:') return;
    if (url.pathname.includes('_debugbar')) return;

    // 1. Images de la BDD (storage Laravel) → network-first avec fallback cache
    if (isStorageImage(url)) {
        return event.respondWith(networkFirstImage(request));
    }

    // 2. Ressources CDN → cache-first
    if (isCDN(url)) {
        return event.respondWith(cacheFirst(request, CDN_CACHE));
    }

    // 3. Assets statiques locaux (css, js, fonts, icônes) → cache-first
    if (isStaticAsset(url)) {
        return event.respondWith(cacheFirst(request, STATIC_CACHE));
    }

    // 4. Pages HTML → network-first avec fallback offline
    if (isHTML(request)) {
        return event.respondWith(networkFirstHTML(request));
    }

    // 5. Tout le reste → stale-while-revalidate
    event.respondWith(staleWhileRevalidate(request));
});

// ── Stratégies de cache ───────────────────────────────────────────────────────

/**
 * Network-first pour les images /storage/
 * Toujours essayer le réseau, mettre en cache si succès.
 * Si hors ligne → retourner le cache, sinon placeholder SVG.
 */
async function networkFirstImage(request) {
    const cache = await caches.open(DYNAMIC_CACHE);
    try {
        const response = await fetch(request, { credentials: 'same-origin' });
        if (response.ok) {
            const ct = response.headers.get('content-type') || '';
            if (ct.startsWith('image/')) {
                cache.put(request, response.clone());
            }
        }
        return response;
    } catch {
        const cached = await cache.match(request);
        if (cached) return cached;
        // Placeholder SVG gris neutre
        return new Response(
            `<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100">
                <rect width="100" height="100" fill="#1e1e1e"/>
                <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle"
                      font-family="sans-serif" font-size="28" fill="#555">📦</text>
             </svg>`,
            { headers: { 'Content-Type': 'image/svg+xml', 'Cache-Control': 'no-store' } }
        );
    }
}

/**
 * Cache-first : retourne le cache immédiatement,
 * sinon fetch + mise en cache.
 */
async function cacheFirst(request, cacheName) {
    const cached = await caches.match(request);
    if (cached) return cached;
    try {
        const response = await fetch(request);
        if (response.ok) (await caches.open(cacheName)).put(request, response.clone());
        return response;
    } catch {
        return new Response('Ressource non disponible', { status: 503 });
    }
}

/**
 * Network-first pour les pages HTML.
 * Si hors ligne → cache → page offline.
 */
async function networkFirstHTML(request) {
    try {
        const response = await fetch(request);
        if (response.ok) (await caches.open(DYNAMIC_CACHE)).put(request, response.clone());
        return response;
    } catch {
        const cached = await caches.match(request);
        return cached || caches.match('/offline.html');
    }
}

/**
 * Stale-while-revalidate : retourne le cache immédiatement
 * et met à jour en arrière-plan.
 */
async function staleWhileRevalidate(request) {
    const cache  = await caches.open(DYNAMIC_CACHE);
    const cached = await cache.match(request);
    const fresh  = fetch(request)
        .then(r => { if (r.ok) cache.put(request, r.clone()); return r; })
        .catch(() => null);
    return cached || fresh;
}

// ── Helpers ───────────────────────────────────────────────────────────────────

/** Images uploadées via Laravel Storage */
const isStorageImage = url =>
    url.pathname.startsWith('/storage/') &&
    /\.(png|jpe?g|gif|svg|webp|avif|bmp)$/i.test(url.pathname);

/** Ressources CDN externes */
const isCDN = url =>
    ['cdn.jsdelivr.net', 'cdnjs.cloudflare.com', 'fonts.googleapis.com', 'fonts.gstatic.com']
    .some(h => url.hostname.includes(h));

/** Assets statiques locaux — exclut /storage/ (géré séparément) */
const isStaticAsset = url =>
    !url.pathname.startsWith('/storage/') &&
    /\.(css|js|png|jpe?g|gif|svg|ico|woff2?|ttf|eot|webp|avif)$/i.test(url.pathname);

/** Requêtes HTML */
const isHTML = req => (req.headers.get('accept') || '').includes('text/html');

// ── Messages ──────────────────────────────────────────────────────────────────
self.addEventListener('message', event => {
    if (event.data?.type === 'SKIP_WAITING') self.skipWaiting();
});
