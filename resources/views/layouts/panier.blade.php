<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    
    <!-- PWA Meta Tags (minimal) -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#fff">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="DSP Cabine">
    
    <!-- Icons -->
    <link rel="apple-touch-icon" href="/wim.png">
    <link rel="shortcut icon" href="/wim.png" type="image/x-icon">
    
    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* VOS STYLES ORIGINAUX RESTAURÉS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
      
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color:#fff;
            line-height: 1.5;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 500px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: transform .3s ease;
            z-index: 1000;
            border-right: 1px solid #0000;
            background-color: #ffde59
        }

        .brand-logo {
            font-size: 24px;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

        }

        .brand-logo i {
            font-size: 28px;
            color: #fbc926;
        }

        .nav-menu {
            list-style: none;
            padding: 12px 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 8px 24px;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .nav-link i {
            margin-right: 20px;
            font-size: 20px;
            width: 20px;
            text-align: center;
            color: #f8c80aff;
        }

        /* Logout form styling */
        .logout-section {
            padding: 20px 25px 0;
        
            margin-top: 10px;
        }

        .logout-form {
            width: 100%;
        }

        .logout-btn {
            width: 100%;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 6px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .logout-btn i {
            margin-right: 12px;
            font-size: 16px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 500px;
            transition: margin-left 0.3s ease;
        }

        /* Header */
        .header {
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgba(245, 244, 244, 0.27);
            padding: 0 20px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 400;
            color: #495057;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-btn:hover {
            background: #f8f9fa;
            border-color: #adb5bd;
        }

        /* Content */
        .content {
            padding: 30px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            padding: 24px;
            transition: all 0.2s ease;
            border-radius:3px
        }

        .stat-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-info h3 {
            color:#FFF;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 25px;
            font-weight: bolder;
            color: #FFF;
            margin-bottom: 12px;
        }

        .stat-footer {
            color: #fff;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stat-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 74px;
            color: #ffffffa9;
            opacity: 1;
        }

        /* Chart Section */
        .chart-section {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 30px;
            overflow-x: auto;
        }

        .chart-header {
            margin-bottom: 24px;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 500;
            color: #495057;
            margin-bottom: 4px;
        }

        .chart-subtitle {
            color: #6c757d;
            font-size: 14px;
        }

        .chart-container {
            height: 300px;
            position: relative;
            margin-bottom: 20px;
            min-width: 500px;
        }

        /* SVG Chart */
        .area-chart {
            width: 100%;
            height: 100%;
        }

        .chart-area-1 { fill: #ff6b6b; fill-opacity: 0.8; }
        .chart-area-2 { fill: #ffd93d; fill-opacity: 0.8; }
        .chart-area-3 { fill: #6bcf7f; fill-opacity: 0.8; }

        .chart-grid {
            stroke: #e9ecef;
            stroke-width: 1;
        }

        .chart-axis {
            stroke: #dee2e6;
            stroke-width: 1;
        }

        .chart-labels {
            fill: #adb5bd;
            font-size: 12px;
            font-family: inherit;
        }

        .chart-legend {
            display: flex;
            gap: 24px;
            margin-top: 16px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #6c757d;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .legend-dot.open { background: #6bcf7f; }
        .legend-dot.click { background: #ff6b6b; }
        .legend-dot.click-second { background: #ffd93d; }

        .mobile-toggle {
            display: none;
            position: fixed;
            bottom: 75px;
            right: 15px;
            z-index: 1001;
            border: 2px solid  #ffd93d;
            border-radius: 50%;
            padding: 8px 12px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .main-title{
            font-weight: bolder;
            color:#fff;
            padding : 0 1rem;
            font-size: 2rem;
            font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }
        
        .up{
            text-align:center;
            margin: 1rem 15px;
            background-color:rgb(0, 0, 0);
            font-size:1rem;
            font-weight:bold;
            color:#fff;
            padding: 5px;
            border-radius : 8px ;
        }
        
        
        /* Overlay pour mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        
        /* Responsive Styles */
        @media (max-width: 1200px) {
            .main-title {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.open {
                transform: translateX(0);
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .mobile-toggle {
                display: block;
            }
            
            .sidebar-overlay.active {
                display: block;
            }
            
            .header {
                padding: 0 15px;
            }
            
            .header h1 {
                font-size: 20px;
            }
            
            .header-actions {
                gap: 15px;
            }
            
            .content {
                padding: 20px;
            }
        }
        
        @media (max-width: 900px) {
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
            
            .stat-content {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .stat-icon {
                margin-top: 15px;
                align-self: flex-end;
                width: 60px;
                height: 60px;
                font-size: 50px;
            }
            
            .main-title {
                font-size: 2rem;
            }
        }
        
        .mobile-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #111;
            padding: 4px 0;
            display: none;
            z-index: 1000;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            border-top: 1px solid #e9ecef;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 2rem 2rem 0 0;    
        }

        .mobile-nav .nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            font-size: 0.5rem;
            padding: 1px 5px;
            transition: all 0.2s ease;
            position: relative;
            flex: 1;
            background: transparent;
            border: none;
            border-radius: 8px;
            margin: 0 2px;
        }

        .mobile-nav .nav-link i {
            font-size: 1.4rem;
            margin: 0 0 4px 0;
            transition: all 0.2s ease;
            color: #fff;
        }

        .mobile-nav .nav-link.active {
            color: #fbc926;;
            font-weight: 600;
        }

        .mobile-nav .nav-link.active i {
            color: #fbc926;
            transform: translateY(-3px);
        }

        .mobile-nav .nav-link:active {
            transform: scale(0.95);
        }

        .mobile-nav .nav-link:hover {
            transform: translateY(-3px);
        }

        .mobile-nav .nav-link span {
            display: block;
            font-size: 0.6rem;
            margin-top: 2px;
        }

        /* Animation pour l'icône active */
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .mobile-nav .nav-link.active i {
            animation: bounce 0.5s ease-in-out;
        }
        
        @media (max-width: 768px) {
            .mobile-nav {
                display: flex;
                justify-content: space-around;
                align-items: center;
            }
            
            /* Ajoute un padding en bas du contenu principal pour éviter que la navigation ne le cache */
            .main-content {
                padding-bottom: 70px;
            }
            .sidebar .nav-link{
                font-size: 12px
            }
          
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .header-actions .header-btn span {
                display: none;
            }
            
            .header-btn {
                padding: 8px 12px;
            }
            
            .content {
                padding: 15px;
            }
            
            .chart-section {
                padding: 15px;
            }
            
            .chart-container {
                height: 250px;
            }
            
            .main-title {
                font-size: 1.5rem;
            }
            
            .header h1 img {
                height: 40px;
            }
            
            .stat-card {
                padding: 20px;
            }
            
            .stat-value {
                font-size: 28px;
            }
        }
        
        @media (max-width: 576px) {
            .header .nom_cab{
                display: none;
            }
            .header {
                justify-content: space-between;
                height: auto;
                padding: 5px;
            }
            
            .header h1 {
                margin-bottom: 10px;
                text-align: center;
            }
            
            .header-actions {
                width: 100%;
                justify-content: end;
            }
            
            .chart-legend {
                flex-direction: column;
                gap: 10px;
            }
            
            .main-title {
                font-size: 1.2rem;
                padding: 0 0.5rem;
            }
            
            .up {
                font-size: 0.9rem;
                border-width: 0.5rem;
                border-radius :  3rem;
            }
            
            .nav-link {
                padding: 12px 20px;
            }
            
            .logout-btn {
                padding: 15px 20px;
            }
        }
        
        @media (max-width: 400px) {
            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 40px;
            }
             
            .stat-value {
                font-size: 24px;
            }
            
            .main-title {
                font-size: 1rem;
            }
            
            .header h1 span {
                display: block;
                text-align: center;
                margin-top: 5px;
            }
        }

/* ============================
   TYPOGRAPHIE GLOBALE
   ============================ */

/* Titres desktop */
h1, .h1 { font-size: 1.75rem; font-weight: 700; }
h2, .h2 { font-size: 1.5rem; font-weight: 600; }
h3, .h3 { font-size: 1.35rem; font-weight: 600; }
h4, .h4 { font-size: 1.15rem; font-weight: 500; }
h5, .h5 { font-size: 1rem; font-weight: 500; }
h6, .h6 { font-size: 0.95rem; font-weight: 500; }

/* Textes de base */
body, p, .form-control-plaintext, .btn, .breadcrumb, .badge, small {
    font-size: 0.95rem;
    line-height: 1.5;
}

/* ============================
   ICONES GLOBALES
   ============================ */
.bi, .fa, .fas, .far, .fal, .fab {
    font-size: 1.1em;
    vertical-align: middle;
}

/* ============================
   RESPONSIVE TEXT & ICONS
   ============================ */

/* Tablettes (< 992px) */
@media (max-width: 992px) {
    h1, .h1 { font-size: 1.6rem; }
    h2, .h2 { font-size: 1.35rem; }
    h3, .h3 { font-size: 1.2rem; }
    h4, .h4 { font-size: 1.05rem; }
    body, p, .btn, small { font-size: 0.9rem; }

    .bi, .fa, .fas, .far, .fal, .fab {
        font-size: 1em;
    }
}

/* Mobiles (< 768px) */
@media (max-width: 768px) {
    h1, .h1 { font-size: 1.4rem; }
    h2, .h2 { font-size: 1.2rem; }
    h3, .h3 { font-size: 1.1rem; }
    h4, .h4 { font-size: 1rem; }
    body, p, .btn, small { font-size: 0.87rem; }
    .fw-bold { font-weight: 600; }

    .bi, .fa, .fas, .far, .fal, .fab {
        font-size: 0.95em;
    }
}

/* Petits mobiles (< 576px) */
@media (max-width: 576px) {
    h1, .h1 { font-size: 1.25rem; }
    h2, .h2 { font-size: 1.1rem; }
    h3, .h3 { font-size: 1rem; }
    body, p, .btn, small { font-size: 0.82rem; }

    .bi, .fa, .fas, .far, .fal, .fab {
        font-size: 0.9em;
    }
}

    .notification-count {
        position: absolute;
        top: -6px;
        right: -6px;
        background:rgb(197, 23, 0);
        color: white;
        font-size: 10px;
        font-weight: bold;
        border-radius: 50%;
        padding: 2px 5px;
        min-width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 3px rgba(0,0,0,0.3);
        transform-origin: center;
    }

    /* Animation de rebond */
    @keyframes bounce {
        0%, 100% {
            transform: scale(1);
        }
        30% {
            transform: scale(1.3);
        }
        50% {
            transform: scale(0.9);
        }
        70% {
            transform: scale(1.1);
        }
    }

    .animate-bounce {
        animation: bounce 1.2s ease-in-out infinite;
    }
    
    .header-btn {
        text-decoration: none;
        color: inherit;
    }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Mobile Toggle -->
        <button class="mobile-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Overlay pour mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">

          <div class="card-header  py-3">
                    <h5 class="mb-2 text-dark fw-bold">
                        <i class="bi bi-cart me-2" style="color: #fbc926;"></i>
                        Panier de Vente
                    </h5>
                </div>
           <!-- Tableau du panier -->
            <div class="card mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="border-dark">Produit</th>
                                    <th class="border-dark">Quantité</th>
                                    <th class="border-dark">Prix unitaire</th>
                                    <th class="border-dark">Total</th>
                                    <th class="border-dark">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="produits-list" class="bg-white">
                                <!-- Les produits seront ajoutés ici dynamiquement -->
                            </tbody>
                            <tfoot class="table-dark">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold border-dark">Total</td>
                                    <td class="fw-bold border-dark" id="total-vente">0 FCFA</td>
                                    <td class="border-dark"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
    </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Content -->
            <div class="content">
                @include('layouts.message')
                @yield('content')
            </div>
        </main>
    </div>
        <!-- Navigation mobile -->
        <div class="mobile-nav">
            <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-check"></i>
                <span>Accueil</span>
            </a>
            <a href="/produits" class="nav-link {{ request()->is('produits*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                <span>Produits</span>
            </a>
            <a href="/Ma_boutique" class="nav-link {{ request()->is('Ma_boutique*') ? 'active' : '' }}">
                <i class="bi bi-shop"></i>
                <span>Ma boutique</span>
            </a>
            <a href="/ventes" class="nav-link {{ request()->is('ventes*') ? 'active' : '' }}">
                <i class="bi bi-cart-check"></i>
                <span>Ventes</span>
            </a>
            <a href="/inventaire" class="nav-link {{ request()->is('inventaire*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check"></i>
                <span>Inventaire</span>
            </a>
        </div>
    <!-- Scripts à la fin du body -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    <!-- Vos scripts existants -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }
        
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (window.innerWidth <= 1024 && 
                !sidebar.contains(e.target) && 
                !toggle.contains(e.target) && 
                sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            }
        });

        // Optional: Add loading states for navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                // Optionnel: ajouter un indicateur de chargement
                this.style.opacity = '0.7';
                
                // Fermer la sidebar sur mobile après un clic
                if (window.innerWidth <= 1024) {
                    closeSidebar();
                }
            });
        });
        
        // Ajuster le layout au redimensionnement de la fenêtre
        window.addEventListener('resize', function() {
            if (window.innerWidth > 1024) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            }
        });
    </script>
    
    <!-- Script PWA minimal -->
    <script>
        // Enregistrement simple du Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(registration => console.log('PWA: Service Worker enregistré'))
                    .catch(error => console.log('PWA: Erreur d\'enregistrement'));
            });
        }
    </script>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    new TomSelect('#produit_id', {
        create: false,          // empêche l’ajout libre
        sortField: 'text',      // tri alphabétique
        placeholder: 'Rechercher un produit…',
        allowEmptyOption: true,
        maxItems: 1
    });
});
</script>
</body>
</html>     