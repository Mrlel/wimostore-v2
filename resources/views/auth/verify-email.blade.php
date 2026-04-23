<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification Email - WimoStock</title>
        <link rel="shortcut icon" href="/wim.png" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #fff;
            overflow-x: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .verification-card {
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 10px;
            border: 1px solid #dee2e6;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            padding: 2rem;
        }

        .verification-icon {
            font-size: 3rem;
            color: #ffde59;
            margin-bottom: 1rem;
        }

        .btn-verify {
            background-color: #ffde59;
            color: #000;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-verify:hover {
            background-color: #000;
            color: #ffde59;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .verification-card {
                padding: 1.2rem;
            }
        }
    </style>
</head>
<body>

    @include('layouts.message')

    <div class="verification-card text-center">
        <i class="bi bi-envelope-check verification-icon"></i>
        <h1 class="h4 fw-bold text-dark mb-2">Vérification de votre email</h1>
        <p class="text-muted mb-4">Un lien de vérification vous a été envoyé par email. Cliquez dessus pour activer votre compte.</p>

        <p class="text-muted mb-3"><small><i class="bi bi-clock me-1"></i>Pas reçu ? Vérifiez vos spams ou renvoyez le lien ci-dessous.</small></p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-verify">
                <i class="bi bi-send me-2"></i>
                Renvoyer l'email de vérification
            </button>
        </form>

        <div class="mt-4 pt-3 border-top">
            <small class="text-muted">
                Besoin d'aide ?
                <a href="https://wa.me/2250585986100" class="text-dark fw-bold">Contactez nous</a>
            </small>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
