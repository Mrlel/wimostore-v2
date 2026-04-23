<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Gestion Stock</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #ffde59;
            --secondary: #000;
            --white: #FFF;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
            --notification-width: 380px;
            --notification-height: 50px;
            --animation-duration: 0.4s;
        }

        /* Notification Container */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1060;
            display: flex;
            flex-direction: column;
            gap: 12px;
            pointer-events: none;
        }

        /* Status Message */
        .status-message {
    display: flex;
    align-items: center;
    width: var(--notification-width);
    min-height: var(--notification-height);
    backdrop-filter: blur(12px) saturate(150%);
    -webkit-backdrop-filter: blur(12px) saturate(150%);
    background: rgb(40, 40, 40);
    color: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    transform: translateX(100%);
    opacity: 0;
    transition: all var(--animation-duration) cubic-bezier(0.68, -0.55, 0.27, 1.55);
    pointer-events: auto;
}


        .status-message.show-message {
            transform: translateX(0);
            opacity: 1;
        }

        .status-message.hide-message {
            transform: translateX(100%);
            opacity: 0;
        }

        /* Icon Container */
        .status-message .icon-container {
            flex-shrink: 0;
            width: 60px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 16px;
        }

        .status-message .success-icon {
            color: var(--success);
            font-size: 24px;
        }

        .status-message .info-icon {
            
            color: var(--info);
            font-size: 24px;
        }

        .status-message .error-icon {
            color: var(--danger);
            font-size: 24px;
        }

        .status-message .warning-icon {
            color: var(--warning);
            font-size: 24px;
        }

        /* Content */
        .status-message .content {
            flex: 1;
            padding: 16px 20px 16px 0;
            min-height: var(--notification-height);
            display: flex;
            align-items: center;
        }

        .status-message .content p {
            margin: 0;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.5;
            color:rgb(247, 247, 247);
        }

        /* Close Button */
        .status-message .close-btn {
            padding: 0 16px;
        }

        .status-message .close-btn button {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status-message .close-btn button:hover {
            background-color: rgba(0, 0, 0, 0.05);
            color: var(--secondary);
        }

        /* Progress Bar */
        .status-message .progress-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: currentColor;
            opacity: 0.3;
            width: 100%;
            transform-origin: left;
        }

        .status-message .progress-bar.animated {
            animation: progressBar 5s linear forwards;
        }

        /* SVG Icons */
        .status-message svg {
            width: 20px;
            height: 20px;
        }

        /* Animations */
        @keyframes progressBar {
            from { transform: scaleX(1); }
            to { transform: scaleX(0); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .status-message.error.show-message {
            animation: shake 0.5s ease-in-out;
        }

        /* Swipe to dismiss */
        .status-message.swipe-left {
            transform: translateX(-100%);
            opacity: 0;
        }

        .status-message.swipe-right {
            transform: translateX(100%);
            opacity: 0;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .notification-container {
                top: 10px;
                right: 10px;
                left: 10px;
                align-items: center;
            }
            
            .status-message {
                width: 95%;
                max-width: 300px;
            }
        }

        /* Hidden utility */
        .hidden {
            display: none !important;
        }
    </style>
</head>
<body>
    <div class="notification-container" aria-live="polite" aria-atomic="true">
        <!-- Messages de session -->
        @if(session('success'))
            <div id="successNotification" class="status-message success" role="alert" aria-describedby="success-message">
                <div class="icon-container success-icon" aria-hidden="true">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="content">
                    <p id="success-message">{{ session('success') }}</p>
                </div>
                <div class="close-btn">
                    <button type="button" onclick="dismissMessage('successNotification')" aria-label="Fermer la notification">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="progress-bar animated"></div>
            </div>
        @endif
        
        @if(session('error'))
            <div id="errorNotification" class="status-message error" role="alert" aria-describedby="error-message">
                <div class="icon-container error-icon" aria-hidden="true">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>
                <div class="content">
                    <p id="error-message">{{ session('error') }}</p>
                </div>
                <div class="close-btn">
                    <button type="button" onclick="dismissMessage('errorNotification')" aria-label="Fermer la notification">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="progress-bar animated"></div>
            </div>
        @endif
        
        @if(session('warning'))
            <div id="warningNotification" class="status-message warning" role="alert" aria-describedby="warning-message">
                <div class="icon-container warning-icon" aria-hidden="true">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div class="content">
                    <p id="warning-message">{{ session('warning') }}</p>
                </div>
                <div class="close-btn">
                    <button type="button" onclick="dismissMessage('warningNotification')" aria-label="Fermer la notification">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="progress-bar animated"></div>
            </div>
        @endif
        
        @if(session('info'))
            <div id="infoNotification" class="status-message info" role="alert" aria-describedby="info-message">
                <div class="icon-container info-icon" aria-hidden="true">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
                <div class="content">
                    <p id="info-message">{{ session('info') }}</p>
                </div>
                <div class="close-btn">
                    <button type="button" onclick="dismissMessage('infoNotification')" aria-label="Fermer la notification">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="progress-bar animated"></div>
            </div>
        @endif
        
        <!-- Messages d'erreur de validation -->
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div id="validationError-{{ $loop->index }}" class="status-message error" role="alert" aria-describedby="validation-error-{{ $loop->index }}">
                    <div class="icon-container error-icon" aria-hidden="true">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <div class="content">
                        <p id="validation-error-{{ $loop->index }}">{{ $error }}</p>
                    </div>
                    <div class="close-btn">
                        <button type="button" onclick="dismissMessage('validationError-{{ $loop->index }}')" aria-label="Fermer la notification">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <div class="progress-bar animated"></div>
                </div>
            @endforeach
        @endif
    </div>

    <script>
        // Gestionnaire de file d'attente de notifications
        const notificationQueue = {
            queue: [],
            isProcessing: false,
            
            add: function(notification) {
                this.queue.push(notification);
                if (!this.isProcessing) {
                    this.process();
                }
            },
            
            process: function() {
                if (this.queue.length === 0) {
                    this.isProcessing = false;
                    return;
                }
                
                this.isProcessing = true;
                const notification = this.queue.shift();
                
                // Afficher la notification
                notification.show();
                
                // Traiter la suivante après un délai
                setTimeout(() => {
                    this.process();
                }, 600); // Délai entre les notifications
            }
        };

        // Classe de notification
        class Notification {
            constructor(type, message, duration = 5000) {
                this.id = 'notification-' + Date.now() + '-' + Math.floor(Math.random() * 1000);
                this.type = type;
                this.message = message;
                this.duration = duration;
                this.element = null;
                this.timer = null;
                this.startX = 0;
                this.currentX = 0;
            }
            
            createElement() {
                const messageTypes = {
                    'success': {
                        icon: 'bi-check-circle-fill',
                        iconClass: 'success-icon',
                        messageClass: 'success'
                    },
                    'error': {
                        icon: 'bi-exclamation-circle-fill',
                        iconClass: 'error-icon',
                        messageClass: 'error'
                    },
                    'warning': {
                        icon: 'bi-exclamation-triangle-fill',
                        iconClass: 'warning-icon',
                        messageClass: 'warning'
                    },
                    'info': {
                        icon: 'bi-info-circle-fill',
                        iconClass: 'info-icon',
                        messageClass: 'info'
                    }
                };

                const config = messageTypes[this.type] || messageTypes.info;
                
                return `
                    <div id="${this.id}" class="status-message ${config.messageClass}" role="alert" aria-describedby="${this.id}-message">
                        <div class="icon-container ${config.iconClass}" aria-hidden="true">
                            <i class="bi ${config.icon}"></i>
                        </div>
                        <div class="content">
                            <p id="${this.id}-message">${this.message}</p>
                        </div>
                        <div class="close-btn">
                            <button type="button" aria-label="Fermer la notification">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <div class="progress-bar ${this.duration > 0 ? 'animated' : ''}"></div>
                    </div>
                `;
            }
            
            show() {
                const container = document.querySelector('.notification-container');
                if (!container) return;
                
                container.insertAdjacentHTML('beforeend', this.createElement());
                this.element = document.getElementById(this.id);
                
                if (!this.element) return;
                
                // Configurer le bouton de fermeture
                const closeBtn = this.element.querySelector('.close-btn button');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => this.dismiss());
                }
                
                // Ajouter la prise en charge du balayage tactile
                this.setupSwipe();
                
                // Afficher avec animation
                setTimeout(() => {
                    this.element.classList.add('show-message');
                }, 100);
                
                // Démarrer le minuteur de disparition automatique
                if (this.duration > 0) {
                    this.timer = setTimeout(() => {
                        this.dismiss();
                    }, this.duration);
                }
            }
            
            setupSwipe() {
                if (!this.element) return;
                
                let startX = 0;
                let currentX = 0;
                
                const onTouchStart = (e) => {
                    startX = e.touches[0].clientX;
                    this.element.style.transition = 'none';
                    
                    // Annimer le timer de disparition
                    if (this.timer) {
                        clearTimeout(this.timer);
                        this.timer = null;
                    }
                };
                
                const onTouchMove = (e) => {
                    if (!startX) return;
                    
                    currentX = e.touches[0].clientX;
                    const diffX = currentX - startX;
                    
                    // Limiter le déplacement à 100px
                    if (Math.abs(diffX) > 100) return;
                    
                    this.element.style.transform = `translateX(${diffX}px)`;
                    this.element.style.opacity = `${1 - Math.abs(diffX) / 200}`;
                };
                
                const onTouchEnd = () => {
                    this.element.style.transition = `all var(--animation-duration) cubic-bezier(0.68, -0.55, 0.27, 1.55)`;
                    
                    const diffX = currentX - startX;
                    
                    if (Math.abs(diffX) > 50) {
                        // Balayage réussi - masquer la notification
                        this.element.classList.add(diffX > 0 ? 'swipe-right' : 'swipe-left');
                        
                        setTimeout(() => {
                            this.remove();
                        }, 300);
                    } else {
                        // Balayage annulé - revenir à la position initiale
                        this.element.style.transform = '';
                        this.element.style.opacity = '';
                        
                        // Redémarrer le minuteur de disparition
                        if (this.duration > 0) {
                            this.timer = setTimeout(() => {
                                this.dismiss();
                            }, this.duration);
                        }
                    }
                    
                    startX = 0;
                    currentX = 0;
                };
                
                this.element.addEventListener('touchstart', onTouchStart, { passive: true });
                this.element.addEventListener('touchmove', onTouchMove, { passive: true });
                this.element.addEventListener('touchend', onTouchEnd, { passive: true });
            }
            
            dismiss() {
                if (!this.element) return;
                
                if (this.timer) {
                    clearTimeout(this.timer);
                    this.timer = null;
                }
                
                this.element.classList.remove('show-message');
                this.element.classList.add('hide-message');
                
                // Supprimer après l'animation
                setTimeout(() => {
                    this.remove();
                }, 400);
            }
            
            remove() {
                if (this.element && this.element.parentNode) {
                    this.element.parentNode.removeChild(this.element);
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const statusMessages = document.querySelectorAll('.status-message');
            
            statusMessages.forEach((message, index) => {
                if (message) {
                    // Délai d'affichage progressif
                    setTimeout(() => {
                        message.classList.add('show-message');
                    }, 100 + (index * 150));
                    
                    // Configurer le bouton de fermeture
                    const closeBtn = message.querySelector('.close-btn button');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', () => {
                            dismissMessage(message.id);
                        });
                    }
                    
                    // Masquer automatiquement après 5 secondes
                    const progressBar = message.querySelector('.progress-bar.animated');
                    if (progressBar) {
                        setTimeout(() => {
                            if (message.classList.contains('show-message')) {
                                dismissMessage(message.id);
                            }
                        }, 5000);
                    }
                }
            });
        });
        
        // Fonction pour fermer le message
        function dismissMessage(messageId) {
            const message = document.getElementById(messageId);
            if (message) {
                message.classList.remove('show-message');
                message.classList.add('hide-message');
                
                // Supprimer après l'animation
                setTimeout(() => {
                    if (message.parentNode) {
                        message.parentNode.removeChild(message);
                    }
                }, 400);
            }
        }

        // Fonction globale pour afficher des messages personnalisés
        window.showNotification = function(type, message, duration = 5000) {
            const notification = new Notification(type, message, duration);
            notificationQueue.add(notification);
        }

        // Exposer la fonction globalement
        window.dismissMessage = dismissMessage;

        // Exemples d'utilisation :
        // showNotification('success', 'Opération réussie!', 3000);
        // showNotification('error', 'Une erreur est survenue', 5000);
        // showNotification('warning', 'Attention: stock faible', 4000);
        // showNotification('info', 'Mise à jour disponible', 3000);
    </script>
</body>
</html>