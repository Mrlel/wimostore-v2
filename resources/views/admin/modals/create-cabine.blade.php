<!-- resources/views/admin/modals/create-cabine.blade.php -->
<div class="modal fade" id="createCabineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle me-2"></i>Nouvelle Cabine
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cabines.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom_cab" class="form-label fw-semibold">Nom de la cabine *</label>
                            <input type="text" class="form-control" id="nom_cab" name="nom_cab" required 
                                   placeholder="Ex: Cabine Principale">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="localisation" class="form-label fw-semibold">Localisation *</label>
                            <input type="text" class="form-control" id="localisation" name="localisation" required
                                   placeholder="Ex: Paris, Boutique Centre-ville">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Type de compte *</label>
                        <select name="type_compte" id="type_compte" class="form-control" required>
                            <option value="standard">Standard</option>
                            <option value="illimite">Illimité</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="max_utilisateurs" class="form-label fw-semibold">Nombre maximum d'utilisateurs *</label>
                        <input type="number" class="form-control" id="max_utilisateurs" name="max_utilisateurs" required
                               placeholder="Ex: 5">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn bg-dark text-white fw-bold">
                        <i class="bi bi-check-circle me-1"></i>Créer la cabine
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .modal-content {
        border: 2px solid #000;
        border-radius: 12px;
    }
    
    .modal-header {
        background: #000;
        border-bottom: 2px solid #000;
        color: #fff;
        border-radius: 10px 10px 0 0 !important;
    }
    
    .form-control:focus {
        border-color: #ffde59;
        box-shadow: 0 0 0 0.25rem rgba(255, 222, 89, 0.25);
    }
    
    .form-check-input:checked {
        background-color: #ffde59;
        border-color: #000;
    }
</style>
