@extends('layouts.base')
@section('title', 'Liste des Abonnements')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 w-100 w-md-auto">
        <div>
            <h1 class="h2 text-dark fw-bold d-flex align-items-center flex-wrap">
                <i class="bi bi-credit-card me-2" style="color: #ffde59;"></i>
                Gestion des Abonnements
            </h1>
            <p class="text-muted mb-0">Consultez et gérez les abonnements des cabines</p>
        </div>
        <div class="d-flex">
            <a href="" class="btn text-dark fw-bold" style="background-color: #ffde59;">
                <i class="bi bi-plus-circle me-1"></i>Nouvel Abonnement
            </a>
        </div>
    </div>

    <!-- Informations tarifaires 
    <div class="card border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-info-circle me-2" style="color: #ffde59;"></i>
                Informations Tarifaires
            </h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3">
                        <i class="bi bi-calendar-check fs-1 text-dark mb-2"></i>
                        <h4 class="fw-bold">30 jours</h4>
                        <h3 class="text-success fw-bold">5 000 FCFA</h3>
                        <small class="text-muted">Abonnement standard</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3">
                        <i class="bi bi-lightning-charge fs-1 text-dark mb-2"></i>
                        <h4 class="fw-bold">Renouvellement</h4>
                        <h3 class="text-primary fw-bold">Instantané</h3>
                        <small class="text-muted">Activation immédiate</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3">
                        <i class="bi bi-shield-check fs-1 text-dark mb-2"></i>
                        <h4 class="fw-bold">Garantie</h4>
                        <h3 class="text-warning fw-bold">Sans interruption</h3>
                        <small class="text-muted">Service continu assuré</small>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Carte principale -->
    <div class="card border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-list-ul me-2" style="color: #ffde59;"></i>
                Liste des Abonnements
            </h5>
            <span class="badge bg-dark fs-6">{{ $abonnements->count() }} abonnement(s)</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="border-dark">#ID</th>
                            <th class="border-dark">Cabine</th>
                            <th class="border-dark">Date début</th>
                            <th class="border-dark">Date fin</th>
                            <th class="text-center border-dark">Jours restants</th>
                            <th class="text-center border-dark">Statut</th>
                            <th class="text-end border-dark">Montant</th>
                            <th class="text-center border-dark">Renouvellement</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($abonnements as $abonnement)
                        @php
                            $dateFin = \Carbon\Carbon::parse($abonnement->date_fin);
                            $joursRestants = $dateFin->diffInDays(now(), false) * -1;
                            $estExpire = $dateFin->isPast();
                            $expireBientot = !$estExpire && $joursRestants <= 7;
                        @endphp
                        <tr>
                            <td class="align-middle">
                                <span class="fw-bold text-dark">#{{ $abonnement->id }}</span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold text-dark">{{ $abonnement->cabine->nom_cab }}</span>
                                        <br>
                                        <small class="text-muted">{{ $abonnement->cabine->code }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="text-dark">{{ \Carbon\Carbon::parse($abonnement->date_debut)->format('d/m/Y') }}</span>
                            </td>
                            <td class="align-middle">
                                <span class="text-dark">{{ $dateFin->format('d/m/Y') }}</span>
                                @if($estExpire)
                                    <br>
                                    <small class="text-danger">
                                        <i class="bi bi-exclamation-triangle me-1"></i>Expiré
                                    </small>
                                @elseif($expireBientot)
                                    <br>
                                    <small class="text-warning">
                                        <i class="bi bi-clock me-1"></i>Expire bientôt
                                    </small>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                @if($estExpire)
                                    <span class="badge bg-danger">0 jour</span>
                                @else
                                    <span class="badge {{ $expireBientot ? 'bg-warning' : 'bg-success' }}">
                                        {{ $joursRestants }} jour(s)
                                    </span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                @if($abonnement->statut == 'actif')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Actif
                                    </span>
                                @elseif($abonnement->statut == 'inactif')
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-pause-circle me-1"></i>Inactif
                                    </span>
                                @elseif($abonnement->statut == 'expiré')
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i>Expiré
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark text-capitalize">
                                        {{ $abonnement->statut }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-end align-middle">
                                <span class="fw-bold text-dark">{{ number_format($abonnement->montant, 0, ',', ' ') }} FCFA</span>
                            </td>
                            <td class="text-center align-middle">
                                <form method="POST" action="{{ route('abonnements.renew') }}" class="d-flex gap-2 align-items-center justify-content-center">
                                    @csrf
                                    <input type="hidden" name="cabine_id" value="{{ $abonnement->cabine_id }}">
                                    
                                    <div class="input-group input-group-sm" style="width: 140px;">
                                        <span class="input-group-text bg-light border-dark">Durée</span>
                                        <select name="duree" class="form-select border-dark" required>
                                            <option value="30" selected>30 jours</option>
                                            <option value="60">60 jours</option>
                                            <option value="90">90 jours</option>
                                            <option value="180">180 jours</option>
                                            <option value="365">365 jours</option>
                                        </select>
                                    </div>
                                    
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <span class="input-group-text bg-light border-dark">Montant</span>
                                        <input type="number" name="montant" class="form-control border-dark text-end" 
                                               value="{{ $abonnement->montant }}" readonly
                                               data-base-price="5000"
                                               onchange="calculatePrice(this)">
                                        <span class="input-group-text bg-light border-dark">FCFA</span>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-sm text-dark fw-bold" style="background-color: #ffde59;"
                                            data-bs-toggle="tooltip" data-bs-title="Renouveler pour 30 jours - 5000 FCFA">
                                        <i class="bi bi-arrow-clockwise me-1"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-credit-card fs-1 text-muted"></i>
                                    <h5 class="text-muted mt-3">Aucun abonnement trouvé</h5>
                                    <p class="text-muted">Commencez par créer votre premier abonnement.</p>
                                    <a href="{{ route('abonnements.create') }}" class="btn text-dark mt-2" style="background-color: #ffde59;">
                                        <i class="bi bi-plus-circle me-1"></i>Créer un abonnement
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
    
    .table th, .table td {
        border-color: #000 !important;
    }
    
    .btn:hover {
        opacity: 0.9;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #ffde59;
        box-shadow: 0 0 0 0.2rem rgba(255, 222, 89, 0.25);
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #000;
        font-size: 0.875rem;
    }
    
    .price-calculator {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Calcul automatique du prix en fonction de la durée
    function calculatePrice(selectElement) {
        const basePrice = 5000; // Prix pour 30 jours
        const duree = parseInt(selectElement.value);
        const form = selectElement.closest('form');
        const montantInput = form.querySelector('input[name="montant"]');
        
        // Calcul proportionnel : (durée / 30) * 5000
        const nouveauMontant = Math.round((duree / 30) * basePrice);
        montantInput.value = nouveauMontant;
        
        // Mettre à jour le tooltip du bouton
        const button = form.querySelector('button[type="submit"]');
        button.setAttribute('data-bs-title', `Renouveler pour ${duree} jours - ${nouveauMontant.toLocaleString()} FCFA`);
        
        // Recréer le tooltip avec le nouveau contenu
        const tooltip = bootstrap.Tooltip.getInstance(button);
        if (tooltip) {
            tooltip.dispose();
        }
        new bootstrap.Tooltip(button);
    }

    // Appliquer le calcul initial et les écouteurs d'événements
    const dureeSelects = document.querySelectorAll('select[name="duree"]');
    dureeSelects.forEach(select => {
        // Calcul initial
        calculatePrice(select);
        
        // Écouteur pour les changements
        select.addEventListener('change', function() {
            calculatePrice(this);
        });
    });

    // Validation des formulaires de renouvellement
    const renewForms = document.querySelectorAll('form[action="{{ route("abonnements.renew") }}"]');
    renewForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const duree = this.querySelector('select[name="duree"]');
            const montant = this.querySelector('input[name="montant"]');
            
            if (!duree.value || duree.value < 1) {
                e.preventDefault();
                alert('Veuillez sélectionner une durée valide');
                duree.focus();
                return;
            }
            
            if (!montant.value || montant.value <= 0) {
                e.preventDefault();
                alert('Le montant calculé est invalide');
                return;
            }
            
            // Confirmation avant renouvellement
            const confirmation = confirm(`Confirmez-vous le renouvellement pour ${duree.value} jours pour ${parseInt(montant.value).toLocaleString()} FCFA ?`);
            if (!confirmation) {
                e.preventDefault();
            }
        });
    });

    // Afficher le prix de base dans une alerte info
    console.log('💰 Abonnement standard : 30 jours = 5 000 FCFA');
});
</script>
@endsection