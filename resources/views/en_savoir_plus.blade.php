<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>En Savoir Plus - WimoStock</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="shortcut icon" href="/wim.png" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        .gradient-bg {
            background: linear-gradient(135deg, #000000 0%, #fbc926 100%);
        }
        .btn-primary {
            background-color: #fbc926;
            color: #000000;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 222, 89, 0.3);
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <div class="max-w-6xl mx-auto bg-white rounded-xl overflow-hidden" data-aos="fade-up">
            <div class="p-8">
                <div class="flex justify-center mb-8">
                    <img src="/wimo.png" class="h-20 w-auto" alt="Logo">
                </div>
                <h1 class="text-center text-3xl font-bold text-gray-900 mb-2">
                    Wimo<span class="text-[#fbc926]">Stock</span>
                </h1>
                <p class="text-center text-gray-500 mb-8">Découvrez les fonctionnalités de WimoStock</p>

                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Présentation</h2>
                        <p class="text-gray-700 mb-4" style="text-align: justify;">
                        Wimo<span class="text-[#fbc926]">Stock</span> est une solution polyvalente qui relie la gestion de stock et la visibilité commerciale en ligne.
                            Conçue pour les vendeurs, agences et gérants indépendants, elle vous aide à gérer vos produits, tout en les rendant visibles auprès de vos clients. 
                            Elle s’adapte aussi bien aux grandes entreprises qu’aux PME, en centralisant vos opérations quotidiennes : gestion des produits, ventes, mouvements de stock, reçus, statistiques et alertes.  
                            Idéale pour les activités e-commerce et physiques, Wimo<span class="text-[#fbc926]">Stock</span> optimise votre suivi et votre performance commerciale.
                        </p>

                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <i data-feather="check-circle" class="text-yellow-500 mr-2 mt-1"></i>
                                <span>Gestion des produits, catégories et niveaux de stock avec seuils d'alerte</span>
                            </li>
                            <li class="flex items-start">
                                <i data-feather="check-circle" class="text-yellow-500 mr-2 mt-1"></i>
                                <span>Enregistrement rapide des ventes et génération de reçus avec QR code</span>
                            </li>
                            <li class="flex items-start">
                                <i data-feather="check-circle" class="text-yellow-500 mr-2 mt-1"></i>
                                <span>Suivi des mouvements (entrées/sorties) et traçabilité complète</span>
                            </li>
                            <li class="flex items-start">
                                <i data-feather="check-circle" class="text-yellow-500 mr-2 mt-1"></i>
                                <span>Export/Impression PDF et consultation facile des historiques</span>
                            </li>
                            <li class="flex items-start">
                                <i data-feather="check-circle" class="text-yellow-500 mr-2 mt-1"></i>
                                <span>Rapports financiers et statistiques</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
        <i data-feather="award" class="text-yellow-500 mr-2"></i>
        Pourquoi choisir cette solution ?
    </h2>
    <ul class="space-y-3">
        <li class="flex items-start">
            <i data-feather="clock" class="text-yellow-500 mr-2 mt-1"></i>
            <span class="font-medium text-gray-700">Gagnez du temps sur toutes vos opérations quotidiennes : ventes, inventaires et rapports en un clic.</span>
        </li>
        <li class="flex items-start">
            <i data-feather="alert-triangle" class="text-yellow-500 mr-2 mt-1"></i>
            <span class="font-medium text-gray-700">Anticipez les ruptures grâce aux alertes automatiques de stock.</span>
        </li>
        <li class="flex items-start">
            <i data-feather="trending-up" class="text-yellow-500 mr-2 mt-1"></i>
            <span class="font-medium text-gray-700">Visualisez vos performances en temps réel (chiffre d’affaires, marges, produits les plus vendus).</span>
        </li>
        <li class="flex items-start">
            <i data-feather="lock" class="text-yellow-500 mr-2 mt-1"></i>
            <span class="font-medium text-gray-700">Profitez d’une sécurité totale : chaque boutique dispose de ses propres données protégées.</span>
        </li>
        <li class="flex items-start">
            <i data-feather="file-text" class="text-yellow-500 mr-2 mt-1"></i>
            <span class="font-medium text-gray-700">Générez des reçus professionnels avec QR Code et export PDF instantané.</span>
        </li>
        <li class="flex items-start">
            <i data-feather="share-2" class="text-yellow-500 mr-2 mt-1"></i>
            <span class="font-medium text-gray-700">Connectez votre boutique à votre site vitrine pour mettre en avant vos produits automatiquement.</span>
        </li>
        <li class="flex items-start">
            <i data-feather="bar-chart-2" class="text-yellow-500 mr-2 mt-1"></i>
            <span class="font-medium text-gray-700">Analyse intelligente : suivez vos tendances de vente et prenez de meilleures décisions commerciales.</span>
        </li>
    </ul>
</div>

                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 text-center">
                        <i data-feather="dollar-sign" class="w-8 h-8 mx-auto text-yellow-500 mb-2"></i>
                        <h3 class="font-bold text-gray-800">CA Mensuel</h3>
                        <p class="text-sm text-gray-500">Suivi automatique</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 text-center">
                        <i data-feather="bell" class="w-8 h-8 mx-auto text-yellow-500 mb-2"></i>
                        <h3 class="font-bold text-gray-800">Alertes Stock</h3>
                        <p class="text-sm text-gray-500">Seuils configurables</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 text-center">
                        <i data-feather="file" class="w-8 h-8 mx-auto text-yellow-500 mb-2"></i>
                        <h3 class="font-bold text-gray-800">Reçus QR</h3>
                        <p class="text-sm text-gray-500">Impression/Export PDF</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 text-center">
                        <i data-feather="shopping-bag" class="w-8 h-8 mx-auto text-yellow-500 mb-2"></i>
                        <h3 class="font-bold text-gray-800">Multi-boutiques</h3>
                        <p class="text-sm text-gray-500">Rôles & permissions</p>
                    </div>
                </div>

                <div class="text-center mt-8">
                    <a href="/login" class="btn-primary inline-flex items-center px-8 py-3 rounded-lg font-medium text-lg shadow-md">
                        <i data-feather="log-in" class="mr-2"></i> Commencer maintenant
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class=" py-6 mt-12">
        <div class="container mx-auto px-4">
            <p class="text-center ">
                © 2025 WimoStock. Tous droits réservés.
            </p>
        </div>
    </footer>

    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        feather.replace();
    </script>
</body>
</html>