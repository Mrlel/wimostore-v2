@extends('layouts.base')
@section('title', 'Gestion des boutiques')

@section('content')
@include('layouts.message')

<div class="container-fluid py-4">
    
    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 w-100 w-md-auto">
        <div>
            <h1 class="h2 text-dark fw-bold d-flex align-items-center flex-wrap">
                <i class="bi bi-shop me-2" style="color: #ffde59;"></i>
                Gestion des boutiques
            </h1>
            <p class="text-muted mb-0">Gérez les boutiques et leurs configurations</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn text-dark fw-bold" type="button" data-bs-toggle="modal" data-bs-target="#createCabineModal" style="background-color: #ffde59;">
                <i class="bi bi-plus-circle me-1"></i> Nouvelle boutique
            </button>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="card border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-shop me-2" style="color: #ffde59;"></i>
                Liste des boutiques
            </h5>
            <span class="badge bg-dark fs-6">{{ $cabines->count() }} cabine(s)</span>
        </div>
        <div class="card-body p-0">
            <!-- Barre de recherche et filtres -->
            <div class="p-4 border-bottom bg-light">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-dark">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-dark cabine-search-box" placeholder="Rechercher une cabine...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select border-dark cabine-status-filter">
                            <option value="">Tous les statuts</option>
                            <option value="actif">Actives</option>
                            <option value="inactif">Inactives</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select border-dark cabine-type-filter">
                            <option value="">Tous les types</option>
                            <option value="admin">Compte Admin</option>
                            <option value="illimite">Compte Illimité</option>
                            <option value="standard">Compte Standard</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tableau des cabines -->
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="border-dark">Code & Statut</th>
                            <th class="border-dark">Nom</th>
                            <th class="border-dark">Localisation</th>
                            <th class="border-dark">Type de Compte</th>
                            <th class="border-dark">Certification</th>
                            <th class="text-center border-dark">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cabines as $cabine)
                        <tr class="cabine-row">
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 bg-light rounded p-2 me-3">
                                        @if($cabine->est_actif == 0)
                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                        @else
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-bold text-dark">{{ $cabine->code }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="text-dark fw-medium">{{ $cabine->nom_cab }}</span>
                            </td>
                            <td class="align-middle">
                                <span class="text-muted">{{ $cabine->localisation ?? 'Non spécifié' }}</span>
                            </td>
                            <td class="align-middle">
                                @if($cabine->type_compte == 'admin')
                                    <span class="badge bg-dark">
                                        <i class="bi bi-shield-check me-1"></i>Compte Admin
                                    </span>
                                @elseif($cabine->type_compte == 'illimite')
                                    <span class="badge bg-success">
                                        Compte Illimité
                                    </span>
                                @else
                                    <span class="badge bg-primary">
                                        Compte Standard
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($cabine->certifier)
                                    <span class="badge bg-success">
                                        Certifié
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Non certifié
                                    </span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
    <div class="dropdown btn-group" role="group">
        <button class="btn btn-sm btn-light dropdown-toggle" 
                type="button" 
                id="dropdownMenuButton{{ $cabine->id }}" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
            <i class="bi bi-three-dots-vertical"></i>
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow-sm" 
            aria-labelledby="dropdownMenuButton{{ $cabine->id }}">

            <!-- Modifier -->
            <li>
                <a class="dropdown-item" 
                   href="{{ route('cabines.edit', $cabine) }}">
                    <i class="bi bi-pencil me-2 text-primary"></i>Modifier
                </a>
            </li>

            <!-- Voir détails -->
            <li>
                <a class="dropdown-item" 
                   href="{{ route('cabines.show', $cabine) }}">
                    <i class="bi bi-eye me-2 text-info"></i>Voir détails
                </a>
            </li>

            <!-- Activer / Désactiver -->
            @if(auth()->user()->role == 'superadmin')
            <li>
                <form action="{{ route('admin.cabines.toggle', $cabine) }}" 
                      method="POST" 
                      class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="dropdown-item text-warning"
                            onclick="return confirm('Voulez-vous vraiment {{ $cabine->est_actif ? 'désactiver' : 'activer' }} cette cabine ?')">
                        <i class="bi bi-power me-2"></i>
                        {{ $cabine->est_actif ? 'Désactiver' : 'Activer' }}
                    </button>
                </form>
            </li>
            @endif

            <!-- Supprimer -->
            <li>
                <form action="{{ route('cabines.destroy', $cabine) }}" 
                      method="POST" 
                      class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="dropdown-item text-danger"
                            onclick="return confirm('Voulez-vous vraiment supprimer cette cabine ?')">
                        <i class="bi bi-trash me-2"></i>Supprimer
                    </button>
                </form>
            </li>

            <!-- Certifier / Descertifier -->
            <li>
                @if(!$cabine->certifier)
                    <form action="{{ route('certification.certifierAdmin', $cabine) }}" 
                          method="POST" 
                          class="d-inline">
                        @csrf
                        <button type="submit" 
                                class="dropdown-item text-success"
                                onclick="return confirm('Voulez-vous vraiment certifier cette cabine ?')">
                            <i class="bi bi-patch-check me-2"></i>Certifier
                        </button>
                    </form>
                @else
                    <form action="{{ route('certification.desertifierAdmin', $cabine) }}" 
                          method="POST" 
                          class="d-inline">
                        @csrf
                        <button type="submit" 
                                class="dropdown-item text-danger"
                                onclick="return confirm('Voulez-vous vraiment descertifier cette cabine ?')">
                            <i class="bi bi-patch-check me-2"></i>Descertifier
                        </button>
                    </form>
                @endif
            </li>
        </ul>
    </div>
