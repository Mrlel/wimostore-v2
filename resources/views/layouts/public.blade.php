<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $page->nom_site . ' | ' . $page->cabine->nom_cab)</title>
    <link rel="icon" href="/static/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
            background: #000000;
            border-bottom: 1px solid var(--border);
            padding: 0 1.5rem;
            height: 62px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 200;
            backdrop-filter: blur(8px);
            transition: box-shadow .3s;
            border-radius: 0 0 10px 10px;
        }
        .navbar-top.scrolled { box-shadow: 0 2px 16px rgba(0,0,0,.07); }
        .nav-social { display: flex; align-items: center; gap: .2rem; }
        .nav-social a {
            font-size: 12px; color: var(--warm-gray); text-decoration: none;
            padding: 5px 10px; border-radius: 20px;
            display: flex; align-items: center; gap: .35rem;
            transition: background .2s, color .2s; white-space: nowrap;
        }
        .nav-social a:hover { background: var(--tag-bg); color: var(--charcoal); }
        .brand-logo {
            font-family: 'DM Sansr', sans-serif;
            font-size: 1.55rem; font-weight: 600;
            letter-spacing: .3em; color: white;
            text-decoration: none; white-space: nowrap;
            display: flex; align-items: center; gap: .5rem;
        }
        .brand-logo img { height: 32px; width: auto; border-radius: 6px; }
        .nav-icons { display: flex; align-items: center; gap: .2rem; }
        .nav-icons a {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1rem; text-decoration: none;
            position: relative; transition: background .2s, color .2s;
        }
        .nav-icons a:hover { background: var(--tag-bg); color: var(--accent); }
        .cart-btn { position: relative; }
        .cart-badge {
            position: absolute; top: 3px; right: 3px;
            background: var(--accent); color: #fff;
            font-size: 8px; width: 14px; height: 14px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: 600; line-height: 1;
            transition: transform .2s cubic-bezier(.34,1.56,.64,1);
        }
        .cart-badge.hidden { display: none; }
        .menu-toggle {
            display: none; background: none; border: none;
            font-size: 1.3rem; color: var(--charcoal); cursor: pointer; padding: 4px;
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
        @media (max-width: 991px) { .nav-social a span { display: none; } }
        @media (max-width: 767px) {
            .nav-social { display: none; }
            .menu-toggle { display: block; }
            .navbar-top { padding: 0 1rem; }
        }
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
    <div class="nav-social">
        <button class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></button>
        @if($page->facebook)
        <a href="{{ $page->facebook }}" target="_blank" rel="noopener">
            <i class="bi bi-facebook"></i> <span>Facebook</span>
        </a>
        @endif
        @if($page->whatsapp)
        <a href="https://wa.me/{{ $page->whatsapp }}" target="_blank" rel="noopener">
            <i class="bi bi-whatsapp"></i> <span>WhatsApp</span>
        </a>
        @endif
        @if($page->instagram)
        <a href="{{ $page->instagram }}" target="_blank" rel="noopener">
            <i class="bi bi-instagram"></i> <span>Instagram</span>
        </a>
        @endif
    </div>

    <a href="{{ route('cabine.public', $cabine->code ?? $page->cabine->code) }}" class="brand-logo">
        @if($page->logo)
        <img src="{{ asset('storage/'.$page->logo) }}" alt="">
        @endif
        {{ $page->nom_site }}
    </a>

    <div class="nav-icons">
        <a href="{{ route('boutique.suivi', $cabine->code ?? $page->cabine->code) }}"
           title="Suivre ma commande" aria-label="Suivi commande">
            <i class="bi bi-truck"></i>
        </a>
        <a href="#" class="cart-btn" id="cartToggle" aria-label="Panier">
            <i class="bi bi-bag"></i>
            <span class="cart-badge hidden" id="cartBadge">0</span>
        </a>
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

// ── État local du panier (miroir de la session serveur) ───────────────────
let _cartItems = [];
let _cartTotal = 0;
let _cartCount = 0;

// ── Navbar scroll ─────────────────────────────────────────────────────────
window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 10);
});

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
    // micro-animation
    badge.style.transform = 'scale(1.4)';
    setTimeout(() => badge.style.transform = '', 200);
}

