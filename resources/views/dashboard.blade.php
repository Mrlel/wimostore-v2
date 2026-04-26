@extends('layouts.app')
@section('title', 'Tableau de bord')
@section('content')
<style>
    /* Animations globales */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
        40% {transform: translateY(-10px);}
        60% {transform: translateY(-5px);}
    }
    
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }
    
    /* Classes d'animation réutilisables */
    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.8s ease-out forwards;
    }
    
    .animate-slideInLeft {
        animation: slideInLeft 0.7s ease-out forwards;
    }
    
    .animate-slideInRight {
        animation: slideInRight 0.7s ease-out forwards;
    }
    
    .animate-pulse {
        animation: pulse 2s infinite;
    }
    
    .animate-bounce {
        animation: bounce 2s infinite;
    }
    
    .animate-shimmer {
        background: linear-gradient(to right, #f6f7f8 8%, #edeef1 18%, #f6f7f8 33%);
        background-size: 1000px 100%;
        animation: shimmer 2s infinite linear;
    }
    
    /* Application des animations avec délais */
    .welcome-section {
        animation: fadeInUp 0.8s ease-out;
    }
    
    .period-filter {
        animation: slideInLeft 0.7s ease-out 0.2s both;
    }
    
    .stats-grid .col-md-4:nth-child(1) {
        animation: fadeInUp 0.6s ease-out 0.3s both;
    }
    
    .stats-grid .col-md-4:nth-child(2) {
        animation: fadeInUp 0.6s ease-out 0.4s both;
    }
    
    .stats-grid .col-md-4:nth-child(3) {
        animation: fadeInUp 0.6s ease-out 0.5s both;
    }
    
    .actions-grid .action-card:nth-child(1) {
        animation: fadeInUp 0.6s ease-out 0.6s both;
    }
    
    .actions-grid .action-card:nth-child(2) {
        animation: fadeInUp 0.6s ease-out 0.7s both;
    }
    
    .actions-grid .action-card:nth-child(3) {
        animation: fadeInUp 0.6s ease-out 0.8s both;
    }
    
    .alert-section {
        animation: fadeInUp 0.8s ease-out 0.9s both;
    }
    
    /* Quick Actions */
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .action-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
    }

    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.7s;
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        border-color: rgb(0, 0, 0);
    }
    
    .action-card:hover::before {
        left: 100%;
    }

    .action-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        background-color: #fbc92662;
        color: #fbc926;
        font-size: 24px;
        transition: all 0.3s ease;
    }
    
    .action-card:hover .action-icon {
        transform: scale(1.1);
        background-color: #fbc926;
        color: white;
    }

    .action-title {
        font-size: 16px;
        font-weight: 500;
        color: #495057;
        margin-bottom: 8px;
        transition: color 0.3s ease;
    }
    
    .action-card:hover .action-title {
        color: #000;
    }

    .action-desc {
        color: #6c757d;
        font-size: 13px;
        margin-bottom: 15px;
        transition: color 0.3s ease;
    }
    
    .action-card:hover .action-desc {
        color: #495057;
    }

    .action-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #fbc926;
        color: #ffffffff;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .action-btn::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
    }
    
    .action-btn:hover {
        background-color: #e6b800;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .action-btn:hover::after {
        animation: ripple 1s ease-out;
    }
    
    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 0.5;
        }
        100% {
            transform: scale(20, 20);
            opacity: 0;
        }
    }
    
    /* Section Bienvenue */
    .welcome-section {
        border: 1px solid #e9ecef;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    }

    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(248, 200, 10, 0.05), transparent);
        transform: rotate(45deg);
        animation: shimmer 3s infinite linear;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
    }

    .welcome-title {
        font-size: 2rem;
        font-weight: 800;
        color: #000;
        margin-bottom: 10px;
        font-family: 'Playfair Display', serif;
    }
    
    .welcome-title i {
        display: inline-block;
        animation: bounce 2s infinite;
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        color: #333;
        margin-bottom: 20px;
        opacity: 0.9;
    }

    .user-info-badge {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 25px;
        padding: 8px 20px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: #000;
        transition: all 0.3s ease;
    }
    
    .user-info-badge:hover {
        background: rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    /* Alertes et Rappels */
    .alert-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .alert-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #e9ecef;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .alert-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: #fbc926;
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .alert-item:last-child {
        border-bottom: none;
    }

    .alert-item:hover {
        background-color: #f8f9fa;
        border-radius: 8px;
        transform: translateX(5px);
    }
    
    .alert-item:hover::before {
        transform: scaleY(1);
    }

    .alert-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 18px;
        transition: all 0.3s ease;
    }
    
    .alert-item:hover .alert-icon {
        transform: scale(1.1);
    }

    .alert-icon.warning {
        background-color: #fff3cd;
        color: #856404;
        border: 2px solid #ffeaa7;
    }

    .alert-icon.info {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 2px solid #bee5eb;
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-weight: 600;
        color: #000;
        margin-bottom: 2px;
    }

    .alert-desc {
        color: #6c757d;
        font-size: 13px;
    }

    /* Filtre période amélioré */
    .period-filter {
        background: white;
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 25px;
    }

    .period-filter label {
        font-weight: 600;
        color: #000;
    }

    .period-filter select {
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .period-filter select:focus {
        border-color: #fbc926;
        box-shadow: 0 0 0 0.2rem rgba(255, 222, 89, 0.25);
        transform: scale(1.02);
    }
    
    /* Stats Cards */
    .stats-grid .border {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stats-grid .border::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: #fbc926;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .stats-grid .border:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .stats-grid .border:hover::before {
        transform: scaleX(1);
    }
    
    .stats-grid i {
        transition: all 0.3s ease;
    }
    
    .stats-grid .border:hover i {
        transform: scale(1.1);
    }
    
    /* Animation pour le badge d'alertes */
    .badge.bg-dark {
        animation: pulse 2s infinite;
    }
</style>

<!-- Section Bienvenue et Informations -->
<div class="welcome-section">
    <div class="welcome-content">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="welcome-title">
                    Bonjour, {{ Auth::user()->nom ?? 'Utilisateur' }} ! 👋
                </h2>
                <p class="welcome-subtitle">
                    Bienvenue sur votre tableau de bord. Voici un résumé de votre activité aujourd'hui.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <span class="user-info-badge">
                        <i class="bi bi-calendar-check"></i>
                        {{ now()->format('d/m/Y') }}
                    </span>
                    <a href="{{ route('cabines.qr.download', ['cabine' => auth()->user()->cabine->id]) }}" class="user-info-badge text-decoration-none">
                        <i class="bi bi-qr-code"></i>
                        #{{ auth()->user()->cabine->code }}
                    </a>
                    <a href="{{ auth()->user()->cabine->public_url }}" target="_blank" class="user-info-badge text-decoration-none">
                        <i class="bi bi-shop"></i>
                        {{ auth()->user()->cabine->nom_cab}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@php $hasBoutique = \App\Models\CabinePage::where('cabine_id', auth()->user()->cabine_id)->exists(); @endphp
@if(!$hasBoutique)
{{-- Bannière "Créer ma boutique" pour les utilisateurs sans boutique --}}
<div style="
    background: linear-gradient(135deg, #111 0%, #1a1a1a 100%);
    border: 1px solid rgba(240,198,29,0.3);
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
">
    <div style="display:flex;align-items:center;gap:14px;">
        <div style="
            width:48px;height:48px;border-radius:12px;
            background:rgba(240,198,29,0.12);
            border:1px solid rgba(240,198,29,0.25);
            display:flex;align-items:center;justify-content:center;
            font-size:1.4rem;flex-shrink:0;
        ">🛍️</div>
        <div>
            <div style="color:#fff;font-weight:700;font-size:0.95rem;margin-bottom:3px;">
                Vous n'avez pas encore de boutique en ligne
            </div>
            <div style="color:rgba(255,255,255,0.5);font-size:0.82rem;">
                Créez votre vitrine en quelques minutes et commencez à vendre en ligne.
            </div>
        </div>
    </div>
    <a href="{{ route('Ma_boutique.create') }}" style="
        background:#f0c61d;color:#000;font-weight:700;
        padding:10px 22px;border-radius:8px;
        text-decoration:none;font-size:0.88rem;
        white-space:nowrap;flex-shrink:0;
        transition:all .2s;
    " onmouseover="this.style.background='#e0b800'" onmouseout="this.style.background='#f0c61d'">
        <i class="bi bi-shop me-1"></i> Créer ma boutique
    </a>
</div>
@endif

<!-- Filtre Période -->
<div class="period-filter d-flex flex-wrap gap-3">
    <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <i class="bi bi-funnel me-2 fs-5 text-dark"></i>
            <label class="me-3 fw-semibold">Filtrer par période :</label>
            <select name="periode" id="periode" onchange="this.form.submit()" 
                    class="form-select form-select-sm w-auto border-2">
                <option value="aujourdhui" {{ $periode == 'aujourdhui' ? 'selected' : '' }}>Aujourd'hui</option>
                <option value="semaine" {{ $periode == 'semaine' ? 'selected' : '' }}>Cette semaine</option>
                <option value="mois" {{ $periode == 'mois' ? 'selected' : '' }}>Ce mois</option>
                <option value="annee" {{ $periode == 'annee' ? 'selected' : '' }}>Cette année</option>
            </select>
        </div>
    </form>
 <a href="{{ route('ventes.create') }}" class="btn btn-outline-dark text-start">
                            <i class="bi bi-cart-plus me-2"></i>Nouvelle vente
                        </a>
                        <a href="{{ route('produits.create') }}" class="btn btn-outline-dark text-start">
                            <i class="bi bi-box-seam me-2"></i>Nouveau produit
                        </a>
                        <a href="{{ route('ventes.index') }}" class="btn btn-outline-dark text-start">
                            <i class="bi bi-list-check me-2"></i>Voir mes ventes
                        </a>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="card-body">
        <div class="row">
            <div class="col-6 col-md-4 mb-3">
                <div class="stat-card">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-cart-check" style="color:#f0c61d;font-size:1rem;"></i>
                        </div>
                    </div>
                    <div class="stat-info"><h3>Ventes</h3></div>
                    <div class="stat-value">{{ $ventes->total_ventes ?? 0 }}</div>
                    <div class="stat-footer">
                        <i class="bi bi-calendar3" style="font-size:0.75rem;"></i>
                        {{ $periode ?? 'aujourd\'hui' }}
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 mb-3">
                <div class="stat-card">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-exclamation-triangle" style="color:#f0c61d;font-size:1rem;"></i>
                        </div>
                        @if($produits_faible_stock > 0)
                        <span class="badge" style="background:rgba(255,80,80,0.12);color:#ff8080;font-size:0.7rem;font-weight:600;padding:4px 10px;border-radius:20px;">
                            ↓ Alerte
                        </span>
                        @endif
                    </div>
                    <div class="stat-info"><h3>Stock faible</h3></div>
                    <div class="stat-value">{{ $produits_faible_stock }}</div>
                    <div class="stat-footer">
                        <i class="bi bi-box-seam" style="font-size:0.75rem;"></i>
                        produit(s) concerné(s)
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <div class="stat-card">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-cash-stack" style="color:#f0c61d;font-size:1rem;"></i>
                        </div>
                    </div>
                    <div class="stat-info"><h3>Chiffre d'affaires</h3></div>
                    <div class="stat-value">{{ number_format($ventes->chiffre_affaires ?? 0) }}<span style="color:#f0c61d;font-size:1rem;"> FCFA</span></div>
                    <div class="stat-footer">
                        <i class="bi bi-calendar3" style="font-size:0.75rem;"></i>
                        {{ $periode ?? 'aujourd\'hui' }}
                    </div>
                </div>
            </div>
        </div>
<!-- 
<div class="row mt-4">
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm p-3">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-graph-up"></i> Évolution du chiffre d'affaires</h5>
            <canvas id="ventesChart" height="150"></canvas>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm p-3">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-box-seam"></i> Stocks les plus faibles</h5>
            <canvas id="stocksChart" height="150"></canvas>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
-->
<script>
document.addEventListener("DOMContentLoaded", function () {
    // --- Données depuis le contrôleur ---
    const ventesLabels = @json($ventesParJour->pluck('jour')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m')));
    const ventesData = @json($ventesParJour->pluck('total'));

    const stockLabels = @json($stocks->pluck('nom'));
    const stockData = @json($stocks->pluck('quantite_stock'));

    // --- Graphique des ventes ---
    const ctxVentes = document.getElementById('ventesChart');
    new Chart(ctxVentes, {
        type: 'line',
        data: {
            labels: ventesLabels,
            datasets: [{
                label: 'Chiffre d\'affaires (FCFA)',
                data: ventesData,
                borderColor: '#fbc926',
                backgroundColor: 'rgba(251, 201, 38, 0.2)',
                fill: true,
                tension: 0.3,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // --- Graphique des stocks faibles ---
    const ctxStocks = document.getElementById('stocksChart');
    new Chart(ctxStocks, {
        type: 'doughnut',
        data: {
            labels: stockLabels,
            datasets: [{
                label: 'Stock restant',
                data: stockData,
                backgroundColor: [
                    '#fbc926', '#ffd54f', '#ffb300', '#f57c00', '#e65100'
                ],
                hoverOffset: 10
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});

    // Animation supplémentaire au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        // Ajout d'un effet de stagger pour les éléments de la grille
        const actionCards = document.querySelectorAll('.action-card');
        actionCards.forEach((card, index) => {
            card.style.animationDelay = `${0.6 + (index * 0.1)}s`;
        });
        
        // Animation pour les stats
        const statsCards = document.querySelectorAll('.stats-grid .border');
        statsCards.forEach((card, index) => {
            card.style.animationDelay = `${0.3 + (index * 0.1)}s`;
        });
        
        // Effet de particules sur le bouton de bienvenue
        const welcomeTitle = document.querySelector('.welcome-title');
        if (welcomeTitle) {
            welcomeTitle.addEventListener('mouseover', function() {
                this.style.transform = 'scale(1.02)';
                this.style.transition = 'transform 0.3s ease';
            });
            
            welcomeTitle.addEventListener('mouseout', function() {
                this.style.transform = 'scale(1)';
            });
        }
    });
</script>

@endsection