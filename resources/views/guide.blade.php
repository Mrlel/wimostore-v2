@extends('layouts.app')
@section('title', 'Guide d\'utilisation')
@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="text-center mb-5">
        <h1 class="h2 text-dark fw-bold">
            <i class="bi bi-book me-2" style="color: #fbc926;"></i>
            Guide d'Utilisation - Tout Savoir
        </h1>
        <p class="lead text-muted">Votre compagnon pour maîtriser toutes les fonctionnalités de l'application</p>
    </div>

    <!-- Navigation rapide améliorée -->
    <div class="card border-0 mb-5">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-compass me-2" style="color: #fbc926;"></i>
                Accès Rapide aux Fonctionnalités
            </h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-2 col-6 mb-3">
                    <a href="#boutique" class="btn btn-outline-dark w-100">
                        <i class="bi bi-shop d-block fs-3 mb-2"></i>
                        Ma Boutique
                    </a>
                </div>
                <div class="col-md-2 col-6 mb-3">
                    <a href="#produits" class="btn btn-outline-dark w-100">
                        <i class="bi bi-box-seam d-block fs-3 mb-2"></i>
                        Produits
                    </a>
                </div>
                <div class="col-md-2 col-6 mb-3">
                    <a href="#ventes" class="btn btn-outline-dark w-100">
                        <i class="bi bi-cart-check d-block fs-3 mb-2"></i>
                        Ventes
                    </a>
                </div>
                <div class="col-md-2 col-6 mb-3">
                    <a href="#rapports" class="btn btn-outline-dark w-100">
                        <i class="bi bi-graph-up d-block fs-3 mb-2"></i>
                        Rapports
                    </a>
                </div>
                <div class="col-md-2 col-6 mb-3">
                    <a href="#notifications" class="btn btn-outline-dark w-100">
                        <i class="bi bi-bell d-block fs-3 mb-2"></i>
                        Alertes
                    </a>
                </div>
                <div class="col-md-2 col-6 mb-3">
                    <a href="#profil" class="btn btn-outline-dark w-100">
                        <i class="bi bi-person d-block fs-3 mb-2"></i>
                        Profil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Ma Boutique -->
    <div id="boutique" class="card border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-shop me-2" style="color: #fbc926;"></i>
                 Gérer Ma Boutique
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold text-dark mb-3">Créer/Modifier ma boutique</h6>
                    <p class="text-muted mb-3"><small>Configurez l'identité de votre commerce</small></p>
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item border-0">Allez dans <strong>"Gerer ma Boutique"</strong></li>
                        <li class="list-group-item border-0">Cliquez sur <strong>"Créer"</strong> ou <strong>"Modifier"</strong></li>
                        <li class="list-group-item border-0">Renseignez le nom, adresse, téléphone etc</li>
                        <li class="list-group-item border-0">Sauvegardez les informations</li>
                    </ol>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold text-dark mb-3">📊 Voir les statistiques</h6>
                    <p class="text-muted mb-3"><small>Suivez la performance de votre boutique</small></p>
                    <ul class="list-group">
                        <li class="list-group-item border-0">Consultez le <strong>nombre de visites</strong></li>
                        <li class="list-group-item border-0">Analysez les <strong>tendances</strong></li>
                        <li class="list-group-item border-0">Identifiez les <strong>périodes d'activité</strong></li>
                    </ul>
                </div>
            </div>

            <div class="alert alert-info mt-4">
                <i class="bi bi-lightbulb me-2"></i>
                <strong>Astuce:</strong> Une boutique bien configurée permet de mieux gérer vos stocks et ventes.
            </div>
            @if (Auth::user()->role === 'responsable')
            <div class="text-center mt-3">
                <a href="{{ route('Ma_boutique') }}" class="btn btn-outline-dark">
                    <i class="bi bi-eye me-1"></i>
                    Gerer ma boutique
                </a>
            </div>
            @endif
        </div>
    </div>
    <!-- Section Produits améliorée -->
    <div id="produits" class="card border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-box-seam me-2" style="color: #fbc926;"></i>
                Gestion des Produits
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p class="text-muted mb-3"><small>Enregistrez un nouveau produit en stock</small></p>
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item border-0">Cliquez sur <strong>"Ajouter un Produit"</strong></li>
                        <li class="list-group-item border-0">Créer et Choisissez une catégorie</li>
                        <li class="list-group-item border-0">Remplissez le nom, description</li>
                        <li class="list-group-item border-0">Définissez le prix d'achat et de vente</li>
                        <li class="list-group-item border-0">Indiquez la quantité initiale</li>
                    </ol>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold text-dark mb-3">📋 Gérer le stock</h6>
                    <p class="text-muted mb-3"><small>Maintenez vos stocks à jour</small></p>
                    <ul class="list-group">
                        <li class="list-group-item border-0"><strong>Réapprovisionner</strong> les produits</li>
                        <li class="list-group-item border-0"><strong>Publier/Masquer</strong> des produits</li>
                        <li class="list-group-item border-0">Voir l'<strong>historique des mouvements</strong></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold text-dark mb-3">🔍 Rechercher & Filtrer</h6>
                    <p class="text-muted mb-3"><small>Trouvez rapidement vos produits</small></p>
                    <ul class="list-group">
                        <li class="list-group-item border-0">Recherche par <strong>nom ou code</strong></li>
                        <li class="list-group-item border-0">Filtrage par <strong>catégorie</strong></li>
                        <li class="list-group-item border-0">Voir les <strong>stocks faibles</strong></li>
                    </ul>
                </div>
            </div>

            <div class="alert alert-warning mt-4">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Important:</strong> Pensez à ajuster régulièrement vos stocks pour éviter les ruptures.
            </div>
        </div>
    </div>

    <!-- Section Ventes améliorée -->
    <div id="ventes" class="card border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-cart-check me-2" style="color: #fbc926;"></i>
                 Gestion des Ventes & Reçus
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h6 class="fw-bold text-dark mb-3">🛒 Créer une vente</h6>
                    <p class="text-muted mb-3"><small>Enregistrez une nouvelle transaction</small></p>
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item border-0">Cliquez sur <strong>"Enregistrer une Vente"</strong></li>
                        <li class="list-group-item border-0">Sélectionnez les produits vendus</li>
                        <li class="list-group-item border-0">Indiquez les quantités</li>
                        <li class="list-group-item border-0">Le total se calcule automatiquement</li>
                        <li class="list-group-item border-0">Validez la vente</li>
                    </ol>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold text-dark mb-3">🧾 Générer des reçus</h6>
                    <p class="text-muted mb-3"><small>Créez des reçus professionnels</small></p>
                    <ul class="list-group">
                        <li class="list-group-item border-0"><strong>Imprimer</strong> un reçu de vente</li>
                        <li class="list-group-item border-0"><strong>Télécharger</strong> en PDF</li>
                        <li class="list-group-item border-0"><strong>Envoyer par email ou whatsapp</strong> au client</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold text-dark mb-3">📈 Suivi des ventes</h6>
                    <p class="text-muted mb-3"><small>Analysez vos performances</small></p>
                    <ul class="list-group">
                        <li class="list-group-item border-0">Voir l'<strong>historique complet</strong></li>
                        <li class="list-group-item border-0">Filtrer par <strong>date ou période</strong></li>
                        <li class="list-group-item border-0">Modifier une vente existante</li>
                        <li class="list-group-item border-0">Consulter les <strong>statistiques</strong></li>
                    </ul>
                </div>
            </div>

            <div class="alert alert-success mt-4">
                <i class="bi bi-currency-euro me-2"></i>
                <strong>Bon à savoir:</strong> Chaque vente réduit automatiquement le stock des produits vendus.
            </div>
        </div>
    </div>

    <!-- Section Rapports Financiers -->
    <div id="rapports" class="card border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-graph-up me-2" style="color: #fbc926;"></i>
                Rapports Financiers & Inventaire
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold text-dark mb-3">📋 Rapports Financiers</h6>
                    <p class="text-muted mb-3"><small>Analysez la santé financière de votre boutique</small></p>
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item border-0">Allez dans <strong>"Rapports Financiers"</strong></li>
                        <li class="list-group-item border-0">Cliquez sur <strong>"Nouveau rapport"</strong></li>
                        <li class="list-group-item border-0">Sélectionnez la période à analyser</li>
                        <li class="list-group-item border-0">Générez le rapport</li>
                        <li class="list-group-item border-0"><strong>Validez</strong> le rapport ou <strong>annulez</strong> la validation</li>
                        <li class="list-group-item border-0">Exportez en <strong>PDF</strong></li>
                    </ol>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold text-dark mb-3">📦 Gestion d'Inventaire</h6>
                    <p class="text-muted mb-3"><small>Contrôlez l'ensemble de votre stock</small></p>
                    <ul class="list-group">
                        <li class="list-group-item border-0">Voir <strong>tout l'inventaire</strong> en un coup d'œil</li>
                        <li class="list-group-item border-0">Identifier les <strong>produits en rupture</strong></li>
                        <li class="list-group-item border-0">Détecter les <strong>surstocks</strong></li>
                        <li class="list-group-item border-0">Générer un <strong>PDF d'inventaire</strong></li>
                        <li class="list-group-item border-0">Analyser les <strong>mouvements de stock</strong></li>
                    </ul>
                </div>
            </div>

            <div class="alert alert-info mt-4">
                <i class="bi bi-lightbulb me-2"></i>
                <strong>Conseil:</strong> Génerez des rapports mensuels pour mieux planifier vos réapprovisionnements.
            </div>
            @if (Auth::user()->role === 'responsable')
            <div class="text-center mt-3">
                <a href="{{ route('rapports-financiers.create') }}" class="btn text-dark fw-bold me-2" style="background-color: #fbc926;">
                    <i class="bi bi-file-earmark-text me-1"></i>
                    Créer un rapport
                </a>
                <a href="{{ route('inventaire') }}" class="btn btn-outline-dark">
                    <i class="bi bi-clipboard-data me-1"></i>
                    Voir l'inventaire
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Section Notifications -->
    <div id="notifications" class="card border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-bell me-2" style="color: #fbc926;"></i>
                 Système de Notifications
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold text-dark mb-3">📱 Gérer les alertes</h6>
                    <p class="text-muted mb-3"><small>Restez informé en temps réel</small></p>
                    <ul class="list-group">
                        <li class="list-group-item border-0">Consultez toutes vos <strong>notifications</strong></li>
                        <li class="list-group-item border-0"><strong>Marquer comme lu</strong> une notification</li>
                        <li class="list-group-item border-0"><strong>Marquer tout comme lu</strong> en un clic</li>
                        <li class="list-group-item border-0"><strong>Supprimer</strong> les notifications anciennes</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold text-dark mb-3">⚠️ Types d'alertes</h6>
                    <p class="text-muted mb-3"><small>Les alertes que vous pouvez recevoir</small></p>
                    <ul class="list-group">
                        <li class="list-group-item border-0"><strong>Stocks faibles</strong> - Produits à réapprovisionner</li>
                        <li class="list-group-item border-0"><strong>Ruptures de stocks</strong> - Produits manquant</li>
                        <li class="list-group-item border-0"><strong>Activités importantes</strong> - Événements clés</li>
                    </ul>
                </div>
            </div>

            <div class="alert alert-warning mt-4">
                <i class="bi bi-bell-fill me-2"></i>
                <strong>Attention:</strong> Les notifications de stocks faibles vous aident à éviter les ruptures de stock.
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('notifications') }}" class="btn text-dark fw-bold" style="background-color: #fbc926;">
                    <i class="bi bi-bell me-1"></i>
                    Voir mes notifications
                </a>
            </div>
        </div>
    </div>

    <!-- Section Tableau de Bord -->
    <div id="dashboard" class="card border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-speedometer2 me-2" style="color: #fbc926;"></i>
                Tableau de Bord
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="fw-bold text-dark mb-3">🎯 Vue d'ensemble de votre activité</h6>
                    <p class="text-muted mb-3"><small>Surveillez vos performances en un coup d'œil</small></p>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item border-0"><strong>Chiffre d'affaires du jour</strong> - Vos ventes quotidiennes</li>
                                <li class="list-group-item border-0"><strong>Produits en stock faible</strong> - À réapprovisionner</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                                                <li class="list-group-item border-0"><strong>Ventes du mois</strong> - Performance mensuelle</li>
                                <li class="list-group-item border-0"><strong>Alertes importantes</strong> - Notifications critiques</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-success mt-4">
                <i class="bi bi-graph-up-arrow me-2"></i>
                <strong>Performance:</strong> Consultez régulièrement votre tableau de bord pour prendre des décisions éclairées.
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('dashboard') }}" class="btn text-dark fw-bold" style="background-color: #fbc926;">
                    <i class="bi bi-speedometer2 me-1"></i>
                    Accéder au tableau de bord
                </a>
            </div>
        </div>
    </div>

    <!-- Section Profil améliorée -->
    <div id="profil" class="card border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-person me-2" style="color: #fbc926;"></i>
                 Mon Profil & Paramètres
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold text-dark mb-3">📝 Informations personnelles</h6>
                    <p class="text-muted mb-3"><small>Gérez vos données personnelles</small></p>
                    <ul class="list-group">
                        <li class="list-group-item border-0"><strong>Nom et prénom</strong> - Votre identité</li>
                        <li class="list-group-item border-0"><strong>Adresse email</strong> - Pour les connexions</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold text-dark mb-3">🔒 Sécurité & Préférences</h6>
                    <p class="text-muted mb-3"><small>Personnalisez votre expérience</small></p>
                    <ul class="list-group">
                        <li class="list-group-item border-0"><strong>Modifier le mot de passe</strong> - Pour plus de sécurité</li>
                        <li class="list-group-item border-0"><strong>Paramètres de notification</strong> - Choisir les alertes</li>
                    </ul>
                </div>
            </div>

            <div class="alert alert-info mt-4">
                <i class="bi bi-shield-check me-2"></i>
                <strong>Sécurité:</strong> Changez régulièrement votre mot de passe pour protéger votre compte.
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('profile.show') }}" class="btn text-dark fw-bold" style="background-color: #fbc926;">
                    <i class="bi bi-person-circle me-1"></i>
                    Gérer mon profil
                </a>
            </div>
        </div>
    </div>

    <!-- Support amélioré -->
    <div class="text-center mt-5">
        <div class="card border-0 bg-light">
            <div class="card-body py-5">
                <i class="bi bi-headset fs-1 text-dark mb-3"></i>
                <h4 class="text-dark fw-bold">Besoin d'aide supplémentaire ?</h4>
                <p class="text-muted">Notre équipe de support est là pour vous accompagner</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="https://wa.me/2250585986100" class="btn btn-outline-dark">
                        <i class="bi bi-whatsapp me-1"></i>WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    .card {
        border: 2px solid #000;
    }
    
    .card-header {
        border-bottom: 2px solid #000 !important;
    }
    
    .btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    
    #boutique, #produits, #ventes, #rapports, #notifications, #dashboard, #profil {
        scroll-margin-top: 100px;
    }
    
    .list-group-item {
        padding: 0.5rem 0;
        background: transparent;
    }
    
    .alert {
        border: 1px solid #000;
    }
    
    /* Animation pour les sections */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
</style>

<script>
    // Smooth scroll pour la navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Animation au défilement
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

    // Observer les cartes
    document.querySelectorAll('.card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
</script>
@endsection