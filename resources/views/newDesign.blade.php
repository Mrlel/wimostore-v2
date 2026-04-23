<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KINGKASH</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />

  <style>
    :root {
      --cream: #F8F6F1;
      --charcoal: #1A1A1A;
      --warm-gray: #8C8880;
      --accent: #C8A97E;
      --accent-dark: #A8895E;
      --border: #E8E4DC;
      --tag-bg: #F0EDE6;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--cream);
      color: var(--charcoal);
      font-size: 14px;
      -webkit-font-smoothing: antialiased;
    }

    /* ── NAVBAR ── */
    .navbar-top {
      background: var(--cream);
      border-bottom: 1px solid var(--border);
      padding: 0 1.5rem;
      height: 62px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 200;
      backdrop-filter: blur(8px);
    }

    .nav-social { display: flex; align-items: center; gap: .2rem; }
    .nav-social a {
      font-size: 12px;
      color: var(--warm-gray);
      text-decoration: none;
      padding: 5px 10px;
      border-radius: 20px;
      display: flex; align-items: center; gap: .35rem;
      transition: background .2s, color .2s;
      white-space: nowrap;
    }
    .nav-social a:hover { background: var(--tag-bg); color: var(--charcoal); }

    .brand-logo {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.55rem;
      font-weight: 600;
      letter-spacing: .3em;
      color: var(--charcoal);
      text-decoration: none;
      white-space: nowrap;
    }

    .nav-icons { display: flex; align-items: center; gap: .2rem; }
    .nav-icons a {
      width: 36px; height: 36px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: var(--charcoal);
      font-size: 1rem;
      text-decoration: none;
      position: relative;
      transition: background .2s, color .2s;
    }
    .nav-icons a:hover { background: var(--tag-bg); color: var(--accent); }
    .cart-badge {
      position: absolute;
      top: 3px; right: 3px;
      background: var(--accent);
      color: #fff;
      font-size: 8px;
      width: 14px; height: 14px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-weight: 600;
    }

    /* ── MOBILE MENU BTN ── */
    .menu-toggle {
      display: none;
      background: none;
      border: none;
      font-size: 1.3rem;
      color: var(--charcoal);
      cursor: pointer;
      padding: 4px;
    }

    /* ── HERO ── */
    .hero-wrap { padding: 1.5rem 1.5rem 0; }
    .hero-banner {
      border-radius: 16px;
      overflow: hidden;
      background: linear-gradient(135deg, #E8E2D8 0%, #D4C9B8 100%);
      height: 200px;
      display: flex;
      box-shadow: 0 4px 24px rgba(0,0,0,.06);
    }
    .hero-image-side {
      flex: 0 0 42%;
      background: url('https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=600&q=80') center/cover no-repeat;
      position: relative;
    }
    .hero-image-side::after {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(to right, transparent 55%, #E8E2D8);
    }
    .hero-content {
      flex: 1;
      padding: 1.8rem 2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .hero-label {
      font-size: 10px;
      letter-spacing: .2em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: .5rem;
    }
    .hero-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.7rem;
      font-weight: 600;
      line-height: 1.2;
      margin-bottom: .6rem;
    }
    .hero-sub {
      font-size: 12.5px;
      color: var(--warm-gray);
      line-height: 1.6;
    }

    /* ── SHOP LAYOUT ── */
    .shop-wrapper {
      display: flex;
      gap: 1.8rem;
      padding: 1.8rem 1.5rem 4rem;
      max-width: 1400px;
      margin: 0 auto;
    }

    /* ── SIDEBAR ── */
    .sidebar {
      flex: 0 0 190px;
      position: sticky;
      top: 72px;
      align-self: flex-start;
    }
    .filter-section { margin-bottom: 1.6rem; }
    .filter-title {
      font-size: 10px;
      letter-spacing: .18em;
      text-transform: uppercase;
      font-weight: 500;
      color: var(--charcoal);
      margin-bottom: .9rem;
      display: block;
    }
    .filter-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 5px 0;
      cursor: pointer;
    }
    .filter-item label {
      font-size: 13px;
      color: var(--warm-gray);
      cursor: pointer;
      transition: color .15s;
    }
    .filter-item:hover label { color: var(--charcoal); }
    .filter-count { font-size: 11px; color: #c0bbb5; }
    .filter-divider { border: none; border-top: 1px solid var(--border); margin: 1.2rem 0; }

    /* Mobile sidebar overlay */
    .sidebar-overlay {
      display: none;
      position: fixed; inset: 0;
      background: rgba(0,0,0,.4);
      z-index: 300;
    }
    .sidebar-overlay.open { display: block; }
    .sidebar-drawer {
      position: fixed;
      top: 0; left: -260px;
      width: 250px; height: 100%;
      background: var(--cream);
      z-index: 310;
      padding: 1.5rem;
      overflow-y: auto;
      transition: left .3s ease;
      box-shadow: 4px 0 20px rgba(0,0,0,.08);
    }
    .sidebar-drawer.open { left: 0; }
    .drawer-close {
      background: none; border: none;
      font-size: 1.2rem; cursor: pointer;
      color: var(--warm-gray);
      float: right; margin-bottom: 1rem;
    }

    .store-card h4 { font-size: 11px; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .5rem; font-weight: 600; }
    .store-card p { font-size: 12px; color: var(--warm-gray); margin-bottom: .8rem; line-height: 1.4; }
    .btn-maps {
      font-size: 11px;
      color: var(--accent);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: .4rem;
      font-weight: 500;
    }
    .btn-maps:hover { color: var(--accent-dark); }

    /* ── MAIN ── */
    .main-content { flex: 1; min-width: 0; }

    .collection-header {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      margin-bottom: 1.4rem;
      gap: 1rem;
      flex-wrap: wrap;
    }
    .breadcrumb-wink {
      font-size: 11.5px;
      color: var(--warm-gray);
      margin-bottom: .3rem;
    }
    .breadcrumb-wink span { color: var(--charcoal); }
    .collection-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.7rem;
      font-weight: 600;
      line-height: 1;
    }
    .sort-bar { display: flex; align-items: center; gap: .7rem; flex-wrap: wrap; }
    .result-count { font-size: 12px; color: var(--warm-gray); white-space: nowrap; }
    .sort-select {
      border: 1px solid var(--border);
      background: #fff;
      font-family: 'DM Sans', sans-serif;
      font-size: 12px;
      color: var(--charcoal);
      padding: 6px 12px;
      border-radius: 8px;
      outline: none;
      cursor: pointer;
    }
    .btn-filter {
      background: var(--charcoal);
      color: #fff;
      border: none;
      font-size: 11px;
      letter-spacing: .08em;
      padding: 7px 16px;
      border-radius: 20px;
      cursor: pointer;
      display: none;
      align-items: center;
      gap: .4rem;
      transition: background .2s;
      white-space: nowrap;
    }
    .btn-filter:hover { background: var(--accent-dark); }

    /* ── PRODUCT GRID ── */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.2rem;
    }

    .product-card {
      background: #faf7f7;
      border-radius: 12px;
      overflow: hidden;
      position: relative;
      cursor: pointer;
      transition: transform .25s, box-shadow .25s;
      animation: fadeUp .5s ease both;
    }
    .product-card:hover { transform: translateY(-4px); box-shadow: 0 12px 36px rgba(0,0,0,.09); }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(18px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .product-card:nth-child(1){animation-delay:.05s}
    .product-card:nth-child(2){animation-delay:.10s}
    .product-card:nth-child(3){animation-delay:.15s}
    .product-card:nth-child(4){animation-delay:.20s}
    .product-card:nth-child(5){animation-delay:.25s}
    .product-card:nth-child(6){animation-delay:.30s}
    .product-card:nth-child(7){animation-delay:.35s}
    .product-card:nth-child(8){animation-delay:.40s}
    .product-card:nth-child(9){animation-delay:.45s}

    .product-image-wrap {
      position: relative;
      overflow: hidden;
      aspect-ratio: 3/4;
      background: var(--tag-bg);
    }
    .product-image-wrap img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform .45s ease;
      display: block;
    }
    .product-card:hover .product-image-wrap img { transform: scale(1.06); }

    .product-badge {
      position: absolute;
      top: 10px; left: 10px;
      color: #fff;
      font-size: 9.5px;
      letter-spacing: .07em;
      padding: 3px 9px;
      border-radius: 20px;
      z-index: 2;
      font-weight: 500;
    }
    .product-badge.new  { background: var(--accent); }
    .product-badge.sale { background: #C06B5A; }

    .product-actions {
      position: absolute;
      bottom: 10px; right: 10px;
      display: flex; gap: .45rem;
      opacity: 0;
      transform: translateY(6px);
      transition: all .25s;
      z-index: 3;
    }
    .product-card:hover .product-actions { opacity: 1; transform: translateY(0); }

    .action-btn {
      width: 34px; height: 34px;
      border-radius: 50%;
      background: #fff;
      border: none;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      font-size: .9rem;
      color: var(--charcoal);
      box-shadow: 0 2px 10px rgba(0,0,0,.11);
      transition: background .2s, color .2s;
    }
    .action-btn:hover { background: var(--charcoal); color: #fff; }
    .action-btn.liked  { background: #C06B5A; color: #fff; }

    .product-info { padding: .85rem .9rem .9rem; }
    .product-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1rem;
      font-weight: 600;
      margin-bottom: .25rem;
      line-height: 1.3;
    }
    .product-desc {
      font-size: 11.5px;
      color: var(--warm-gray);
      line-height: 1.5;
      margin-bottom: .7rem;
    }
    .product-desc em { color: var(--accent); font-style: normal; }

    .product-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: .4rem;
    }
    .product-price { font-size: 13.5px; font-weight: 500; }
    .product-price .original {
      font-size: 11px;
      color: var(--warm-gray);
      text-decoration: line-through;
      margin-right: .25rem;
    }
    .product-price .sale-price { color: #C06B5A; }

    .footer-actions { display: flex; gap: .35rem; }
    .sm-btn {
      width: 28px; height: 28px;
      border-radius: 50%;
      border: 1px solid var(--border);
      background: transparent;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      font-size: .75rem;
      color: var(--warm-gray);
      transition: all .2s;
      flex-shrink: 0;
    }
    .sm-btn:hover { background: var(--charcoal); color: #fff; border-color: var(--charcoal); }

    .btn-add-cart {
      background: var(--charcoal);
      color: #fff;
      border: none;
      border-radius: 20px;
      padding: 6px 13px;
      font-size: 11px;
      letter-spacing: .05em;
      cursor: pointer;
      display: flex; align-items: center; gap: .35rem;
      transition: background .2s;
      white-space: nowrap;
      flex-shrink: 0;
    }
    .btn-add-cart:hover { background: var(--accent-dark); }

    /* ── PAGINATION ── */
    .pagination-wrap {
      display: flex;
      justify-content: center;
      margin-top: 2.2rem;
      gap: .35rem;
      flex-wrap: wrap;
    }
    .page-btn {
      width: 34px; height: 34px;
      border-radius: 8px;
      border: 1px solid var(--border);
      background: #fff;
      font-size: 12.5px;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      color: var(--warm-gray);
      transition: all .2s;
    }
    .page-btn:hover, .page-btn.active {
      background: var(--charcoal);
      color: #fff;
      border-color: var(--charcoal);
    }

    /* ══════════════════════════════
       RESPONSIVE BREAKPOINTS
    ══════════════════════════════ */

    /* ── Large desktop (1200px+): 4 cols — default ── */

    /* ── Tablet landscape / small desktop (992–1199px) ── */
    @media (max-width: 1199px) {
      .product-grid { grid-template-columns: repeat(3, 1fr); }
    }

    /* ── Tablet portrait (768–991px) ── */
    @media (max-width: 991px) {
      .sidebar { display: none; }
      .btn-filter { display: flex; }
      .product-grid { grid-template-columns: repeat(3, 1fr); }
      .nav-social a span { display: none; } /* icons only */
      .hero-banner { height: 180px; }
      .hero-title { font-size: 1.4rem; }
    }

    /* ── iPad / large phone (600–767px) ── */
    @media (max-width: 767px) {
      .nav-social { display: none; }
      .menu-toggle { display: block; }
      .hero-banner { height: 160px; }
      .hero-image-side { flex: 0 0 38%; }
      .hero-title { font-size: 1.25rem; }
      .hero-sub { display: none; }
      .product-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
      .shop-wrapper { padding: 1.2rem 1rem 3rem; }
      .hero-wrap { padding: 1rem 1rem 0; }
      .collection-header { gap: .6rem; }
      .sort-bar { gap: .5rem; }
      .result-count { display: none; }
    }

    /* ── Mobile (< 480px) ── */
    @media (max-width: 479px) {
      .navbar-top { padding: 0 1rem; }
      .brand-logo { font-size: 1.3rem; letter-spacing: .2em; }
      .hero-banner { height: auto; flex-direction: column; border-radius: 12px; }
      .hero-image-side {
        flex: 0 0 140px;
        width: 100%;
      }
      .hero-image-side::after {
        background: linear-gradient(to bottom, transparent 55%, #E8E2D8);
      }
      .hero-content { padding: 1.2rem 1.4rem 1.4rem; }
      .hero-title { font-size: 1.3rem; }
      .hero-sub { display: block; font-size: 12px; }
      .product-grid { grid-template-columns: repeat(2, 1fr); gap: .8rem; }
      .product-name { font-size: .92rem; }
      .product-desc { display: none; }
      .btn-add-cart { padding: 5px 10px; font-size: 10px; }
      .shop-wrapper { padding: 1rem .85rem 3rem; gap: 0; }
      .collection-title { font-size: 1.4rem; }
      .pagination-wrap { gap: .25rem; }
      .page-btn { width: 30px; height: 30px; font-size: 11px; }
    }

    /* ── Very small (< 360px) ── */
    @media (max-width: 359px) {
      .product-grid { grid-template-columns: 1fr; }
      .product-image-wrap { aspect-ratio: 4/3; }
    }
  </style>
</head>
<body>

<!-- ══════════ SIDEBAR DRAWER (mobile) ══════════ -->
<div class="sidebar-overlay" id="overlay"></div>
<div class="sidebar-drawer" id="drawer">
  <button class="drawer-close" id="drawerClose"><i class="bi bi-x-lg"></i></button>
  <div style="clear:both"></div>
  <div class="filter-section">
    <span class="filter-title">Produits disponibles</span>
    <div class="filter-item"><label>Sneakers</label><span class="filter-count">120</span></div>
    <div class="filter-item"><label>T-Shirts</label><span class="filter-count">34</span></div>
    <div class="filter-item"><label>Jassen</label><span class="filter-count">10</span></div>
    <div class="filter-item"><label>Broeken</label><span class="filter-count">8</span></div>
    <div class="filter-item"><label>Sweaters</label><span class="filter-count">8</span></div>
    <div class="filter-item"><label>Overhemden</label><span class="filter-count">6</span></div>
    <div class="filter-item"><label>Boots</label><span class="filter-count">5</span></div>
  </div>
</div>

<!-- ══════════ NAVBAR ══════════ -->
<nav class="navbar-top">
  <div class="nav-social">
    <button class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></button>
    <a href="#"><i class="bi bi-facebook"></i> <span>Facebook</span></a>
    <a href="#"><i class="bi bi-whatsapp"></i> <span>WhatsApp</span></a>
    <a href="#"><i class="bi bi-instagram"></i> <span>Instagram</span></a>
  </div>
  <a href="#" class="brand-logo">KINGKASH</a>
  <div class="nav-icons">
    <a href="#"><i class="bi bi-bell"></i></a>
    <a href="#">
      <i class="bi bi-bag"></i>
      <span class="cart-badge">3</span>
    </a>
    <a href="#"><i class="bi bi-truck"></i></a>
  </div>
</nav>

<!-- ══════════ HERO ══════════ -->
<div class="hero-wrap">
  <div class="hero-banner">
    <div class="hero-image-side"></div>
    <div class="hero-content">
      <p class="hero-label">— Collections</p>
      <h1 class="hero-title">Explore The Various<br>Collection of Wink</h1>
      <p class="hero-sub">Don't miss out to our shopping collection.<br>You'll not be let down.</p>
    </div>
  </div>
</div>

<!-- ══════════ SHOP WRAPPER ══════════ -->
<div class="shop-wrapper">

  <!-- Sidebar desktop -->
  <aside class="sidebar">
    <div class="filter-section">
      <span class="filter-title">Produits disponibles</span>
      <div class="filter-item"><label>Sneakers</label><span class="filter-count">120</span></div>
      <div class="filter-item"><label>T-Shirts</label><span class="filter-count">34</span></div>
      <div class="filter-item"><label>Jassen</label><span class="filter-count">10</span></div>
      <div class="filter-item"><label>Broeken</label><span class="filter-count">8</span></div>
      <div class="filter-item"><label>Sweaters</label><span class="filter-count">8</span></div>
      <div class="filter-item"><label>Overhemden</label><span class="filter-count">6</span></div>
      <div class="filter-item"><label>Boots</label><span class="filter-count">5</span></div>
    </div>
    <hr class="filter-divider">

      <div class="store-card">
        <h4>Notre Boutique</h4>
        <p>Avenue du Luxe, Abidjan<br>Ouvert de 09h à 20h</p>
        <a href="https://maps.google.com" target="_blank" class="btn-maps">
            <i class="bi bi-geo-alt"></i> Cliquer pour voir l'itinéraire
        </a>
    </div>

  </aside>

  <!-- Main -->
  <main class="main-content">

    <div class="collection-header">
      <div>
        <p class="breadcrumb-wink">Home › <span>Collection</span></p>
        <h2 class="collection-title">Nos Produits</h2>
      </div>
      <div class="sort-bar">
        <span class="result-count">248 produits</span>
        <select class="sort-select">
          <option>Sneakers</option>
          <option>T-Shirts</option>
          <option>Jassen</option>
          <option>Broeken</option>
          <option>Sweaters</option>
          <option>Overhemden</option>
          <option>Boots</option>
        </select>
        <button class="btn-filter" id="filterBtn"><i class="bi bi-sliders"></i> Filtrer</button>
      </div>
    </div>

    <!-- Grid -->
    <div class="product-grid">

      <div class="product-card">
        <div class="product-image-wrap">
          <span class="product-badge new">New</span>
          <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&q=80" alt="Japan Green Outer" loading="lazy" />
          <div class="product-actions">
            <button class="action-btn liked"><i class="bi bi-heart-fill"></i></button>
            <button class="action-btn"><i class="bi bi-bag-plus"></i></button>
          </div>
        </div>
        <div class="product-info">
          <p class="product-name">Japan Green Outer</p>
          <p class="product-desc">Silk and linen blend polo shirt with <em>stripes that fits slim</em></p>
          <div class="product-footer">
            <div class="product-price">399.000 FCFA</div>
            <button class="btn-add-cart"><i class="bi bi-bag-plus"></i> Ajouter</button>
          </div>
        </div>
      </div>

      <div class="product-card">
        <div class="product-image-wrap">
          <img src="https://images.unsplash.com/photo-1576871337622-98d48d1cf531?w=600&q=80" alt="Black to Basic Tee" loading="lazy" />
          <div class="product-actions">
            <button class="action-btn"><i class="bi bi-heart"></i></button>
            <button class="action-btn"><i class="bi bi-bag-plus"></i></button>
          </div>
        </div>
        <div class="product-info">
          <p class="product-name">Black to Basic Tee</p>
          <p class="product-desc">Silk and linen blend polo shirt with <em>stripes that fits slim</em></p>
          <div class="product-footer">
            <div class="product-price">150.000 FCFA</div>
            <div class="footer-actions">
              <button class="btn-add-cart"><i class="bi bi-bag-plus"></i> Ajouter</button>
            </div>
          </div>
        </div>
      </div>

      <div class="product-card">
        <div class="product-image-wrap">
          <img src="https://images.unsplash.com/photo-1511385348-a52b4a160dc2?w=600&q=80" alt="Soft Hoodie" loading="lazy" />
          <div class="product-actions">
            <button class="action-btn"><i class="bi bi-heart"></i></button>
            <button class="action-btn"><i class="bi bi-bag-plus"></i></button>
          </div>
        </div>
        <div class="product-info">
          <p class="product-name">Soft Hoodie</p>
          <p class="product-desc">Silk and linen blend polo shirt with <em>stripes that fits slim</em></p>
          <div class="product-footer">
            <div class="product-price">250.000 FCFA</div>
            <div class="footer-actions">
       <button class="btn-add-cart"><i class="bi bi-bag-plus"></i> Ajouter</button>
            </div>
          </div>
        </div>
      </div>

      <div class="product-card">
        <div class="product-image-wrap">
          <img src="https://images.unsplash.com/photo-1621072156002-e2fccdc0b176?w=600&q=80" alt="White Off Jacket 2024" loading="lazy" />
          <div class="product-actions">
            <button class="action-btn"><i class="bi bi-heart"></i></button>
            <button class="action-btn"><i class="bi bi-bag-plus"></i></button>
          </div>
        </div>
        <div class="product-info">
          <p class="product-name">White Off Jacket 2024</p>
          <p class="product-desc">Silk and linen blend polo shirt with <em>stripes that fits slim</em></p>
          <div class="product-footer">
            <div class="product-price">150.000 FCFA</div>
            <div class="footer-actions">
       <button class="btn-add-cart"><i class="bi bi-bag-plus"></i> Ajouter</button>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /product-grid -->

    <!-- Pagination -->
    <div class="pagination-wrap">
      <button class="page-btn"><i class="bi bi-chevron-left"></i></button>
      <button class="page-btn active">1</button>
      <button class="page-btn">2</button>
      <button class="page-btn">3</button>
      <button class="page-btn">…</button>
      <button class="page-btn">12</button>
      <button class="page-btn"><i class="bi bi-chevron-right"></i></button>
    </div>

  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Heart toggle
  document.querySelectorAll('.sm-btn, .action-btn').forEach(btn => {
    const icon = btn.querySelector('i');
    if (!icon || (!icon.classList.contains('bi-heart') && !icon.classList.contains('bi-heart-fill'))) return;
    btn.addEventListener('click', function () {
      const i = this.querySelector('i');
      const liked = i.classList.contains('bi-heart-fill');
      i.classList.toggle('bi-heart', liked);
      i.classList.toggle('bi-heart-fill', !liked);
      this.style.background = liked ? '' : '#C06B5A';
      this.style.color = liked ? '' : '#fff';
      this.style.borderColor = liked ? '' : '#C06B5A';
    });
  });

  // Mobile drawer
  const overlay   = document.getElementById('overlay');
  const drawer    = document.getElementById('drawer');
  const filterBtn = document.getElementById('filterBtn');
  const menuToggle= document.getElementById('menuToggle');
  const closeBtn  = document.getElementById('drawerClose');

  function openDrawer()  { drawer.classList.add('open'); overlay.classList.add('open'); }
  function closeDrawer() { drawer.classList.remove('open'); overlay.classList.remove('open'); }

  if (filterBtn)  filterBtn.addEventListener('click', openDrawer);
  if (menuToggle) menuToggle.addEventListener('click', openDrawer);
  if (closeBtn)   closeBtn.addEventListener('click', closeDrawer);
  overlay.addEventListener('click', closeDrawer);
</script>
</body>
</html>