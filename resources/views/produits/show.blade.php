@extends('layouts.app')
@section('title', 'Détails du Produits')
@section('content')
<div class="container-fluid py-4 bg-white">
    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 w-100 w-md-auto">
        <div>
            <h1 class="h2 text-dark fw-bold d-flex align-items-center flex-wrap">
                @if($produit->latestImagePath())
                    <img src="{{ asset('storage/' . $produit->latestImagePath()) }}" alt="Image produit" class="rounded me-2" style="max-width:40px;">
                @else
                    <i class="bi bi-box-seam"></i>
                @endif
                <span>{{ $produit->nom }}</span>
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('produits.index') }}">Produits</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($produit->nom, 20) }}</li>
                </ol>
            </nav>
        </div>
            <div class="col-12 col-md-auto text-md-end">
                <a href="{{ route('produits.edit', $produit) }}" class="btn w-100 w-md-auto btn-warning bold">
                    <i class="bi bi-pencil"></i> Modifier le produit
                </a>      
            </div>
    </div>

    <div class="row g-4">
        <!-- Informations principales -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold d-flex align-items-center">
                        <i class="bi bi-info-circle me-2" style="color: #fbc926;"></i>
                        Informations du produit
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- colonnes infos produit -->
                        <div class="col-sm-6 mb-3 ">
                            <label class="form-label fw-semibold">Nom du produit</label>
                            <p class="form-control-plaintext fw-bold">{{ $produit->nom }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-semibold">Catégorie</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-dark">{{ $produit->categorie->nom }}</span>
                            </p>
                        </div>
                       @if($produit->marque)
                       <div class="col-sm-6 mb-3">
                            <label class="form-label fw-semibold">Marque</label>
                            <p class="form-control-plaintext">{{ $produit->marque ?? 'Non spécifié' }}</p>
                        </div>
                        @endif
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-semibold">Marge</label>
                            <p class="form-control-plaintext fw-bold 
                                @if(($produit->prix_vente - $produit->prix_achat) > 0) text-success @else text-danger @endif">
                                {{ number_format($produit->prix_vente - $produit->prix_achat) }} FCFA
                                ({{ number_format((($produit->prix_vente - $produit->prix_achat) / $produit->prix_achat) * 100, 2) }}%)
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques de stock -->
            <div class="card border-0 mb-4">
                <div class="card-header border-0 bg-white py-3">
                    <h5 class="mb-0 text-dark fw-bold d-flex align-items-center">
                        <i class="bi bi-graph-up me-2" style="color: #fbc926;"></i>
                        Statistiques de stock
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 col-md-3 mb-3">
                            <div class="border rounded p-3 h-100">
                                <i class="bi bi-box-seam fs-1 text-dark mb-2"></i>
                                <h4 class="fw-bold {{ $produit->quantite_stock == 0 ? 'text-danger' : ($produit->quantite_stock <= $produit->seuil_alerte ? 'text-warning' : 'text-success') }}">
                                    {{ $produit->quantite_stock }}
                                </h4>
                                <small class="text-muted">Stock actuel</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="border rounded p-3 h-100">
                                <i class="bi bi-exclamation-triangle fs-1 text-warning mb-2"></i>
                                <h4 class="fw-bold">{{ $produit->seuil_alerte }}</h4>
                                <small class="text-muted">Seuil d'alerte</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="border rounded p-3 h-100">
                                <i class="bi bi-box-arrow-in-down fs-1 text-success mb-2"></i>
                                <h4 class="fw-bold">{{ $produit->mouvements()->where('type', 'entree')->sum('quantite') }}</h4>
                                <small class="text-muted">Total entrées</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="border rounded p-3 h-100">
                                <i class="bi bi-box-arrow-up fs-1 text-danger mb-2"></i>
                                <h4 class="fw-bold">{{ $produit->mouvements()->where('type', 'sortie')->sum('quantite') }}</h4>
                                <small class="text-muted">Total sorties</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-12 col-lg-4">
             <!-- Informations produit -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-box me-2" style="color: #fbc926;"></i>
                        État du produit
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class=" p-4 d-inline-flex align-items-center justify-content-center">
                            @if($produit->latestImagePath())
                                <img src="{{ asset('storage/' . $produit->latestImagePath()) }}" alt="Image produit" class="rounded" style="max-height:150px;">
                            @else
                                <i class="bi bi-box-seam"></i>
                            @endif
                        </div>
                        <h5 class="mt-3">{{ $produit->nom }}</h5>
                    </div>

                    <!-- Graphique -->
                    <div class="my-4">
                        <label class="form-label fw-semibold">Évolution du stock</label>
                        <div class="progress mb-2" style="height: 20px;">
                            @php
                                $maxStock = max($produit->quantite_stock, $produit->seuil_alerte * 2, 10);
                                $pourcentage = min(100, ($produit->quantite_stock / $maxStock) * 100);
                                $classe = $produit->quantite_stock == 0 ? 'bg-danger' : 
                                         ($produit->quantite_stock <= $produit->seuil_alerte ? 'bg-warning' : 'bg-success');
                            @endphp
                            <div class="progress-bar {{ $classe }}" role="progressbar" 
                                 style="width: {{ $pourcentage }}%;" 
                                 aria-valuenow="{{ $pourcentage }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $produit->quantite_stock }} / {{ $maxStock }}
                            </div>
                        </div>
                        <small class="text-muted">
                            Niveau de stock: 
                            @if($produit->quantite_stock == 0)
                                <span class="text-danger">Rupture de stock</span>
                            @elseif($produit->quantite_stock <= $produit->seuil_alerte)
                                <span class="text-warning">Stock faible</span>
                            @else
                                <span class="text-success">Stock normal</span>
                            @endif
                        </small>
                    </div>

                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <small class="text-muted d-block">Prix d'achat</small>
                                <strong>{{ number_format($produit->prix_achat) }} FCFA</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <small class="text-muted d-block">Prix de vente</small>
                                <strong>{{ number_format($produit->prix_vente) }} FCFA</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
            <!-- Derniers mouvements -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold d-flex align-items-center">
                        <i class="bi bi-clock-history me-2" style="color: #fbc926;"></i>
                        Derniers mouvements
                    </h5>
                </div>
                <div class="card-body">
                    @if($produit->mouvements->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($produit->mouvements()->latest()->take(5)->get() as $mouvement)
                            <div class="list-group-item border-0 px-0 py-2">
                                <div class="d-flex justify-content-between flex-wrap align-items-center">
                                    <div>
                                        <span class="badge 
                                            @if($mouvement->type == 'entree') bg-success
                                            @else bg-danger
                                            @endif">
                                            {{ $mouvement->type == 'entree' ? 'Entrée' : 'Sortie' }}
                                        </span>
                                        <small class="text-muted ms-2">{{ $mouvement->quantite }} unités</small>
                                    </div>
                                    <small class="text-muted">{{ $mouvement->created_at->format('d/m H:i') }}</small>
                                </div>
                                @if($mouvement->remarque)
                                    <small class="text-muted d-block mt-1">{{ Str::limit($mouvement->remarque, 30) }}</small>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-2">
                            <a href="{{ route('mouvements.index') }}?produit={{ $produit->id }}" 
                               class="btn btn-sm btn-outline-dark">
                                Voir tous les mouvements
                            </a>
                        </div>
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="bi bi-inbox fs-1"></i>
                            <p class="mt-2">Aucun mouvement</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informations techniques -->
            <div class="card border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold d-flex align-items-center">
                        <i class="bi bi-tools me-2" style="color: #fbc926;"></i>
                        Informations techniques
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Créé le:</small>
                        <p class="mb-0">{{ $produit->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Dernière modification:</small>
                        <p class="mb-0">{{ $produit->updated_at->format('d/m/Y à H:i') }}</p>
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
    .list-group-item {
        border-color: #dee2e6;
    }
    .progress {
        border: 1px solid #dee2e6;
    }
    /* Ajustements mobiles */
    @media (max-width: 576px) {
        h1.h2 {
            font-size: 1.3rem;
        }
        .card-body .row > div {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endsection
