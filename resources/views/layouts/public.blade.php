<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $page->nom_site . ' | ' . $page->cabine->nom_cab)</title>
    <link rel="icon" href="/wim.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        :root {
            --cream: #F8F6F1;
            --charcoal: #1A1A1A;
            --warm-gray: #8C8880;
            --accent: #C8A97E;
            --accent-dark: #A8895E;
            --border: #E8E4DC;
            --tag-bg: #F0EDE6;
            /* compat vues existantes */
            --primary-color: #1A1A1A;
            --primary-light: #1A1A1A33;
            --accent-color: #C8A97E;
            --dark: #1A1A1A;
            --light: #FFFFFF;
            --gray: #8C8880;
            --gray-light: #F0EDE6;
            --gray-medium: #E8E4DC;
            --border-soft: #E8E4DC;
            --shadow-sm: 0 2px 8px rgba(0,0,0,.05);
            --shadow-md: 0 4px 16px rgba(0,0,0,.08);
            --shadow-lg: 0 8px 28px rgba(0,0,0,.10);
            --radius-sm: 10px; --radius-md: 14px; --radius-lg: 18px; --radius-xl: 20px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {

            color: var(--charcoal);
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ══ NAVBAR ══════════════════════════════════════════════════════════ */
        .navbar-top {
            background: #000;
            padding: 0 1.5rem;
            height: 64px;
            display: flex; align-items: center; gap: 12px;
            position: sticky; top: 0; z-index: 200;
            transition: box-shadow .3s;
        }
        .navbar-top.scrolled { box-shadow: 0 4px 24px rgba(0,0,0,.35); }

        /* Logo / brand */
        .brand-logo {
            font-family: 'DM Sans', sans-serif;
            font-size: 1.15rem; font-weight: 700;
            letter-spacing: .06em; color: #fff;
            text-decoration: none; white-space: nowrap;
            display: flex; align-items: center; gap: 8px;
            flex-shrink: 0;
        }
        .brand-logo img { height: 34px; width: auto; border-radius: 8px; }

        /* Barre de recherche centrale */
        .nav-search {
            flex: 1; max-width: 480px; margin: 0 auto;
            position: relative;
        }
        .nav-search input {
            width: 100%;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 50px;
            padding: 9px 16px 9px 40px;
            color: #fff;
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: background .2s, border-color .2s;
        }
        .nav-search input::placeholder { color: rgba(255,255,255,0.4); }
        .nav-search input:focus {
            background: rgba(255,255,255,0.13);
            border-color: rgba(200,169,126,0.6);
        }
        .nav-search .search-icon {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.4);
            font-size: 14px; pointer-events: none;
        }
        .nav-search .search-clear {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.35);
            font-size: 13px; cursor: pointer;
            display: none; background: none; border: none; padding: 0;
            transition: color .2s;
        }
        .nav-search .search-clear:hover { color: #fff; }

        /* Résultats de recherche dropdown */
        .search-results {
            position: absolute; top: calc(100% + 8px); left: 0; right: 0;
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(0,0,0,.5);
            display: none;
            z-index: 500;
            max-height: 360px;
            overflow-y: auto;
        }
        .search-results.open { display: block; }
        .search-result-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px; cursor: pointer;
            transition: background .15s;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .search-result-item:last-child { border-bottom: none; }
        .search-result-item:hover { background: rgba(255,255,255,0.06); }
        .search-result-img {
            width: 40px; height: 48px; border-radius: 8px;
            object-fit: cover; flex-shrink: 0;
            background: rgba(255,255,255,0.06);
        }
        .search-result-name {
            font-size: 13px; font-weight: 600; color: #fff;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .search-result-price {
            font-size: 11px; color: var(--accent); margin-top: 2px;
        }
        .search-result-cat {
            font-size: 10px; color: rgba(255,255,255,0.35); margin-top: 1px;
        }
        .search-no-result {
            padding: 20px; text-align: center;
            color: rgba(255,255,255,0.35); font-size: 13px;
        }

        /* Icônes droite */
        .nav-icons { display: flex; align-items: center; gap: 4px; flex-shrink: 0; }
        .nav-icon-btn {
            width: 38px; height: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.75); font-size: 1rem;
            text-decoration: none; position: relative;
            transition: background .2s, color .2s;
            background: transparent; border: none; cursor: pointer;
        }
        .nav-icon-btn:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .cart-badge {
            position: absolute; top: 2px; right: 2px;
            background: var(--accent); color: #fff;
            font-size: 8px; min-width: 16px; height: 16px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: 700; line-height: 1; padding: 0 3px;
            transition: transform .25s cubic-bezier(.34,1.56,.64,1);
            border: 2px solid #000;
        }
        .cart-badge.hidden { display: none; }

        /* Réseaux sociaux — icônes seulement */
        .nav-social { display: flex; align-items: center; gap: 2px; flex-shrink: 0; }
        .nav-social a {
            width: 34px; height: 34px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.5); font-size: .95rem;
            text-decoration: none; transition: background .2s, color .2s;
        }
        .nav-social a:hover { background: rgba(255,255,255,0.1); color: #fff; }

        /* Bouton menu mobile */
        .menu-toggle {
            display: none; background: none; border: none;
            font-size: 1.3rem; color: rgba(255,255,255,0.8);
            cursor: pointer; padding: 4px; flex-shrink: 0;
        }

        /* ══ RESPONSIVE NAVBAR ═══════════════════════════════════════════════ */
        @media (max-width: 991px) {
            .nav-social { display: none; }
            .nav-search { max-width: none; }
        }
        @media (max-width: 767px) {
            .navbar-top { height: auto; flex-wrap: wrap; padding: 10px 14px; gap: 8px; }
            .menu-toggle { display: flex; }
            .brand-logo { font-size: 1rem; }
            .nav-search { order: 3; flex: 0 0 100%; max-width: 100%; margin: 0; }
            .nav-icons { margin-left: auto; }
        }

        /* ══ SIDEBAR DRAWER (mobile catégories) ══════════════════════════════ */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.4); z-index: 300;
        }
        .sidebar-overlay.open { display: block; }
        .sidebar-drawer {
            position: fixed; top: 0; left: -270px;
            width: 260px; height: 100%; background: var(--cream);
            z-index: 310; padding: 1.5rem; overflow-y: auto;
            transition: left .3s ease; box-shadow: 4px 0 20px rgba(0,0,0,.08);
        }
        .sidebar-drawer.open { left: 0; }
        .drawer-close-cat {
            background: none; border: none; font-size: 1.2rem;
            cursor: pointer; color: var(--warm-gray); float: right; margin-bottom: 1rem;
        }
        .filter-title {
            font-size: 10px; letter-spacing: .18em; text-transform: uppercase;
            font-weight: 500; color: var(--charcoal); margin-bottom: .9rem; display: block;
        }
        .filter-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 7px 0; cursor: pointer; border-bottom: 1px solid var(--border);
        }
        .filter-item:last-child { border-bottom: none; }
        .filter-item label { font-size: 13px; color: var(--warm-gray); cursor: pointer; transition: color .15s; }
        .filter-item:hover label, .filter-item.active label { color: var(--charcoal); font-weight: 500; }
        .filter-count { font-size: 11px; color: #c0bbb5; }

        /* ══ CART DRAWER ══════════════════════════════════════════════════════ */
        .cart-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,.45);
            z-index: 400; opacity: 0; pointer-events: none; transition: opacity .3s;
        }
        .cart-overlay.open { opacity: 1; pointer-events: all; }
        .cart-drawer {
            position: fixed; top: 0; right: 0;
            width: min(400px, 100vw); height: 100dvh;
            background: var(--cream); z-index: 410;
            display: flex; flex-direction: column;
            transform: translateX(100%);
            transition: transform .35s cubic-bezier(.4,0,.2,1);
            box-shadow: -4px 0 24px rgba(0,0,0,.10);
        }
        .cart-drawer.open { transform: translateX(0); }
        .drawer-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 20px; border-bottom: 1px solid var(--border); flex-shrink: 0;
        }
        .drawer-header h2 {
            font-family: 'DM Sans', sans-serif;
            font-size: 1.2rem; font-weight: 600; margin: 0;
            display: flex; align-items: center; gap: 8px;
        }
        .drawer-close {
            width: 32px; height: 32px; border: 1px solid var(--border);
            background: transparent; border-radius: 50%; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; transition: all .2s; color: var(--warm-gray);
        }
        .drawer-close:hover { background: var(--charcoal); color: #fff; border-color: var(--charcoal); }
        .drawer-body { flex: 1; overflow-y: auto; padding: 12px 20px; }
        .cart-item {
            display: flex; gap: 12px; padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }
        .cart-item-img {
            width: 60px; height: 72px; border-radius: 8px;
            object-fit: cover; flex-shrink: 0; background: var(--tag-bg);
        }
        .cart-item-info { flex: 1; min-width: 0; }
        .cart-item-name {
            font-family: 'DM Sans', sans-serif;
            font-size: 15px; font-weight: 600; color: var(--charcoal);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .cart-item-price { font-size: 12px; color: var(--warm-gray); margin-top: 2px; }
        .cart-item-controls { display: flex; align-items: center; gap: 6px; margin-top: 8px; }
        .qty-btn {
            width: 26px; height: 26px; border: 1px solid var(--border);
            background: #fff; border-radius: 6px; cursor: pointer;
            font-size: 14px; display: flex; align-items: center; justify-content: center;
            transition: all .2s;
        }
        .qty-btn:hover { background: var(--charcoal); color: #fff; border-color: var(--charcoal); }
        .qty-value { font-size: 13px; font-weight: 600; min-width: 22px; text-align: center; }
        .cart-item-remove {
            background: none; border: none; color: #c0bbb5; cursor: pointer;
            font-size: 13px; padding: 4px; margin-left: auto; align-self: flex-start;
            transition: color .2s;
        }
        .cart-item-remove:hover { color: #C06B5A; }
        .cart-empty { text-align: center; padding: 60px 20px; color: var(--warm-gray); }
        .cart-empty i { font-size: 40px; margin-bottom: 12px; display: block; opacity: .4; }
        .drawer-footer {
            padding: 16px 20px; border-top: 1px solid var(--border); flex-shrink: 0;
            background: var(--cream);
        }
        .cart-total-row {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;
        }
        .cart-total-label { font-size: 13px; color: var(--warm-gray); }
        .cart-total-amount {
            font-family: 'Inter', sans-serif;
            font-size: 1.3rem; font-weight: 600; color: var(--charcoal);
        }
        .btn-checkout {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; padding: 13px; background: var(--charcoal); color: #fff;
            border: none; border-radius: 30px; font-size: 13px; font-weight: 500;
            letter-spacing: .06em; text-decoration: none; cursor: pointer; transition: background .2s;
        }
        .btn-checkout:hover { background: var(--accent-dark); color: #fff; }

        /* ══ TOAST ════════════════════════════════════════════════════════════ */
        .toast-container-custom {
            position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%);
            z-index: 9999; display: flex; flex-direction: column; gap: 8px; pointer-events: none;
        }
        .toast-msg {
            background: var(--charcoal); color: #fff; padding: 11px 20px;
            border-radius: 30px; font-size: 13px; font-weight: 500;
            box-shadow: var(--shadow-lg); white-space: nowrap;
            animation: toastIn .3s ease, toastOut .3s ease 2.5s forwards;
        }
        .toast-msg.success { border-left: 3px solid #10B981; }
        .toast-msg.error   { border-left: 3px solid #C06B5A; }
        @keyframes toastIn  { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes toastOut { from { opacity:1; } to { opacity:0; } }

        /* ══ COMPAT classes vues existantes ══════════════════════════════════ */
        .container { max-width: 1400px; margin: 0 auto; padding: 0 1.5rem; }
        .text-center { text-align: center; }
        .mb-0{margin-bottom:0} .mb-3{margin-bottom:16px} .mb-4{margin-bottom:24px} .mt-4{margin-top:24px}
        .map-container { border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-md); }
        .map-container iframe { width: 100%; height: 380px; border: 0; }
        .map-btn {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--charcoal); color: #fff; padding: 12px 24px;
            border-radius: 30px; text-decoration: none; font-size: 13px;
            font-weight: 500; margin-top: 16px; transition: background .2s;
        }
        .map-btn:hover { background: var(--accent-dark); color: #fff; }
        .section-title {
            font-family: 'DM Sans', sans-serif;
            font-size: 1.6rem; font-weight: 600; color: var(--charcoal); margin: 0;
        }
        .footer { margin-top: 48px; padding: 24px 0; text-align: center; color: var(--warm-gray); font-size: 12px; border-top: 1px solid var(--border); }

        /* ══ RESPONSIVE ══════════════════════════════════════════════════════ */
    </style>
</head>
<body>

<!-- Sidebar drawer mobile (catégories) -->
<div class="sidebar-overlay" id="catOverlay"></div>
<div class="sidebar-drawer" id="catDrawer">
    <button class="drawer-close-cat" id="catDrawerClose"><i class="bi bi-x-lg"></i></button>
    <div style="clear:both;margin-bottom:1rem;"></div>
    <span class="filter-title">Catégories</span>
    <div id="mobileCatList">
        <div class="filter-item active" data-filter="" onclick="filterByCategory('', this)">
            <label>Tous les produits</label>
        </div>
        @isset($categories)
        @foreach($categories as $cat)
        <div class="filter-item" data-filter="{{ $cat->id }}" onclick="filterByCategory('{{ $cat->id }}', this)">
            <label>{{ $cat->nom }}</label>
            <span class="filter-count">{{ $cat->produits_count ?? '' }}</span>
        </div>
        @endforeach
        @endisset
    </div>
</div>

<!-- Cart overlay + drawer -->
<div class="cart-overlay" id="cartOverlay"></div>
<aside class="cart-drawer" id="cartDrawer" aria-label="Panier">
    <div class="drawer-header">
        <h2><i class="bi bi-bag" style="font-size:1rem;"></i> Mon Panier</h2>
        <button class="drawer-close" id="cartClose" aria-label="Fermer"><i class="bi bi-x"></i></button>
    </div>
    <div class="drawer-body" id="drawerBody">
        <div class="cart-empty">
            <i class="bi bi-bag"></i>
            <p>Votre panier est vide</p>
        </div>
    </div>
    <div class="drawer-footer" id="drawerFooter" style="display:none;">
        <div class="cart-total-row">
            <span class="cart-total-label">Total</span>
            <span class="cart-total-amount" id="drawerTotal">0 FCFA</span>
        </div>
        <a href="{{ route('boutique.checkout', $cabine->code ?? $page->cabine->code) }}" class="btn-checkout">
            <i class="bi bi-lock"></i> Commander
        </a>
    </div>
</aside>

<!-- Toast container -->
<div class="toast-container-custom" id="toastContainer"></div>

<!-- NAVBAR -->
<nav class="navbar-top" id="navbar">

    <button class="menu-toggle" id="menuToggle" aria-label="Menu"><i class="bi bi-list"></i></button>

    <div class="nav-social">
        @if($page->facebook)
        <a href="{{ $page->facebook }}" target="_blank" rel="noopener" title="Facebook"><i class="bi bi-facebook"></i></a>
        @endif
        @if($page->whatsapp)
        <a href="https://wa.me/{{ $page->whatsapp }}" target="_blank" rel="noopener" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
        @endif
        @if($page->instagram)
        <a href="{{ $page->instagram }}" target="_blank" rel="noopener" title="Instagram"><i class="bi bi-instagram"></i></a>
        @endif
    </div>

    <a href="{{ route('cabine.public', $cabine->code ?? $page->cabine->code) }}" class="brand-logo">
        @if($page->logo)
        <img src="{{ asset('storage/'.$page->logo) }}" alt="{{ $page->nom_site }}">
        @endif
        {{ $page->nom_site }}
    </a>

    <div class="nav-search" id="navSearch">
        <i class="bi bi-search search-icon"></i>
        <input type="text" id="navSearchInput"
               placeholder="Rechercher un produit..."
               autocomplete="off"
               aria-label="Rechercher un produit">
        <button class="search-clear" id="searchClear" aria-label="Effacer"><i class="bi bi-x-lg"></i></button>
        <div class="search-results" id="searchResults"></div>
    </div>

    <div class="nav-icons">
        <a href="{{ route('boutique.suivi', $cabine->code ?? $page->cabine->code) }}"
           class="nav-icon-btn" title="Suivre ma commande" aria-label="Suivi commande">
            <i class="bi bi-truck"></i>
        </a>
        <button class="nav-icon-btn" id="cartToggle" aria-label="Panier" style="position:relative;">
             <i class="bi bi-cart3"></i>
            <span class="cart-badge hidden" id="cartBadge">0</span>
        </button>
    </div>
</nav>

<div class="content">
    @yield('content')
</div>

<footer class="footer">
    <p>© {{ date('Y') }} {{ $page->nom_site }}. Tous droits réservés.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const CABINE_CODE = '{{ $cabine->code ?? $page->cabine->code }}';
const CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').content;

// ── État local du panier ──────────────────────────────────────────────────
let _cart = { items: [], total: 0, count: 0 };

// ── Navbar scroll ─────────────────────────────────────────────────────────
window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 10);
}, { passive: true });

// ── Toast ─────────────────────────────────────────────────────────────────
function showToast(msg, type = 'success') {
    const el = document.createElement('div');
    el.className = `toast-msg ${type}`;
    el.textContent = msg;
    document.getElementById('toastContainer').appendChild(el);
    setTimeout(() => el.remove(), 3000);
}

// ── Helpers ───────────────────────────────────────────────────────────────
function formatPrice(n) {
    return new Intl.NumberFormat('fr-FR').format(Math.round(n)) + ' FCFA';
}

function updateBadge(count) {
    const badge = document.getElementById('cartBadge');
    badge.textContent = count;
    badge.classList.toggle('hidden', count === 0);
    badge.style.transform = 'scale(1.5)';
    setTimeout(() => badge.style.transform = '', 250);
}

// ── Appliquer une réponse serveur ─────────────────────────────────────────
function applyData(data) {
    _cart.items = data.items || [];
    _cart.total = data.total || 0;
    _cart.count = data.count || 0;
    updateBadge(_cart.count);
    renderDrawer();
}

// ── Render drawer depuis l'état local (0 appel réseau) ───────────────────
function renderDrawer() {
    const body   = document.getElementById('drawerBody');
    const footer = document.getElementById('drawerFooter');

    if (!_cart.items.length) {
        body.innerHTML = `
            <div class="cart-empty">
                <i class="bi bi-bag" style="font-size:40px;display:block;margin-bottom:12px;opacity:.3;"></i>
                <p style="color:var(--warm-gray);font-size:14px;">Votre panier est vide</p>
            </div>`;
        footer.style.display = 'none';
        return;
    }

    body.innerHTML = _cart.items.map(item => {
        const sub = item.prix_unitaire * item.quantite;
        const img = item.image ? `/storage/${item.image}` : '/image-box.jpeg';
        return `
        <div class="cart-item" data-id="${item.produit_id}" style="animation:fadeItemIn .25s ease both;">
            <img class="cart-item-img" src="${img}" alt="${item.nom}"
                 onerror="this.src='/image-box.jpeg'">
            <div class="cart-item-info">
                <div class="cart-item-name">${item.nom}</div>
                <div class="cart-item-price">${formatPrice(item.prix_unitaire)} / unité</div>
                <div class="cart-item-controls">
                    <button class="qty-btn" onclick="changeQty(${item.produit_id}, -1)" aria-label="Diminuer">−</button>
                    <span class="qty-value">${item.quantite}</span>
                    <button class="qty-btn" onclick="changeQty(${item.produit_id}, 1)" aria-label="Augmenter">+</button>
                    <span style="margin-left:auto;font-size:12px;font-weight:600;color:var(--charcoal);">
                        ${formatPrice(sub)}
                    </span>
                </div>
            </div>
            <button class="cart-item-remove" onclick="removeItem(${item.produit_id})" aria-label="Supprimer">
                <i class="bi bi-trash3"></i>
            </button>
        </div>`;
    }).join('');

    document.getElementById('drawerTotal').textContent = formatPrice(_cart.total);
    footer.style.display = 'block';
}

// ── Sync initial depuis le serveur (1 seul appel au chargement) ───────────
function syncCart() {
    return fetch(`/boutique/${CABINE_CODE}/panier/data`, { credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => applyData(data))
        .catch(() => {});
}

// ── Ajouter au panier — INSTANTANÉ ───────────────────────────────────────
function addToCart(produitId, quantite, btn) {
    // 1. Feedback visuel immédiat sur le bouton
    if (btn) {
        btn.disabled = true;
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check2"></i> Ajouté !';
        btn.style.background = '#10B981';
        setTimeout(() => {
            btn.innerHTML = orig;
            btn.style.background = '';
            btn.disabled = false;
        }, 1800);
    }

    // 2. Mise à jour optimiste IMMÉDIATE de l'état local
    const existing = _cart.items.find(i => i.produit_id === produitId);
    if (existing) {
        existing.quantite += quantite;
        _cart.total += existing.prix_unitaire * quantite;
    } else {
        // On ajoute un item temporaire (sans image/nom complet) pour le badge
        _cart.items.push({ produit_id: produitId, nom: '...', prix_unitaire: 0, quantite, image: null });
    }
    _cart.count += quantite;
    updateBadge(_cart.count);
    // Ouvrir le drawer immédiatement avec l'état optimiste
    renderDrawer();
    openCartDrawer();

    // 3. POST serveur — la réponse contient items+total+count complets
    fetch(`/boutique/${CABINE_CODE}/panier/ajouter`, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ produit_id: produitId, quantite })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            applyData(data); // remplace l'état optimiste par les vraies données
            showToast('✓ Ajouté au panier');
        } else {
            showToast(data.message || 'Erreur', 'error');
            syncCart(); // resync pour corriger
        }
    })
    .catch(() => { showToast('Erreur réseau', 'error'); syncCart(); });
}

