<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — WimoStock</title>

    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#000000">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="WimoStock">
    <link rel="apple-touch-icon" href="/wim.png">
    <link rel="shortcut icon" href="/wim.png" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
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
     <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Libs -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    /* ═══════════════════════════════════════════
       VARIABLES & RESET
    ═══════════════════════════════════════════ */
    :root {
        --gold:        #f0c61d;
        --gold-light:  #ffd93d;
        --gold-dim:    rgba(240,198,29,0.12);
        --gold-glow:   rgba(240,198,29,0.22);
        --black:       #000000;
        --surface:     #0d0d0d;
        --surface-2:   #161616;
        --surface-3:   #1e1e1e;
        --border:      rgba(255,255,255,0.07);
        --text:        #ffffff;
        --text-muted:  rgba(255, 255, 255, 0.91);
        --text-sub:    rgba(255,255,255,0.25);
        --sidebar-w:   260px;
        --header-h:    64px;
        --radius:      12px;
        --radius-sm:   8px;
        --shadow:      0 8px 32px rgba(0,0,0,0.45);
        --transition:  0.22s ease;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    body {
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        line-height: 1.5;
        overflow-x: hidden;
         background: var(--black);
    }

    /* ═══════════════════════════════════════════
       LAYOUT SHELL
    ═══════════════════════════════════════════ */
    .shell {
        display: flex;
        min-height: 100vh;
    }

    /* ═══════════════════════════════════════════
       SIDEBAR
    ═══════════════════════════════════════════ */
    .sidebar {
        width: var(--sidebar-w);
        background: var(--black);
        position: fixed;
        top: 0; left: 0; bottom: 0;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        transition: transform var(--transition);
        overflow: hidden;
        border-radius: 0 10px 10px 0;
    }

 
    /* ── Brand ── */
    .sidebar-brand {
        padding: 22px 24px 16px;
        flex-shrink: 0;
    }
    .sidebar-brand-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }
    .sidebar-brand-logo img {
        height: 36px;
        width: auto;
    }
    .brand-text {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        font-weight: 900;
        color: var(--text);
        letter-spacing: -0.01em;
    }
    .brand-text span { color: var(--gold); }

    /* ── Shop badge ── */
    .sidebar-shop {
        margin: 12px 16px;
        padding: 10px 14px;
        background: var(--gold-dim);
        border: 1px solid rgba(240,198,29,0.2);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        transition: background var(--transition);
        flex-shrink: 0;
    }
    .sidebar-shop:hover { background: rgba(240,198,29,0.18); }
    .sidebar-shop i { color: var(--gold); font-size: 1rem; }
    .sidebar-shop-name {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--gold);
        letter-spacing: 0.04em;
        text-transform: uppercase;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ── Nav ── */
    .nav-section-label {
        padding: 16px 20px 6px;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--text-sub);
        flex-shrink: 0;
    }

    .nav-menu {
        list-style: none;
        flex: 1;
        overflow-y: auto;
        padding: 4px 10px 12px;
        scrollbar-width: thin;
        scrollbar-color: var(--border) transparent;
    }
    .nav-menu::-webkit-scrollbar { width: 4px; }
    .nav-menu::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

    .nav-item { margin-bottom: 2px; }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 9px 12px;
        border-radius: var(--radius-sm);
        color: var(--text-muted) !important;
        font-size: 0.82rem;
        font-weight: 500;
        text-decoration: none;
        letter-spacing: 0.02em;
        transition: all var(--transition);
        position: relative;
        overflow: hidden;
        border: 1px solid transparent;
    }
    .nav-link::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, var(--gold-dim), transparent);
        opacity: 0;
        transition: opacity var(--transition);
    }
    .nav-link:hover { color: var(--text) !important; border-color: var(--border); }
    .nav-link:hover::before { opacity: 1; }
    .nav-link.active {
        color: var(--gold) !important;
        background: var(--gold-dim);
        border-color: rgba(240,198,29,0.2);
    }
    .nav-link.active i { color: var(--gold); }
    .nav-link i {
        font-size: 1rem;
        width: 18px;
        text-align: center;
        color: var(--text-muted);
        flex-shrink: 0;
        position: relative;
        z-index: 1;
        transition: color var(--transition);
    }
    .nav-link:hover i { color: var(--gold); }
    .nav-link span { position: relative; z-index: 1; }

    .nav-badge {
        margin-left: auto;
        background: var(--gold);
        color: #000;
        font-size: 0.6rem;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 20px;
        position: relative;
        z-index: 1;
    }

    /* ── Logout ── */
    .sidebar-footer {
        padding: 12px 10px;
        border-top: 1px solid var(--border);
        flex-shrink: 0;
    }
    .logout-btn {
        width: 100%;
        padding: 10px 14px;
        background: rgba(255,80,80,0.07);
        border: 1px solid rgba(255,80,80,0.15);
        border-radius: var(--radius-sm);
        color: rgba(255,130,130,0.8);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all var(--transition);
    }
    .logout-btn:hover {
        background: rgba(255,80,80,0.14);
        border-color: rgba(255,80,80,0.3);
        color: #ff8080;
    }

    /* ── Nav divider ── */
    .nav-divider {
        height: 1px;
        background: var(--border);
        margin: 8px 12px;
    }

    /* ═══════════════════════════════════════════
       MAIN CONTENT
    ═══════════════════════════════════════════ */
    .main-content {
        flex: 1;
        margin-left: var(--sidebar-w);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        transition: margin-left var(--transition);
  
    }

    /* ═══════════════════════════════════════════
       HEADER
    ═══════════════════════════════════════════ */
    .header {
     
        z-index: 100;
        height: var(--header-h);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-bottom: 1px solid var(--border);
        display: flex;
         background: var(--black);
        align-items: center;
        justify-content: space-between;
        padding: 0 28px;
        gap: 16px;
        border-radius: 8px;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .header-logo-link { text-decoration: none; display: flex; align-items: center; gap: 10px; }
    .header-logo-link img { height: 32px; width: auto; }
    .header-shop-name {
        font-size: 0.88rem;
        font-weight: 600;
        color: rgba(0, 0, 0, 0.7);
        letter-spacing: 0.02em;
    }

    /* Mobile menu toggle in header */
    .header-menu-btn {
        display: none;
        background: none;
        border: 1px solid var(--border);
        color: var(--text);
        border-radius: var(--radius-sm);
        padding: 6px 10px;
        cursor: pointer;
        font-size: 1rem;
        transition: all var(--transition);
    }
    .header-menu-btn:hover { border-color: var(--gold); color: var(--gold); }

    .header-right {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Notif bell */
    .header-icon-btn {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px; height: 38px;
        border-radius: var(--radius-sm);
        background: var(--surface-2);
        border: 1px solid var(--border);
        color: var(--text-muted);
        text-decoration: none;
        transition: all var(--transition);
        font-size: 1rem;
    }
    .header-icon-btn:hover { border-color: var(--gold); color: var(--gold); }

    .notif-badge {
        position: absolute;
        top: -5px; right: -5px;
        background: #c51700;
        color: #fff;
        font-size: 0.6rem;
        font-weight: 700;
        border-radius: 50%;
        min-width: 17px; height: 17px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 0 0 2px #000;
        animation: pulse 2s ease-in-out infinite;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }

    /* User chip */
    .header-user {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 12px 5px 8px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 50px;
        text-decoration: none;
        color: var(--text-muted);
        font-size: 0.8rem;
        font-weight: 500;
        transition: all var(--transition);
        white-space: nowrap;
    }
    .header-user:hover { border-color: var(--gold); color: var(--text); }
    .header-user-avatar {
        width: 26px; height: 26px;
        border-radius: 50%;
        background: var(--gold-dim);
        border: 1.5px solid rgba(240,198,29,0.3);
        display: flex; align-items: center; justify-content: center;
        color: var(--gold);
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    /* Shop link */
    .header-shop-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px; height: 38px;
        border-radius: var(--radius-sm);
        background: var(--surface-2);
        border: 1px solid var(--border);
        color: var(--text-muted);
        text-decoration: none;
        transition: all var(--transition);
        font-size: 1rem;
    }
    .header-shop-btn:hover { border-color: var(--gold); color: var(--gold); }

    /* ═══════════════════════════════════════════
       PAGE CONTENT
    ═══════════════════════════════════════════ */
    .page-content {
        flex: 1;
        padding: 28px 28px 100px;
         background: #FFF;
         border-radius:8px;
    }

    /* Flash messages */
    .flash-zone {
        margin-bottom: 20px;
    }

    /* ═══════════════════════════════════════════
       SIDEBAR OVERLAY (mobile)
    ═══════════════════════════════════════════ */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.7);
        z-index: 999;
        backdrop-filter: blur(3px);
    }
    .sidebar-overlay.active { display: block; }

    /* ═══════════════════════════════════════════
       BOTTOM NAV (mobile)
    ═══════════════════════════════════════════ */
    .mobile-nav {
        display: none;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: rgba(0,0,0,0.92);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-top: 1px solid var(--border);
        z-index: 1000;
        padding: 6px 0 max(6px, env(safe-area-inset-bottom));
        border-radius: 20px 20px 0 0;
    }
    .mobile-nav-inner {
        display: flex;
        justify-content: space-around;
        align-items: stretch;
    }
    .mobile-nav-link {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 3px;
        padding: 6px 4px;
        color: var(--text-sub);
        text-decoration: none;
        font-size: 0.55rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        transition: all var(--transition);
        border-radius: var(--radius-sm);
    }
    .mobile-nav-link i {
        font-size: 1.3rem;
        transition: all var(--transition);
        color: inherit;
    }
    .mobile-nav-link.active { color: var(--gold); }
    .mobile-nav-link.active i {
        color: var(--gold);
        filter: drop-shadow(0 0 6px rgba(240,198,29,0.5));
    }
    .mobile-nav-link:hover { color: rgba(255,255,255,0.6); }

    /* ═══════════════════════════════════════════
       TYPOGRAPHY
    ═══════════════════════════════════════════ */
    h1, .h1 { font-size: 1.75rem; font-weight: 700; }
    h2, .h2 { font-size: 1.5rem; font-weight: 600; }
    h3, .h3 { font-size: 1.3rem; font-weight: 600; }
    h4, .h4 { font-size: 1.1rem; font-weight: 500; }
    h5, .h5 { font-size: 1rem; font-weight: 500; }
    h6, .h6 { font-size: 0.9rem; font-weight: 500; }
    p, body, .btn, small { font-size: 0.92rem; }

    .bi, .fa, .fas, .far, .fal, .fab { font-size: 1em; vertical-align: middle; }

    /* ═══════════════════════════════════════════
       NOTIFICATION BADGE
    ═══════════════════════════════════════════ */
    .notification-count {
        position: absolute;
        top: -6px; right: -6px;
        background: #c51700;
        color: #fff;
        font-size: 0.6rem;
        font-weight: 700;
        border-radius: 50%;
        min-width: 17px; height: 17px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 0 0 2px #000;
    }
    .animate-bounce { animation: pulse 1.4s ease-in-out infinite; }

    /* ═══════════════════════════════════════════
       VOICE PLAYER
    ═══════════════════════════════════════════ */
    .voice-player-widget {
        display: flex;
        align-items: center;
        gap: 12px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        padding: 12px 16px;
        border-radius: var(--radius);
        max-width: 320px;
    }
    .btn-voice-play {
        background: var(--gold-dim);
        color: var(--gold);
        border: 1px solid rgba(240,198,29,0.25);
        border-radius: 50%;
        width: 36px; height: 36px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all var(--transition);
    }
    .btn-voice-play:hover { background: var(--gold); color: #000; }
    .voice-progress {
        flex: 1;
        height: 4px;
        background: var(--surface-3);
        border-radius: 2px;
        overflow: hidden;
        cursor: pointer;
    }
    .voice-progress-bar {
        height: 100%;
        background: var(--gold);
        border-radius: 2px;
        width: 0%;
        transition: width 0.1s linear;
    }
    .voice-time {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 500;
        min-width: 70px;
        text-align: center;
    }

    /* ═══════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════ */
    @media (max-width: 1024px) {
        .sidebar {
            transform: translateX(-100%);
            box-shadow: none;
        }
        .sidebar.open {
            transform: translateX(0);
            box-shadow: 4px 0 24px rgba(0,0,0,0.5);
        }
        .main-content { margin-left: 0; }
        .header-menu-btn { display: flex; }
    }

    @media (max-width: 768px) {
        .mobile-nav { display: block; }
        .main-content { padding-bottom: 70px; }
        .page-content { padding: 16px 16px 90px; }
        .header { padding: 0 16px; height: 56px; }
        .header-shop-name { display: none; }

        h1, .h1 { font-size: 1.4rem; }
        h2, .h2 { font-size: 1.2rem; }
        h3, .h3 { font-size: 1.1rem; }
        p, body, .btn, small { font-size: 0.87rem; }

        /* Tables responsive */
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .table { min-width: 500px; }

        /* Cards */
        .card { border-radius: 8px !important; }
        .card-body { padding: 12px !important; }
        .card-header { padding: 10px 12px !important; }

        /* Buttons */
        .btn-group { flex-wrap: wrap; gap: 4px; }
        .btn-group .btn { flex: 1; min-width: 80px; }

        /* Pagination */
        .d-flex.justify-content-between { flex-direction: column; gap: 8px; align-items: center !important; }

        /* Welcome section */
        .welcome-section { padding: 16px !important; }
        .welcome-title { font-size: 1.4rem !important; }
        .user-info-badge { font-size: 0.78rem; padding: 6px 12px; }

        /* Period filter */
        .period-filter { flex-direction: column; align-items: stretch !important; gap: 8px !important; }
        .period-filter form { width: 100%; }
        .period-filter .btn { width: 100%; }
    }

    @media (max-width: 576px) {
        .header-user span.user-name { display: none; }
        .page-content { padding: 12px 12px 90px; }

        h1, .h1 { font-size: 1.25rem; }
        h2, .h2 { font-size: 1.1rem; }
        p, body, .btn, small { font-size: 0.83rem; }

        /* Stat cards : 2 colonnes sur petit mobile */
        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .stat-card { padding: 12px; }
        .stat-value { font-size: 1.1rem; }
        .stat-info h3 { font-size: 0.65rem; }
        .stat-footer { font-size: 0.65rem; }

        /* Tables : scroll horizontal */
        .table { font-size: 0.78rem; }
        .table th, .table td { padding: 6px 8px !important; }

        /* Modals */
        .modal-dialog { margin: 8px; }
        .modal-body { padding: 12px; }

        /* Navigation header buttons */
        .navigation-header .btn { font-size: 0.8rem; padding: 6px 10px; }

        /* Charts */
        .chart-container { height: 220px !important; }

        /* Action cards dashboard */
        .actions-grid { grid-template-columns: 1fr 1fr !important; gap: 10px !important; }
        .action-card { padding: 14px !important; }
        .action-icon { width: 44px !important; height: 44px !important; font-size: 18px !important; }
        .action-title { font-size: 13px !important; }
        .action-desc { display: none; }
    }

    @media (max-width: 400px) {
        .page-content { padding: 10px 10px 90px; }
        .stats-grid { grid-template-columns: 1fr; }
        .stat-value { font-size: 1.3rem; }
        .actions-grid { grid-template-columns: 1fr !important; }
    }

    /* ═══════════════════════════════════════════
       RESPONSIVE TABLES
    ═══════════════════════════════════════════ */

    /* Wrapper scroll horizontal sur mobile */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 0 0 var(--radius) var(--radius);
    }

    /* Card-table : chaque ligne devient une carte sur mobile */
    @media (max-width: 640px) {
        .table-card-mobile thead { display: none; }

        .table-card-mobile tbody tr {
            display: block;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            margin-bottom: 12px;
            padding: 12px 14px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }

        .table-card-mobile tbody td {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 5px 0;
            border: none !important;
            font-size: 0.82rem;
            gap: 8px;
        }

        .table-card-mobile tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #555;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            white-space: nowrap;
            flex-shrink: 0;
            min-width: 90px;
        }

        .table-card-mobile tbody td:last-child {
            border-top: 1px solid #f0f0f0 !important;
            margin-top: 6px;
            padding-top: 10px;
            justify-content: flex-end;
        }

        .table-card-mobile tbody td:last-child::before { display: none; }

        /* Pagination sur mobile */
        .pagination { flex-wrap: wrap; justify-content: center; gap: 4px; }
        .pagination .page-item .page-link { padding: 5px 10px; font-size: 0.8rem; }
    }

    /* ═══════════════════════════════════════════
       PAGE-SPECIFIC HELPERS
    ═══════════════════════════════════════════ */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
    }
    .page-header-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 900;
        color: var(--text);
        line-height: 1.2;
    }
    .page-header-title span { color: var(--gold); }
    .page-header-sub {
        font-size: 0.82rem;
        color: var(--text-muted);
        margin-top: 2px;
    }

    /* Card base */
    .wimo-card {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px;
        transition: border-color var(--transition);
    }
    .wimo-card:hover { border-color: rgba(240,198,29,0.15); }

    /* Stat card */
    .stat-card {
        background: var(--black);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 18px;
        position: relative;
        overflow: hidden;
        transition: all var(--transition);
        height: 100%;
    }
    .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--gold), var(--gold-light));
        opacity: 0;
        transition: opacity var(--transition);
    }
    .stat-card:hover::after { opacity: 1; }
    .stat-card:hover { border-color: rgba(240,198,29,0.2); }
    .stat-info h3 { font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px; }
    .stat-value { font-size: 1.5rem; font-weight: 700; color: var(--text); margin-bottom: 8px; word-break: break-word; }
    .stat-footer { font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }

    /* Chart section */
    .chart-section {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 22px;
        margin-bottom: 24px;
        overflow-x: auto;
    }
    .chart-title { font-size: 1rem; font-weight: 600; color: var(--text); }
    .chart-subtitle { font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; }
    .chart-container { height: 300px; position: relative; min-width: 0; }
    .chart-labels { fill: var(--text-muted); font-size: 11px; font-family: inherit; }
    .chart-grid { stroke: var(--border); stroke-width: 1; }

    /* Stats grid — responsive */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }

    @media (max-width: 767px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .stat-card {
            padding: 14px;
        }
        .stat-value {
            font-size: 1.2rem;
        }
        .stat-info h3 {
            font-size: 0.7rem;
        }
        .stat-footer {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 400px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Announcement bar */
    .up {
        background: var(--black);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        color: var(--text-muted);
        font-size: 0.82rem;
        font-weight: 500;
        padding: 8px 14px;
        margin-bottom: 20px;
        text-align: center;
    }
    </style>

    @stack('styles')
</head>
<body>

<div class="shell">

    <!-- ── OVERLAY ── -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- ═══════════════════════════
         SIDEBAR
    ═══════════════════════════ -->
    <nav class="sidebar" id="sidebar">

        <!-- Brand -->
        <div class="sidebar-brand">
            <a href="/dashboard" class="sidebar-brand-logo">
                <img src="/wimo.png" alt="WimoStock">
                <span class="brand-text">Wimo<span>Stock</span></span>
            </a>
        </div>

        <!-- Shop badge -->
        <a href="/Ma_boutique" class="sidebar-shop">
            <i class="bi bi-shop"></i>
            <span class="sidebar-shop-name">{{ Auth::user()->cabine->nom_cab ?? 'Ma Boutique' }}</span>
        </a>

        <!-- Nav items -->
        <span class="nav-section-label">Navigation</span>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-columns-gap"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/produits" class="nav-link {{ request()->is('produits*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Mes produits</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/ventes" class="nav-link {{ request()->is('ventes*') ? 'active' : '' }}">
                    <i class="bi bi-cart-check"></i>
                    <span>Mes ventes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/commandes-boutique" class="nav-link {{ request()->is('commandes-boutique*') ? 'active' : '' }}">
                    <i class="bi bi-bag-check"></i>
                    <span>Commandes</span>
                    <span id="cmdBadgeSidebar" class="nav-badge animate-bounce" style="display:none;"></span>
                </a>
            </li>

            <div class="nav-divider"></div>
            <span class="nav-section-label" style="padding-top:8px;">Analyse</span>

            <li class="nav-item">
                <a href="/details_inventaire" class="nav-link {{ request()->is('details_inventaire*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart"></i>
                    <span>Mes performances</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/rapports-financiers" class="nav-link {{ request()->is('rapports-financiers*') ? 'active' : '' }}">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>Rapports financiers</span>
                </a>
            </li>

            <div class="nav-divider"></div>
            <span class="nav-section-label" style="padding-top:8px;">Stock</span>

            <li class="nav-item">
                <a href="/inventaire" class="nav-link {{ request()->is('inventaire*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Inventaire &amp; stock</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/mouvements" class="nav-link {{ request()->is('mouvements*') ? 'active' : '' }}">
                    <i class="bi bi-arrow-left-right"></i>
                    <span>Mouvements stock</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/certification" class="nav-link {{ request()->is('certification*') ? 'active' : '' }}">
                    <i class="bi bi-award"></i>
                    <span>Certification</span>
                </a>
            </li>
        </ul>

        <!-- Logout -->
        <div class="sidebar-footer">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Se déconnecter
                </button>
            </form>
        </div>
    </nav>

    <!-- ═══════════════════════════
         MAIN CONTENT
    ═══════════════════════════ -->
    <main class="main-content">
        <div class="page-content">
            
<!-- ── HEADER── -->
        <header class="header">
            <div class="header-left">
                <button class="header-menu-btn" onclick="toggleSidebar()" aria-label="Menu">
                    <i class="bi bi-list"></i>
                </button>
                <a href="/dashboard" class="header-logo-link">
                    <img src="/wimo.png" alt="WimoStock">
                    <span class="header-shop-name">{{ Auth::user()->cabine->nom_cab ?? '' }}</span>
                </a>
            </div>

            <div class="header-right">
               
                <a href="{{ route('notifications') }}" class="header-icon-btn">
                    <i class="bi bi-bell"></i>
                    @if(isset($notifications) && $notifications->count() > 0)
                        <span class="notif-badge animate-bounce">{{ $notifications->count() }}</span>
                    @endif
                </a>

               
                <a href="/Ma_boutique" class="header-shop-btn">
                    <i class="bi bi-shop"></i>
                </a>

           
                <a href="/profile" class="header-user">
                    <div class="header-user-avatar">
                        <i class="bi bi-person"></i>
                    </div>
                    <span class="user-name">{{ Auth::user()->nom }}</span>
                </a>
            </div>
        </header> 
            <div class="flash-zone">
                @include('layouts.message')
            </div>
            @yield('content')
        </div>

    </main>
</div>

<!-- ═══════════════════════════
     MOBILE BOTTOM NAV
═══════════════════════════ -->
<nav class="mobile-nav">
    <div class="mobile-nav-inner">
        <a href="/dashboard" class="mobile-nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-check"></i>
            <span>Accueil</span>
        </a>
        <a href="/produits" class="mobile-nav-link {{ request()->is('produits*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Produits</span>
        </a>
        <a href="/Ma_boutique" class="mobile-nav-link {{ request()->is('Ma_boutique*') ? 'active' : '' }}">
            <i class="bi bi-shop"></i>
            <span>Boutique</span>
        </a>
        <a href="/ventes" class="mobile-nav-link {{ request()->is('ventes*') ? 'active' : '' }}">
            <i class="bi bi-cart-check"></i>
            <span>Ventes</span>
        </a>
        <a href="/details_inventaire" class="mobile-nav-link {{ request()->is('details_inventaire*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i>
            <span>Stats</span>
        </a>
    </div>
</nav>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<script>
    /* ── SIDEBAR ── */
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('active');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('active');
    }
    window.addEventListener('resize', () => {
        if (window.innerWidth > 1024) closeSidebar();
    });
    // Close on nav click (mobile)
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 1024) closeSidebar();
        });
    });

    /* ── PWA ── */
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js').catch(() => {});
        });
    }
