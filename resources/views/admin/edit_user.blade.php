@extends('layouts.base')
@section('content')

<h2>Modifier l'utilisateur <span class="text-success">{{ $user->nom }}</span></h2>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrer le nom" value="{{ $user->nom }}" required>
    </div>
    <div class="mb-3">
        <label for="numero" class="form-label">N° téléphone</label>
        <input type="text" class="form-control" id="matricule" name="numero" placeholder="Entrer le numéro" value="{{ $user->numero }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Entrer l'email" value="{{ $user->email }}" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Rôle</label>
        <select class="form-select" id="role" name="role" required>
            <option value="user">Utilisateur</option>
            <option value="responsable">Responsable</option>
            <option value="admin">Administrateur</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="cabine_id" class="form-label">Cabine</label>
        <select name="cabine_id" class="form-select" id="cabine_id">
            <option value="">-- Sélectionner une cabine --</option>
            @foreach($cabines as $cabine)
                <option value="{{ $cabine->id }}" {{ $user->cabine_id == $cabine->id ? 'selected' : '' }}>{{ $cabine->code }} - {{ $cabine->nom_cab }} </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-dark"> <i class="bi bi-save"></i> Enregistrer</button>
</form>

@endsection