// ── Changer quantité — INSTANTANÉ ────────────────────────────────────────
function changeQty(produitId, delta) {
    const item = _cart.items.find(i => i.produit_id === produitId);
    if (!item) return;

    const newQty = Math.max(0, item.quantite + delta);

    // Mise à jour optimiste immédiate
    _cart.total += item.prix_unitaire * delta;
    _cart.count += delta;
    if (newQty === 0) {
        _cart.items = _cart.items.filter(i => i.produit_id !== produitId);
        _cart.total -= item.prix_unitaire * item.quantite; // correction
        _cart.count -= item.quantite;
        // recalcul propre
        _cart.total = _cart.items.reduce((s, i) => s + i.prix_unitaire * i.quantite, 0);
        _cart.count = _cart.items.reduce((s, i) => s + i.quantite, 0);
    } else {
        item.quantite = newQty;
    }
    updateBadge(_cart.count);
    renderDrawer();

    fetch(`/boutique/${CABINE_CODE}/panier/mettre-a-jour`, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ produit_id: produitId, quantite: newQty })
    })
    .then(r => r.json())
    .then(d => { if (d.success) applyData(d); else syncCart(); })
    .catch(() => syncCart());
}

// ── Supprimer un article — INSTANTANÉ ────────────────────────────────────
function removeItem(produitId) {
    // Animation de sortie
    const el = document.querySelector(`.cart-item[data-id="${produitId}"]`);
    if (el) {
        el.style.transition = 'all .2s ease';
        el.style.opacity = '0';
        el.style.transform = 'translateX(20px)';
    }

    // Mise à jour optimiste immédiate
    const item = _cart.items.find(i => i.produit_id === produitId);
    if (item) {
        _cart.total -= item.prix_unitaire * item.quantite;
        _cart.count -= item.quantite;
        _cart.items = _cart.items.filter(i => i.produit_id !== produitId);
    }
    setTimeout(() => { updateBadge(_cart.count); renderDrawer(); }, 200);

    fetch(`/boutique/${CABINE_CODE}/panier/supprimer`, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ produit_id: produitId })
    })
    .then(r => r.json())
    .then(d => { if (!d.success) syncCart(); })
    .catch(() => syncCart());
}

