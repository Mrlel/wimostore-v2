@extends('layouts.base')
@section('title', 'Modifier l\'utilisateur')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h1 class="h2 text-dark fw-bold d-flex align-items-center">
            <i class="bi bi-person-gear me-2" style="color:#f0c61d;"></i>
            Modifier l'utilisateur
        </h1>
        <p class="text-muted mb-0">{{ $user->nom }}</p>
    </div>
    <a href="/admin/users" class="btn btn-outline-dark">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card border-0" style="max-width:640px;">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 text-dark fw-bold">
            <i class="bi bi-pencil me-2" style="color:#f0c61d;"></i>
            Informations de l'utilisateur
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            @if($errors->any())
            <div class="alert alert-danger border-0 mb-4">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                    <input type="text" class="form-control border-dark" name="nom" value="{{ old('nom', $user->nom) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">N° téléphone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control border-dark" name="numero" value="{{ old('numero', $user->numero) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control border-dark" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Rôle <span class="text-danger">*</span></label>
                    <select class="form-select border-dark" name="role" required>
                        <option value="user"        {{ $user->role == 'user'        ? 'selected' : '' }}>Utilisateur</option>
                        <option value="responsable" {{ $user->role == 'responsable' ? 'selected' : '' }}>Responsable</option>
                        <option value="admin"       {{ $user->role == 'admin'       ? 'selected' : '' }}>Administrateur</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Cabine</label>
                    <select name="cabine_id" class="form-select border-dark">
                        <option value="">— Sélectionner une cabine —</option>
                        @foreach($cabines as $cabine)
                        <option value="{{ $cabine->id }}" {{ $user->cabine_id == $cabine->id ? 'selected' : '' }}>
                            {{ $cabine->code }} — {{ $cabine->nom_cab }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn fw-bold text-dark" style="background:#f0c61d;">
                    <i class="bi bi-check-circle me-1"></i> Enregistrer
                </button>
                <a href="/admin/users" class="btn btn-outline-dark">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
