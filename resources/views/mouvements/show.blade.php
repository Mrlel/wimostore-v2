@extends('layouts.app')
@section('title', 'Détails du mouvement')
@section('content')
<div class="container-fluid py-4 bg-white rounded">
    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-dark fw-bold">
                <i class="bi bi-clipboard-data me-2" style="color: #fbc926;"></i>
                Détails du Mouvement
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mouvements.index') }}">Mouvements</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Détails du  mouvement effectué par : 
                                <span class="fw-bold text-dark">{{ $mouvement->user->nom }}</span></li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ url()->previous() }}" class="btn btn-outline-dark me-2">
                <i class="bi bi-arrow-left me-1"></i>Retour
            </a>
        </div>
    </div>

    <!-- Détails du mouvement -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-info-circle me-2" style="color: #fbc926;"></i>
                        Informations du mouvement
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Date et heure</label>
                            <p class="form-control-plaintext">
                                {{ $mouvement->created_at->format('d/m/Y H:i:s') }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Type de mouvement</label>
                            <p class="form-control-plaintext">
                                @if($mouvement->type === 'entree')
                                    <span class="badge bg-success">
                                        <i class="bi bi-box-arrow-in-down me-1"></i>Entrée de stock
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-box-arrow-up me-1"></i>Sortie de stock
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Produit</label>
                            <p class="form-control-plaintext fw-semibold">{{ $mouvement->produit->nom }}</p>
                            <small class="text-muted">
                                {{ $mouvement->produit->marque }}
                                @if($mouvement->produit->modele)
                                    • {{ $mouvement->produit->modele }}
                                @endif
                            </small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Quantité</label>
                            <p class="form-control-plaintext fw-bold fs-5">{{ $mouvement->quantite }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stock avant</label>
                            <p class="form-control-plaintext fw-bold">
                                @php
                                    $stockApres = $mouvement->type === 'entree' 
                                        ? $mouvement->produit->quantite_stock - $mouvement->quantite
                                        : $mouvement->produit->quantite_stock + $mouvement->quantite ;
                                @endphp
                                {{ $stockApres }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stock après</label>
                            <p class="form-control-plaintext fw-bold">
                                 {{ $mouvement->produit->quantite_stock }}
                            </p>
                        </div>
                        @if($mouvement->remarque)
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Remarque</label>
                            <div class="border rounded p-3 bg-light">
                                {{ $mouvement->remarque }}
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <!-- Informations produit -->
        <div class="col-lg-4">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-box me-2" style="color: #fbc926;"></i>
                        État du produit
                    </h5>
                </div>
                <div class="card-body border-0">
                    <div class="text-center mb-4">
                        <div class=" p-4 d-inline-flex align-items-center justify-content-center">
                            @if($mouvement->produit->latestImagePath())
                                <img src="{{ asset('storage/' . $mouvement->produit->latestImagePath()) }}" alt="rounded" class="img-thumbnail" style="max-height:120px;">
                            @else
                                <i class="bi bi-box-seam"></i>
                            @endif
                        </div>
                        <h5 class="mt-3">{{ $mouvement->produit->nom }}</h5>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Stock actuel</label>
                        <div class="progress mb-2" style="height: 20px;">
                            @php
                                $pourcentage = min(100, ($mouvement->produit->quantite_stock / max($mouvement->produit->seuil_alerte * 3, 1)) * 100);
                                $classe = $mouvement->produit->quantite_stock == 0 ? 'bg-danger' : 
                                         ($mouvement->produit->quantite_stock <= $mouvement->produit->seuil_alerte ? 'bg-warning' : 'bg-success');
                            @endphp
                            <div class="progress-bar {{ $classe }}" role="progressbar" 
                                 style="width: {{ $pourcentage }}%;" 
                                 aria-valuenow="{{ $pourcentage }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $mouvement->produit->quantite_stock }}
                            </div>
                        </div>
                        <small class="text-muted">
                            Seuil d'alerte: {{ $mouvement->produit->seuil_alerte }}
                        </small>
                    </div>

                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <small class="text-muted d-block">Prix d'achat</small>
                                <strong>{{ number_format($mouvement->produit->prix_achat) }} FCFA</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <small class="text-muted d-block">Prix de vente</small>
                                <strong>{{ number_format($mouvement->produit->prix_vente) }} FCFA</strong>
                            </div>
                        </div>
                    </div>
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
    }
    
    .badge {
        font-size: 0.9em;
    }
    
    .progress {
        border: 1px solid #dee2e6;
    }
</style>
@endsection