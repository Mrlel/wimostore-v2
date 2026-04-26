@extends('layouts.app')
@section('title', 'Gestion de ma boutique')
@section('content')
<div class="container-fluid py-4">
    @if($boutiques)
    <div class="navigation-header mb-4">
        <!-- URL de la boutique + copier -->
        <div class="d-flex align-items-center gap-2 mb-3 p-3 rounded" style="background:#f8f8f8;border:1px solid #e0e0e0;">
            <i class="bi bi-link-45deg text-muted"></i>
            <input type="text" id="boutiqueUrlDash" value="{{ $boutiques->cabine->public_url ?? '' }}"
                   readonly class="form-control form-control-sm border-0 bg-transparent"
                   style="font-family:monospace;font-size:0.82rem;color:#333;">
            <a href="{{ $boutiques->cabine->public_url }}" target="_blank"
               class="btn btn-sm fw-bold text-dark flex-shrink-0" style="background:#f0c61d;">
                <i class="bi bi-box-arrow-up-right me-1"></i> Visiter
            </a>
            <button onclick="copyDashUrl()" id="copyDashBtn"
                    class="btn btn-sm btn-outline-dark flex-shrink-0">
                <i class="bi bi-clipboard" id="copyDashIcon"></i>
                <span id="copyDashText">Copier</span>
            </button>
        </div>
        <!-- Pour desktop -->
        <div class="d-none d-lg-flex justify-content-between align-items-center">
            <div class="flex-grow-1"></div> <!-- Espace vide à gauche -->
            <div class="d-flex gap-3">
                <a href="{{ route('Ma_boutique.edit', ['boutique' => $boutiques->id]) }}" 
                class="btn text-dark fw-bold px-4" 
                style="background-color: #ffde59; min-width: 180px;">
                    <i class="bi bi-pencil me-2"></i>Modifier ma boutique
                </a>
                <a href="{{ route('visites', ['code' => $boutiques->cabine->code ?? $boutiques->code]) }}" 
                class="btn text-white fw-bold px-4"
                    style="background-color: #000000; min-width: 180px;">
                    <i class="bi bi-bar-chart me-2"></i>Statistiques des visites
                </a>
            </div>
        </div>

    <!-- Pour tablette -->
    <div class="d-none d-md-flex d-lg-none justify-content-center">
        <div class="d-flex flex-wrap gap-2 justify-content-center w-100">
            <a href="{{ route('Ma_boutique.edit', ['boutique' => $boutiques->id]) }}" 
               class="btn text-dark fw-bold flex-fill text-center" 
               style="background-color: #ffde59; max-width: 200px;">
                <i class="bi bi-pencil me-1"></i>Modifier
            </a>
            <a href="{{ route('visites', ['code' => $boutiques->cabine->code ?? $boutiques->code]) }}" 
               class="btn text-white fw-bold px-4"
                style="background-color: #000000; min-width: 180px;">
                <i class="bi bi-bar-chart me-2"></i>Statistiques des visites
            </a>
        </div>
    </div>

    <!-- Pour mobile -->
    <div class="d-md-none">
        <div class="d-grid gap-2">
            <a href="{{ route('Ma_boutique.edit', ['boutique' => $boutiques->id]) }}" 
               class="btn text-dark fw-bold py-2" 
               style="background-color: #ffde59;">
                <i class="bi bi-pencil me-2"></i>Modifier ma boutique
            </a>
 
            <a href="{{ route('visites', ['code' => $boutiques->cabine->code ?? $boutiques->code]) }}" 
               class="btn text-white fw-bold px-4"
                style="background-color: #000000; min-width: 180px;">
                <i class="bi bi-bar-chart me-2"></i>Statistiques des visites
            </a>
        </div>
    </div>
</div>
    @endif
        <!-- Statistiques visites -->
       
            <div class="card-body py-4">
                <div class="row">
                    <div class="col-6 col-md-4 mb-3">
                        <div class="stat-card">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-globe-americas" style="color:#f0c61d;font-size:1rem;"></i>
                                </div>
                                <span class="badge" style="background:rgba(45,180,90,0.15);color:#4ecb71;font-size:0.7rem;font-weight:600;padding:4px 10px;border-radius:20px;">
                                    En ligne
                                </span>
                            </div>
                            <div class="stat-info"><h3>Produits publiés</h3></div>
                            <div class="stat-value">{{ $nb_produits_publies ?? 0 }}</div>
                            <div class="stat-footer">
                                <i class="bi bi-shop" style="font-size:0.75rem;"></i>
                                visibles en boutique
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 mb-3">
                        <div class="stat-card">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-box-seam" style="color:#f0c61d;font-size:1rem;"></i>
                                </div>
                                <span class="badge" style="background:rgba(255,80,80,0.12);color:#ff8080;font-size:0.7rem;font-weight:600;padding:4px 10px;border-radius:20px;">
                                    Masqués
                                </span>
                            </div>
                            <div class="stat-info"><h3>Produits non publiés</h3></div>
                            <div class="stat-value">{{ $nb_produits_non_publies ?? 0 }}</div>
                            <div class="stat-footer">
                                <i class="bi bi-eye-slash" style="font-size:0.75rem;"></i>
                                non visibles
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <div class="stat-card">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-people" style="color:#f0c61d;font-size:1rem;"></i>
                                </div>
                            </div>
                            <div class="stat-info"><h3>Gestionnaires</h3></div>
                            <div class="stat-value">{{ $gestionnaires->count() }}</div>
                            <div class="stat-footer">
                                <i class="bi bi-person-check" style="font-size:0.75rem;"></i>
                                membres actifs
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Gestionnaires -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 w-100 w-md-auto">
            <div>
                <div class="h2 text-dark fw-bold d-flex align-items-center flex-wrap">
                    <i class="bi bi-people me-2" style="color: #ffde59;"></i>
                    Gestionnaires
                </div>
            </div>
            <div class="col-12 col-md-auto text-md-end">
                <button type="button" class="btn w-100 w-md-auto text-white fw-bold" style="background-color: #000000;" data-bs-toggle="modal" data-bs-target="#addGestionnaireModal">
                    <i class="bi bi-plus-circle me-1"></i> Ajouter un gestionnaire
                </button>
            </div>
        </div>

        <!-- Tableau des gestionnaires -->
        <div class="card border-0">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-dark fw-bold">
                    Liste des gestionnaires
                </h5>
                <span class="badge bg-dark fs-6">{{ $gestionnaires->count() }} gestionnaire(s)</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 table-card-mobile">
                        <thead class="table-dark">
                            <tr>
                                <th class="border-dark">Nom</th>
                                <th class="border-dark">Email</th>
                                <th class="border-dark">Téléphone</th>
                                <th class="border-dark">Role</th>
                                <th class="border-dark text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gestionnaires as $gestionnaire)
                            <tr>
                                <td class="align-middle" data-label="Nom">
                                    <span class="fw-semibold text-dark">
                                        <i class="bi bi-person me-2"></i>{{ $gestionnaire->nom }}
                                    </span>
                                </td>
                                <td class="align-middle" data-label="Email">
                                    <span class="fw-semibold text-dark">
                                        <i class="bi bi-envelope me-2"></i>{{ $gestionnaire->email }}
                                    </span>
                                </td>
                                <td class="align-middle" data-label="Téléphone">
                                    <span class="fw-semibold text-dark">
                                        <i class="bi bi-phone me-2"></i>{{ $gestionnaire->numero }}
                                    </span>
                                </td>
                                <td class="align-middle" data-label="Role">
                                    @if($gestionnaire->role == 'responsable')
                                        <span class="badge bg-success d-flex align-items-center justify-content-center" style="width: fit-content;">
                                            <i class="fas fa-user-shield me-1"></i> Responsable
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark d-flex align-items-center justify-content-center" style="width: fit-content;">
                                            <i class="fas fa-user-tie me-1"></i> Gestionnaire
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle text-end">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-dark btn-sm edit-gestionnaire-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editGestionnaireModal"
                                                data-id="{{ $gestionnaire->id }}"
                                                data-nom="{{ $gestionnaire->nom }}"
                                                data-email="{{ $gestionnaire->email }}"
                                                data-numero="{{ $gestionnaire->numero }}"
                                                data-role="{{ $gestionnaire->role }}">
                                            <i class="bi bi-pencil me-1"></i> Modifier
                                        </button>
                                        <form action="{{ route('gestionnaires.destroy', $gestionnaire->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce gestionnaire ?')">
                                                <i class="bi bi-trash me-1"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-people fs-1 text-muted"></i>
                                        <h5 class="text-muted mt-3">Aucun gestionnaire enregistré</h5>
                                        <p class="text-muted">Les gestionnaires apparaîtront ici.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- 
        <div class="text-center mt-2">
            <div class="card border-0 bg-light">
                <div class="card-body py-5">
                    <i class="bi bi-shop fs-1 text-dark mb-3"></i>
                    <h4 class="text-dark fw-bold">Boutique en ligne non Configurée !</h4>
                    <p class="text-muted">
                        Veuillez nous contacter pour la configuration de votre boutique en ligne.<br>
                        C'est gratuit 🥳🎉
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="https://wa.me/2250585986100?text=Bonjour, j'aimerai configuré ma boutique en ligne dont le code est le suivant : {{ urlencode(auth()->user()->cabine->code) }}" 
                           class="btn text-dark fw-bold" style="background-color: #ffde59;">
                            <i class="bi bi-whatsapp me-1"></i>Nous contacter
                        </a>
                    </div>
                </div>
            </div>
        </div> -->

</div>

<!-- Modal d'ajout de gestionnaire -->
<div class="modal fade" id="addGestionnaireModal" tabindex="-1" aria-labelledby="addGestionnaireModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-dark" id="addGestionnaireModalLabel">
                    <i class="bi bi-person-plus me-2" style="color: #ffde59;"></i>
                    Ajouter un gestionnaire
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('gestionnaires.store') }}" method="POST" id="addGestionnaireForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label fw-semibold">Nom complet <span class="text-danger">*</span></label>
                            <input type="text" class="form-control border-dark" id="nom" name="nom" required 
                                   placeholder="Entrez le nom complet">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control border-dark" id="email" name="email" required 
                                   placeholder="exemple@email.com">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="numero" class="form-label fw-semibold">Numéro de téléphone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control border-dark" id="numero" name="numero" required 
                                   placeholder="+2250101010101">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label fw-semibold">Rôle <span class="text-danger">*</span></label>
                            <select class="form-select border-dark" id="role" name="role" required>
                                <option value="">Sélectionnez un rôle</option>
                                <option value="user">Gestionnaire</option>
                                <option value="responsable">Responsable</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-semibold">Mot de passe <span class="text-danger">*</span></label>
                            <input type="password" class="form-control border-dark" id="password" name="password" required 
                                   placeholder="Mot de passe sécurisé">
                            <div class="form-text">Le mot de passe doit contenir une majuscule, une minuscule, un chiffre et un caractere special(@, #, $, %, ^, *, ?, _, +)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">Confirmer le mot de passe <span class="text-danger">*</span></label>
                            <input type="password" class="form-control border-dark" id="password_confirmation" name="password_confirmation" required 
                                   placeholder="Confirmez le mot de passe">
                            <div class="form-text">Identique au mot de passe</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Annuler
                </button>
                <button type="submit" form="addGestionnaireForm" class="btn text-dark fw-bold" style="background-color: #ffde59;">
                    <i class="bi bi-check-circle me-1"></i> Enregistrer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de modification de gestionnaire -->
<div class="modal fade" id="editGestionnaireModal" tabindex="-1" aria-labelledby="editGestionnaireModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-dark" id="editGestionnaireModalLabel">
                    <i class="bi bi-person-gear me-2" style="color: #ffde59;"></i>
                    Modifier le gestionnaire
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="editGestionnaireForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nom" class="form-label fw-semibold">Nom complet <span class="text-danger">*</span></label>
                            <input type="text" class="form-control border-dark" id="edit_nom" name="nom" required 
                                   placeholder="Entrez le nom complet">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control border-dark" id="edit_email" name="email" required 
                                   placeholder="exemple@email.com">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_numero" class="form-label fw-semibold">Numéro de téléphone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control border-dark" id="edit_numero" name="numero" required 
                                   placeholder="+2250101010101">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_role" class="form-label fw-semibold">Rôle <span class="text-danger">*</span></label>
                            <select class="form-select border-dark" id="edit_role" name="role" required>
                                <option value="">Sélectionnez un rôle</option>
                                <option value="user">Gestionnaire</option>
                                <option value="responsable">Responsable</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Annuler
                </button>
                <button type="submit" form="editGestionnaireForm" class="btn text-dark fw-bold" style="background-color: #ffde59;">
                    <i class="bi bi-check-circle me-1"></i> Mettre à jour
                </button>
            </div>
        </div>
    </div>
</div>

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
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }
    
    .border-bottom {
        border-color: #ffde59 !important;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #ffde59;
        box-shadow: 0 0 0 0.2rem rgba(255, 222, 89, 0.25);
    }
    
    .badge {
        font-size: 0.75em;
    }
</style>

<script>
// ── Copier l'URL de la boutique ───────────────────────────────────────────────
function copyDashUrl() {
    const input = document.getElementById('boutiqueUrlDash');
    const btn   = document.getElementById('copyDashBtn');
    const icon  = document.getElementById('copyDashIcon');
    const text  = document.getElementById('copyDashText');
    if (!input) return;
    navigator.clipboard.writeText(input.value).then(() => {
        btn.classList.remove('btn-outline-dark');
        btn.classList.add('btn-success');
        icon.className = 'bi bi-check2';
        text.textContent = 'Copié !';
        setTimeout(() => {
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-dark');
            icon.className = 'bi bi-clipboard';
            text.textContent = 'Copier';
        }, 2500);
    }).catch(() => { input.select(); document.execCommand('copy'); });
}

document.addEventListener('DOMContentLoaded', function() {
    // Gestion de la modification des gestionnaires
    const editButtons = document.querySelectorAll('.edit-gestionnaire-btn');    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nom = this.getAttribute('data-nom');
            const email = this.getAttribute('data-email');
            const numero = this.getAttribute('data-numero');
            const role = this.getAttribute('data-role');
            
            // Mettre à jour le formulaire de modification
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nom').value = nom;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_numero').value = numero;
            document.getElementById('edit_role').value = role;
            
            // Mettre à jour l'action du formulaire
            document.getElementById('editGestionnaireForm').action = `/gestionnaires/${id}`;
        });
    });
    
    // Validation des formulaires
    const addForm = document.getElementById('addGestionnaireForm');
    const editForm = document.getElementById('editGestionnaireForm');
    
    if (addForm) {
        addForm.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas.');
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert('Le mot de passe doit contenir au moins 8 caractères.');
                return false;
            }
        });
    }
    
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const password = document.getElementById('edit_password').value;
            const confirmPassword = document.getElementById('edit_password_confirmation').value;
            
            if (password && password.length < 8) {
                e.preventDefault();
                alert('Le mot de passe doit contenir au moins 8 caractères.');
                return false;
            }
            
            if (password && password !== confirmPassword) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas.');
                return false;
            }
        });
    }
});
</script>
@endsection