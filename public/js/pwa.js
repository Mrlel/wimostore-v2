// PWA Manager optimisé pour Digital Solution Pro
class PWAManager {
    constructor() {
        this.deferredPrompt = null;
        this.init();
    }

    init() {
        this.registerServiceWorker();
        this.setupInstallPrompt();
        this.setupUpdateNotification();
        this.setupConnectionStatus();
        this.preloadCriticalResources();
    }

    // Précharger les ressources critiques
    preloadCriticalResources() {
        if ('serviceWorker' in navigator && 'caches' in window) {
            // Précharger les ressources CDN critiques
            const criticalCDNResources = [
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
                'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css'
            ];

            criticalCDNResources.forEach(resource => {
                fetch(resource, { cache: 'force-cache' }).catch(() => {
                    console.log('Ressource CDN non disponible:', resource);
                });
            });
        }
    }

    // Enregistrement du Service Worker
    registerServiceWorker() {
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(registration => {
                        console.log('✅ PWA: Service Worker enregistré');
                        
                        // Vérifier les mises à jour
                        registration.addEventListener('updatefound', () => {
                            const newWorker = registration.installing;
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    this.showUpdateNotification();
                                }
                            });
                        });
                    })
                    .catch(error => {
                        console.error('❌ PWA: Erreur d\'enregistrement:', error);
                    });
            });
        }
    }

    setupInstallPrompt() {
        window.addEventListener('beforeinstallprompt', (e) => {
            console.log('✅ PWA: Installation disponible');
            e.preventDefault();
            this.deferredPrompt = e;
            this.showInstallButton();
        });

        window.addEventListener('appinstalled', () => {
            console.log('🎉 PWA: Installée avec succès');
            this.hideInstallButton();
        });
    }

    // Afficher le bouton d'installation
    showInstallButton() {
        if (document.getElementById('pwa-install-btn')) return;

        const installButton = document.createElement('button');
        installButton.id = 'pwa-install-btn';
        installButton.innerHTML = `
            <i class="fas fa-download"></i>
            <span>Installer l'app</span>
        `;
        installButton.className = 'pwa-install-button';
        
        // Styles optimisés
        Object.assign(installButton.style, {
            position: 'fixed',
            bottom: '20px',
            right: '20px',
            background: '#ffde59',
            color: '#000',
            border: 'none',
            padding: '12px 20px',
            borderRadius: '25px',
            fontSize: '14px',
            fontWeight: '600',
            cursor: 'pointer',
            boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
            zIndex: '1000',
            transition: 'all 0.3s ease',
            display: 'flex',
            alignItems: 'center',
            gap: '8px'
        });

        installButton.addEventListener('click', async () => {
            if (this.deferredPrompt) {
                this.deferredPrompt.prompt();
                const { outcome } = await this.deferredPrompt.userChoice;
                console.log(`Résultat installation: ${outcome}`);
                this.deferredPrompt = null;
                this.hideInstallButton();
            }
        });

        // Effets hover
        installButton.addEventListener('mouseenter', () => {
            installButton.style.transform = 'translateY(-2px)';
            installButton.style.boxShadow = '0 6px 16px rgba(0,0,0,0.2)';
        });

        installButton.addEventListener('mouseleave', () => {
            installButton.style.transform = 'translateY(0)';
            installButton.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        });

        document.body.appendChild(installButton);
    }

    // Masquer le bouton d'installation
    hideInstallButton() {
        const installButton = document.getElementById('pwa-install-btn');
        if (installButton) {
            installButton.remove();
        }
    }

    // Notification de mise à jour
    setupUpdateNotification() {
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.addEventListener('controllerchange', () => {
                window.location.reload();
            });
        }
    }

    // Afficher notification de mise à jour
    showUpdateNotification() {
        if (document.getElementById('pwa-update-notification')) return;

        const notification = document.createElement('div');
        notification.id = 'pwa-update-notification';
        notification.innerHTML = `
            <div class="update-content">
                <i class="fas fa-sync-alt"></i>
                <span>Nouvelle version disponible</span>
                <button onclick="this.parentElement.parentElement.remove()">×</button>
            </div>
        `;
        
        Object.assign(notification.style, {
            position: 'fixed',
            top: '20px',
            left: '50%',
            transform: 'translateX(-50%)',
            background: '#28a745',
            color: 'white',
            padding: '12px 20px',
            borderRadius: '8px',
            boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
            zIndex: '1001',
            display: 'flex',
            alignItems: 'center',
            gap: '10px',
            fontSize: '14px',
            fontWeight: '500'
        });

        document.body.appendChild(notification);

        // Auto-suppression après 5 secondes
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    // Gestion du statut de connexion
    setupConnectionStatus() {
        if (!navigator.onLine) {
            this.showOfflineIndicator();
        }

        window.addEventListener('online', () => {
            this.hideOfflineIndicator();
            console.log('🌐 PWA: Connexion rétablie');
        });

        window.addEventListener('offline', () => {
            this.showOfflineIndicator();
            console.log('📱 PWA: Connexion perdue');
        });
    }

    // Afficher indicateur hors ligne
    showOfflineIndicator() {
        if (document.getElementById('offline-indicator')) return;

        const indicator = document.createElement('div');
        indicator.id = 'offline-indicator';
        indicator.innerHTML = `
            <i class="fas fa-wifi"></i>
            <span>Hors ligne</span>
        `;
        
        Object.assign(indicator.style, {
            position: 'fixed',
            top: '0',
            left: '0',
            right: '0',
            background: '#dc3545',
            color: 'white',
            textAlign: 'center',
            padding: '8px',
            fontSize: '14px',
            zIndex: '1002',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            gap: '8px'
        });
        
        document.body.appendChild(indicator);
    }

    // Masquer indicateur hors ligne
    hideOfflineIndicator() {
        const indicator = document.getElementById('offline-indicator');
        if (indicator) {
            indicator.remove();
        }
    }
}

// Initialiser PWA Manager
document.addEventListener('DOMContentLoaded', () => {
    const pwaManager = new PWAManager();
});

// Exporter pour utilisation globale
window.PWAManager = PWAManager;