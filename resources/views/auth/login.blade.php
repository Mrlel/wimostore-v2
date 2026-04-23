<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Wimostock – Connexion</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --orange: #f0c61d;
      --orange-light: #e5c703;
      --orange-glow: rgba(240, 198, 29, 0.25);
      --teal: #000000;
      --teal-dark: #000000;
      --card-bg: #ffffff;
      --text-dark: #111111;
      --text-muted: #888;
      --border: #f0ece6;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #0a0a0a;
      color: var(--text-dark);
      min-height: 100vh;
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
    }

    /* ── NAVBAR ── */
    .navbar-auth {
      position: relative;
      z-index: 10;
      padding: 16px 0;
    }
    .navbar-brand {
      font-family: 'Playfair Display', serif;
      font-size: 1.6rem;
      font-weight: 900;
      color: #fff !important;
      text-decoration: none;
      letter-spacing: -0.01em;
    }
    .navbar-brand span { color: var(--orange); }

    /* ── MAIN LAYOUT ── */
    .auth-wrapper {
      position: relative;
      z-index: 5;
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 16px 60px;
    }

    .auth-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      max-width: 1000px;
      width: 100%;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 40px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(240,198,29,0.1);
    }

    /* ── LEFT PANEL ── */
    .auth-left {
      background: linear-gradient(145deg, #111 0%, #0d0d0d 100%);
      padding: 52px 44px;
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .auth-left::before {
      content: '';
      position: absolute;
      top: -60px; right: -60px;
      width: 280px; height: 280px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(240,198,29,0.12) 0%, transparent 70%);
      pointer-events: none;
    }
    .auth-left::after {
      content: '';
      position: absolute;
      bottom: -40px; left: -40px;
      width: 200px; height: 200px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(240,198,29,0.07) 0%, transparent 70%);
      pointer-events: none;
    }

    .auth-left-eyebrow {
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.2em;
      color: var(--orange);
      text-transform: uppercase;
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 28px;
    }
    .auth-left-eyebrow::before {
      content: '';
      display: inline-block;
      width: 24px; height: 2px;
      background: var(--orange);
    }

    .auth-left h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.4rem;
      font-weight: 900;
      color: #fff;
      line-height: 1.15;
      margin-bottom: 20px;
      position: relative;
      z-index: 1;
    }
    .auth-left h2 em {
      font-style: normal;
      color: var(--orange);
    }

    .auth-left p {
      color: rgba(255,255,255,0.55);
      font-size: 0.9rem;
      line-height: 1.7;
      position: relative;
      z-index: 1;
      max-width: 300px;
    }

    .auth-left-stats {
      display: flex;
      gap: 28px;
      margin-top: 40px;
      padding-top: 28px;
      border-top: 1px solid rgba(255,255,255,0.08);
      position: relative;
      z-index: 1;
    }
    .auth-left-stat-value {
      font-family: 'Playfair Display', serif;
      font-size: 1.5rem;
      font-weight: 900;
      color: #fff;
    }
    .auth-left-stat-label {
      font-size: 0.7rem;
      color: rgba(255,255,255,0.45);
      letter-spacing: 0.06em;
      text-transform: uppercase;
    }

    .auth-left-features {
      margin-top: 32px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      position: relative;
      z-index: 1;
    }
    .auth-left-feature {
      display: flex;
      align-items: center;
      gap: 12px;
      color: rgba(255,255,255,0.7);
      font-size: 0.88rem;
    }
    .auth-left-feature i {
      color: var(--orange);
      font-size: 1rem;
      flex-shrink: 0;
    }

    /* ── RIGHT PANEL (FORM) ── */
    .auth-right {
      background: #fff;
      padding: 52px 44px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .auth-right-header {
      margin-bottom: 32px;
    }
    .auth-right-header h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1.9rem;
      font-weight: 900;
      color: var(--teal-dark);
      margin-bottom: 6px;
    }
    .auth-right-header p {
      color: var(--text-muted);
      font-size: 0.88rem;
    }
    .auth-right-header p a {
      color: var(--orange-light);
      font-weight: 600;
      text-decoration: none;
    }
    .auth-right-header p a:hover { text-decoration: underline; }

    /* ── FORM FIELDS ── */
    .form-label {
      font-weight: 600;
      font-size: 0.83rem;
      color: #333;
      margin-bottom: 7px;
      display: block;
    }

    .input-with-icon {
      position: relative;
    }
    .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #bbb;
      font-size: 0.85rem;
      pointer-events: none;
      transition: color 0.2s;
      z-index: 2;
    }

    .form-control-custom {
      width: 100%;
      padding: 11px 42px 11px 38px;
      border: 1.5px solid #eee;
      border-radius: 10px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.88rem;
      color: var(--text-dark);
      background: #fafafa;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
      outline: none;
    }
    .form-control-custom:focus {
      border-color: var(--orange);
      box-shadow: 0 0 0 3px var(--orange-glow);
      background: #fff;
    }
    .form-control-custom:focus + .input-icon,
    .input-with-icon:focus-within .input-icon {
      color: var(--orange);
    }
    .form-control-custom::placeholder { color: #ccc; }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #bbb;
      cursor: pointer;
      padding: 4px;
      display: flex;
      align-items: center;
      transition: color 0.2s;
      z-index: 2;
    }
    .toggle-password:hover { color: var(--orange); }

    /* ── REMEMBER / FORGOT ── */
    .form-check-input:checked {
      background-color: var(--orange);
      border-color: var(--orange);
    }
    .form-check-input:focus {
      box-shadow: 0 0 0 3px var(--orange-glow);
      border-color: var(--orange);
    }
    .link-yellow {
      color: var(--orange-light);
      font-weight: 600;
      text-decoration: none;
      font-size: 0.82rem;
    }
    .link-yellow:hover { text-decoration: underline; color: var(--orange-light); }

    /* ── SUBMIT BUTTON ── */
    .btn-primary-custom {
      width: 100%;
      background: var(--teal-dark);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 13px 24px;
      font-family: 'DM Sans', sans-serif;
      font-weight: 600;
      font-size: 0.92rem;
      letter-spacing: 0.03em;
      cursor: pointer;
      transition: all 0.25s;
      position: relative;
      overflow: hidden;
    }
    .btn-primary-custom::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, var(--orange) 0%, var(--orange-light) 100%);
      opacity: 0;
      transition: opacity 0.25s;
    }
    .btn-primary-custom:hover::before { opacity: 1; }
    .btn-primary-custom:hover { color: #000; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(240,198,29,0.35); }
    .btn-primary-custom span, .btn-primary-custom i { position: relative; z-index: 1; }

    /* ── DIVIDER ── */
    .auth-divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 20px 0;
      color: #ddd;
      font-size: 0.78rem;
    }
    .auth-divider::before, .auth-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #eee;
    }

    /* ── FOOTER ── */
    .auth-footer {
      position: relative;
      z-index: 5;
      text-align: center;
      padding: 16px;
      color: rgba(255,255,255,0.3);
      font-size: 0.75rem;
    }
    .auth-footer a { color: rgba(255,255,255,0.4); text-decoration: none; }
    .auth-footer a:hover { color: var(--orange); }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .auth-container { animation: fadeUp 0.6s ease both; }

    /* ── RESPONSIVE ── */
    @media (max-width: 767px) {
      .auth-container {
        grid-template-columns: 1fr;
        border-radius: 16px;
      }
      .auth-left { display: none; }
      .auth-right { padding: 36px 28px; }
      .auth-wrapper { padding: 24px 12px 40px; }
    }
  </style>
