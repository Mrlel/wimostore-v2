<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe — WimoStock</title>
    <link rel="shortcut icon" href="/wim.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --gold:       #f0c61d;
            --gold-dim:   rgba(240,198,29,0.12);
            --gold-glow:  rgba(240,198,29,0.22);
            --border:     rgba(255,255,255,0.07);
            --surface:    #0d0d0d;
            --surface-2:  #161616;
            --text-muted: rgba(255,255,255,0.45);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            padding: 20px;
            font-family: 'DM Sans', sans-serif;
            position: relative;
            overflow: hidden;
        }

        /* Glow décoratif */
        body::before {
            content: '';
            position: fixed;
            top: -200px; left: 50%;
            transform: translateX(-50%);
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(240,198,29,0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            background: #0d0d0d;
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        /* Ligne dorée en haut */
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #f0c61d, #ffd93d);
        }

        /* Logo + titre */
        .auth-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 1.8rem;
        }
        .auth-brand img { height: 36px; width: auto; }
        .auth-brand-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 900;
            color: #fff;
        }
        .auth-brand-text span { color: #f0c61d; }

        .auth-icon {
            width: 56px; height: 56px;
            border-radius: 14px;
            background: rgba(240,198,29,0.12);
            border: 1px solid rgba(240,198,29,0.2);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.2rem;
            color: #f0c61d;
            font-size: 1.5rem;
        }

        .auth-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 900;
            color: #fff;
            text-align: center;
            margin-bottom: 0.3rem;
        }

        .auth-sub {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.4);
            text-align: center;
            margin-bottom: 1.8rem;
        }

        /* Inputs */
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }

        .form-control {
            background: #161616;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 8px;
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.88rem;
            padding: 11px 14px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.2); }
        .form-control:focus {
            background: #161616;
            border-color: rgba(240,198,29,0.45);
            box-shadow: 0 0 0 3px rgba(240,198,29,0.1);
            color: #fff;
            outline: none;
        }

        /* Bouton principal */
        .btn-wimo {
            width: 100%;
            padding: 12px;
            background: #f0c61d;
            border: none;
            border-radius: 8px;
            color: #000;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            cursor: pointer;
            transition: all 0.22s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-wimo:hover {
            background: #ffd93d;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(240,198,29,0.25);
        }
        .btn-wimo:active { transform: translateY(0); }

        /* Lien retour */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 1.2rem;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.35);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .back-link:hover { color: #f0c61d; }

        /* Erreurs */
        .text-danger { font-size: 0.78rem; color: #ff8080 !important; }

        /* Alerts flash */
        .alert {
            border-radius: 8px;
            font-size: 0.82rem;
            border: none;
            margin-bottom: 1.2rem;
        }
        .alert-success {
            background: rgba(45,180,90,0.12);
            color: #4ecb71;
            border: 1px solid rgba(45,180,90,0.25);
        }
        .alert-danger {
            background: rgba(255,80,80,0.1);
            color: #ff8080;
            border: 1px solid rgba(255,80,80,0.2);
        }

        @media (max-width: 480px) {
            .auth-card { padding: 2rem 1.4rem; }
        }
    </style>
</head>
<body>

<div class="auth-card">
    <!-- Icône + titre -->
    <div class="auth-icon">
        <i class="bi bi-shield-lock"></i>
    </div>
    <h1 class="auth-title">Nouveau mot de passe</h1>
    <p class="auth-sub">Choisissez un mot de passe sécurisé pour votre compte.</p>

    @include('layouts.message')

    <form method="POST" action="{{ route('reset.password') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ request('email') }}">

        <div class="mb-3">
            <label class="form-label">Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            @error('password')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-wimo">
            <i class="bi bi-arrow-repeat"></i>
            Réinitialiser le mot de passe
        </button>
    </form>

    <a href="{{ route('login') }}" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Retour à la connexion
    </a>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>