</script>

@auth
<script>
/* ── POLLING COMMANDES ── */
(function () {
    const badge = document.getElementById('cmdBadgeSidebar');

    function checkCommandes() {
        fetch('/commandes-boutique/api/nouvelles', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.ok ? r.json() : null)
            .then(data => {
                if (!data) return;
                if (data.count > 0) {
                    if (badge) { badge.textContent = data.count; badge.style.display = 'inline-flex'; }
                    if (Notification.permission === 'granted' && data.count !== window._lastCmdCount) {
                        new Notification('Nouvelle commande !', { body: data.count + ' commande(s) en attente', icon: '/wim.png' });
                    }
                    window._lastCmdCount = data.count;
                } else {
                    if (badge) badge.style.display = 'none';
                    window._lastCmdCount = 0;
                }
            }).catch(() => {});
    }

    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }
    window._lastCmdCount = 0;
    checkCommandes();
    setInterval(checkCommandes, 30000);
})();
</script>
@endauth

<script>
/* ── VOICE PLAYER ── */
function toggleVoicePlayer() {
    const audio = document.getElementById('noteVocale');
    if (!audio) return;
    const btn = document.querySelector('.btn-voice-play');
    if (audio.paused) {
        audio.play(); btn.classList.add('playing');
    } else {
        audio.pause(); btn.classList.remove('playing');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const audio = document.getElementById('noteVocale');
    if (!audio) return;

    audio.addEventListener('timeupdate', function () {
        const prog = document.getElementById('voiceProgressBar');
        const cur  = document.getElementById('voiceCurrentTime');
        const dur  = document.getElementById('voiceDuration');
        if (!this.duration) return;
        if (prog) prog.style.width = (this.currentTime / this.duration * 100) + '%';
        if (cur)  cur.textContent  = fmt(this.currentTime);
        if (dur)  dur.textContent  = fmt(this.duration);
    });

    const vpBar = document.querySelector('.voice-progress');
    if (vpBar) {
        vpBar.addEventListener('click', function (e) {
            audio.currentTime = (e.offsetX / this.offsetWidth) * audio.duration;
        });
    }

    audio.addEventListener('ended', function () {
        const btn  = document.querySelector('.btn-voice-play');
        const prog = document.getElementById('voiceProgressBar');
        if (btn)  btn.classList.remove('playing');
        if (prog) prog.style.width = '0%';
    });

    function fmt(s) {
        return Math.floor(s / 60) + ':' + String(Math.floor(s % 60)).padStart(2, '0');
    }

    /* Tom Select (si présent) */
    const produitEl = document.getElementById('produit_id');
    if (produitEl) {
        new TomSelect('#produit_id', {
            create: false, sortField: 'text',
            placeholder: 'Rechercher un produit…',
            allowEmptyOption: true, maxItems: 1
        });
    }
});
</script>

@stack('scripts')
</body>
</html>