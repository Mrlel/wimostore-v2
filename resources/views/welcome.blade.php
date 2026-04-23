<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Wimostock – Vente en Ligne & Gestion de Stock Intelligente</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    :root {
      --orange: #f0c61dff;
      --orange-light: #e5c703ff;
      --teal: #000000ff;
      --teal-dark: #000000ff;
      --teal-light: #0d0e0eff;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--warm-white);
      color: var(--text-dark);
      overflow-x: hidden;
    }

    /* ── TOPBAR ── */
    .topbar {
      background: var(--teal-dark);
      color: #fff;
      font-size: 0.78rem;
      padding: 8px 0;
      letter-spacing: 0.02em;
      max-width: 1250px;
      border-radius: 0 0 8px 8px;
      margin: auto;
    }
    .topbar a { color: #cce8e5; text-decoration: none; }
    .topbar a:hover { color: var(--orange-light); }
    .topbar .social-icons a {
      display: inline-flex; align-items: center; justify-content: center;
      width: 26px; height: 26px; border-radius: 50%;
      background: rgba(255,255,255,0.1);
      color: #fff; margin-left: 5px; transition: background 0.2s;
    }
    .topbar .social-icons a:hover { background: var(--orange); }

    /* ── NAVBAR ── */
    .navbar {
      background: #fff;
      padding: 14px 0;
      position: sticky; top: 0; z-index: 1000;
    }
    .navbar-brand { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: var(--teal-dark) !important; text-decoration:none; }
    .navbar-brand span { color: var(--orange); }
    .nav-link { color: var(--text-dark) !important; font-weight: 500; font-size: 0.9rem; padding: 6px 14px !important; border-radius: 6px; transition: color 0.2s; }
    .nav-link:hover, .nav-link.active { color: var(--orange) !important; }
    .btn-donate {
      background: var(--orange);
      color: #000000ff !important;
      border-radius: 50px;
      padding: 10px 26px !important;
      font-weight: 600;
      font-size: 0.85rem;
      letter-spacing: 0.05em;
      transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 4px 14px rgba(240,106,29,0.35);
    }
    .btn-donate:hover { background: var(--orange-light); color: #000000ff !important; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(240,106,29,0.45); }

    /* ── HERO ── */
    .hero {
      background: linear-gradient(135deg, var(--teal-dark) 0%, var(--teal) 55%, #1e7068 100%);
      min-height: 88vh;
      position: relative;
      overflow: hidden;
      display: flex; align-items: center;
      max-width: 1250px;
      border-radius: 11px;
      margin: auto;
    }
    .hero::before {
      content: '';
      position: absolute; inset: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .hero-blob {
      position: absolute; right: -60px; top: 50%; transform: translateY(-50%);
      width: 55%; max-width: 680px; height: 105%;
      border-radius: 40% 0 0 40%;
      overflow: hidden;
    }
    .hero-blob img {
      width: 100%; height: 100%;
      object-fit: cover; object-position: center;
      opacity: 0.85;
      mix-blend-mode: luminosity;
      filter: sepia(10%) saturate(90%);
    }
    .hero-blob::after {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(90deg, var(--teal) 0%, transparent 40%);
    }
    .hero-content { position: relative; z-index: 2; }
    .hero-eyebrow {
      font-size: 0.78rem; font-weight: 600; letter-spacing: 0.18em;
      color: var(--orange-light); text-transform: uppercase; margin-bottom: 18px;
      display: flex; align-items: center; gap: 8px;
    }
    .hero-eyebrow::before { content: ''; display: inline-block; width: 28px; height: 2px; background: var(--orange-light); }
    .hero h1 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.6rem, 5vw, 4rem);
      font-weight: 900;
      color: #fff;
      line-height: 1.12;
      margin-bottom: 22px;
    }
    .hero h1 em { font-style: normal; color: var(--orange-light); }
    .hero p { color: rgba(255,255,255,0.75); font-size: 1rem; line-height: 1.7; max-width: 420px; margin-bottom: 36px; }
    .btn-hero-primary {
      background: var(--orange);
      color: #fff;
      border: none;
      border-radius: 50px;
      padding: 14px 34px;
      font-weight: 600;
      font-size: 0.9rem;
      letter-spacing: 0.04em;
      text-decoration: none;
      transition: all 0.25s;
      box-shadow: 0 6px 24px rgba(240,106,29,0.4);
    }
    .btn-hero-primary:hover { background: var(--orange-light); transform: translateY(-2px); color: #fff; }
    .hero-stats {
      display: flex; gap: 36px; margin-top: 52px;
      padding-top: 32px;
      border-top: 1px solid rgba(255,255,255,0.12);
    }
    .hero-stat-value { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 900; color: #fff; }
    .hero-stat-label { font-size: 0.78rem; color: rgba(255,255,255,0.6); letter-spacing: 0.05em; }

    /* ── TRUST BAR ── */
    .trust-bar {
      background: #fff;
      padding: 32px 0;
    }
    .trust-item {
      display: flex; align-items: center; gap: 14px;
      padding: 10px 20px;
      border-right: 1px solid #f0ece6;
    }
    .trust-item:last-child { border-right: none; }
    .trust-icon {
      width: 48px; height: 48px; border-radius: 14px;
      background: linear-gradient(135deg, #fff5ee, #ffe8d6);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.3rem; color: var(--orange); flex-shrink: 0;
    }
    .trust-title { font-weight: 700; font-size: 0.95rem; color: var(--text-dark); }
    .trust-sub { font-size: 0.8rem; color: var(--text-muted); }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.7s ease both; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.22s; }
    .delay-4 { animation-delay: 0.46s; }

    /* ── RESPONSIVE ── */

    /* Tablette (≤991px) */
    @media (max-width: 991px) {
      .hero-blob { display: none; }
      .hero h1 { font-size: 2.2rem; }

      .hero {
        min-height: 70vh;
        border-radius: 8px;
        padding: 48px 0;
      }

      .hero-stats {
        gap: 20px;
        margin-top: 36px;
      }

      .trust-item {
        border-right: none;
        border-bottom: 1px solid #f0ece6;
        padding: 16px 10px;
      }
      .trust-item:last-child { border-bottom: none; }

      /* Topbar : centrer sur tablette */
      .topbar .container > div {
        justify-content: center !important;
        text-align: center;
      }

      /* Footer */
      footer .d-flex {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 12px !important;
      }
    }

    /* Mobile (≤767px) */
    @media (max-width: 767px) {

      /* Topbar */
      .topbar {
        border-radius: 0;
        font-size: 0.72rem;
        padding: 6px 0;
      }
      .topbar .container > div {
        flex-direction: column !important;
        align-items: center !important;
        gap: 6px !important;
        text-align: center;
      }
      .topbar .d-flex.align-items-center.gap-3 {
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px !important;
      }

      /* Navbar */
      .navbar { padding: 10px 0; }
      .navbar-brand { font-size: 1.3rem; }
      .navbar-collapse {
        background: #fff;
        border-top: 1px solid #f0ece6;
        padding: 12px 0;
        margin-top: 8px;
      }
      .navbar-collapse .navbar-nav {
        padding: 0 8px;
      }
      .btn-donate {
        margin: 10px 14px 4px;
        display: block;
        text-align: center;
      }

      /* Hero */
      .hero {
        min-height: auto;
        border-radius: 0;
        padding: 52px 0 40px;
        margin: 0;
      }
      .hero h1 {
        font-size: 2rem;
        line-height: 1.18;
      }
      .hero p {
        font-size: 0.92rem;
        max-width: 100%;
      }
      .hero-stats {
        flex-wrap: wrap;
        gap: 20px 28px;
        margin-top: 30px;
        padding-top: 22px;
      }
      .hero-stat-value { font-size: 1.5rem; }

      /* Trust bar */
      .trust-bar { padding: 20px 0; }
      .trust-item {
        padding: 14px 8px;
        flex-direction: row;
      }

      /* Features section */
      #features {
        border-radius: 0 !important;
        margin: 0 !important;
      }
      #features .container { padding-top: 36px !important; padding-bottom: 24px !important; }
      #features h2 { font-size: 1.8rem !important; }

      /* Feature cards */
      #features .row.g-4 > [class*="col-"] .p-4 {
        padding: 20px !important;
      }

      /* Preview section */
      #preview {
        border-radius: 0 !important;
        margin: 24px 0 !important;
      }
      #preview .container { padding-top: 36px !important; padding-bottom: 36px !important; }
      #preview h2 { font-size: 1.8rem !important; }
      #preview .col-lg-5 { margin-bottom: 32px; }

      /* Footer */
      footer {
        margin: 0 0 20px !important;
        border-radius: 0 !important;
      }
      footer .d-flex {
        flex-direction: column !important;
        align-items: center !important;
        text-align: center;
        gap: 10px !important;
      }
    }

    /* Très petits mobiles (≤400px) */
    @media (max-width: 400px) {
      .hero h1 { font-size: 1.75rem; }
      .hero-stats { gap: 14px 20px; }
      .hero-stat-value { font-size: 1.3rem; }
      #features h2 { font-size: 1.5rem !important; }
      #preview h2 { font-size: 1.5rem !important; }
    }
  </style>
</head>
<body>

<div class="topbar">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div class="d-flex align-items-center gap-3">
        <span><i class="bi bi-rocket-takeoff-fill me-1 text-warning"></i> BOOSTEZ VOTRE COMMERCE AVEC WIMOSTOCK</span>
      </div>
      <div class="d-flex align-items-center gap-3">
        <a href="tel:+22500000000"><i class="bi bi-telephone me-1"></i>+225 05 85 98 61 00</a>
        <div class="social-icons">
          <a href="#"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>

<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">
        Wimo<span>Stock</span>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <i class="bi bi-list fs-4"></i>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav mx-auto gap-1">
        <li class="nav-item"><a class="nav-link active" href="#">Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="#features">Fonctionnalités</a></li>
        <li class="nav-item"><a class="nav-link" href="#preview">Aperçu</a></li>
      </ul>
      <a href="{{ Route('login') }}" class="btn-donate nav-link">Se Connecter</a>
    </div>
  </div>
</nav>

<section class="hero" id="home">
  <div class="hero-blob">
    <img src="blv.jfif" alt="Gestion de stock">
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="hero-content">
          
          <h1 class="fade-up delay-1">
            Gérez votre stock <em>et vendez partout</em><br>avec votre<br><em> mini e-commerce intégré.</em>
          </h1>

          <div class="hero-stats fade-up delay-4">
            <div>
              <div class="hero-stat-value">50+</div>
              <div class="hero-stat-label">BOUTIQUES </div>
            </div>
            <div>
              <div class="hero-stat-value">99.9%</div>
              <div class="hero-stat-label">DISPONIBILITÉ</div>
            </div>
            <div>
              <div class="hero-stat-value">24/7</div>
              <div class="hero-stat-label">SUIVI EN DIRECT</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="trust-bar">
  <div class="container">
    <div class="row g-0">
      <div class="col-md-4">
        <div class="trust-item">
          <div class="trust-icon"><i class="bi bi-shop"></i></div>
          <div>
           <div class="trust-title">Vente en ligne + POS</div>
            <div class="trust-sub">En boutique et sur internet</div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="trust-item">
          <div class="trust-icon"><i class="bi bi-box-seam"></i></div>
          <div>
            <div class="trust-title">Stock Intelligent</div>
            <div class="trust-sub">Alertes de rupture auto</div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="trust-item">
          <div class="trust-icon"><i class="bi bi-graph-up-arrow"></i></div>
          <div>
            <div class="trust-title">Rapports Détaillés</div>
            <div class="trust-sub">Analysez vos performances</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<section id="features" class="mb-4" style="max-width: 1250px; margin: 0 auto; background: #fcfaf8; border-radius: 11px;">
  <div class="container py-4">
    <div class="text-center mb-5">
      <h2 style="font-family: 'Playfair Display', serif; font-weight: 900; color: var(--teal-dark); font-size: 2.5rem;">
        Tout pour piloter votre <span>Croissance</span>
      </h2>
      <p style="color: var(--text-muted); max-width: 600px; margin: 0 auto;">
        Une solution complète, pensée pour les commerçants exigeants qui veulent gagner du temps.
      </p>
    </div>

    <div class="row g-4 px-lg-4">
        
        <div class="col-lg-4 col-md-6">
        <div class="p-4 h-100" style="background: #fff; border: 1px solid #f0ece6; border-radius: 16px;">
            <div style="color: var(--orange); font-size: 2rem; margin-bottom: 20px;">
            <i class="bi bi-globe2"></i>
            </div>
            <h4 style="font-weight: 700; font-size: 1.2rem; color: var(--teal-dark);">
            Boutique en ligne intégrée
            </h4>
            <p style="font-size: 0.9rem; color: #666; line-height: 1.6;">
            Vendez vos produits en ligne sans créer de site web. Partagez simplement votre catalogue avec vos clients.
            </p>
        </div>
        </div>
      <div class="col-lg-4 col-md-6">
        <div class="p-4 h-100" style="background: #fff; border: 1px solid #f0ece6; border-radius: 16px;">
          <div style="color: var(--orange); font-size: 2rem; margin-bottom: 20px;"><i class="bi bi-shield-check"></i></div>
          <h4 style="font-weight: 700; font-size: 1.2rem; color: var(--teal-dark);">Sécurité Totale</h4>
          <p style="font-size: 0.9rem; color: #666; line-height: 1.6;">Vos données sont cryptées et sauvegardées quotidiennement. Gardez le contrôle total.</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mx-md-auto">
        <div class="p-4 h-100" style="background: #fff; border: 1px solid #f0ece6; border-radius: 16px;">
          <div style="color: var(--orange); font-size: 2rem; margin-bottom: 20px;"><i class="bi bi-phone"></i></div>
          <h4 style="font-weight: 700; font-size: 1.2rem; color: var(--teal-dark);">Multi-Support</h4>
          <p style="font-size: 0.9rem; color: #666; line-height: 1.6;">Gérez votre boutique depuis votre smartphone, tablette ou ordinateur partout.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="preview" class="py-5 mb-5" style="max-width: 1250px; margin: 60px auto; background: #000; border-radius: 11px; overflow: hidden;">
  <div class="container py-5">
    <div class="row align-items-center px-lg-4">
      <div class="col-lg-5 mb-5 mb-lg-0">
        <span style="color: var(--orange); font-weight: 700; font-size: 0.8rem; letter-spacing: 0.1em; text-transform: uppercase;">Interface Moderne</span>
        <h2 class="mt-3 mb-4" style="font-family: 'Playfair Display', serif; font-weight: 900; color: #fff; font-size: 2.5rem; line-height: 1.2;">
          Une clarté visuelle pour des décisions <em style="font-style: normal; color: var(--orange-light);">Efficaces</em>
        </h2>
        <ul class="list-unstyled" style="color: rgba(255,255,255,0.8);">
          <li class="mb-3 d-flex align-items-start gap-2">
            <i class="bi bi-check2-circle text-warning fs-5"></i>
            <span><strong class="text-white">Dashboard dynamique :</strong> Visualisez vos bénéfices en temps réel.</span>
          </li>
          <li class="mb-3 d-flex align-items-start gap-2">
  <i class="bi bi-check2-circle text-warning fs-5"></i>
  <span><strong class="text-white">Commandes en ligne :</strong> Recevez et traitez les achats clients automatiquement.</span>
</li>
          <li class="mb-3 d-flex align-items-start gap-2">
            <i class="bi bi-check2-circle text-warning fs-5"></i>
            <span><strong class="text-white">Stocks :</strong> Suivi précis des entrées et sorties par article.</span>
          </li>
        </ul>
        <a href="{{ Route('register') }}" class="btn-hero-primary" style="display: inline-block; padding: 12px 30px;">Créer ma boutique gratuitement</a>
      </div>
      <div class="col-lg-7">
        <div style="position: relative; padding: 10px; background: rgba(255,255,255,0.1); border-radius: 20px; backdrop-filter: blur(10px);">
          <img src="/preview.png" 
               alt="Aperçu Wimostock" 
               class="img-fluid" 
               style="border-radius: 12px; opacity: 0.9;">
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="py-4" style="max-width: 1250px; margin: 0 auto 40px; color: var(--text-dark); font-size: 0.85rem;">
  <div class="container text-center text-md-start">
<div class="d-flex justify-content-center align-items-center flex-wrap gap-3">
        <p class="mb-0 text-center"><strong>Wimo<span>Stock</span></strong> &copy; 2026. Tous droits réservés.</p>
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>