// ── Cart drawer ───────────────────────────────────────────────────────────
function openCartDrawer() {
    document.getElementById('cartDrawer').classList.add('open');
    document.getElementById('cartOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
    renderDrawer(); // affiche l'état local immédiatement, sans attendre le réseau
}
function closeCartDrawer() {
    document.getElementById('cartDrawer').classList.remove('open');
    document.getElementById('cartOverlay').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('cartToggle').addEventListener('click', e => {
    e.preventDefault();
    document.getElementById('cartDrawer').classList.contains('open')
        ? closeCartDrawer()
        : openCartDrawer();
});
document.getElementById('cartClose').addEventListener('click', closeCartDrawer);
document.getElementById('cartOverlay').addEventListener('click', closeCartDrawer);

// Fermer avec Escape
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeCartDrawer(); closeCatDrawer(); }
});

// ── Category sidebar (mobile) ─────────────────────────────────────────────
function openCatDrawer()  {
    document.getElementById('catDrawer').classList.add('open');
    document.getElementById('catOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeCatDrawer() {
    document.getElementById('catDrawer').classList.remove('open');
    document.getElementById('catOverlay').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('menuToggle').addEventListener('click', openCatDrawer);
document.getElementById('catDrawerClose').addEventListener('click', closeCatDrawer);
document.getElementById('catOverlay').addEventListener('click', closeCatDrawer);

// ── Product filter ────────────────────────────────────────────────────────
function filterByCategory(catId, el) {
    document.querySelectorAll('.category-chip, .filter-item').forEach(i => i.classList.remove('active'));
    if (el) el.classList.add('active');
    // Sync les chips desktop avec le filtre actif
    document.querySelectorAll(`.category-chip[data-filter="${catId}"]`).forEach(c => c.classList.add('active'));
    document.querySelectorAll('.product-card').forEach((p, i) => {
        const match = !catId || (p.dataset.category || '').toString() === catId.toString();
        p.style.display = match ? '' : 'none';
        if (match) p.style.animationDelay = `${i * 0.04}s`;
    });
    closeCatDrawer();
}
document.querySelectorAll('.category-chip').forEach(chip => {
    chip.addEventListener('click', () => filterByCategory(chip.dataset.filter, chip));
});

// ── Recherche produits en temps réel ─────────────────────────────────────
const searchInput = document.getElementById('productSearch');
if (searchInput) {
    searchInput.addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        document.querySelectorAll('.product-card').forEach(p => {
            const name = (p.dataset.name || '').toLowerCase();
            p.style.display = (!q || name.includes(q)) ? '' : 'none';
        });
    });
}

