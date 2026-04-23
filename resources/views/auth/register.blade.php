<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Wimostock – Créer un compte</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --orange: #f0c61d;
      --orange-light: #e5c703;
      --orange-glow: rgba(240, 198, 29, 0.22);
      --teal: #000000;
      --teal-dark: #000000;
      --text-dark: #111111;
      --text-muted: #888;
      --border: #eee;
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
    }
    .navbar-brand span { color: var(--orange); }

    /* ── MAIN ── */
    .auth-wrapper {
      position: relative;
      z-index: 5;
      flex: 1;
      display: flex;
      align-items: flex-start;
      justify-content: center;
      padding: 20px 16px 60px;
    }

    .register-container {
      display: grid;
      grid-template-columns: 320px 1fr;
      max-width: 1040px;
      width: 100%;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 40px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(240,198,29,0.1);
      animation: fadeUp 0.6s ease both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── LEFT SIDEBAR ── */
    .auth-left {
      background: #111;
      padding: 44px 36px;
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
      width: 260px; height: 260px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(240,198,29,0.12) 0%, transparent 70%);
    }
    .auth-left::after {
      content: '';
      position: absolute;
      bottom: -30px; left: -30px;
      width: 180px; height: 180px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(240,198,29,0.06) 0%, transparent 70%);
    }

    .auth-left-eyebrow {
      font-size: 0.7rem;
      font-weight: 600;
      letter-spacing: 0.2em;
      color: var(--orange);
      text-transform: uppercase;
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 22px;
    }
    .auth-left-eyebrow::before {
      content: '';
      display: inline-block;
      width: 20px; height: 2px;
      background: var(--orange);
    }

    .auth-left h2 {
      font-family: 'Playfair Display', serif;
      font-size: 1.9rem;
      font-weight: 900;
      color: #fff;
      line-height: 1.18;
      margin-bottom: 16px;
      position: relative;
      z-index: 1;
    }
    .auth-left h2 em { font-style: normal; color: var(--orange); }
    .auth-left p {
      color: rgba(255,255,255,0.5);
      font-size: 0.85rem;
      line-height: 1.7;
      position: relative;
      z-index: 1;
    }

    .auth-left-steps {
      margin-top: 32px;
      display: flex;
      flex-direction: column;
      gap: 16px;
      position: relative;
      z-index: 1;
    }
    .auth-step {
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }
    .auth-step-num {
      width: 28px; height: 28px;
      border-radius: 50%;
      background: rgba(240,198,29,0.12);
      border: 1.5px solid rgba(240,198,29,0.3);
      color: var(--orange);
      font-size: 0.72rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .auth-step-text {
      color: rgba(255,255,255,0.6);
      font-size: 0.83rem;
      line-height: 1.5;
      padding-top: 4px;
    }
    .auth-step-text strong { color: #fff; display: block; font-size: 0.85rem; }

    .auth-left-stats {
      display: flex;
      gap: 20px;
      margin-top: 36px;
      padding-top: 24px;
      border-top: 1px solid rgba(255,255,255,0.07);
      position: relative;
      z-index: 1;
    }
    .stat-val { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 900; color: #fff; }
    .stat-lbl { font-size: 0.65rem; color: rgba(255,255,255,0.4); letter-spacing: 0.06em; text-transform: uppercase; }

    /* ── RIGHT (FORM) ── */
    .auth-right {
      background: #fff;
      padding: 44px 44px;
      overflow-y: auto;
    }

    .auth-right-header {
      margin-bottom: 28px;
      padding-bottom: 20px;
      border-bottom: 1px solid #f0ece6;
    }
    .auth-right-header h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1.7rem;
      font-weight: 900;
      color: var(--teal-dark);
      margin-bottom: 5px;
    }
    .auth-right-header p {
      color: var(--text-muted);
      font-size: 0.85rem;
    }
    .auth-right-header p a {
      color: var(--orange-light);
      font-weight: 600;
      text-decoration: none;
    }
    .auth-right-header p a:hover { text-decoration: underline; }

    /* ── SECTION HEADING ── */
    .section-heading {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 20px;
    }
    .section-heading-icon {
      width: 34px; height: 34px;
      border-radius: 10px;
      background: linear-gradient(135deg, #fff8d6, #fff0a0);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #b8960a;
      font-size: 0.95rem;
      flex-shrink: 0;
    }
    .section-heading h4 {
      font-weight: 700;
      font-size: 1rem;
      color: var(--teal-dark);
      margin: 0;
    }

    /* ── DIVIDER ── */
    .section-divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 8px 0 24px;
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: #aaa;
    }
    .section-divider::before, .section-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #eee;
    }

    /* ── FORM LABELS & INPUTS ── */
    .form-label {
      font-weight: 600;
      font-size: 0.82rem;
      color: #333;
      margin-bottom: 6px;
      display: block;
    }

    .form-control {
      border: 1.5px solid #eee;
      border-radius: 10px;
      padding: 10px 14px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.87rem;
      color: var(--text-dark);
      background: #fafafa;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }
    .form-control:focus {
      border-color: var(--orange);
      box-shadow: 0 0 0 3px var(--orange-glow);
      background: #fff;
      outline: none;
    }
    .form-control::placeholder { color: #ccc; }
    .form-control.is-invalid { border-color: #dc3545; }

    /* Password field wrapper */
    .form-group { position: relative; }
    .btn-eye {
      position: absolute;
      right: 10px;
      bottom: 10px;
      background: none;
      border: none;
      color: #bbb;
      cursor: pointer;
      padding: 2px 4px;
      transition: color 0.2s;
      z-index: 2;
    }
    .btn-eye:hover { color: var(--orange); }
    /* shift input right padding for eye btn */
    .form-group input[type="password"],
    .form-group input[type="text"] {
      padding-right: 40px;
    }

    /* ── CHECKBOX ── */
    .form-check-input:checked {
      background-color: var(--orange);
      border-color: var(--orange);
    }
    .form-check-input:focus {
      box-shadow: 0 0 0 3px var(--orange-glow);
      border-color: var(--orange);
    }
    .text-yellow { color: var(--orange-light); }
    .text-yellow:hover { color: var(--orange); }
    .bg-yellow-light { background: linear-gradient(135deg, #fff8d6, #fff0a0); }

    /* ── POLITIQUE BLOCK ── */
    .politique-block {
      background: #fafafa;
      border: 1.5px solid #f0ece6;
      border-radius: 12px;
      padding: 14px 18px;
    }

    /* ── SUBMIT ── */
    .btn-primary-custom {
      width: 100%;
      background: var(--teal-dark);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 14px 24px;
      font-family: 'DM Sans', sans-serif;
      font-weight: 600;
      font-size: 0.92rem;
      letter-spacing: 0.03em;
      cursor: pointer;
      transition: all 0.25s;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
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
    .btn-primary-custom i, .btn-primary-custom span { position: relative; z-index: 1; }

    /* Code parrainage block */
    .parrain-block {
      background: linear-gradient(135deg, #fffde7, #fff9c4);
      border: 1.5px dashed rgba(240,198,29,0.4);
      border-radius: 12px;
      padding: 14px 18px;
    }
    .parrain-block label .badge-optional {
      background: rgba(240,198,29,0.15);
      color: #b8960a;
      font-size: 0.68rem;
      font-weight: 600;
      padding: 2px 8px;
      border-radius: 20px;
      margin-left: 6px;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      vertical-align: middle;
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

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
      .register-container { grid-template-columns: 1fr; }
      .auth-left { display: none; }
    }
    @media (max-width: 767px) {
      .auth-right { padding: 28px 20px; }
      .auth-wrapper { padding: 16px 10px 40px; }
      .register-container { border-radius: 16px; }
    }
    @media (max-width: 400px) {
      .auth-right-header h3 { font-size: 1.4rem; }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-auth">
  <div class="container d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="/">Wimo<span>Stock</span></a>
    <a href="/" class="d-flex align-items-center gap-2 text-decoration-none"
       style="color: rgba(255,255,255,0.5); font-size: 0.85rem; transition: color 0.2s;"
       onmouseover="this.style.color='#f0c61d'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">
      <i class="bi bi-arrow-left"></i> Retour à l'accueil
    </a>
  </div>
</nav>

<!-- MAIN -->
<div class="auth-wrapper">
  <div class="register-container">

    <!-- LEFT SIDEBAR -->
    <div class="auth-left">
      <div>
        <div class="auth-left-eyebrow">Inscription gratuite</div>
        <h2>Lancez votre <em>boutique</em> en 2 minutes</h2>
        <p>Rejoignez 500+ commerçants qui pilotent leur activité avec WimoStock.</p>

        <div class="auth-left-steps">
          <div class="auth-step">
            <div class="auth-step-num">1</div>
            <div class="auth-step-text">
              <strong>Vos informations</strong>
              Nom, email, mot de passe
            </div>
          </div>
          <div class="auth-step">
            <div class="auth-step-num">2</div>
            <div class="auth-step-text">
              <strong>Votre boutique</strong>
              Nom et localisation
            </div>
          </div>
          <div class="auth-step">
            <div class="auth-step-num">3</div>
            <div class="auth-step-text">
              <strong>C'est parti !</strong>
              Accédez à votre dashboard
            </div>
          </div>
        </div>
      </div>

      <div class="auth-left-stats">
        <div>
          <div class="stat-val">500+</div>
          <div class="stat-lbl">Boutiques</div>
        </div>
        <div>
          <div class="stat-val">99.9%</div>
          <div class="stat-lbl">Uptime</div>
        </div>
        <div>
          <div class="stat-val">24/7</div>
          <div class="stat-lbl">Support</div>
        </div>
      </div>
    </div>

    <!-- RIGHT: FORM -->
    <div class="auth-right">
      <div class="auth-right-header">
        <h3>Créer mon compte 🚀</h3>
        <p>Déjà inscrit ? <a href="{{ route('login') }}">Connectez-vous ici</a></p>
      </div>

      <div class="bg-white rounded-4" data-aos="fade-up">
        <form action="{{ route('register') }}" method="POST" id="registrationForm" class="row g-3">
          @csrf

          <!-- Section personnelle -->
          <div class="col-12">
            <div class="section-heading">
              <div class="section-heading-icon"><i class="bi bi-person"></i></div>
              <h4>Informations personnelles</h4>
            </div>
          </div>

          <div class="col-md-6 form-group">
            <label class="form-label">Nom complet</label>
            <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror"
              placeholder="Ex: Awa Diop" value="{{ old('nom') }}" required>
            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-6 form-group">
            <label class="form-label">Numéro de téléphone</label>
            <input type="tel" name="numero" id="numero" class="form-control @error('numero') is-invalid @enderror"
              placeholder="Ex: +225 0102345678" value="{{ old('numero') }}" required>
            @error('numero')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="col-12 form-group">
            <label class="form-label">Adresse Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
              placeholder="exemple@email.com" value="{{ old('email') }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <!-- Code parrainage -->
          <div class="col-12">
            <div class="parrain-block">
              <label for="code_parrain" class="form-label mb-2">
                Code de parrainage
                <span class="badge-optional">Optionnel</span>
              </label>
              <input type="text"
                class="form-control @error('code_parrain') is-invalid @enderror"
                id="code_parrain" name="code_parrain"
                value="{{ old('code_parrain') }}"
                placeholder="Ex: REF-ABC12345">
              @error('code_parrain')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <small class="text-muted d-block mt-1" style="font-size:0.78rem;">
                <i class="bi bi-gift me-1" style="color:var(--orange)"></i>
                Entrez le code d'un parrain pour bénéficier d'avantages exclusifs.
              </small>
            </div>
          </div>

          <!-- Mots de passe -->
          <div class="col-md-6 form-group">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" id="password"
              class="form-control @error('password') is-invalid @enderror"
              placeholder="Ex: Abc@1234" required>
            <button type="button" id="togglePassword" class="btn-eye">
              <i class="bi bi-eye" id="eyeIcon"></i>
            </button>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <small class="text-muted d-block mt-1" style="font-size:0.77rem;">
              <i class="bi bi-info-circle me-1"></i> Majuscule, minuscule, chiffre, caractère spécial
            </small>
          </div>

          <div class="col-md-6 form-group">
            <label class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
              class="form-control"
              placeholder="Répétez le mot de passe" required>
            <button type="button" id="togglePasswordConfirm" class="btn-eye">
              <i class="bi bi-eye" id="eyeIconConfirm"></i>
            </button>
          </div>

          <!-- Divider boutique -->
          <div class="col-12">
            <div class="section-divider">Votre boutique</div>
            <div class="section-heading">
              <div class="section-heading-icon"><i class="bi bi-bag"></i></div>
              <h4>Détails de votre boutique</h4>
            </div>
          </div>

          <div class="col-md-6 form-group">
            <label class="form-label">Nom de votre boutique</label>
            <input type="text" name="nom_cab" id="nom_cab"
              class="form-control @error('nom_cab') is-invalid @enderror"
              placeholder="Ex: Ma Belle Boutique"
              value="{{ old('nom_cab') }}" required>
            @error('nom_cab')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-6 form-group">
            <label class="form-label">Localisation</label>
            <input type="text" name="localisation" id="localisation"
              class="form-control @error('localisation') is-invalid @enderror"
              placeholder="Ex: Abidjan, Plateau"
              value="{{ old('localisation') }}" required>
            @error('localisation')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <!-- Politique -->
          <div class="col-12">
            <div class="politique-block">
              <div class="form-check">
                <input class="form-check-input border-warning" type="checkbox"
                  id="accept_politique" name="accept_politique" value="1" required>
                <label class="form-check-label" for="accept_politique" style="font-size:0.86rem;">
                  J'ai lu et j'accepte la
                  <a href="/politique-confidentialite" target="_blank"
                    class="text-yellow text-decoration-underline fw-semibold">
                    politique de confidentialité
                  </a>
                </label>
              </div>
            </div>
          </div>

          <!-- Submit -->
          <div class="col-12 mt-2">
            <button type="submit" class="btn-primary-custom">
              <i class="bi bi-check-circle"></i>
              <span>Créer mon compte</span>
            </button>
          </div>

          <div class="col-12 text-center">
            <p class="text-muted small mb-0">
              Vous avez déjà un compte ?
              <a href="{{ route('login') }}" class="text-yellow fw-semibold text-decoration-none">Connectez-vous ici</a>
            </p>
          </div>

        </form>
      </div>
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
  // Toggle password
  function togglePwd(btnId, inputId, iconId) {
    document.getElementById(btnId).addEventListener('click', function () {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
      }
    });
  }
  togglePwd('togglePassword', 'password', 'eyeIcon');
  togglePwd('togglePasswordConfirm', 'password_confirmation', 'eyeIconConfirm');

  // Password match indicator
  document.getElementById('password_confirmation').addEventListener('input', function () {
    const pwd = document.getElementById('password').value;
    const confirm = this.value;
    if (confirm.length === 0) {
      this.style.borderColor = '';
    } else if (pwd === confirm) {
      this.style.borderColor = '#28a745';
    } else {
      this.style.borderColor = '#dc3545';
    }
  });
</script>
</body>
</html>