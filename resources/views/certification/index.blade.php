@extends('layouts.app')
@section('title', 'Certification - Inventaire')
@section('content')
<style>
:root {
    --primary-color: #0D6E6E;
    --secondary-color: #fbc926;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
    --info-color: #000000;
}

.dashboard-card {
    border: none;
    border-radius: 12px;
    transition: transform 0.3s ease;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: linear-gradient(135deg, #ffffff, #f8f9fa);
    border-radius: 10px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
}

.stat-value {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 5px;
}

.stat-label {
    color: #6c757d;
    font-size: 14px;
    font-weight: 500;
}

.badge-marge {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success-color);
    font-weight: 600;
}

.table-enhanced th {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 1rem;
}

.table-enhanced td {
    vertical-align: middle;
    padding: 1rem;
}

.progress-stock {
    height: 8px;
    border-radius: 4px;
}

.filter-section {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
}

/* Styles spécifiques certification */
.condition-progress {
    height: 8px;
    border-radius: 4px;
    background-color: #e9ecef;
}

.condition-progress-bar {
    height: 100%;
    border-radius: 4px;
    transition: width 0.6s ease;
}

.benefit-list {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
}

.benefit-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.benefit-item:last-child {
    border-bottom: none;
}

.benefit-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.benefit-icon.success {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success-color);
}

.benefit-icon.warning {
    background: rgba(255, 193, 7, 0.1);
    color: var(--warning-color);
}

.benefit-icon.primary {
    background: rgba(13, 110, 110, 0.1);
    color: var(--primary-color);
}

.benefit-icon.info {
    background: rgba(26, 46, 53, 0.1);
    color: var(--info-color);
}

.benefit-icon.secondary {
    background: rgba(251, 201, 38, 0.1);
    color: var(--secondary-color);
}

