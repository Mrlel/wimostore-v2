<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MarketHub - Marketplace Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #000000;
            --accent: #ffde59;
            --white: #FFFFFF;
            --black: #000000;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* Header */
        .top-bar {
            background-color: var(--primary);
            color: var(--white);
            padding: 8px 0;
            font-size: 0.85rem;
        }

        .navbar {
            background-color: var(--white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary) !important;
        }

        .navbar-brand span {
            color: var(--accent);
        }

        .nav-link {
            color: var(--primary) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--accent) !important;
        }

        .search-bar {
            position: relative;
            max-width: 600px;
        }

        .search-bar input {
            border: 2px solid var(--primary);
            border-radius: 25px;
            padding: 0.6rem 3rem 0.6rem 1.5rem;
        }

        .search-bar button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--accent);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            color: var(--primary);
        }

        .btn-cart {
            background-color: var(--accent);
            color: var(--primary);
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            border: none;
            transition: transform 0.2s;
        }

        .btn-cart:hover {
            transform: scale(1.05);
            background-color: var(--accent);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, #2a4a54 100%);
            color: var(--white);
            padding: 4rem 0;
            margin-top: 1rem;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .btn-primary-custom {
            background-color: var(--accent);
            color: var(--primary);
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: transform 0.3s;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 222, 89, 0.4);
        }

        /* Categories */
        .categories {
            padding: 3rem 0;
        }

        .category-card {
            background-color: var(--white);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .category-icon {
            font-size: 3rem;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .category-card h5 {
            color: var(--primary);
            font-weight: 600;
        }

        /* Boutiques */
        .boutiques-section {
            background-color: #f0f0f0;
            padding: 3rem 0;
        }

        .boutique-card {
            background-color: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
            transition: transform 0.3s;
        }

        .boutique-card:hover {
            transform: scale(1.03);
        }

        .boutique-header {
            background-color: var(--primary);
            color: var(--white);
            padding: 1.5rem;
            text-align: center;
        }

        .boutique-logo {
            width: 80px;
            height: 80px;
            background-color: var(--accent);
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--primary);
        }

        /* Products */
        .products-section {
            padding: 3rem 0;
        }

        .product-card {
            background-color: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
            transition: all 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .product-image {
            width: 100%;
            height: 250px;
            background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: #ccc;
        }

        .product-body {
            padding: 1.5rem;
        }

        .product-boutique {
            font-size: 0.75rem;
            color: var(--accent);
            background-color: var(--primary);
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .product-title {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .btn-add-cart {
            width: 100%;
            background-color: var(--accent);
            color: var(--primary);
            border: none;
            border-radius: 25px;
            padding: 0.7rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-add-cart:hover {
            background-color: var(--primary);
            color: var(--accent);
        }

        .rating {
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        /* Footer */
        footer {
            background-color: var(--primary);
            color: var(--white);
            padding: 3rem 0 1rem;
            margin-top: 3rem;
        }

        footer h5 {
            color: var(--accent);
            margin-bottom: 1rem;
        }

        footer a {
            color: var(--white);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s;
        }

        footer a:hover {
            color: var(--accent);
        }

        .social-icons a {
            color: var(--accent);
            font-size: 1.5rem;
            margin-right: 1rem;
            transition: transform 0.3s;
            display: inline-block;
        }

        .social-icons a:hover {
            transform: scale(1.2);
        }

        .section-title {
            color: var(--primary);
            font-weight: bold;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background-color: var(--accent);
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div>
                    <i class="fas fa-phone me-2"></i> +33 1 23 45 67 89
                    <span class="ms-3"><i class="fas fa-envelope me-2"></i> contact@markethub.fr</span>
                </div>
                <div>
                    <i class="fas fa-truck me-2"></i> Livraison gratuite à partir de 50€
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><span>Market</span>Hub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-4">
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-home me-1"></i> Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#boutiques"><i class="fas fa-store me-1"></i> Boutiques</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products"><i class="fas fa-box me-1"></i> Produits</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-percent me-1"></i> Promotions</a></li>
                </ul>
                <button class="btn-cart">
                    <i class="fas fa-shopping-cart me-2"></i> Panier (0)
                </button>
            </div>
        </div>
    </nav>

    <!-- Search Bar -->
    <div class="container mt-4">
        <div class="search-bar mx-auto">
            <input type="text" class="form-control" placeholder="Rechercher des produits, boutiques...">
            <button><i class="fas fa-search"></i></button>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Découvrez des milliers de produits</h1>
                    <p>Explorez les meilleures boutiques en ligne réunies sur une seule plateforme</p>
                    <button class="btn-primary-custom">Explorer maintenant</button>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="fas fa-shopping-bag" style="font-size: 15rem; color: rgba(255,222,89,0.3);"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="categories">
        <div class="container">
            <h2 class="section-title text-center">Catégories Populaires</h2>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="category-icon"><i class="fas fa-laptop"></i></div>
                        <h5>Électronique</h5>
                        <p class="text-muted mb-0">2,453 produits</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="category-icon"><i class="fas fa-tshirt"></i></div>
                        <h5>Mode</h5>
                        <p class="text-muted mb-0">3,821 produits</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="category-icon"><i class="fas fa-home"></i></div>
                        <h5>Maison & Déco</h5>
                        <p class="text-muted mb-0">1,654 produits</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="category-icon"><i class="fas fa-dumbbell"></i></div>
                        <h5>Sport</h5>
                        <p class="text-muted mb-0">987 produits</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Boutiques Partenaires -->
    <section class="boutiques-section" id="boutiques">
        <div class="container">
            <h2 class="section-title">Nos Boutiques Partenaires</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="boutique-card">
                        <div class="boutique-header">
                            <div class="boutique-logo"><i class="fas fa-gem"></i></div>
                            <h5 class="mb-0">Luxe & Style</h5>
                            <small>Mode Premium</small>
                        </div>
                        <div class="p-3 text-center">
                            <p class="mb-2"><strong>245</strong> produits</p>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="ms-1">4.8</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="boutique-card">
                        <div class="boutique-header">
                            <div class="boutique-logo"><i class="fas fa-mobile-alt"></i></div>
                            <h5 class="mb-0">Tech Haven</h5>
                            <small>Électronique & High-Tech</small>
                        </div>
                        <div class="p-3 text-center">
                            <p class="mb-2"><strong>568</strong> produits</p>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="ms-1">5.0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="boutique-card">
                        <div class="boutique-header">
                            <div class="boutique-logo"><i class="fas fa-couch"></i></div>
                            <h5 class="mb-0">Home Design</h5>
                            <small>Décoration Intérieure</small>
                        </div>
                        <div class="p-3 text-center">
                            <p class="mb-2"><strong>423</strong> produits</p>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span class="ms-1">4.5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products -->
    <section class="products-section" id="products">
        <div class="container">
            <h2 class="section-title">Produits Tendance</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <div class="product-body">
                            <span class="product-boutique">Tech Haven</span>
                            <h5 class="product-title">Laptop Pro X15</h5>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="ms-1">(245)</span>
                            </div>
                            <div class="product-price">1 299€</div>
                            <button class="btn-add-cart">Ajouter au panier</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-headphones"></i>
                        </div>
                        <div class="product-body">
                            <span class="product-boutique">Tech Haven</span>
                            <h5 class="product-title">Casque Audio Premium</h5>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="ms-1">(189)</span>
                            </div>
                            <div class="product-price">249€</div>
                            <button class="btn-add-cart">Ajouter au panier</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-shoe-prints"></i>
                        </div>
                        <div class="product-body">
                            <span class="product-boutique">Luxe & Style</span>
                            <h5 class="product-title">Baskets Sport Elite</h5>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span class="ms-1">(156)</span>
                            </div>
                            <div class="product-price">129€</div>
                            <button class="btn-add-cart">Ajouter au panier</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div class="product-body">
                            <span class="product-boutique">Home Design</span>
                            <h5 class="product-title">Fauteuil Scandinave</h5>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="ms-1">(312)</span>
                            </div>
                            <div class="product-price">449€</div>
                            <button class="btn-add-cart">Ajouter au panier</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-watch"></i>
                        </div>
                        <div class="product-body">
                            <span class="product-boutique">Luxe & Style</span>
                            <h5 class="product-title">Montre Connectée Pro</h5>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="ms-1">(203)</span>
                            </div>
                            <div class="product-price">399€</div>
                            <button class="btn-add-cart">Ajouter au panier</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-camera"></i>
                        </div>
                        <div class="product-body">
                            <span class="product-boutique">Tech Haven</span>
                            <h5 class="product-title">Appareil Photo 4K</h5>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="ms-1">(178)</span>
                            </div>
                            <div class="product-price">899€</div>
                            <button class="btn-add-cart">Ajouter au panier</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div class="product-body">
                            <span class="product-boutique">Home Design</span>
                            <h5 class="product-title">Lampe Design LED</h5>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span class="ms-1">(92)</span>
                            </div>
                            <div class="product-price">79€</div>
                            <button class="btn-add-cart">Ajouter au panier</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <div class="product-body">
                            <span class="product-boutique">Luxe & Style</span>
                            <h5 class="product-title">T-shirt Premium Coton</h5>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="ms-1">(267)</span>
                            </div>
                            <div class="product-price">45€</div>
                            <button class="btn-add-cart">Ajouter au panier</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5>À Propos</h5>
                    <p>MarketHub réunit les meilleures boutiques en ligne pour vous offrir une expérience d'achat unique et diversifiée.</p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <h5>Aide & Support</h5>
                    <a href="#">Centre d'aide</a>
                    <a href="#">FAQ</a>
                    <a href="#">Livraison</a>
                    <a href="#">Retours</a>
                    <a href="#">Suivi de commande</a>
                </div>
                <div class="col-md-3">
                    <h5>Informations</h5>
                    <a href="#">Qui sommes-nous</a>
                    <a href="#">Devenir partenaire</a>
                    <a href="#">Conditions générales</a>
                    <a href="#">Politique de confidentialité</a>
                    <a href="#">Mentions légales</a>
                </div>
                <div class="col-md-3">
                    <h5>Newsletter</h5>
                    <p>Inscrivez-vous pour recevoir nos offres exclusives</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Votre email">
                        <button class="btn btn-warning" type="button">OK</button>
                    </div>
                </div>
            </div>
            <hr class="mt-4" style="border-color: rgba(255,255,255,0.2);">
            <div class="text-center py-3">
                <p class="mb-0">&copy; 2025 MarketHub. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.product-card, .category-card, .boutique-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease-out';
            observer.observe(el);
        });

        // Gestion du panier
        let cartCount = 0;
        document.querySelectorAll('.btn-add-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                cartCount++;
                document.querySelector('.btn-cart').innerHTML = `<i class="fas fa-shopping-cart me-2"></i> Panier (${cartCount})`;
                this.innerHTML = '<i class="fas fa-check me-2"></i> Ajouté';
                this.style.backgroundColor = '#000000';
                this.style.color = '#ffde59';
                setTimeout(() => {
                    this.innerHTML = 'Ajouter au panier';
                    this.style.backgroundColor = '#ffde59';
                    this.style.color = '#000000';
                }, 2000);
            });
        });

        // Animation du bouton de recherche
        document.querySelector('.search-bar button').addEventListener('click', function() {
            const input = document.querySelector('.search-bar input');
            if(input.value) {
                alert('Recherche pour: ' + input.value);
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>