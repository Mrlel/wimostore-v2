<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — WimoStock Admin</title>

    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#f0c61d">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="WimoStock">
    <link rel="apple-touch-icon" href="/icons/wimo-192x192.png">
    <link rel="shortcut icon" href="/wim.png" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    :root {
        --gold:       #f0c61d;
        --gold-light: #ffd93d;
        --gold-dim:   rgba(240,198,29,0.12);
        --black:      #000000;
        --surface-2:  #161616;
        --border:     rgba(255,255,255,0.07);
        --text:       #ffffff;
        --text-muted: rgba(255,255,255,0.6);
        --text-sub:   rgba(255,255,255,0.25);
        --sidebar-w:  260px;
        --radius:     12px;
        --radius-sm:  8px;
        --transition: 0.22s ease;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body { font-family: 'DM Sans', sans-serif; color: var(--text); background: var(--black); overflow-x: hidden; line-height: 1.5; }

    /* ── Shell ── */
    .shell { display: flex; min-height: 100vh; }

    /* ── Sidebar ── */
    .sidebar {
        width: var(--sidebar-w);
        background: var(--black);
        position: fixed; top: 0; left: 0; bottom: 0;
        z-index: 1000;
        display: flex; flex-direction: column;
        transition: transform var(--transition);
        border-right: 1px solid var(--border);
    }
    .sidebar-brand { padding: 22px 24px 16px; flex-shrink: 0; }
    .sidebar-brand-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .sidebar-brand-logo img { height: 36px; width: auto; }
    .brand-text { font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 900; color: var(--text); }
    .brand-text span { color: var(--gold); }

    .admin-badge {
        margin: 0 16px 12px;
        padding: 8px 14px;
        background: rgba(240,198,29,0.08);
        border: 1px solid rgba(240,198,29,0.2);
        border-radius: var(--radius-sm);
        display: flex; align-items: center; gap: 8px;
        flex-shrink: 0;
    }
    .admin-badge i { color: var(--gold); font-size: 0.9rem; }
    .admin-badge span { font-size: 0.75rem; font-weight: 700; color: var(--gold); letter-spacing: 0.1em; text-transform: uppercase; }

    .nav-section-label {
        padding: 14px 20px 5px;
        font-size: 0.62rem; font-weight: 700;
        letter-spacing: 0.14em; text-transform: uppercase;
        color: var(--text-sub); flex-shrink: 0;
    }
    .nav-menu { list-style: none; flex: 1; overflow-y: auto; padding: 4px 10px 12px; scrollbar-width: thin; scrollbar-color: var(--border) transparent; }
    .nav-menu::-webkit-scrollbar { width: 4px; }
    .nav-menu::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }
    .nav-item { margin-bottom: 2px; }

    .nav-link {
        display: flex; align-items: center; gap: 12px;
        padding: 9px 12px; border-radius: var(--radius-sm);
        color: var(--text-muted) !important;
        font-size: 0.82rem; font-weight: 500;
        text-decoration: none; letter-spacing: 0.02em;
        transition: all var(--transition);
        position: relative; overflow: hidden;
        border: 1px solid transparent;
    }
    .nav-link::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(90deg, var(--gold-dim), transparent);
        opacity: 0; transition: opacity var(--transition);
    }
    .nav-link:hover { color: var(--text) !important; border-color: var(--border); }
    .nav-link:hover::before { opacity: 1; }
    .nav-link:hover i { color: var(--gold); }
    .nav-link.active { color: var(--gold) !important; background: var(--gold-dim); border-color: rgba(240,198,29,0.2); }
    .nav-link.active i { color: var(--gold); }
    .nav-link i { font-size: 1rem; width: 18px; text-align: center; color: var(--text-muted); flex-shrink: 0; position: relative; z-index: 1; transition: color var(--transition); }
    .nav-link span { position: relative; z-index: 1; }
    .nav-divider { height: 1px; background: var(--border); margin: 8px 12px; }

    .sidebar-footer { padding: 12px 10px; border-top: 1px solid var(--border); flex-shrink: 0; }
    .logout-btn {
        width: 100%; padding: 10px 14px;
        background: rgba(255,80,80,0.07); border: 1px solid rgba(255,80,80,0.15);
        border-radius: var(--radius-sm); color: rgba(255,130,130,0.8);
        font-family: 'DM Sans', sans-serif; font-size: 0.82rem; font-weight: 500;
        cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: all var(--transition);
    }
    .logout-btn:hover { background: rgba(255,80,80,0.14); border-color: rgba(255,80,80,0.3); color: #ff8080; }

    /* ── Main ── */
    .main-content { flex: 1; margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; transition: margin-left var(--transition); }

    /* ── Header ── */
    .header {
        height: 64px; background: var(--black);
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 28px; gap: 16px; flex-shrink: 0;
    }
    .header-left { display: flex; align-items: center; gap: 12px; }
    .header-menu-btn {
        display: none; background: none; border: 1px solid var(--border);
        color: var(--text); border-radius: var(--radius-sm);
        padding: 6px 10px; cursor: pointer; font-size: 1rem; transition: all var(--transition);
    }
    .header-menu-btn:hover { border-color: var(--gold); color: var(--gold); }
    .header-right { display: flex; align-items: center; gap: 8px; }
    .header-icon-btn {
        position: relative; display: flex; align-items: center; justify-content: center;
        width: 38px; height: 38px; border-radius: var(--radius-sm);
        background: var(--surface-2); border: 1px solid var(--border);
        color: var(--text-muted); text-decoration: none; transition: all var(--transition); font-size: 1rem;
    }
    .header-icon-btn:hover { border-color: var(--gold); color: var(--gold); }
    .header-user {
        display: flex; align-items: center; gap: 8px;
        padding: 5px 12px 5px 8px;
        background: var(--surface-2); border: 1px solid var(--border);
        border-radius: 50px; text-decoration: none;
        color: var(--text-muted); font-size: 0.8rem; font-weight: 500;
        transition: all var(--transition); white-space: nowrap;
    }
    .header-user:hover { border-color: var(--gold); color: var(--text); }
    .header-user-avatar {
        width: 26px; height: 26px; border-radius: 50%;
        background: var(--gold-dim); border: 1.5px solid rgba(240,198,29,0.3);
        display: flex; align-items: center; justify-content: center;
        color: var(--gold); font-size: 0.75rem; flex-shrink: 0;
    }

    /* ── Page content ── */
    .page-content { flex: 1; padding: 28px 28px 80px; background: #fff; border-radius: 8px; }

    /* ── Overlay ── */
    .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 999; backdrop-filter: blur(3px); }
    .sidebar-overlay.active { display: block; }

    /* ── Mobile nav ── */
    .mobile-nav {
        display: none; position: fixed; bottom: 0; left: 0; right: 0;
        background: rgba(0,0,0,0.95); backdrop-filter: blur(16px);
        border-top: 1px solid var(--border); z-index: 1000;
        padding: 6px 0 max(6px, env(safe-area-inset-bottom));
        border-radius: 20px 20px 0 0;
    }
    .mobile-nav-inner { display: flex; justify-content: space-around; align-items: stretch; }
    .mobile-nav-link {
        flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 3px; padding: 6px 4px; color: var(--text-sub); text-decoration: none;
        font-size: 0.55rem; font-weight: 600; letter-spacing: 0.03em; text-transform: uppercase;
        transition: all var(--transition); border-radius: var(--radius-sm);
    }
    .mobile-nav-link i { font-size: 1.3rem; transition: all var(--transition); color: inherit; }
    .mobile-nav-link.active { color: var(--gold); }
    .mobile-nav-link.active i { color: var(--gold); filter: drop-shadow(0 0 6px rgba(240,198,29,0.5)); }

    /* ── Typography ── */
    h1,.h1{font-size:1.75rem;font-weight:700} h2,.h2{font-size:1.5rem;font-weight:600}
    h3,.h3{font-size:1.3rem;font-weight:600} h4,.h4{font-size:1.1rem;font-weight:500}
    h5,.h5{font-size:1rem;font-weight:500} h6,.h6{font-size:0.9rem;font-weight:500}
    p,body,.btn,small{font-size:0.92rem}
    .bi,.fa,.fas,.far,.fal,.fab{font-size:1em;vertical-align:middle}

    /* ── Stats grid ── */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; margin-bottom: 24px; }
    .stat-card {
        background: var(--black); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 18px;
        position: relative; overflow: hidden; transition: all var(--transition); height: 100%;
    }
    .stat-card::after {
        content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--gold), var(--gold-light));
        opacity: 0; transition: opacity var(--transition);
    }
    .stat-card:hover::after { opacity: 1; }
    .stat-card:hover { border-color: rgba(240,198,29,0.2); }
    .stat-info h3 { font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px; }
    .stat-value { font-size: 1.5rem; font-weight: 700; color: var(--text); margin-bottom: 8px; word-break: break-word; }
    .stat-footer { font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }

    /* ── Tables ── */
    .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    @media (max-width: 640px) {
        .table-card-mobile thead { display: none; }
        .table-card-mobile tbody tr { display: block; background: #fff; border: 1px solid #e0e0e0; border-radius: 10px; margin-bottom: 12px; padding: 12px 14px; }
        .table-card-mobile tbody td { display: flex; justify-content: space-between; align-items: flex-start; padding: 5px 0; border: none !important; font-size: 0.82rem; gap: 8px; }
        .table-card-mobile tbody td::before { content: attr(data-label); font-weight: 600; color: #555; font-size: 0.72rem; text-transform: uppercase; white-space: nowrap; flex-shrink: 0; min-width: 90px; }
        .table-card-mobile tbody td:last-child { border-top: 1px solid #f0f0f0 !important; margin-top: 6px; padding-top: 10px; justify-content: flex-end; }
        .table-card-mobile tbody td:last-child::before { display: none; }
    }

    /* ── Responsive ── */
    @media (max-width: 1024px) {
        .sidebar { transform: translateX(-100%); }
        .sidebar.open { transform: translateX(0); box-shadow: 4px 0 24px rgba(0,0,0,0.5); }
        .main-content { margin-left: 0; }
        .header-menu-btn { display: flex; }
    }
    @media (max-width: 768px) {
        .mobile-nav { display: block; }
        .main-content { padding-bottom: 70px; }
        .page-content { padding: 16px 16px 90px; }
        .header { padding: 0 16px; height: 56px; }
        h1,.h1{font-size:1.4rem} h2,.h2{font-size:1.2rem} h3,.h3{font-size:1.1rem}
        p,body,.btn,small{font-size:0.87rem}
        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .card-body { padding: 12px !important; }
        .card-header { padding: 10px 12px !important; }
        .d-flex.justify-content-between { flex-direction: column; gap: 8px; align-items: center !important; }
        .pagination { flex-wrap: wrap; justify-content: center; gap: 4px; }
    }
    @media (max-width: 576px) {
        .page-content { padding: 12px 12px 90px; }
        h1,.h1{font-size:1.25rem} h2,.h2{font-size:1.1rem}
        p,body,.btn,small{font-size:0.83rem}
        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .stat-card { padding: 12px; }
        .stat-value { font-size: 1.1rem; }
        .table { font-size: 0.78rem; }
        .table th, .table td { padding: 6px 8px !important; }
        .modal-dialog { margin: 8px; }
    }
    @media (max-width: 400px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
    </style>

    @stack('styles')
</head>
<body>
<div class="shell">

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- ── SIDEBAR ── -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <a href="/admin/dashboard" class="sidebar-brand-logo">
                <img src="/wimo.png" alt="WimoStock">
                <span class="brand-text">Wimo<span>Stock</span></span>
            </a>
        </div>

        <div class="admin-badge">
            <i class="bi bi-shield-check"></i>
            <span>Administration</span>
        </div>

        <span class="nav-section-label">Gestion</span>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="/admin/dashboard" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-shop"></i>
                    <span>Boutiques</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/users" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/cabine_pages" class="nav-link {{ request()->is('cabine_pages*') ? 'active' : '' }}">
                    <i class="bi bi-globe"></i>
                    <span>Sites vitrines</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/abonnements" class="nav-link {{ request()->is('abonnements') ? 'active' : '' }}">
                    <i class="bi bi-credit-card"></i>
                    <span>Abonnements</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Se déconnecter
                </button>
            </form>
        </div>
    </nav>

    <!-- ── MAIN ── -->
    <main class="main-content">
        <header class="header">
            <div class="header-left">
                <button class="header-menu-btn" onclick="toggleSidebar()" aria-label="Menu">
                    <i class="bi bi-list"></i>
                </button>
                <a href="/admin/dashboard" style="text-decoration:none;display:flex;align-items:center;gap:8px;">
                    <img src="/wimo.png" height="32" alt="WimoStock">
                </a>
            </div>
            <div class="header-right">
                <a href="/profile" class="header-user">
                    <div class="header-user-avatar"><i class="bi bi-person"></i></div>
                    <span>{{ Auth::user()->nom }}</span>
                </a>
            </div>
        </header>

        <div class="page-content">
            <div style="margin-bottom:16px;">
                @include('layouts.message')
            </div>
            @yield('content')
        </div>
    </main>
</div>

<!-- ── MOBILE NAV ── -->
<nav class="mobile-nav">
    <div class="mobile-nav-inner">
        <a href="/admin/dashboard" class="mobile-nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="bi bi-shop"></i><span>Boutiques</span>
        </a>
        <a href="/admin/users" class="mobile-nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
            <i class="bi bi-people"></i><span>Utilisateurs</span>
        </a>
        <a href="/cabine_pages" class="mobile-nav-link {{ request()->is('cabine_pages*') ? 'active' : '' }}">
            <i class="bi bi-globe"></i><span>Vitrines</span>
        </a>
        <a href="/abonnements" class="mobile-nav-link {{ request()->is('abonnements') ? 'active' : '' }}">
            <i class="bi bi-credit-card"></i><span>Abonnements</span>
        </a>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('active');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('active');
}
window.addEventListener('resize', () => { if (window.innerWidth > 1024) closeSidebar(); });
document.querySelectorAll('.sidebar .nav-link').forEach(l => {
    l.addEventListener('click', () => { if (window.innerWidth <= 1024) closeSidebar(); });
});
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => navigator.serviceWorker.register('/service-worker.js').catch(() => {}));
}
</script>
@stack('scripts')
</body>
</html>
