@extends('layouts.app')
@section('title', 'Catégories des produits')
@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="h2 text-dark fw-bold mb-1">
            <a  href="{{ url()->previous() }}" class="btn btn-outline-dark rounded">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>
            Liste des catégories ({{ $categories->count() }})
        </h2>
    </div>

    <div class="col-12 col-md-auto gap-2">
        <button type="button" 
                class="btn w-100 md:w-auto text-dark fw-bold" 
                style="background-color: #fbc926;" 
                data-bs-toggle="modal" data-bs-target="#categorieModalCreate">
            <i class="bi bi-bookmarks me-1"></i>Créer une catégorie
        </button>
    </div>
</div>

<table class="table table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th scope="col">N°</th>
            <th scope="col">Nom </th>
            <th scope="col">Nombre de produits</th>
            <th scope="col" class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $categorie)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $categorie->nom }}</td>
                <td>
                    <span class="badge bg-secondary">{{ $categorie->produits_count }}</span>
                </td>
                <td class="d-flex gap-2 justify-content-end">
                    @if($categorie->produits_count === 0)
                    <form action="{{ route('categories.destroy', $categorie) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-outline-danger" 
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @else
                    <button class="btn btn-outline-secondary" 
                            title="Impossible de supprimer - catégorie utilisée"
                            disabled>
                        <i class="bi bi-trash"></i>
                    </button>
                    @endif

                    <a href="{{ route('categories.edit', $categorie) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Aucune catégorie trouvée</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- 🟡 Modal Créer une catégorie -->
<div class="modal fade" id="categorieModalCreate" tabindex="-1" aria-labelledby="categorieModalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categorieModalCreateLabel">Créer une nouvelle catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nom" class="form-label fw-semibold">Nom de la catégorie *</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Téléphone, Accessoire, PC..." required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn text-dark fw-bold" style="background-color: #fbc926;">
                            <i class="bi bi-check-lg me-1"></i>Créer la catégorie
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 🔵 Modal Modifier une catégorie (corrigé) -->
<div class="modal fade" id="categorieModalEdit" tabindex="-1" aria-labelledby="categorieModalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categorieModalEditLabel">Modifier la catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <!-- action sera rempli dynamiquement via JS -->
                <form id="editCategorieForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editNom" class="form-label fw-semibold">Nom de la catégorie *</label>
                        
                        <input type="text" class="form-control" id="editNom" name="nom" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn text-dark fw-bold" style="background-color: #fbc926;">
                            <i class="bi bi-check-lg me-1"></i>Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('categorieModalEdit');
    const editForm = document.getElementById('editCategorieForm');
    const editNomInput = document.getElementById('editNom');

    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nom = button.getAttribute('data-nom');

        console.log('Données reçues:', { id, nom }); // Debug

        // Remplissage dynamique
        editNomInput.value = nom || '';
        
        // CORRECTION : Mettre à jour l'action du formulaire avec la route correcte
        editForm.action = `{{ route('categories.update', ':id') }}`.replace(':id', id);
    });

    // Nettoyage quand on ferme le modal
    editModal.addEventListener('hidden.bs.modal', function () {
        editForm.action = '';
        editNomInput.value = '';
    });
});
</script>
@endsection