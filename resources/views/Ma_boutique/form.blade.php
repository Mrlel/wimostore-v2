@extends('layouts.app')
@section('title', isset($boutiques) ? 'Modifier la boutique' : 'Configurer ma boutique')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
<div class="container-fluid py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 w-100 w-md-auto">
        <div>
            <h1 class="h2 text-dark fw-bold d-flex align-items-center flex-wrap">
                <i class="bi bi-shop me-2" style="color: #ffde59;"></i>
                {{ isset($boutiques) ? 'Modifier ma boutique' : 'Configurer ma boutique en ligne' }}
            </h1>
            <p class="text-muted mb-0">
                {{ isset($boutiques) ? 'Mettez à jour les informations de votre boutique' : 'Configurez votre boutique en ligne pour attirer plus de clients' }}
            </p>
        </div>
        <div class="d-flex align-items-center mb-3">
            <audio controls style="max-width: 400px; ">
                <source src="{{ asset('audios/page_modifier_boutique.mp3') }}" type="audio/mpeg">
                Votre navigateur ne supporte pas la lecture audio.
            </audio>
        </div>
    </div>

    @php
        $isEdit = isset($boutiques) && $boutiques;
        $action = $isEdit
            ? route('Ma_boutique.update', ['boutique' => $boutiques->id])
            : route('Ma_boutique.store');
    @endphp

    <!-- Formulaire -->
    <div class="card border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-gear me-2" style="color: #ffde59;"></i>
                Informations de la boutique
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <input type="hidden" name="cabine_id" value="{{ auth()->user()->cabine_id }}">

                <!-- Section 1: Identité de la boutique -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="bi bi-building me-2" style="color: #ffde59;"></i>
                            Identité de votre boutique
                        </h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Nom de votre boutique <span class="text-danger">*</span>
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                               data-bs-title="Le nom officiel de votre boutique"></i>
                        </label>
                        <input type="text" name="nom_site" class="form-control border-1 border-dark"
                               value="{{ old('nom_site', $isEdit ? $boutiques->nom_site : '') }}" 
                               placeholder="Ex: Fashion Store, Tech Market..." required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            N° de téléphone professionnel <span class="text-danger">*</span>
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                               data-bs-title="Numéro de contact principal pour pour que les clients puissent vous contacter directement"></i>
                        </label>
                        <input type="text" name="telephone" class="form-control border-1 border-dark"
                               value="{{ old('telephone', $isEdit ? $boutiques->telephone : '') }}" 
                               placeholder="Ex: +225 0102030405" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Titre principal <span class="text-danger">*</span>
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                               data-bs-title="Titre accrocheur en gros sur votre page d'accueil"></i>
                        </label>
                        <input type="text" name="titre" class="form-control border-1 border-dark"
                               value="{{ old('titre', $isEdit ? $boutiques->titre : '') }}" 
                               placeholder="Ex: Votre Partenaire Mode, Excellence Technologique..." required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Sous-titre <span class="text-danger">*</span>
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                               data-bs-title="Complément d'information qui précise votre valeur ajoutée"></i>
                        </label>
                        <input type="text" name="sous_titre" class="form-control border-1 border-dark"
                               value="{{ old('sous_titre', $isEdit ? $boutiques->sous_titre : '') }}" 
                               placeholder="Ex: Livraison gratuite, Meilleur rapport qualité-prix..." required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">
                            Description <span class="text-danger">*</span>
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                               data-bs-title="Description détaillée de votre boutique et de vos services"></i>
                        </label>
                        <textarea name="description" class="form-control border-1 border-dark" rows="4" 
                                  placeholder="Décrivez votre boutique, vos produits, vos valeurs, ce qui vous rend unique..." required>{{ old('description', $isEdit ? $boutiques->description : '') }}</textarea>
                        <div class="form-text">
                            📝 Cette description aide au référencement et permet aux clients de mieux comprendre votre activité.
                        </div>
                    </div>
                </div>

                <!-- Section 2: Identité visuelle -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="bi bi-palette me-2" style="color: #ffde59;"></i>
                            Identité visuelle
                        </h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Logo *
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                               data-bs-title="Image qui représente votre marque"></i>
                        </label>
                        <input type="file" name="logo" class="form-control border-1 border-dark" 
                               {{ $isEdit ? '' : 'required' }} accept="image/*">
                        @if($isEdit && $boutiques->logo)
                            <div class="mt-2">
                                <small class="text-muted fw-semibold">Logo actuel:</small>
                                <div class="mt-1">
                                    <img src="{{ Storage::disk('public')->url($boutiques->logo) }}" 
                                         alt="Logo actuel" height="80" class="border rounded p-2">
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Bannière *
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                               data-bs-title="Image d'en-tête de votre boutique"></i>
                        </label>
                        <input type="file" name="banniere" class="form-control border-1 border-dark" 
                               {{ $isEdit ? '' : 'required' }} accept="image/*">

                        <div class="form-text">
                            Choisissez une Image qui représente votre univers.
                        </div>
                    </div>
                </div>

                <!-- Section 3: Contacts et réseaux sociaux -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="bi bi-telephone me-2" style="color: #ffde59;"></i>
                            Contacts et réseaux sociaux
                        </h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            WhatsApp
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                               data-bs-title="Numéro WhatsApp pour les commandes et questions"></i>
                        </label>
                        <input type="text" name="whatsapp" class="form-control border-1 border-dark"
                               value="{{ old('whatsapp', $isEdit ? $boutiques->whatsapp : '') }}" 
                               placeholder="Ex: 0708091011">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Email professionnel
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                               data-bs-title="Adresse email pour les demandes professionnelles"></i>
                        </label>
                        <input type="email" name="email" class="form-control border-1 border-dark"
                               value="{{ old('email', $isEdit ? $boutiques->email : '') }}" 
                               placeholder="Ex: contact@votreboutique.com">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Facebook (URL complète)
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                               data-bs-title="Lien vers votre page Facebook"></i>
                        </label>
                        <input type="url" name="facebook" class="form-control border-1 border-dark"
                               value="{{ old('facebook', $isEdit ? $boutiques->facebook : '') }}" 
                               placeholder="Ex: https://facebook.com/votreboutique">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Instagram (URL complète)
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                               data-bs-title="Lien vers votre compte Instagram"></i>
                        </label>
                        <input type="url" name="instagram" class="form-control border-1 border-dark"
                               value="{{ old('instagram', $isEdit ? $boutiques->instagram : '') }}" 
                               placeholder="Ex: https://instagram.com/votreboutique">
                    </div>
                </div>

                <!-- Section 4: Localisation -->
                <div class="row mb-4" hidden>
                    <div class="col-12">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="bi bi-geo-alt me-2" style="color: #ffde59;"></i>
                            Localisation
                        </h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Latitude
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                               data-bs-title="Coordonnée GPS latitude pour votre localisation"></i>
                        </label>
                        <input type="number" step="0.0000001" name="latitude" class="form-control border-1 border-dark"
                               value="{{ old('latitude', $isEdit ? $boutiques->latitude : '') }}" 
                               placeholder="Ex: 5.3599517">
                        <div class="form-text">
                            🗺️ Permet d'afficher votre position exacte sur une carte. Facilite la localisation pour vos clients.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Longitude
                            <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                               data-bs-title="Coordonnée GPS longitude pour votre localisation"></i>
                        </label>
                        <input type="number" step="0.0000001" name="longitude" class="form-control border-1 border-dark"
                               value="{{ old('longitude', $isEdit ? $boutiques->longitude : '') }}" 
                               placeholder="Ex: -4.0082563">
                        <div class="form-text">
                            🗺️ Deuxième coordonnée GPS nécessaire pour positionner votre boutique sur la carte.
                        </div>
                    </div>
                </div>

                <!-- Section 5: Publication -->
                <div class="row">
                    <div class="col-12">
                        <div class="">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input border-dark fs-5" name="est_publiee" id="est_publiee" value="1"
                                       {{ old('est_publiee', $isEdit ? ($boutiques->est_publiee ?? false) : false) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-dark" for="est_publiee">
                                    Publier cette boutique en ligne
                                </label>
                                <div class="form-text mt-2">
                                     Votre boutique sera visible publiquement et accessible à tous les clients si cette case est cochée. 
                                    Décochez pour mettre en mode brouillon.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                    <a href="{{ route('Ma_boutique') }}" class="btn btn-outline-dark">
                        <i class="bi bi-arrow-left me-1"></i>
                        Annuler
                    </a>
                    <button type="submit" class="btn text-dark fw-bold" style="background-color: #ffde59;">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ $isEdit ? 'Mettre à jour la boutique' : 'Créer ma boutique' }}
                    </button>
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
    
    .form-control:focus, .form-select:focus {
        border-color: #ffde59;
        box-shadow: 0 0 0 0.2rem rgba(255, 222, 89, 0.25);
    }
    
    .form-text {
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Validation des URLs pour les réseaux sociaux
    const urlInputs = document.querySelectorAll('input[type="url"]');
    urlInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value && !this.value.startsWith('http')) {
                this.value = 'https://' + this.value;
            }
        });
    });
});
</script>
@endsection