</head>
<body>


<!-- NAVBAR -->
<nav class="navbar-auth">
  <div class="container d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="/">Wimo<span>Stock</span></a>
    <a href="/" class="d-flex align-items-center gap-2 text-decoration-none" style="color: rgba(255,255,255,0.5); font-size: 0.85rem; transition: color 0.2s;"
       onmouseover="this.style.color='#f0c61d'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">
      <i class="bi bi-arrow-left"></i> Retour à l'accueil
    </a>
  </div>
</nav>

<!-- AUTH WRAPPER -->
<div class="auth-wrapper">
  <div class="auth-container">

    <!-- LEFT PANEL -->
    <div class="auth-left">
      <div>
        <div class="auth-left-eyebrow">Connexion sécurisée</div>
        <h2>Reprenez le<br>contrôle de votre <em>business</em></h2>
        <p>Votre tableau de bord vous attend. Gérez stocks, ventes et performances en un seul endroit.</p>

        <div class="auth-left-features">
          <div class="auth-left-feature">
            <i class="bi bi-cart-check-fill"></i>
            <span>Interface POS ultra-rapide</span>
          </div>
          <div class="auth-left-feature">
            <i class="bi bi-box-seam-fill"></i>
            <span>Alertes de rupture de stock en temps réel</span>
          </div>
          <div class="auth-left-feature">
            <i class="bi bi-graph-up-arrow"></i>
            <span>Rapports et analyses détaillés</span>
          </div>
          <div class="auth-left-feature">
            <i class="bi bi-shield-check"></i>
            <span>Données cryptées & sauvegardées</span>
          </div>
        </div>
      </div>

      <div class="auth-left-stats">
        <div>
          <div class="auth-left-stat-value">500+</div>
          <div class="auth-left-stat-label">Boutiques actives</div>
        </div>
        <div>
          <div class="auth-left-stat-value">99.9%</div>
          <div class="auth-left-stat-label">Disponibilité</div>
        </div>
        <div>
          <div class="auth-left-stat-value">24/7</div>
          <div class="auth-left-stat-label">Suivi en direct</div>
        </div>
      </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="auth-right">
      <div class="auth-right-header">
        <h3>Bon retour 👋</h3>
        <p>Connectez-vous à votre espace WimoStock.<br>
           Pas encore de compte ? <a href="{{ route('register') }}">Créez-en un ici</a>
        </p>
      </div>

      <!-- LOGIN FORM -->
      <form action="{{ route('login') }}" method="POST" id="loginForm">
        @csrf

        <!-- Email -->
        <div class="mb-3">
          <label for="email" class="form-label">Adresse Email</label>
          <div class="input-with-icon">
            <i class="fas fa-envelope input-icon"></i>
            <input
              type="email"
              id="email"
              name="email"
              class="form-control-custom"
              placeholder="exemple@mail.com"
              value="{{ old('email') }}"
              required
            >
          </div>
          @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
          @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe</label>
          <div class="input-with-icon">
            <i class="fas fa-lock input-icon"></i>
            <input
              type="password"
              id="password"
              name="password"
              class="form-control-custom"
              placeholder="••••••••"
              required
            >
            <button type="button" id="togglePassword" class="toggle-password">
              <i class="fas fa-eye" id="eyeIcon"></i>
            </button>
          </div>
          @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
          @enderror
          <div class="text-danger small mt-1 d-none" id="passwordError"></div>
        </div>

        <!-- Remember / Forgot -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember" name="remember">
            <label class="form-check-label small" for="remember" style="color:#555;">Se souvenir de moi</label>
          </div>
          <a href="{{ route('password.request') }}" class="link-yellow">Mot de passe oublié ?</a>
        </div>

        <!-- Submit -->
        <div class="mb-3">
          <button type="submit" class="btn-primary-custom">
            <i class="fas fa-sign-in-alt me-2"></i>
            <span>Se connecter</span>
          </button>
        </div>

        <div class="auth-divider">ou</div>

        <p class="text-center" style="font-size: 0.85rem; color: #888;">
          Pas encore de compte ?
          <a href="{{ route('register') }}" class="link-yellow">Créer un compte gratuit</a>
        </p>
      </form>
    </div>

  </div>
</div>

<!-- FOOTER -->
<div class="auth-footer">
  <strong style="color:rgba(255,255,255,0.5);">Wimo<span style="color:var(--orange)">Stock</span></strong> &copy; 2026 &nbsp;·&nbsp;
  <a href="#">Confidentialité</a> &nbsp;·&nbsp;
  <a href="#">Conditions</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Toggle password visibility
  document.getElementById('togglePassword').addEventListener('click', function () {
    const pwd = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    if (pwd.type === 'password') {
      pwd.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      pwd.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  });
</script>
</body>
</html>