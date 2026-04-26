@extends('layouts.base')
@section('title', 'Gestion des Utilisateurs')

@section('content')
@include('layouts.message')

<div class="container-fluid py-4">
    
    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 w-100 w-md-auto">
        <div>
            <h1 class="h2 text-dark fw-bold d-flex align-items-center flex-wrap">
                <i class="bi bi-people me-2" style="color: #ffde59;"></i>
                Gestion des Utilisateurs
            </h1>
            <p class="text-muted mb-0">Gérez les utilisateurs et leurs permissions</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn text-dark fw-bold" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color: #ffde59;">
                <i class="bi bi-person-plus me-1"></i> Ajouter un utilisateur
            </button>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="card border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-list-ul me-2" style="color: #ffde59;"></i>
                Liste des utilisateurs
            </h5>
            <span class="badge bg-dark fs-6">{{ $utilisateurs->count() }} utilisateur(s)</span>
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
                            <input type="text" class="form-control border-dark user-search-box" placeholder="Rechercher un utilisateur...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select border-dark user-role-filter">
                            <option value="">Tous les rôles</option>
                            <option value="admin">Administrateur</option>
                            <option value="responsable">Responsable</option>
                            <option value="user">Utilisateur</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select border-dark user-cabine-filter">
                            <option value="">Toutes les cabines</option>
                            @foreach($cabines as $cabine)
                                <option value="{{ $cabine->id }}">{{ $cabine->nom_cab }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tableau des utilisateurs -->
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="border-dark">Nom</th>
                            <th class="border-dark">N° Téléphone</th>
                            <th class="border-dark">Email</th>
                            <th class="border-dark">Boutique</th>
                            <th class="border-dark">Rôle</th>
                            <th class="text-center border-dark">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($utilisateurs as $user)
                        <tr class="user-row">
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 bg-light rounded p-2 me-3">
                                        @if($user->email_verified_at == null)
                                        <i class="bi bi-person" style="color: #ffde59;"></i>
                                        @else
                                        <i class="bi bi-person-check" style="color: #28a745;"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-bold text-dark">{{ $user->nom }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="text-muted">{{ $user->numero }}</span>
                            </td>
                            <td class="align-middle">
                                <span>{{ $user->email }}</span>
                            </td>
                            <td class="align-middle">
                                @if($user->cabine)
                                    <span class="badge bg-light text-dark text-capitalize">
                                        <i class="bi bi-shop me-1"></i>
                                        {{ $user->cabine->nom_cab }}
                                    </span>
                                @else
                                    <span class="text-muted">Aucune</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($user->role == 'superadmin')
                                    <span class="badge bg-black text-white">
                                        <i class="bi bi-shield-check me-1"></i>Superadmin
                                    </span>
                                @elseif($user->role == 'admin')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-person-gear me-1"></i>Admin
                                    </span>
                                @elseif($user->role == 'responsable')
                                    <span class="badge bg-success">
                                        <i class="bi bi-person-gear me-1"></i>Responsable
                                    </span>
                                @else
                                    <span class="badge bg-secondary text-capitalize">
                                        <i class="bi bi-person me-1"></i>{{ $user->role ?? 'user' }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="btn btn-sm btn-outline-dark"
                                       data-bs-toggle="tooltip" data-bs-title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    <a href="{{ route('reset-password', $user->id) }}" 
                                       class="btn btn-sm btn-outline-dark"
                                       data-bs-toggle="tooltip" data-bs-title="Réinitialiser mot de passe">
                                        <i class="bi bi-key"></i>
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="tooltip" 
                                                data-bs-title="Supprimer"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-people fs-1 text-muted"></i>
                                    <h5 class="text-muted mt-3">Aucun utilisateur trouvé</h5>
                                    <p class="text-muted">Commencez par ajouter votre premier utilisateur.</p>
                                    <button class="btn text-dark mt-2" style="background-color: #ffde59;" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="bi bi-person-plus me-1"></i>Ajouter un utilisateur
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter un utilisateur -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-white py-3 border-bottom">
                <h5 class="modal-title fw-bold text-dark" id="exampleModalLabel">
                    <i class="bi bi-person-plus me-2" style="color: #ffde59;"></i>Ajouter un nouvel utilisateur
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($errors->any())
                    <div class="alert alert-danger border-0 mb-4">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Veuillez corriger les erreurs suivantes :</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control border-1 border-dark" id="nom" name="nom" 
                                   placeholder="Entrer le nom" value="{{ old('nom') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="numero" class="form-label fw-semibold">N° téléphone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control border-1 border-dark" id="numero" name="numero" 
                                   placeholder="Entrer le numéro" value="{{ old('numero') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control border-1 border-dark" id="email" name="email" 
                                   placeholder="Entrer l'email" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label fw-semibold">Rôle <span class="text-danger">*</span></label>
                            <select class="form-control border-1 border-dark" id="role" name="role" required>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Utilisateur</option>
                                <option value="responsable" {{ old('role') == 'responsable' ? 'selected' : '' }}>Responsable</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="cabine_id" class="form-label fw-semibold">Cabine</label>
                        <select name="cabine_id" class="form-control border-1 border-dark" id="cabine_id">
                            <option value="">-- Sélectionner une cabine --</option>
                            @foreach($cabines as $cabine)
                                <option value="{{ $cabine->id }}" {{ old('cabine_id') == $cabine->id ? 'selected' : '' }}>
                                    {{ $cabine->code }} - {{ $cabine->nom_cab }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer mt-4 border-top pt-3">
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Annuler
                        </button>
                        <button class="btn text-dark fw-bold" type="submit" style="background-color: #ffde59;">
                            <i class="bi bi-check-circle me-2"></i>Enregistrer l'utilisateur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));

    function filterUsers() {
        const q     = document.querySelector('.user-search-box').value.toLowerCase().trim();
        const role  = document.querySelector('.user-role-filter').value.toLowerCase();
        const cab   = document.querySelector('.user-cabine-filter').value;
        document.querySelectorAll('.user-row').forEach(row => {
            const nom   = row.cells[0].textContent.toLowerCase();
            const email = row.cells[2].textContent.toLowerCase();
            const badge = row.cells[4].querySelector('.badge');
            const r     = badge ? badge.textContent.toLowerCase() : '';
            const show  = (!q || nom.includes(q) || email.includes(q)) && (!role || r.includes(role));
            row.style.display = show ? '' : 'none';
        });
    }
    let t;
    document.querySelector('.user-search-box').addEventListener('input', () => { clearTimeout(t); t = setTimeout(filterUsers, 250); });
    document.querySelector('.user-role-filter').addEventListener('change', filterUsers);
    document.querySelector('.user-cabine-filter').addEventListener('change', filterUsers);
    document.getElementById('exampleModal')?.addEventListener('shown.bs.modal', () => document.getElementById('nom')?.focus());
});
</script>
@endpush

@endsection