// ── Render drawer depuis l'état local ─────────────────────────────────────
function renderDrawer() {
    const body   = document.getElementById('drawerBody');
    const footer = document.getElementById('drawerFooter');

    if (!_cartItems.length) {
        body.innerHTML = '<div class="cart-empty"><i class="bi bi-bag"></i><p>Votre panier est vide</p></div>';
        footer.style.display = 'none';
        return;
    }

    body.innerHTML = _cartItems.map(item => {
        const sub = item.prix_unitaire * item.quantite;
        const img = item.image ? `/storage/${item.image}` : '/image-box.jpeg';
        return `
        <div class="cart-item" data-id="${item.produit_id}">
            <img class="cart-item-img" src="${img}" alt="${item.nom}" onerror="this.src='/image-box.jpeg'">
            <div class="cart-item-info">
                <div class="cart-item-name">${item.nom}</div>
                <div class="cart-item-price">${formatPrice(item.prix_unitaire)} / unité</div>
                <div class="cart-item-controls">
                    <button class="qty-btn" onclick="changeQty(${item.produit_id}, -1)">−</button>
                    <span class="qty-value">${item.quantite}</span>
                    <button class="qty-btn" onclick="changeQty(${item.produit_id}, 1)">+</button>
                    <span style="margin-left:auto;font-size:12px;font-weight:600;color:var(--charcoal);">${formatPrice(sub)}</span>
                </div>
            </div>
            <button class="cart-item-remove" onclick="removeItem(${item.produit_id})" aria-label="Supprimer">
                <i class="bi bi-trash3"></i>
            </button>
        </div>`;
    }).join('');

    document.getElementById('drawerTotal').textContent = formatPrice(_cartTotal);
    footer.style.display = 'block';
}

// ── Appliquer une réponse serveur à l'état local ──────────────────────────
function applyServerData(data) {
    _cartItems = data.items || [];
    _cartTotal = data.total || 0;
    _cartCount = data.count || 0;
    updateBadge(_cartCount);
    renderDrawer();
}

// ── Fetch complet depuis le serveur (utilisé à l'init et à l'ouverture) ───
function syncCart() {
    return fetch(`/boutique/${CABINE_CODE}/panier/data`)
        .then(r => r.json())
        .then(data => applyServerData(data))
        .catch(() => {});
}

// ── Ajouter au panier ─────────────────────────────────────────────────────
function addToCart(produitId, quantite = 1, btn) {
    // 1. Feedback visuel immédiat sur le bouton
    if (btn) {
        btn.disabled = true;
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check2"></i> Ajouté';
        setTimeout(() => { btn.innerHTML = orig; btn.disabled = false; }, 1500);
    }

    // 2. Mise à jour optimiste du badge AVANT la réponse serveur
    const existing = _cartItems.find(i => i.produit_id === produitId);
    if (existing) {
        existing.quantite += quantite;
    } else {
        // on ne connaît pas encore le nom/prix, on incrémente juste le count
        _cartCount += quantite;
        updateBadge(_cartCount);
    }
    if (existing) {
        _cartCount += quantite;
        _cartTotal += existing.prix_unitaire * quantite;
        updateBadge(_cartCount);
        renderDrawer();
    }

    // 3. POST serveur — la réponse contient déjà items+total+count
    fetch(`/boutique/${CABINE_CODE}/panier/ajouter`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ produit_id: produitId, quantite })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('Ajouté au panier ✓');
            // Sync complet pour avoir les vraies données (nom, image, prix)
            syncCart().then(() => openCartDrawer());
        } else {
            showToast(data.message || 'Erreur', 'error');
            syncCart(); // resync pour corriger l'état optimiste
        }
    })
    .catch(() => { showToast('Erreur réseau', 'error'); syncCart(); });
}

