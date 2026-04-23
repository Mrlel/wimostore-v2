<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MarketPlace CI - {{ $title ?? 'Plateforme Commerciale' }}</title>
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="fixed top-0 w-full bg-white shadow-lg z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('marketplace') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                        <i data-feather="shopping-bag" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">MarketPlace CI</span>
                </a>

                <!-- Navigation Desktop -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="" 
                       class="text-gray-700 hover:text-yellow-600 font-medium transition-colors">
                        Accueil
                    </a>
                    <a href="" 
                       class="text-gray-700 hover:text-yellow-600 font-medium transition-colors">
                        Cabines
                    </a>
                    <a href="" 
                       class="text-gray-700 hover:text-yellow-600 font-medium transition-colors">
                        Catégories
                    </a>
                    <a href="" 
                       class="text-gray-700 hover:text-yellow-600 font-medium transition-colors">
                        Contact
                    </a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Recherche Mobile -->
                    <button class="md:hidden text-gray-600 hover:text-yellow-600">
                        <i data-feather="search" class="w-5 h-5"></i>
                    </button>
                    
                    <!-- Compte -->
                    <a href="" 
                       class="flex items-center space-x-2 text-gray-700 hover:text-yellow-600 transition-colors">
                        <i data-feather="user" class="w-5 h-5"></i>
                        <span class="hidden sm:block">Mon compte</span>
                    </a>
                    
                    <!-- Cabine Commerçant -->
                    <a href="{{ route('login') }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded-lg font-semibold transition-colors">
                        Espace Commerçant
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenu Principal -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <!-- Logo et Description -->
                <div class="md:col-span-1">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                            <i data-feather="shopping-bag" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="text-xl font-bold">MarketPlace CI</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        La première marketplace ivoirienne connectant commerçants et clients.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-yellow-500 transition-colors">
                            <i data-feather="facebook" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-yellow-500 transition-colors">
                            <i data-feather="instagram" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-yellow-500 transition-colors">
                            <i data-feather="twitter" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>

                <!-- Liens Rapides -->
                <div>
                    <h3 class="font-semibold text-lg mb-4">Liens Rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('marketplace') }}" class="text-gray-400 hover:text-yellow-500 transition-colors">Accueil</a></li>
                        <li><a href="{{ route('marketplace') }}" class="text-gray-400 hover:text-yellow-500 transition-colors">Cabines</a></li>
                        <li><a href="{{ route('marketplace') }}" class="text-gray-400 hover:text-yellow-500 transition-colors">Catégories</a></li>
                        <li><a href="{{ route('marketplace') }}" class="text-gray-400 hover:text-yellow-500 transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Commerçants -->
                <div>
                    <h3 class="font-semibold text-lg mb-4">Commerçants</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-yellow-500 transition-colors">Créer une cabine</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-yellow-500 transition-colors">Espace Commerçant</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition-colors">Tarifs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-semibold text-lg mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center space-x-2">
                            <i data-feather="phone" class="w-4 h-4"></i>
                            <span>+225 07 07 07 07 07</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i data-feather="mail" class="w-4 h-4"></i>
                            <span>contact@marketplaceci.ci</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i data-feather="map-pin" class="w-4 h-4"></i>
                            <span>Abidjan, Côte d'Ivoire</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2024 MarketPlace CI. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100
            });
        });

        // Navigation mobile (à implémenter)
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>