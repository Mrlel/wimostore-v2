<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - MarketHub</title>
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

        .btn-cart {
            background-color: var(--accent);
            color: var(--primary);
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            border: none;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, #2a4a54 100%);
            color: var(--white);
            padding: 3rem 0;
            margin-bottom: 3rem;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: var(--accent);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--white);
        }

        /* Cart Section */
        .cart-section {
            padding: 2rem 0;
        }

        .cart-card {
            background-color: var(--white);
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .cart-header {
            background-color: var(--primary);
            color: var(--white);
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-header h4 {
            margin: 0;
            font-weight: 600;
        }

        .cart-item {
            padding: 1.5rem;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: background-color 0.3s;
        }

        .cart-item:hover {
            background-color: #f8f9fa;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #ccc;
            flex-shrink: 0;
        }

        .item-details {
            flex: 1;
        }

        .item-boutique {
            font-size: 0.75rem;
            color: var(--accent);
            background-color: var(--primary);
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .item-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .item-description {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .item-stock {
            color: #28a745;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .item-stock.low {
            color: #ff6b6b;
        }

        .item-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
            text-align: center;
            flex-shrink: 0;
            width: 120px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .quantity-btn {
            width: 35px;
            height: 35px;
            border: 2px solid var(--primary);
            background-color: var(--white);
            color: var(--primary);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .quantity-btn:hover {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 0.5rem;
            font-weight: 600;
            color: var(--primary);
        }

        .remove-btn {
            background-color: transparent;
            color: #dc3545;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            transition: transform 0.2s;
            padding: 0.5rem;
            flex-shrink: 0;
        }

        .remove-btn:hover {
            transform: scale(1.2);
        }

        /* Summary Card */
        .summary-card {
            background-color: var(--white);
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            padding: 2rem;
            position: sticky;
            top: 100px;
        }

        .summary-title {
            color: var(--primary);
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--accent);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .summary-row.total {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--primary);
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid #e0e0e0;
        }

        .discount-code {
            margin: 1.5rem 0;
        }

        .discount-code input {
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 0.7rem;
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .btn-apply {
            width: 100%;
            background-color: var(--white);
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 0.7rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-apply:hover {
            background-color: var(--primary);
            color: var(--white);
        }

        .btn-checkout {
            width: 100%;
            background-color: var(--accent);
            color: var(--primary);
            border: none;
            border-radius: 25px;
            padding: 1rem;
            font-size: 1.2rem;
            font-weight: bold;
            transition: all 0.3s;
            margin-top: 1.5rem;
        }

        .btn-checkout:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 222, 89, 0.4);
        }

        .btn-continue {
            width: 100%;
            background-color: var(--white);
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 25px;
            padding: 0.8rem;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 1rem;
        }

        .btn-continue:hover {
            background-color: var(--primary);
            color: var(--white);
        }

        .payment-methods {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e0e0e0;
        }

        .payment-methods p {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .payment-icons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .payment-icon {
            font-size: 2rem;
            color: var(--primary);
        }

        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-cart-icon {
            font-size: 8rem;
            color: #e0e0e0;
            margin-bottom: 2rem;
        }

        .empty-cart h3 {
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .empty-cart p {
            color: #6c757d;
            margin-bottom: 2rem;
        }

        /* Recommendations */
        .recommendations {
            background-color: var(--white);
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-top: 2rem;
        }

        .recommendations h4 {
            color: var(--primary);
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        .recommendation-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border-radius: 10px;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .recommendation-item:hover {
            background-color: #f8f9fa;
        }

        .recommendation-image {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #ccc;
            flex-shrink: 0;
        }

        .recommendation-details {
            flex: 1;
        }

        .recommendation-title {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.3rem;
        }

        .recommendation-price {
            color: var(--primary);
            font-weight: bold;
            font-size: 1.1rem;
        }

        .btn-add-small {
            background-color: var(--accent);
            color: var(--primary);
            border: none;
            border-radius: 20px;
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-add-small:hover {
            background-color: var(--primary);
            color: var(--accent);
        }

        /* Footer */
        footer {
            background-color: var(--primary);
            color: var(--white);
            padding: 3rem 0 1rem;
            margin-top: 4rem;
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

        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                text-align: center;
            }

            .item-price {
                width: 100%;
                margin-top: 1rem;
            }

            .quantity-controls {
                margin-top: 1rem;
            }

            .summary-card {
                position: static;
            }
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
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-store me-1"></i> Boutiques</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-box me-1"></i> Produits</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-percent me-1"></i> Promotions</a></li>
                </ul>
                <button class="btn-cart">
                    <i class="fas fa-shopping-cart me-2"></i> Panier (<span id="cart-count">3</span>)
                </button>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mon Panier</li>
                </ol>
            </nav>
            <h1><i class="fas fa-shopping-cart me-3"></i>Mon Panier</h1>
        </div>
    </div>

    <!-- Cart Section -->
    <section class="cart-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Cart Items -->
                    <div class="cart-card">
                        <div class="cart-header">
                            <h4><i class="fas fa-box-open me-2"></i>Produits (<span id="items-count">3</span>)</h4>
                            <button class="btn btn-sm btn-outline-light" onclick="clearCart()">
                                <i class="fas fa-trash me-1"></i> Vider le panier
                            </button>
                        </div>
                        
                        <div id="cart-items">
                            <!-- Item 1 -->
                            <div class="cart-item" data-price="1299" data-id="1">
                                <div class="item-image">
                                    <i class="fas fa-laptop"></i>
                                </div>
                                <div class="item-details">
                                    <span class="item-boutique">Tech Haven</span>
                                    <h5 class="item-title">Laptop Pro X15</h5>
                                    <p class="item-description">Intel Core i7, 16GB RAM, 512GB SSD, Écran 15.6"</p>
                                    <span class="item-stock"><i class="fas fa-check-circle me-1"></i> En stock</span>
                                </div>
                                <div class="item-price">
                                    <span class="unit-price">1 299€</span>
                                </div>
                                <div class="quantity-controls">
                                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                                    <input type="number" class="quantity-input" value="1" min="1" readonly>
                                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                                </div>
                                <button class="remove-btn" onclick="removeItem(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <!-- Item 2 -->
                            <div class="cart-item" data-price="249" data-id="2">
                                <div class="item-image">
                                    <i class="fas fa-headphones"></i>
                                </div>
                                <div class="item-details">
                                    <span class="item-boutique">Tech Haven</span>
                                    <h5 class="item-title">Casque Audio Premium</h5>
                                    <p class="item-description">Réduction de bruit active, Bluetooth 5.0, 30h d'autonomie</p>
                                    <span class="item-stock"><i class="fas fa-check-circle me-1"></i> En stock</span>
                                </div>
                                <div class="item-price">
                                    <span class="unit-price">249€</span>
                                </div>
                                <div class="quantity-controls">
                                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                                    <input type="number" class="quantity-input" value="2" min="1" readonly>
                                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                                </div>
                                <button class="remove-btn" onclick="removeItem(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <!-- Item 3 -->
                            <div class="cart-item" data-price="449" data-id="3">
                                <div class="item-image">
                                    <i class="fas fa-chair"></i>
                                </div>
                                <div class="item-details">
                                    <span class="item-boutique">Home Design</span>
                                    <h5 class="item-title">Fauteuil Scandinave</h5>
                                    <p class="item-description">Design moderne, Tissu premium, Pieds en bois massif</p>
                                    <span class="item-stock low"><i class="fas fa-exclamation-circle me-1"></i> Plus que 2 en stock</span>
                                </div>
                                <div class="item-price">
                                    <span class="unit-price">449€</span>
                                </div>
                                <div class="quantity-controls">
                                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                                    <input type="number" class="quantity-input" value="1" min="1" readonly>
                                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                                </div>
                                <button class="remove-btn" onclick="removeItem(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Recommendations -->
                    <div class="recommendations">
                        <h4><i class="fas fa-star me-2"></i>Vous aimerez aussi</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="recommendation-item">
                                    <div class="recommendation-image">
                                        <i class="fas fa-mouse"></i>
                                    </div>
                                    <div class="recommendation-details">
                                        <div class="recommendation-title">Souris Gaming Pro</div>
                                        <div class="recommendation-price">79€</div>
                                    </div>
                                    <button class="btn-add-small">Ajouter</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="recommendation-item">
                                    <div class="recommendation-image">
                                        <i class="fas fa-lightbulb"></i>
                                    </div>
                                    <div class="recommendation-details">
                                        <div class="recommendation-title">Lampe LED Design</div>
                                        <div class="recommendation-price">59€</div>
                                    </div>
                                    <button class="btn-add-small">Ajouter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="col-lg-4">
                    <div class="summary-card">
                        <h4 class="summary-title">Récapitulatif</h4>
                        
                        <div class="summary-row">
                            <span>Sous-total</span>
                            <span id="subtotal">2 246€</span>
                        </div>
                        <div class="summary-row">
                            <span>Livraison</span>
                            <span id="shipping" style="color: #28a745; font-weight: 600;">GRATUITE</span>
                        </div>
                        <div class="summary-row" id="discount-row" style="display: none; color: #28a745;">
                            <span>Réduction</span>
                            <span id="discount">-0€</span>
                        </div>

                        <div class="discount-code">
                            <input type="text" id="coupon-input" placeholder="Code promo">
                            <button class="btn-apply" onclick="applyCoupon()">
                                <i class="fas fa-tag me-2"></i>Appliquer
                            </button>
                        </div>

                        <div class="summary-row total">
                            <span>Total</span>
                            <span id="total">2 246€</span>
                        </div>

                        <button class="btn-checkout" onclick="checkout()">
                            <i class="fas fa-lock me-2"></i>Procéder au paiement
                        </button>
                        <button class="btn-continue" onclick="window.history.back()">
                            <i class="fas fa-arrow-left me-2"></i>Continuer mes achats
                        </button>

                        <div class="payment-methods">
                            <p><i class="fas fa-shield-alt me-1"></i> Paiement 100% sécurisé</p>
                            <div class="payment-icons">
                                <i class="fab fa-cc-visa payment-icon"></i>
                                <i class="fab fa-cc-mastercard payment-icon"></i>
                                <i class="fab fa-cc-paypal payment-icon"></i>
                                <i class="fab fa-cc-amex payment-icon"></i>
                            </div>
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
                    <p>MarketHub réunit les meilleures boutiques en ligne pour vous offrir une expérience d'achat unique.</p>
                </div>
                <div class="col-md-3">
                    <h5>Aide & Support</h5>
                    <a href="#">Centre d'aide</a>
                    <a href="#">FAQ</a>
                    <a href="#">Livraison</a>
                    <a href="#">Retours</a>
                </div>
                <div class="col-md-3">
                    <h5>Informations</h5>
                    <a href="#">Qui sommes-nous</a>
                    <a href="#">Conditions générales</a>
                    <a href="#">Politique de confidentialité</a>
                </div>
                <div class="col-md-3">
                    <h5>Newsletter</h5>
                    <p>Inscrivez-vous pour recevoir nos offres</p>
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
        // Calcul du total
        function calculateTotal() {
            let subtotal = 0;
            const items = document.querySelectorAll('.cart-item');
            
            items.forEach(item => {
                const price = parseFloat(item.dataset.price);
                const quantity = parseInt(item.querySelector('.quantity-input').value);
                subtotal += price * quantity;
            });

            // Mise à jour de l'affichage
            document.getElementById('subtotal').textContent = subtotal.toFixed(0) + '€';
            
            // Livraison gratuite si > 50€
            const shipping = subtotal >= 50 ? 0 : 5.90;
            document.getElementById('shipping').textContent = shipping === 0 ? 'GRATUITE' : shipping.toFixed(2) + '€';
            document.getElementById('shipping').style.color = shipping === 0 ? '#28a745' : '#000';
            
            // Total
            const discountElement = document.getElementById('discount');
            const discount = discountElement ? parseFloat(discountElement.textContent.replace('-', '').replace('€', '')) : 0;
            const total = subtotal + shipping - discount;
            
            document.getElementById('total').textContent = total.toFixed(0) + '€';
            
            // Mise à jour du compteur
            updateCartCount();
        }

        // Augmenter la quantité
        function increaseQuantity(btn) {
            const input = btn.previousElementSibling;
            input.value = parseInt(input.value) + 1;
            calculateTotal();
        }

        // Diminuer la quantité
        function decreaseQuantity(btn) {
            const input = btn.nextElementSibling;
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                calculateTotal();
            }
        }

        // Supprimer un article
        function removeItem(btn) {
            const item = btn.closest('.cart-item');
            item.style.opacity = '0';
            item.style.transform = 'translateX(-100%)';
            item.style.transition = 'all 0.3s';
            
            setTimeout(() => {
                item.remove();
                calculateTotal();
                
                // Si le panier est vide
                if (document.querySelectorAll('.cart-item').length === 0) {
                    showEmptyCart();
                }
            }, 300);
        }

        // Vider le panier
        function clearCart() {
            if (confirm('Êtes-vous sûr de vouloir vider votre panier ?')) {
                const items = document.querySelectorAll('.cart-item');
                items.forEach((item, index) => {
                    setTimeout(() => {
                        item.style.opacity = '0';
                        item.style.transform = 'translateX(-100%)';
                        item.style.transition = 'all 0.3s';
                    }, index * 100);
                });
                
                setTimeout(() => {
                    showEmptyCart();
                }, items.length * 100 + 300);
            }
        }

        // Afficher le panier vide
        function showEmptyCart() {
            const cartItems = document.getElementById('cart-items');
            cartItems.innerHTML = `
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>Votre panier est vide</h3>
                    <p>Découvrez nos produits et commencez vos achats dès maintenant !</p>
                    <button class="btn-checkout" onclick="window.location.href='#'">
                        <i class="fas fa-shopping-bag me-2"></i>Découvrir nos produits
                    </button>
                </div>
            `;
            
            document.getElementById('subtotal').textContent = '0€';
            document.getElementById('total').textContent = '0€';
            document.getElementById('shipping').textContent = '0€';
            updateCartCount();
        }

        // Appliquer un code promo
        function applyCoupon() {
            const couponInput = document.getElementById('coupon-input');
            const coupon = couponInput.value.trim().toUpperCase();
            
            const validCoupons = {
                'WELCOME10': 10,
                'PROMO20': 20,
                'BLACKFRIDAY': 50
            };
            
            if (validCoupons[coupon]) {
                const discount = validCoupons[coupon];
                document.getElementById('discount-row').style.display = 'flex';
                document.getElementById('discount').textContent = '-' + discount + '€';
                
                couponInput.style.borderColor = '#28a745';
                couponInput.value = '✓ Code appliqué: ' + coupon;
                couponInput.disabled = true;
                
                // Animation de succès
                const btn = document.querySelector('.btn-apply');
                btn.innerHTML = '<i class="fas fa-check me-2"></i>Appliqué !';
                btn.style.backgroundColor = '#28a745';
                btn.style.color = '#fff';
                btn.style.borderColor = '#28a745';
                btn.disabled = true;
                
                calculateTotal();
            } else {
                couponInput.style.borderColor = '#dc3545';
                couponInput.placeholder = 'Code invalide';
                couponInput.value = '';
                
                setTimeout(() => {
                    couponInput.style.borderColor = '#000000';
                    couponInput.placeholder = 'Code promo';
                }, 2000);
            }
        }

        // Mise à jour du compteur de panier
        function updateCartCount() {
            const items = document.querySelectorAll('.cart-item');
            let totalItems = 0;
            
            items.forEach(item => {
                const quantity = parseInt(item.querySelector('.quantity-input').value);
                totalItems += quantity;
            });
            
            document.getElementById('cart-count').textContent = totalItems;
            document.getElementById('items-count').textContent = items.length;
        }

        // Procéder au paiement
        function checkout() {
            const items = document.querySelectorAll('.cart-item');
            if (items.length === 0) {
                alert('Votre panier est vide !');
                return;
            }
            
            // Animation de chargement
            const btn = document.querySelector('.btn-checkout');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Chargement...';
            btn.disabled = true;
            
            setTimeout(() => {
                alert('Redirection vers la page de paiement...\n\nTotal: ' + document.getElementById('total').textContent);
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 1500);
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotal();
            
            // Animation d'entrée des items
            const items = document.querySelectorAll('.cart-item');
            items.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.5s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Permettre l'application du coupon avec Enter
            document.getElementById('coupon-input').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    applyCoupon();
                }
            });
        });

        // Animation des boutons de recommandation
        document.querySelectorAll('.btn-add-small').forEach(btn => {
            btn.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check"></i> Ajouté';
                this.style.backgroundColor = '#000000';
                this.style.color = '#ffde59';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.backgroundColor = '#ffde59';
                    this.style.color = '#000000';
                }, 2000);
            });
        });
    </script>
</body>
</html>