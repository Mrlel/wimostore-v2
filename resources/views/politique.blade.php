<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politique de Confidentialité - WimoStock</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="shortcut icon" href="/wim.png" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, rgb(255, 255, 255) 0%, rgb(255, 250, 235) 100%);
            min-height: 100vh;
        }
        
        .section-title {
            color: #fbc926;
            border-left: 4px solid #fbc926;
            padding-left: 1rem;
            margin: 2rem 0 1rem 0;
        }
        
        .back-btn {
            background-color: #fbc926;
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            transform: translateX(-5px);
            box-shadow: 0 8px 20px rgba(251, 201, 38, 0.3);
        }
    </style>
</head>
<body>
    <div class="policy-content">
        <div class="bg-yellow-500 p-6 text-center">
            <h1 class="text-3xl font-bold text-white">
                <i data-feather="shield" class="inline mr-3"></i>
                Politique de Confidentialité
            </h1>
            <p class="text-white opacity-90 mt-2">Dernière mise à jour: 2024</p>
        </div>

        <div class="p-8">
            <a href="/" class="back-btn inline-flex items-center px-4 py-2 rounded-lg text-black font-semibold mb-6">
                <i data-feather="arrow-left" class="mr-2"></i>
                Retour à l'accueil
            </a>

            <div class="prose max-w-none">
                <h2 class="section-title">1. Qui sommes-nous ?</h2>
                <p class="text-gray-700 mb-6">
                    Cette application est conçue pour aider les entreprises à gérer leurs stocks, ventes et produits. 
                    Nous nous engageons à protéger vos données personnelles et à respecter votre vie privée.
                </p>

                <h2 class="section-title">2. Quelles données collectons-nous ?</h2>
                <p class="text-gray-700 mb-4">
                    Nous collectons uniquement les données nécessaires au bon fonctionnement de l'application :
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li>Informations de compte : nom, email, mot de passe</li>
                    <li>Données d'usage : produits, ventes, mouvements de stock</li>
                    <li>Informations techniques : adresse IP, type de navigateur, date de connexion</li>
                </ul>

                <h2 class="section-title">3. Pourquoi collectons-nous ces données ?</h2>
                <p class="text-gray-700 mb-4">
                    Vos données sont utilisées pour :
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li>Créer et sécuriser votre compte</li>
                    <li>Gérer vos produits, ventes et mouvements</li>
                    <li>Générer des rapports et statistiques</li>
                    <li>Améliorer l'expérience utilisateur</li>
                    <li>Respecter nos obligations légales</li>
                </ul>

                <h2 class="section-title">4. Avec qui partageons-nous vos données ?</h2>
                <p class="text-gray-700 mb-6">
                    Nous ne vendons ni ne louons vos données. Elles peuvent être partagées uniquement avec :
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li>Nos prestataires techniques (hébergement, sécurité)</li>
                    <li>Les autorités compétentes en cas d'obligation légale</li>
                </ul>

                <h2 class="section-title">5. Quels sont vos droits ?</h2>
                <p class="text-gray-700 mb-4">
                    Conformément au RGPD, vous pouvez :
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
                    <li>Accéder à vos données</li>
                    <li>Les corriger ou les supprimer</li>
                    <li>Demander leur portabilité</li>
                    <li>Retirer votre consentement à tout moment</li>
                </ul>

                <h2 class="section-title">6. Sécurité</h2>
                <p class="text-gray-700 mb-6">
                    Vos données sont stockées de manière sécurisée. Nous utilisons des protocoles de chiffrement 
                    et des mesures de protection contre les accès non autorisés.
                </p>

                <h2 class="section-title">7. Mise à jour</h2>
                <p class="text-gray-700">
                    Cette politique peut évoluer. Toute modification sera annoncée sur l'application ou par email.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
</body>
</html>