.btn-certification {
    background: var(--secondary-color);
    color: var(--info-color);
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-certification:hover:not(.disabled) {
    background: #e6b722;
}

.btn-certification-alt {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-certification-alt:hover {
    background: #0a5959;
}
</style>

<div class="container-fluid py-4">
    <!-- En-tête identique à la page d'analyse -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-dark fw-bold">
                <i class="bi bi-award me-2" style="color: var(--secondary-color);"></i>
                Certification de Boutique
            </h1>
            <p class="text-muted mb-0">Statut de certification et avantages exclusifs</p>
        </div>
        <div class="col-md-4 text-end">
            @if($cabine->certifier)
                <span class="btn text-white bg-dark align-items-center fw-bold">
                  Status: @if($cabine->certifier) <img src="/Certifier.png" width="25" height="25" alt=""> @endif
                </span>
            @else
                <audio controls style="max-width: 380px;">
                    <source src="{{ asset('audios/page_certification.mp3') }}" type="audio/mpeg">
                    Votre navigateur ne supporte pas la lecture audio.
                </audio>
            @endif
        </div>
    </div>

    <!-- Bannière de statut -->
    <div class="dashboard-card">
        <div class="card-body rounded text-center" style="background-color: {{ $cabine->certifier ? 'var(--primary-color)' : 'var(--info-color)' }};">
            <div class="py-4">
                @if($cabine->certifier)
                    <h3 class="fw-bold text-white mb-3">
                        <i class="bi bi-patch-check me-2"></i>
                        Félicitations {{ Auth::user()->nom }} !
                    </h3>
                    <p class="text-white mb-0 fs-5">
                        Votre boutique est certifiée, vous bénéficiez maintenant des avantages de la certification 🎉
                    </p>
                @else
                    <h3 class="fw-bold text-white mb-3">
                        <i class="bi bi-info-circle me-2"></i>
                        Votre boutique n'est pas encore certifiée
                    </h3>
                    <p class="text-white mb-0">
                        Remplissez les conditions ci-dessous pour obtenir la certification
                    </p>
                @endif
            </div>
        </div>
    </div>

    @if(!$cabine->certifier)
    <!-- Conditions d'éligibilité -->
    <div class="dashboard-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title fw-bold mb-0 text-black">
                    <i class="bi bi-list-check me-2"></i>
                    Conditions d'Éligibilité
                </h5>
                
                     
            </div>

            <div class="row">
                <!-- Condition Ventes -->
                <div class="col-md-6 mb-4">
                    <div class="stat-card h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="condition-icon {{ $statistiques['nombre_ventes_mois'] >= 1500 ? 'fulfilled' : 'pending' }} me-3">
                                <i class="bi bi-cart-check"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Ventes Enregistrées</h5>
                        </div>
                        
                        <div class="stat-value">
                            {{ number_format($statistiques['nombre_ventes_mois'], 0, ',', ' ') }}
                        </div>
                        <div class="stat-label mb-3">
                            sur {{ number_format($statistiques['ventes_requises'], 0, ',', ' ') }} requises
                        </div>

                        <div class="condition-progress mb-3">
                            <div class="condition-progress-bar {{ $statistiques['nombre_ventes_mois'] >= 1500 ? 'bg-success' : 'bg-primary' }}" 
                                 style="width: {{ min($statistiques['progression_ventes'], 100) }}%">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            @if($statistiques['nombre_ventes_mois'] >= 500)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i> Condition remplie
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    {{ number_format($statistiques['ventes_requises'] - $statistiques['nombre_ventes_mois'], 0, ',', ' ') }} restantes
                                </span>
                            @endif
                            <span class="fw-bold text-dark">{{ number_format($statistiques['progression_ventes'], 1) }}%</span>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mb-4">
                     <!-- Condition Parrainage -->
                    <div class="stat-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="condition-icon {{ $statistiques['nombre_filleuls'] >= 3 ? 'fulfilled' : 'pending' }} me-3">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Filleuls Parrainés</h5>
                        </div>
                        
                        <div class="stat-value">
                            {{ number_format($statistiques['nombre_filleuls'], 0, ',', ' ') }}
                        </div>
                        <div class="stat-label mb-3">
                            sur {{ $statistiques['filleuls_requis'] }} requis
                        </div>

                        <div class="condition-progress mb-3">
                            <div class="condition-progress-bar {{ $statistiques['nombre_filleuls'] >= 3 ? 'bg-success' : 'bg-primary' }}" 
                                 style="width: {{ min($statistiques['progression_parrainage'], 100) }}%">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            @if($statistiques['nombre_filleuls'] >= 5)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i> Condition remplie
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    {{ $statistiques['filleuls_requis'] - $statistiques['nombre_filleuls'] }} restants
                                </span>
                            @endif

                            @if($statistiques['nombre_filleuls'] < 5)
                                <div class="">
                                    <a href="{{ route('parrainage.index') }}" class="btn btn-sm btn-outline-dark">
                                        <i class="bi bi-share me-1"></i>
                                        parrainer
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Avantages de la certification -->
    <div class="dashboard-card">
        <div class="card-body">
            <h5 class="card-title fw-bold mb-4 text-black">
                @if(!$cabine->certifier)
                     <i class="bi bi-gift me-2"></i> Avantages de la Certification
                @endif
            </h5>

            <div class="benefit-list">
                <div class="row">
                    <div class="col-md-6">
                        <div class="benefit-item">
                            <div class="benefit-icon success">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <div>
                                <strong class="text-black">Gestionnaires multiples</strong>
                                <p class="text-muted mb-0 small">Ajouter 1 à 10 autres gestionnaires</p>
                            </div>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon warning">
                                <i class="bi bi-award"></i>
                            </div>
                            <div>
                                <strong class="text-black">Badge certifié</strong>
                                <p class="text-muted mb-0 small">Visible sur votre page publique</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="benefit-item">
                            <div class="benefit-icon info">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div>
                                <strong class="text-black">Fiabilité</strong>
                                <p class="text-muted mb-0 small">Confiance accrue des clients</p>
                            </div>
                        </div>
                        
                        
                        <div class="benefit-item">
                            <div class="benefit-icon secondary">
                                <i class="bi bi-percent"></i>
                            </div>
                            <div>
                                <strong class="text-black">Réduction sur les frais</strong>
                                <p class="text-muted mb-0 small">-16% sur abonnement Mensuel</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appel à l'action -->
    @if(!$cabine->certifier)
    <div class="dashboard-card">
        <div class="card-body rounded text-center" style="background-color: var(--secondary-color);">
            <div class="py-4">
                <h3 class="fw-bold text-dark mb-3">
                    Obtenez Votre Certification
                </h3>
                <p class="text-dark mb-4">
                    Choisissez la méthode qui vous convient pour obtenir la certification
                </p>

                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <form action="{{ route('certification.demander') }}" method="POST" class="d-inline bg-dark rounded text-white">
                        @csrf
                        <button type="submit" 
                                class="btn btn-certification {{ !$statistiques['est_eligible'] ? 'disabled' : '' }}"
                                {{ !$statistiques['est_eligible'] ? 'disabled' : '' }}>
                            <i class="bi bi-award me-2"></i>
                            Certification Gratuite
                        </button>
                    </form>

                    <button type="button" 
        class="btn btn-certification-alt"
        data-bs-toggle="modal" 
        data-bs-target="#modalCertificationPaiement" hidden>
    <i class="bi bi-credit-card me-2"></i>
    Payer 10 000 FCFA
</button>
  <a href="https://wa.me/2250585986100?text=Bonjour%20Wimo%20👋%0AJe%20souhaite%20payer%20pour la certification de ma boutique.%0A----------------------------------------------%0ANom%20boutique%20:%20{{ urlencode(auth()->user()->cabine->nom_cab) }}%0ACode%20boutique%20:%20{{ urlencode(auth()->user()->cabine->code) }}%0A----------------------------------------------%0AMerci.%20🙏"
       target="_blank"
      class="btn btn-certification-alt">
           <i class="bi bi-credit-card me-2"></i>
    Payer 10 000 FCFA
    </a>

<!-- Modal pour le formulaire de paiement -->
<div class="modal fade" id="modalCertificationPaiement" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paiement de Certification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('certification.checkout') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Numéro de téléphone</label>
                        <input type="text" 
                               name="client_numero" 
                               class="form-control" 
                               placeholder="Ex: +225 07 12 34 56 78"
                               required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom complet</label>
                        <input type="text" 
                               name="client_nom" 
                               class="form-control" 
                               value="{{ auth()->user()->nom ?? '' }}"
                               required>
                    </div>
                    <p class="text-muted small">
                        <i class="bi bi-info-circle me-1"></i>
                        Montant à payer : <strong>10 000 FCFA</strong>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-certification-alt">
                        <i class="bi bi-credit-card me-2"></i>
                        Procéder au paiement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
                </div>

                <div class="mt-4">
                    @if(!$statistiques['est_eligible'])
                        <p class="text-dark mb-2">
                            <i class="bi bi-info-circle me-1"></i>
                            La certification gratuite nécessite de remplir toutes les conditions
                        </p>
                    @endif
                    <p class="text-dark mb-0">
                        <i class="bi bi-lightning me-1"></i>
                        L'option payante vous donne un accès immédiat à tous les avantages
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.condition-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
}

.condition-icon.fulfilled {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success-color);
}

.condition-icon.pending {
    background: rgba(13, 110, 110, 0.1);
    color: var(--primary-color);
}
</style>
@endsection