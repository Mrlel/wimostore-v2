@extends('layouts.app')
@section('title', 'Mon Profil')
@section('content')
<div class="container-fluid py-4 bg-white rounded">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-dark fw-bold">
                <i class="bi bi-person-circle me-2" style="color: #fbc926;"></i>
                Mon Profil
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profil</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('guide') }}" class="btn btn-outline-dark me-2">
                <i class="bi bi-book me-1"></i>Guide
            </a>
            <a href="/certification" class="btn btn-outline-dark me-2">
                <i class="bi bi-check-circle me-1"></i>Certification
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informations utilisateur -->
        <div class="col-lg-8">
            <div class="card  border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-person-badge me-2" style="color: #fbc926;"></i>
                        Informations Personnelles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nom complet</label>
                            <p class="form-control-plaintext fw-bold">{{ auth()->user()->nom }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Adresse email</label>
                            <p class="form-control-plaintext">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">N° de téléphone</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-dark text-capitalize">
                                    {{ auth()->user()->numero }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Date d'inscription</label>
                            <p class="form-control-plaintext">
                                {{ auth()->user()->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="subscription-card p-3 rounded shadow-sm border w-100">
                                <label class="form-label fw-semibold text-muted mb-1">
                                    <i class="bi bi-calendar-check me-1 text-success"></i> Date Fin de l'abonnement
                                </label>
                                <div class="subscription-status">
                                    @if(auth()->user()->cabine && auth()->user()->cabine->abonnementActuel)
                                        @if(auth()->user()->cabine->abonnementActuel->date_fin)
                                            <span class="badge-custom success">
                                                {{ auth()->user()->cabine->abonnementActuel->date_fin->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="badge-custom info">Illimité</span>
                                        @endif
                                    @else
                                        <span class="badge-custom secondary">Fin de l'abonnement</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row gap-4 mt-4">
                        <button class="btn btn-outline-dark me-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="bi bi-pencil me-1"></i>Modifier le profil
                        </button>
                        <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="bi bi-key me-1"></i>Changer le mot de passe
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistiques utilisateur 
            <div class="card  border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-graph-up me-2" style="color: #fbc926;"></i>
                        Mes Statistiques
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3">
                                <i class="bi bi-cart-check fs-1 text-dark mb-2"></i>
                                <h4 class="fw-bold">{{ auth()->user()->ventes->count() }}</h4>
                                <small class="text-muted">Ventes effectuées</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3">
                                <i class="bi bi-arrow-left-right fs-1 text-dark mb-2"></i>
                                <h4 class="fw-bold">{{ auth()->user()->mouvements->count() }}</h4>
                                <small class="text-muted">Mouvements créés</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3">
                                <i class="bi bi-currency-euro fs-1 text-dark mb-2"></i>
                                <h4 class="fw-bold">
                                    {{ number_format(auth()->user()->ventes->sum('montant_total'), 2) }} FCFA
                                </h4>
                                <small class="text-muted">Chiffre d'affaires</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>

        <!-- Informations Boutique -->
        <div class="col-lg-4">
            <!-- Actions rapides -->
            <div class="card  border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-lightning me-2" style="color: #fbc926;"></i>
                        Actions Rapides
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('ventes.create') }}" class="btn btn-outline-dark text-start">
                            <i class="bi bi-cart-plus me-2"></i>Nouvelle vente
                        </a>
                        <a href="{{ route('mouvements.create') }}" class="btn btn-outline-dark text-start">
                            <i class="bi bi-plus-circle me-2"></i>Nouveau mouvement
                        </a>
                        <a href="{{ route('produits.create') }}" class="btn btn-outline-dark text-start">
                            <i class="bi bi-box-seam me-2"></i>Nouveau produit
                        </a>
                        <a href="{{ route('ventes.index') }}" class="btn btn-outline-dark text-start">
                            <i class="bi bi-list-check me-2"></i>Voir mes ventes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modification Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Modifier le profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="{{ auth()->user()->nom }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="numero" class="form-label">N° de téléphone</label>
                        <input type="text" class="form-control" id="numero" name="numero" value="{{ auth()->user()->numero }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn text-dark" style="background-color: #fbc926;">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Changement Mot de Passe -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Changer le mot de passe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" placeholder="************" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" placeholder="Nouveau mot de passe" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                        <input type="password" placeholder="Confirmer le nouveau mot de passe" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn text-dark" style="background-color: #fbc926;">Changer le mot de passe</button>
                </div>
            </form>
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
    
    .btn:hover {
        opacity: 0.9;
    }
    
    .badge {
        font-size: 0.9em;
    }
    
    .modal-content {
        border: 2px solid #000;
    }
    
    .modal-header {
        border-bottom: 2px solid #000 !important;
    }
</style>
@endsection