// ── Changer quantité ──────────────────────────────────────────────────────
function changeQty(produitId, delta) {
    const item   = _cartItems.find(i => i.produit_id === produitId);
    const newQty = Math.max(0, (item ? item.quantite : 1) + delta);

    // Mise à jour optimiste immédiate
    if (item) {
        if (newQty === 0) {
            _cartItems = _cartItems.filter(i => i.produit_id !== produitId);
            _cartTotal -= item.prix_unitaire * item.quantite;
            _cartCount -= item.quantite;
        } else {
            _cartTotal += item.prix_unitaire * delta;
            _cartCount += delta;
            item.quantite = newQty;
        }
        updateBadge(_cartCount);
        renderDrawer();
    }

    fetch(`/boutique/${CABINE_CODE}/panier/mettre-a-jour`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ produit_id: produitId, quantite: newQty })
    })
    .then(r => r.json())
    .then(d => { if (d.success) applyServerData({ items: _cartItems, total: _cartTotal, count: _cartCount }); else syncCart(); })
    .catch(() => syncCart());
}

// ── Supprimer un article ──────────────────────────────────────────────────
function removeItem(produitId) {
    const item = _cartItems.find(i => i.produit_id === produitId);

    // Mise à jour optimiste immédiate
    if (item) {
        _cartTotal -= item.prix_unitaire * item.quantite;
        _cartCount -= item.quantite;
        _cartItems = _cartItems.filter(i => i.produit_id !== produitId);
        updateBadge(_cartCount);
        renderDrawer();
    }

    fetch(`/boutique/${CABINE_CODE}/panier/supprimer`, {
        method: 'POST',
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
    renderDrawer(); // affiche l'état local immédiatement
    syncCart();     // puis confirme avec le serveur en arrière-plan
}
function closeCartDrawer() {
    document.getElementById('cartDrawer').classList.remove('open');
    document.getElementById('cartOverlay').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('cartToggle').addEventListener('click', e => {
    e.preventDefault();
    document.getElementById('cartDrawer').classList.contains('open') ? closeCartDrawer() : openCartDrawer();
});
document.getElementById('cartClose').addEventListener('click', closeCartDrawer);
document.getElementById('cartOverlay').addEventListener('click', closeCartDrawer);

// ── Category sidebar (mobile) ─────────────────────────────────────────────
function openCatDrawer()  { document.getElementById('catDrawer').classList.add('open'); document.getElementById('catOverlay').classList.add('open'); document.body.style.overflow='hidden'; }
function closeCatDrawer() { document.getElementById('catDrawer').classList.remove('open'); document.getElementById('catOverlay').classList.remove('open'); document.body.style.overflow=''; }
document.getElementById('menuToggle').addEventListener('click', openCatDrawer);
document.getElementById('catDrawerClose').addEventListener('click', closeCatDrawer);
document.getElementById('catOverlay').addEventListener('click', closeCatDrawer);

// ── Product filter ────────────────────────────────────────────────────────
function filterByCategory(catId, el) {
    document.querySelectorAll('.category-chip, .filter-item').forEach(i => i.classList.remove('active'));
    if (el) el.classList.add('active');
    document.querySelectorAll(`.category-chip[data-filter="${catId}"]`).forEach(c => c.classList.add('active'));
    document.querySelectorAll('.product-card').forEach(p => {
        const match = !catId || (p.dataset.category||'').toString() === catId.toString();
        p.style.display = match ? '' : 'none';
    });
    closeCatDrawer();
}
document.querySelectorAll('.category-chip').forEach(chip => {
    chip.addEventListener('click', () => filterByCategory(chip.dataset.filter, chip));
});

// ── Init : charge le panier au chargement de la page ─────────────────────
syncCart();
</script>
@stack('scripts')
</body>
</html>
