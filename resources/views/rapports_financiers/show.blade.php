@extends('layouts.app')

@section('title', 'Rapport Financier - ' . $rapport->periode)

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex  flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 w-100 w-md-auto">
        <div>
            <h1 class="h2 text-dark fw-bold d-flex align-items-center flex-wrap">
                <i class="bi bi-graph-up me-2" style="color: #fbc926;"></i>
                Rapport Financier
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('rapports-financiers.index') }}">Rapports Financiers</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $rapport->periode }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @if(!$rapport->est_valide)
                <a href="{{ route('rapports-financiers.edit', $rapport) }}" class="btn btn-outline-dark ">
                    <i class="bi bi-pencil me-1"></i>
                    Modifier
                </a>
            @endif
            
            <a href="{{ route('rapports-financiers.export-pdf', $rapport) }}" class="btn text-dark fw-bold " style="background-color: #fbc926;">
                <i class="bi bi-file-earmark-pdf me-1"></i>
                Exporter en PDF
            </a>
            <a href="{{ route('rapports-financiers.export-excel', $rapport) }}" class="btn text-white fw-bold " style="background-color: #27a53cff;">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Exporter en Excel
            </a>
           
        </div>
    </div>
    <div class="card-body ">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-3">
                <a href="#produits" class="btn btn-outline-dark w-100">
                <i class="bi bi-bar-chart fs-3 mb-2"></i>
                    <h5 class="mb-2 fw-bold">{{ number_format($rapport->chiffre_affaires_total, 0, ',', ' ') }} FCFA</h5>
                    Chiffre d'affaires
                </a>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <a href="#ventes" class="btn btn-outline-dark w-100">
                <i class="bi bi-cash-coin fs-3 mb-2"></i>
                    <h5 class="fw-bold mb-2">{{ number_format($rapport->marge_brute, 0, ',', ' ') }} FCFA</h5>
                   Gain sur les ventes 
                </a>
            </div>
             <div class="col-md-3 col-6 mb-3">
                <a href="#profil" class="btn btn-outline-dark w-100">
                <i class="bi bi-currency-exchange fs-3 mb-2"></i>
                    <h5 class="fw-bold">{{ number_format($rapport->couts_fixes_total ?? ($rapport->loyer + $rapport->electricite + $rapport->eau + $rapport->internet + $rapport->maintenance + $rapport->autres_charges), 0, ',', ' ') }} FCFA</h5>
                    Coûts fixes (dépenses)
                </a>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <a href="#mouvements" class="btn btn-outline-dark w-100">
                <i class="bi bi-wallet2 fs-3 mb-2"></i>
                    <h5 class="fw-bold">
                        {{ number_format($rapport->marge_nette, 0, ',', ' ') }} FCFA
                    </h5>
                    Gain net (bénéfices)
                </a>
            </div>
        </div>
    </div>
    <div class="row bg-white rounded">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <!-- Détails des ventes et coûts -->
            <div class="flex-colmun">
                 <!-- Métriques de performance -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-bar-chart me-2" style="color: #fbc926;"></i>
                        Métriques de Performance
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3 text-center">
                            <h3 class=" fw-bold">{{ $rapport->nombre_ventes }}</h3>
                            <p class="text-muted mb-0">Nombre de ventes</p>
                        </div>
                        <div class="col-md-3 mb-3 text-center">
                            <h3 class="fw-bold">{{ $rapport->nombre_produits_vendus }}</h3>
                            <p class="text-muted mb-0">Produits vendus</p>
                        </div>
                        <div class="col-md-3 mb-3 text-center">
                            <h3 class=" fw-bold">{{ number_format($rapport->panier_moyen, 0, ',', ' ') }} FCFA</h3>
                            <p class="text-muted mb-0">Panier moyen</p>
                        </div>
                        <div class="col-md-3 mb-3 text-center">
                            <h3 class=" fw-bold">{{ number_format($rapport->produit_moyen_vendu, 1) }}</h3>
                            <p class="text-muted mb-0">Produits/vente</p>
                        </div>
                    </div>
                </div>
            </div>
                <!-- Détails des ventes -->
                <div class="col-md-12 mb-4">
                    <div class="card border-0 h-100">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="mb-0 text-dark fw-bold">
                                <i class="bi bi-cart me-2" style="color: #fbc926;"></i>
                                Détail des Ventes
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="border-dark"><strong>Espèces</strong></td>
                                            <td class="text-end border-dark">{{ number_format($rapport->ventes_especes, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                        <tr>
                                            <td class="border-dark"><strong>Carte bancaire</strong></td>
                                            <td class="text-end border-dark">{{ number_format($rapport->ventes_carte, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                        <tr>
                                            <td class="border-dark"><strong>Mobile Money</strong></td>
                                            <td class="text-end border-dark">{{ number_format($rapport->ventes_mobile, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                        <tr>
                                            <td class="border-dark"><strong>Virement</strong></td>
                                            <td class="text-end border-dark">{{ number_format($rapport->ventes_virement, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                        <tr>
                                            <td class="border-dark"><strong>Autre</strong></td>
                                            <td class="text-end border-dark">{{ number_format($rapport->ventes_autre, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                        <tr class="table-success">
                                            <td class="border-dark"><strong>Total</strong></td>
                                            <td class="text-end border-dark fw-bold">{{ number_format($rapport->chiffre_affaires_total, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Détails des coûts -->
                <div class="col-md-12 mb-4">
                    <div class="card border-0 h-100">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="mb-0 text-dark fw-bold">
                                <i class="bi bi-cash-coin me-2" style="color: #fbc926;"></i>
                                Détail des Coûts
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <tbody>
                                        @if($rapport->cout_achats_total > 0)
                                        <tr>
                                            <td class="border-dark"><strong>Coût des achats</strong></td>
                                            <td class="text-end border-dark">{{ number_format($rapport->cout_achats_total, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                        @endif
                                        
                                        @if($rapport->loyer > 0)
                                        <tr>
                                            <td class="border-dark"><strong>Loyer</strong></td>
                                            <td class="text-end border-dark">{{ number_format($rapport->loyer, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                        @endif
                                        
                                        @if($rapport->electricite > 0)
                                        <tr>
                                            <td class="border-dark"><strong>Électricité</strong></td>
                                            <td class="text-end border-dark">{{ number_format($rapport->electricite, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                        @endif
                                        
                                        @if($rapport->eau > 0)
                                        <tr>
                                            <td class="border-dark"><strong>Eau</strong></td>
                                            <td class="text-end border-dark">{{ number_format($rapport->eau, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                        @endif
                                        
                                        @if($rapport->internet > 0)
                                        <tr>
                                            <td class="border-dark"><strong>Internet</strong></td>
                                            <td class="text-end border-dark">{{ number_format($rapport->internet, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                        @endif
                                        
                                        @if($rapport->maintenance > 0)
                                        <tr>
                                            <td class="border-dark"><strong>Maintenance</strong></td>
                                            <td class="text-end border-dark">{{ number_format($rapport->maintenance, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                        @endif
                                        
                                        @if($rapport->autres_charges > 0)
                                        <tr>
                                            <td class="border-dark"><strong>Autres charges</strong></td>
                                            <td class="text-end border-dark">{{ number_format($rapport->autres_charges, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                        @endif
                                        
                                        <!-- Afficher le total uniquement s'il y a au moins un coût -->
                                        @php
                                            $hasCosts = $rapport->cout_achats_total > 0 || 
                                                       $rapport->loyer > 0 || 
                                                       $rapport->electricite > 0 || 
                                                       $rapport->eau > 0 || 
                                                       $rapport->internet > 0 || 
                                                       $rapport->maintenance > 0 || 
                                                       $rapport->autres_charges > 0;
                                        @endphp
                                        
                                        @if($hasCosts)
                                        <tr class="table-warning">
                                            <td class="border-dark"><strong>Total coûts</strong></td>
                                            <td class="text-end border-dark fw-bold">{{ number_format(($rapport->cout_achats_total ?? 0) + ($rapport->couts_fixes_total ?? ($rapport->loyer + $rapport->electricite + $rapport->eau + $rapport->internet + $rapport->maintenance + $rapport->autres_charges)), 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td colspan="2" class="text-center text-muted border-dark">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Aucun coût enregistré
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Informations du rapport -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-info-circle me-2" style="color: #fbc926;"></i>
                        Informations du Rapport
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="form-control-plaintext text-capitalize">Type de rapport : {{ $rapport->type_rapport }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="form-control-plaintext">Créé par : {{ $rapport->user->nom ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="form-control-plaintext">Date de création : {{ $rapport->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="form-control-plaintext">
                            Statut :
                            @if($rapport->est_valide)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-lg me-1"></i>Validé
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-clock me-1"></i>En attente
                                </span>
                            @endif
                        </p>
                    </div>
                    @if($rapport->est_valide)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Validé par</label>
                            <p class="form-control-plaintext">{{ $rapport->validePar->nom ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Date de validation</label>
                            <p class="form-control-plaintext">{{ $rapport->date_validation->format('d/m/Y à H:i') }}</p>
                        </div>
                    @endif
                    
                    @if($rapport->remarques)
                        <div class="mt-3">
                            <label class="form-label fw-semibold">Remarques</label>
                            <p class="form-control-plaintext text-muted">{{ $rapport->remarques }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions de validation -->
            @if(!$rapport->est_valide)
                <div class="card border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 text-dark fw-bold">
                            <i class="bi bi-check-circle me-2" style="color: #fbc926;"></i>
                            Validation du Rapport
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rapports-financiers.valider', $rapport) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="remarques_validation" class="form-label fw-semibold">Remarques de validation</label>
                                <textarea name="remarques" id="remarques_validation" rows="3" 
                                        class="form-control border-1 border-dark" 
                                        placeholder="Ajoutez des remarques lors de la validation..."></textarea>
                            </div>
                            <button type="submit" class="btn text-dark fw-bold w-100" style="background-color: #fbc926;">
                                <i class="bi bi-check-lg me-1"></i>
                                Valider ce rapport
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="card border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 text-dark fw-bold">
                            <i class="bi bi-arrow-counterclockwise me-2" style="color: #fbc926;"></i>
                            Annuler la Validation
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">Si vous souhaitez modifier ce rapport, vous devez d'abord annuler sa validation.</p>
                        <form action="{{ route('rapports-financiers.annuler-validation', $rapport) }}" method="POST" 
                            onsubmit="return confirm('Êtes-vous sûr de vouloir annuler la validation de ce rapport ?')">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark w-100">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                Annuler la validation
                            </button>
                        </form>
                    </div>
                </div>
            @endif
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
    
    .border-bottom {
        border-color: #fbc926 !important;
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
    
    .badge {
        font-size: 0.85em;
    }
    
    .form-control-plaintext {
        padding: 0.375rem 0;
        margin-bottom: 0;
        line-height: 1.5;
        background-color: transparent;
        border: solid transparent;
        border-width: 1px 0;
    }
</style>

<script>
    // Initialiser les tooltips Bootstrap si nécessaire
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection