@extends('layouts.app')
@section('title', 'Liste des Produits')
@section('content')

<style>
    .badge{
        font-size:13px;
    }
</style><div class="stats-grid">

  <!-- Card 1 : Quantité globale -->
  <div class="stat-card">
    <div class="d-flex align-items-start justify-content-between mb-3">
      <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
        <i class="bi bi-box-seam" style="color:#f0c61d;font-size:1rem;"></i>
      </div>
      <span class="badge" style="background:rgba(45,180,90,0.15);color:#4ecb71;font-size:0.7rem;font-weight:600;padding:4px 10px;border-radius:20px;">
        ↑ 
      </span>
    </div>
    <div class="stat-info">
      <h3>Quantité globale</h3>
    </div>
    <div class="stat-value">{{ $produits->sum('quantite_stock') }}</div>
    <div class="stat-footer">
      <i class="bi bi-box2" style="font-size:0.75rem;"></i>
      Quantité globale de tous les produits enregistrés
    </div>
  </div>

  <!-- Card 2 : Valeur d'entrée en stock -->
  <div class="stat-card">
    <div class="d-flex align-items-start justify-content-between mb-3">
      <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
        <i class="bi bi-wallet" style="color:#f0c61d;font-size:1rem;"></i>
      </div>
      <span class="badge" style="background:rgba(45,180,90,0.15);color:#4ecb71;font-size:0.7rem;font-weight:600;padding:4px 10px;border-radius:20px;">
        ↑ 
      </span>
    </div>
    <div class="stat-info">
      <h3>Valeur d'entrée en stock</h3>
    </div>
    <div class="stat-value">{{ number_format($valeur_acquisition ?? 0, 0, ',', ' ') }}<span style="color:#f0c61d;"> FCFA</span></div>
    <div class="stat-footer">
      <i class="bi bi-shop" style="font-size:0.75rem;"></i>
      Valeur totale des marchandises à l'achat
    </div>
  </div>

  <!-- Card 3 : Valeur commerciale -->
  <div class="stat-card">
    <div class="d-flex align-items-start justify-content-between mb-3">
      <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
        <i class="bi bi-wallet2" style="color:#f0c61d;font-size:1rem;"></i>
      </div>
      <span class="badge" style="background:rgba(233, 167, 0, 0.12);color:#ff8080;font-size:0.7rem;font-weight:600;padding:4px 10px;border-radius:20px;">
        ↑ 
      </span>
    </div>
    <div class="stat-info">
      <h3>Valeur commerciale</h3>
    </div>
    <div class="stat-value">{{ number_format($valeur_revente ?? 0, 0, ',', ' ') }}<span style="color:#f0c61d;"> FCFA</span></div>
    <div class="stat-footer">
      <i class="bi bi-cart3" style="font-size:0.75rem;"></i>
      Valeur totale des marchandises à la revente
    </div>
  </div>

</div>
<!-- En-tête -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h1 class="h2 h-md2 text-dark fw-bold mb-1">
            <i class="bi bi-list-ul me-2" style="color: #000000;"></i>
            Mes Produits 
        </h1>
        <p class="text-muted small small-md mb-0">Consultez et gérez tous vos produits</p>
    </div>

    <div class="d-flex flex-sm-row gap-2">
        <a href="{{ route('produits.create') }}" 
           class="btn text-dark fw-bold px-3 py-2 fs-sm" 
           style="background-color: #fbc926;">
            <i class="bi bi-box-seam me-1"></i> Enregistrer un produit
        </a>

        <a href="{{ route('categories.index') }}" 
           class="btn text-dark fw-bold px-3 py-2 fs-sm" 
           style="background-color: #fbc926;">
           <i class="bi bi-list-ul me-1"></i> Catégorie des produits
        </a>
    </div>
</div>

<!-- Filtres -->
<div class="card border-0 bg-light mb-4" style="margin: 3rem 0;">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-12 col-lg-6">
                <label for="search" class="form-label fw-semibold small-md">
                     Recherche
                </label>
                <input type="text" id="search" name="search"    
                    class="form-control border-1 border-dark fs-sm"
                    placeholder="Rechercher un produit...">
            </div> 
            <div class="col-md-12 col-lg-6">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="categorie" class="form-label fw-semibold small-md">
                         Catégorie
                        </label>
                        <select id="categorie" class="form-select border-1 border-dark fs-sm">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="publier" class="form-label fw-semibold small-md">
                             Statut
                        </label>
                        <select id="publier" class="form-select border-1 border-dark fs-sm">
                            <option value="">Tous les statuts</option>
                            <option value="1">Publié</option>
                            <option value="0">Non publié</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Résultats et tableau -->
    <div class="card border-0 shadow-sm">
       <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-list-ul me-2" style="color: #000000;"></i>
                Liste des produits
            </h5>
            <span class="badge bg-dark fs-6">{{ $produits->count() }} produit(s)</span>
        </div>
    <div class="card-body p-0">
        @if($produits->count() > 0)
        <div class="table-responsive">
            <table id="produits-table" class="table table-hover mb-0 table-card-mobile">
                <thead class="table-dark small-md">
                    <tr>
                        <th class="ps-4">Désignation</th>
                        <th>Code</th>
                        <th>Catégorie</th>
                        <th>Statut</th>
                        <th>Prix achat</th>
                        <th>Prix vente</th>
                        <th>Qté</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="fs-sm">
                    @foreach ($produits as $produit)
                    <tr data-categorie-id="{{ $produit->categorie->id }}" data-publier="{{ $produit->publier ? '1' : '0' }}" data-nom="{{ strtolower($produit->nom) }}" data-code="{{ strtolower($produit->code) }}" data-categorie-nom="{{ strtolower($produit->categorie->nom) }}">
                        <td class="ps-4 fw-semibold" data-label="Désignation">
                            @if($produit->images->last())
                                <img src="{{ asset('storage/' . $produit->images->last()->path) }}" 
                                    alt="Image du produit" 
                                    class="img-fluid me-2 rounded shadow-sm" 
                                    style="max-width: 50px; max-height: 40px;">
                                {{ $produit->nom }}
                            @else
                                <i class="bi bi-box-seam me-2" style="color: #000000;"></i>{{ $produit->nom }}
                            @endif
                        </td>
                        <td data-label="Code"><span>{{ $produit->code }}</span></td>
                        <td data-label="Catégorie">{{ $produit->categorie->nom }}</td>
                        <td data-label="Statut">
                            @if($produit->publier == true)
                                <span class="badge bg-dark">Publié <i class="bi bi-check-circle text-success ms-1"></i></span>
                            @else
                                <span class="badge bg-secondary">Non publié</span>
                            @endif
                        </td>
                        <td data-label="Prix achat">{{ number_format($produit->prix_achat, 0, ',', ' ') }} FCFA</td>
                        <td class="fw-bold text-success" data-label="Prix vente">{{ number_format($produit->prix_vente, 0, ',', ' ') }} FCFA</td>
                        <td data-label="Quantité">
                            <div class="d-flex align-items-center gap-1">
                                <span>{{ $produit->quantite_stock }}</span>
                                @if($produit->quantite_stock == 0)
                                    <span class="badge bg-danger">Rupture</span>
                                @elseif($produit->quantite_stock <= $produit->seuil_alerte)
                                    <span class="badge bg-warning text-dark">Faible</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton{{ $produit->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $produit->id }}">
                                    @if (Auth::user()->role === 'responsable')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('produits.edit', $produit->id) }}">
                                            <i class="bi bi-pencil text-primary me-2"></i> Modifier
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="{{ route('produits.show', $produit->id) }}">
                                            <i class="bi bi-eye me-2"></i> Détails
                                        </a>
                                    </li>
                                    <li>
                                        <button 
                                            type="button" 
                                            class="dropdown-item btn-reappro" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#reapprovisionnerModal"
                                            data-id="{{ $produit->id }}"
                                            data-nom="{{ $produit->nom }}">
                                            <i class="bi bi-box-arrow-down me-2"></i> Réapprovisionner
                                        </button>
                                    </li>
                                    @if($produit->publier == false)
                                    <li>
                                        <form action="{{ route('produits.publier', $produit->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-globe-americas me-2"></i> Publier
                                            </button>
                                        </form>
                                    </li>
                                    @else
                                    <li>
                                        <form action="{{ route('produits.despublier', $produit->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-globe-americas me-2"></i> Rétirer
                                            </button>
                                        </form>
                                    </li>
                                    @endif
                                    @can('manage-gestionnaires')
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('produits.destroy', $produit->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit?')">
                                                <i class="bi bi-trash me-2"></i> Supprimer
                                            </button>
                                        </form>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        
        @else
        <div class="text-center py-5">
            <div class="py-4">
                <i class="bi bi-inbox display-6 text-muted fs-2"></i>
            </div>
            <p class="text-muted fs-6 mb-2">Aucun produit trouvé</p>
            <p class="text-muted mb-4 small">Commencez par ajouter votre premier produit</p>
            <a href="{{ route('produits.create') }}" class="btn text-dark fw-bold px-3 py-2 fs-sm" style="background-color: #fbc926;">
                <i class="bi bi-plus-circle me-1"></i> Ajouter un produit
            </a>
        </div>
        @endif
    </div>
</div>

<div class="modal fade" id="reapprovisionnerModal" tabindex="-1" aria-labelledby="reapprovisionnerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reapprovisionnerModalLabel">Réapprovisionner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form method="POST" id="reapproForm">

                        @csrf
                        <div class="mb-3">
                            <label for="quantite" class="form-label fw-semibold small">Quantité *</label>
                            <input type="number" class="form-control fs-sm" id="quantite" name="quantite" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn text-dark fw-bold px-3 py-2 fs-sm" style="background-color: #fbc926;">
                                <i class="bi bi-box-arrow-down me-1"></i> Reapprovisionner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>

<!-- Modal pour créer une catégorie -->
<div class="modal fade" id="categorieModal" tabindex="-1" aria-labelledby="categorieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="categorieModalLabel">Créer une nouvelle catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nom" class="form-label fw-semibold small">Nom de la catégorie *</label>
                        <input type="text" class="form-control fs-sm" id="nom" name="nom" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn text-dark fw-bold px-3 py-2 fs-sm" style="background-color: #fbc926;">
                            <i class="bi bi-check-lg me-1"></i> Créer la catégorie
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('reapprovisionnerModal');
    const modalTitle = modal.querySelector('.modal-title');
    const form = document.getElementById('reapproForm');
    
    document.querySelectorAll('.btn-reappro').forEach(button => {
        button.addEventListener('click', function() {
            const produitId = this.dataset.id;
            const produitNom = this.dataset.nom;

            // Met à jour le titre du modal
            modalTitle.textContent = 'Réapprovisionner : ' + produitNom;

            // Met à jour dynamiquement l’action du formulaire
            form.action = '/produits/' + produitId + '/reapprovisionner';
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const categorieSelect = document.getElementById('categorie');
    const publierSelect = document.getElementById('publier');
    const produitsTable = document.getElementById('produits-table');
    
    if (!produitsTable || !searchInput || !categorieSelect || !publierSelect) return;
    
    const tableRows = produitsTable.querySelectorAll('tbody tr');

    function filterTable() {
        const query = searchInput.value.trim().toLowerCase();
        const categorieValue = categorieSelect.value;
        const publierValue = publierSelect.value;
        
        let visibleCount = 0;

        tableRows.forEach(row => {
            // Récupération des données depuis les attributs data
            const categorieId = row.getAttribute('data-categorie-id');
            const publier = row.getAttribute('data-publier');
            const nom = row.getAttribute('data-nom') || '';
            const code = row.getAttribute('data-code') || '';
            const categorieNom = row.getAttribute('data-categorie-nom') || '';
            
            // Récupération du texte des cellules pour la recherche dans les prix et quantités
            const cells = row.querySelectorAll('td');
            let prixAchat = '';
            let prixVente = '';
            let quantite = '';
            
            if (cells.length > 4) prixAchat = cells[4].textContent.trim().toLowerCase();
            if (cells.length > 5) prixVente = cells[5].textContent.trim().toLowerCase();
            if (cells.length > 6) quantite = cells[6].textContent.trim().toLowerCase();
            
            // Recherche globale dans toutes les colonnes
            const searchMatch = !query || 
                nom.includes(query) || 
                code.includes(query) || 
                categorieNom.includes(query) ||
                prixAchat.includes(query) ||
                prixVente.includes(query) ||
                quantite.includes(query);
            
            // Filtre par catégorie (comparaison par ID)
            const categorieMatch = !categorieValue || categorieId === categorieValue;
            
            // Filtre par statut (comparaison directe)
            const publierMatch = !publierValue || publier === publierValue;
            
            // Afficher ou masquer la ligne selon les filtres
            const shouldShow = searchMatch && categorieMatch && publierMatch;
            row.style.display = shouldShow ? '' : 'none';
            
            if (shouldShow) visibleCount++;
        });
        
        // Mise à jour du badge de comptage (optionnel)
        const countBadge = document.querySelector('.badge.bg-dark');
        if (countBadge) {
            countBadge.textContent = visibleCount + ' produit(s)';
        }
    }

    // Événements pour déclencher le filtrage
    searchInput.addEventListener('input', filterTable);
    categorieSelect.addEventListener('change', filterTable);
    publierSelect.addEventListener('change', filterTable);
    
    // Initialisation du filtrage au chargement
    filterTable();
});
</script>

<!-- Styles responsives -->
<style>
/* Mobile : texte plus petit */
@media (max-width: 576px) {
  .h2 { font-size: 1.25rem !important; } /* ~20px */
  .h4 { font-size: 1.15rem !important; }
  .fs-sm { font-size: 0.875rem !important; } /* 14px */
  .small-md { font-size: 0.9rem !important; }
  .display-6 { font-size: 2rem !important; } /* Icône inbox */
}
</style>
@endsection