// ── Animation CSS pour les items du drawer ────────────────────────────────
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeItemIn {
        from { opacity:0; transform:translateX(-10px); }
        to   { opacity:1; transform:translateX(0); }
    }
    .cart-badge { transition: transform .25s cubic-bezier(.34,1.56,.64,1); }
`;
document.head.appendChild(style);

// ── Init : charge le panier au chargement ─────────────────────────────────
syncCart();

// ── Recherche produits dans la navbar ─────────────────────────────────────
(function () {
    const input    = document.getElementById('navSearchInput');
    const results  = document.getElementById('searchResults');
    const clearBtn = document.getElementById('searchClear');
    if (!input) return;

    // Données produits injectées depuis Blade (disponibles sur la page accueil)
    // On lit les product-cards du DOM pour éviter un appel API supplémentaire
    function getProducts() {
        return Array.from(document.querySelectorAll('.product-card')).map(card => ({
            id:       card.dataset.id || '',
            name:     card.dataset.name || '',
            category: card.querySelector('.product-cat')?.textContent?.trim() || '',
            price:    card.querySelector('.product-price, .price-badge')?.textContent?.trim() || '',
            img:      card.querySelector('img')?.src || '',
            url:      card.querySelector('a[href]')?.href || '#',
        }));
    }

    function renderResults(query) {
        if (!query) { results.classList.remove('open'); return; }

        const q = query.toLowerCase();
        const matches = getProducts().filter(p =>
            p.name.toLowerCase().includes(q) ||
            p.category.toLowerCase().includes(q)
        ).slice(0, 6);

        if (!matches.length) {
            results.innerHTML = `<div class="search-no-result">Aucun produit trouvé pour "<strong>${query}</strong>"</div>`;
        } else {
            results.innerHTML = matches.map(p => `
                <a class="search-result-item" href="${p.url}">
                    <img class="search-result-img" src="${p.img}" alt="${p.name}"
                         onerror="this.src='/image-box.jpeg'">
                    <div style="min-width:0;flex:1;">
                        <div class="search-result-name">${p.name}</div>
                        <div class="search-result-price">${p.price}</div>
                        <div class="search-result-cat">${p.category}</div>
                    </div>
                </a>`).join('');
        }
        results.classList.add('open');
    }

    // Aussi filtrer les cards visibles sur la page
    function filterCards(query) {
        const q = query.toLowerCase();
        let visible = 0;
        document.querySelectorAll('.product-card').forEach(card => {
            const match = !q || (card.dataset.name || '').toLowerCase().includes(q);
            card.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        const counter = document.getElementById('resultCount');
        if (counter) counter.textContent = visible + ' produit(s)';
    }

    let debounceTimer;
    input.addEventListener('input', function () {
        const q = this.value.trim();
        clearBtn.style.display = q ? 'block' : 'none';
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            renderResults(q);
            filterCards(q);
        }, 180);
    });

    clearBtn.addEventListener('click', () => {
        input.value = '';
        clearBtn.style.display = 'none';
        results.classList.remove('open');
        filterCards('');
        input.focus();
    });

    // Fermer le dropdown en cliquant ailleurs
    document.addEventListener('click', e => {
        if (!document.getElementById('navSearch').contains(e.target)) {
            results.classList.remove('open');
        }
    });

    // Navigation clavier dans les résultats
    input.addEventListener('keydown', e => {
        const items = results.querySelectorAll('.search-result-item');
        const active = results.querySelector('.search-result-item:focus');
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            (active ? active.nextElementSibling || items[0] : items[0])?.focus();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            (active ? active.previousElementSibling || items[items.length-1] : items[items.length-1])?.focus();
        } else if (e.key === 'Escape') {
            results.classList.remove('open');
            input.blur();
        }
    });
})();
</script>
@stack('scripts')
</body>
</html>