</td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-building fs-1 text-muted"></i>
                                    <h5 class="text-muted mt-3">Aucune cabine trouvée</h5>
                                    <p class="text-muted">Commencez par ajouter votre première cabine.</p>
                                    <button class="btn text-dark mt-2" style="background-color: #ffde59;" data-bs-toggle="modal" data-bs-target="#createCabineModal">
                                        <i class="bi bi-plus-circle me-1"></i>Ajouter une cabine
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($cabines->hasPages())
            <div class="card-footer bg-white py-3 border-top">
                <div class="d-flex justify-content-center">
                    {{ $cabines->links() }}
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
    
    .form-control:focus, .form-select:focus {
        border-color: #ffde59;
        box-shadow: 0 0 0 0.2rem rgba(255, 222, 89, 0.25);
    }
    
    .progress {
        background-color: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .progress-bar {
        transition: width 0.3s ease;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Filtrage des cabines
    function filterCabines() {
        const searchText = document.querySelector('.cabine-search-box').value.toLowerCase().trim();
        const statusValue = document.querySelector('.cabine-status-filter').value.toLowerCase();
        const typeValue = document.querySelector('.cabine-type-filter').value.toLowerCase();
        
        document.querySelectorAll('.cabine-row').forEach(row => {
            const code = row.cells[0].textContent.toLowerCase();
            const nom = row.cells[1].textContent.toLowerCase();
            const localisation = row.cells[2].textContent.toLowerCase();
            const typeBadge = row.cells[3].querySelector('.badge');
            const type = typeBadge ? typeBadge.textContent.toLowerCase() : '';
            const statusIcon = row.cells[0].querySelector('i');
            const isActive = statusIcon.classList.contains('bi-check-circle-fill');
            
            const matchesSearch = !searchText || 
                                code.includes(searchText) || 
                                nom.includes(searchText) || 
                                localisation.includes(searchText);
            
            const matchesStatus = !statusValue || 
                                (statusValue === 'actif' && isActive) || 
                                (statusValue === 'inactif' && !isActive);
            
            const matchesType = !typeValue || type.includes(typeValue);
            
            row.style.display = (matchesSearch && matchesStatus && matchesType) ? '' : 'none';
        });
    }

    // Événements de filtrage
    let searchTimeout;
    document.querySelector('.cabine-search-box').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(filterCabines, 300);
    });
    
    document.querySelector('.cabine-status-filter').addEventListener('change', filterCabines);
    document.querySelector('.cabine-type-filter').addEventListener('change', filterCabines);

    // Auto-focus sur le premier champ du modal
    const cabineModal = document.getElementById('createCabineModal');
    if (cabineModal) {
        cabineModal.addEventListener('shown.bs.modal', function () {
            const firstInput = cabineModal.querySelector('input');
            if (firstInput) firstInput.focus();
        });
    }
});
</script>

@endsection

@include('admin.modals.create-cabine')
