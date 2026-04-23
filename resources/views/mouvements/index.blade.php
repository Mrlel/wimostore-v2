@extends('layouts.app')
@section('title', 'Mouvemets')
@section('content')

                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="stat-card">
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-box-arrow-in-down" style="color:#f0c61d;font-size:1rem;"></i>
                                    </div>
                                    <span class="badge" style="background:rgba(45,180,90,0.15);color:#4ecb71;font-size:0.7rem;font-weight:600;padding:4px 10px;border-radius:20px;">
                                        ↑ Entrées
                                    </span>
                                </div>
                                <div class="stat-info"><h3>Entrées en stock</h3></div>
                                <div class="stat-value">{{ $mouvements->where('type', 'entree')->sum('quantite') }}</div>
                                <div class="stat-footer">
                                    <i class="bi bi-calendar3" style="font-size:0.75rem;"></i>
                                    total affiché
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="stat-card">
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-box-arrow-up" style="color:#f0c61d;font-size:1rem;"></i>
                                    </div>
                                    <span class="badge" style="background:rgba(255,80,80,0.12);color:#ff8080;font-size:0.7rem;font-weight:600;padding:4px 10px;border-radius:20px;">
                                        ↓ Sorties
                                    </span>
                                </div>
                                <div class="stat-info"><h3>Sorties du stock</h3></div>
                                <div class="stat-value">{{ $mouvements->where('type', 'sortie')->sum('quantite') }}</div>
                                <div class="stat-footer">
                                    <i class="bi bi-calendar3" style="font-size:0.75rem;"></i>
                                    total affiché
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="container-fluid py-4">
                    <!-- En-tête -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4">
                        <div>
                            <h1 class="h2 text-dark fw-bold d-flex align-items-center flex-wrap">
                                <i class="bi bi-arrow-left-right me-2" style="color: #fbc926;"></i>
                                Mouvements de Stock
                            </h1>
                            <p class="text-muted mb-0">Historique des entrées et sorties de stock</p>
                        </div>
                        <div class="col-12 col-md-auto text-md-end">
                            <a href="{{ route('mouvements.create') }}" class="btn w-100 w-md-auto text-dark fw-bold" style="background-color: #fbc926;">
                                <i class="bi bi-plus-circle me-1"></i> Ajouter un mouvement
                            </a>
                        </div>
                    </div>


   
    <div class="card border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-funnel me-2" style="color: #fbc926;"></i>
                Filtres de recherche
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('mouvements.index') }}">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="type" class="form-label fw-semibold">Type de mouvement</label>
                        <select id="type" name="type" class="form-select border-1 border-dark">
                            <option value="">Tous les types</option>
                            <option value="entree" {{ request('type') == 'entree' ? 'selected' : '' }}>Entrée de stock</option>
                            <option value="sortie" {{ request('type') == 'sortie' ? 'selected' : '' }}>Sortie de stock</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="produit" class="form-label fw-semibold">Produit</label>
                        <select id="produit" name="produit" class="form-select border-1 border-dark">
                            <option value="">Tous les produits</option>
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id }}" {{ request('produit') == $produit->id ? 'selected' : '' }}>
                                    {{ $produit->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn text-dark me-2 w-100" style="background-color: #fbc926;">
                            <i class="bi bi-funnel me-1"></i>Filtrer
                        </button>
                        <a href="{{ route('mouvements.index') }}" class="btn btn-outline-dark">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des mouvements -->
    <div class="card border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-list-ul me-2" style="color: #fbc926;"></i>
                Historique des mouvements
            </h5>
            <span class="badge bg-dark fs-6">{{ $mouvements->total() }} résultat(s)</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-card-mobile">
                    <thead class="table-dark">
                        <tr>
                            <th class="border-dark">Date</th>
                            <th class="border-dark">Produit</th>
                            <th class="text-center border-dark">Type</th>
                            <th class="text-center border-dark">Quantité</th>
                            <th class="border-dark">Remarque</th>
                            <th class="text-center border-dark">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mouvements as $mouvement)
                        <tr>
                            <td class="align-middle" data-label="Date">
                                <small>{{ $mouvement->created_at->format('d/m/Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $mouvement->created_at->format('H:i') }}</small>
                            </td>
                            <td class="align-middle" data-label="Produit">
                                <span class="fw-semibold">{{ $mouvement->produit->nom }}</span>
                                <br>
                                <small class="text-muted">
                                    {{ $mouvement->produit->marque }}
                                    @if($mouvement->produit->modele)
                                        • {{ $mouvement->produit->modele }}
                                    @endif
                                </small>
                            </td>
                            <td class="text-center align-middle" data-label="Type">
                                @if($mouvement->type === 'entree')
                                    <span class="badge bg-success">
                                        <i class="bi bi-box-arrow-in-down me-1"></i>Entrée
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-box-arrow-up me-1"></i>Sortie
                                    </span>
                                @endif
                            </td>
                            <td class="text-center align-middle fw-bold" data-label="Quantité">
                                {{ $mouvement->quantite }}
                            </td>
                            <td class="align-middle" data-label="Remarque">
                                @if($mouvement->remarque)
                                    <small>{{ Str::limit($mouvement->remarque, 50) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <a href="{{ route('mouvements.show', $mouvement) }}" 
                                   class="btn btn-sm btn-outline-dark"
                                   data-bs-toggle="tooltip" data-bs-title="Voir détails">
                                    <i class="bi bi-eye"></i> Voir les détails
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <h5 class="text-muted mt-3">Aucun mouvement trouvé</h5>
                                    <p class="text-muted">
                                        @if(request()->anyFilled(['type', 'produit']))
                                            Aucun mouvement ne correspond à vos critères de recherche.
                                        @else
                                            Commencez par enregistrer votre premier mouvement.
                                        @endif
                                    </p>
                                    <a href="{{ route('mouvements.create') }}" class="btn text-dark mt-2" style="background-color: #fbc926;">
                                        <i class="bi bi-plus-circle me-1"></i>Créer un mouvement
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($mouvements->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
                Page {{ $mouvements->currentPage() }} sur {{ $mouvements->lastPage() }}
            </div>
            <div>
                {{ $mouvements->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
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
        vertical-align: middle;
    }
    
    .btn:hover {
        opacity: 0.9;
    }
    
    .badge {
        font-size: 0.85em;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(255, 222, 89, 0.1) !important;
    }
    
    .pagination .page-link {
        color: #000;
        border: 1px solid #000;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #fbc926;
        border-color: #000;
        color: #000;
        font-weight: bold;
    }
</style>

<script>
    // Initialiser les tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection