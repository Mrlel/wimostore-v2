@extends('layouts.base')

@section('content')
<div class="container">
    <!-- Carte principale avec le même style -->
    <div class="card mb-4 border-0">
        <div class="card-header py-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0">
                    <i class="bi bi-globe2 text-success me-2"></i>
                    Liste des pages
                </h3>
                <a href="{{ route('cabine_pages.create') }}" class="btn btn-warning text-bold">
                    <i class="fas fa-plus me-1"></i>Enregistrer une nouvelle page
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Message de succès -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Barre de recherche -->
            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchPages" class="form-control" 
                           placeholder="Rechercher par titre, cabine ou statut...">
                </div>
            </div>

            <!-- Tableau -->
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="border-0">Cabine</th>
                            <th class="border-0">Titre</th>
                            <th class="border-0">Statut</th>
                            <th class="border-0">Crée le</th>
                            <th class="border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="pagesTableBody">
                        @forelse($pages as $page)
                            <tr class="page-row" 
                                data-titre="{{ strtolower($page->titre ?? '') }}"
                                data-cabine="{{ strtolower($page->cabine->nom_cab ?? '') }}"
                                data-statut="{{ $page->est_publiee ? 'publiée' : 'brouillon' }}">
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-shop text-muted me-2"></i>
                                        {{ $page->cabine->nom_cab ?? 'Sans titre' }}
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="fw-bold text-dark">{{ $page->titre ?? 'Sans titre' }}</span>
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-{{ $page->est_publiee ? 'success' : 'secondary' }}">
                                        {{ $page->est_publiee ? '✅ Publiée' : '❌ Brouillon' }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $page->created_at }}
                                    </small>
                                </td>
                                <td class="align-middle text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('cabine_pages.edit', $page->id) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ $page->cabine->public_url }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-success"
                                           title="Voir">
                                            <i class="fas fa-globe"></i>
                                        </a>
                                        <form action="{{ route('cabine_pages.destroy', $page->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Attention ! Voulez-vous vraiment supprimer cette page ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyState">
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-file-alt fa-2x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Aucune page créée pour l'instant</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Compteur de résultats -->
            <div class="mt-3 text-end">
                <small id="resultCount" class="text-muted fw-bold">
                    {{ $pages->count() }} page(s) trouvée(s)
                </small>
            </div>
        </div>
    </div>

</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .btn-outline-orange {
        color: #fbc926;
        border-color: #fbc926;
    }
    
    .btn-outline-orange:hover {
        background-color: #fbc926;
        color: #000;
        border-color: #fbc926;
    }
    
    .table th {
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }
    
    .table td {
        border-bottom: 1px solid #dee2e6;
    }
    
    .btn-group .btn {
        border-radius: 4px;
        margin-left: 2px;
    }
    
    .page-row {
        transition: background-color 0.2s ease;
    }
    
    .page-row:hover {
        background-color: rgba(251, 201, 38, 0.05);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchPages');
    const pageRows = document.querySelectorAll('.page-row');
    const emptyState = document.getElementById('emptyState');
    const resultCount = document.getElementById('resultCount');
    
    // Fonction de recherche instantanée
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let visibleCount = 0;
        
        pageRows.forEach(row => {
            const titre = row.getAttribute('data-titre');
            const cabine = row.getAttribute('data-cabine');
            const statut = row.getAttribute('data-statut');
            
            const matches = 
                titre.includes(searchTerm) || 
                cabine.includes(searchTerm) || 
                statut.includes(searchTerm) ||
                searchTerm === '';
            
            if (matches) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Gérer l'affichage de l'état vide
        if (emptyState) {
            if (visibleCount === 0 && searchTerm !== '') {
                emptyState.style.display = '';
                emptyState.innerHTML = `
                    <td colspan="5" class="text-center py-4">
                        <i class="fas fa-search fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Aucun résultat trouvé pour "${searchTerm}"</p>
                    </td>
                `;
            } else if (visibleCount === 0) {
                emptyState.style.display = '';
                emptyState.innerHTML = `
                    <td colspan="5" class="text-center py-4">
                        <i class="fas fa-file-alt fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Aucune page créée pour l'instant</p>
                    </td>
                `;
            } else {
                emptyState.style.display = 'none';
            }
        }
        
        // Mettre à jour le compteur
        resultCount.textContent = `${visibleCount} page(s) trouvée(s)`;
    });
    
    // Focus sur la barre de recherche
    searchInput.focus();
});
</script>
@endsection