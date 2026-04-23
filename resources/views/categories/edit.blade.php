@extends('layouts.app')
@section('title', 'Modifier une catégorie')
@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="h2 text-dark fw-bold mb-1">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-arrow-left me-1"></i>
            </a>
            Modifier la catégorie
        </h2>
    </div>
</div>

<form method="POST" action="{{ route('categories.update', $categorie) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="nom" class="form-label fw-semibold">Nom de la catégorie *</label>
        <input type="text" class="form-control" id="nom" name="nom" value="{{ $categorie->nom }}" required>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn text-dark fw-bold" style="background-color: #fbc926;">
            <i class="bi bi-check-lg me-1"></i>Mettre à jour
        </button>
    </div>
</form>
@endsection