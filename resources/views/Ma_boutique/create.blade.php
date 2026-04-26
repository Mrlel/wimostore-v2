@extends('layouts.app')
@section('title', 'Créer ma boutique en ligne')

@section('content')

{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

<style>
    /* ── Stepper ── */
    .form-label{
        color: black;
    }
    .form-stepper {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 32px;
        overflow-x: auto;
        padding-bottom: 4px;
    }
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        position: relative;
        min-width: 80px;
    }
    .step::before {
        content: '';
        position: absolute;
        top: 18px;
        left: -50%;
        width: 100%;
        height: 2px;
        background: #e0e0e0;
        z-index: 0;
    }
    .step:first-child::before { display: none; }
    .step.done::before, .step.active::before { background: #f0c61d; }
    .step-circle {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: #e0e0e0;
        color: #888;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem; font-weight: 700;
        position: relative; z-index: 1;
        transition: all .25s;
    }
    .step.active .step-circle { background: #f0c61d; color: #000; box-shadow: 0 0 0 4px rgba(240,198,29,0.2); }
    .step.done .step-circle { background: #10b981; color: #fff; }
    .step-label { font-size: 0.7rem; font-weight: 600; color: #888; margin-top: 6px; text-align: center; white-space: nowrap; }
    .step.active .step-label { color: #000; }
    .step.done .step-label { color: #10b981; }

    /* ── Section panels ── */
    .form-section { display: none; }
    .form-section.active { display: block; animation: fadeIn .3s ease; }
    @keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }

    /* ── Preview images ── */
    .img-preview {
        width: 100%; height: 140px;
        border: 2px dashed #e0e0e0;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; cursor: pointer;
        transition: border-color .2s;
        background: #fafafa;
    }
    .img-preview:hover { border-color: #f0c61d; }
    .img-preview img { width: 100%; height: 100%; object-fit: cover; }
    .img-preview .placeholder { text-align: center; color: #aaa; font-size: 0.82rem; }
    .img-preview .placeholder i { font-size: 2rem; display: block; margin-bottom: 6px; }

    /* ── Map ── */
    #map-picker { height: 320px; border-radius: 10px; border: 1px solid #e0e0e0; }

    /* ── Form controls ── */
    .form-control:focus, .form-select:focus {
        border-color: #f0c61d;
        box-shadow: 0 0 0 3px rgba(240,198,29,0.15);
    }
    .section-title {
        font-size: 1rem; font-weight: 700; color: #111;
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 20px; padding-bottom: 10px;
        border-bottom: 2px solid #f0c61d;
    }
    .section-title i { color: #f0c61d; font-size: 1.1rem; }

    /* ── Nav buttons ── */
    .form-nav { display: flex; justify-content: space-between; align-items: center; margin-top: 28px; padding-top: 20px; border-top: 1px solid #f0f0f0; }
    .btn-next { background: #f0c61d; color: #000; border: none; font-weight: 600; padding: 10px 28px; border-radius: 8px; transition: all .2s; }
    .btn-next:hover { background: #e0b800; transform: translateY(-1px); }
    .btn-prev { background: transparent; color: #555; border: 1px solid #ddd; font-weight: 500; padding: 10px 24px; border-radius: 8px; transition: all .2s; }
    .btn-prev:hover { border-color: #999; color: #000; }
    .btn-submit { background: #111; color: #fff; border: none; font-weight: 600; padding: 10px 32px; border-radius: 8px; transition: all .2s; }
    .btn-submit:hover { background: #333; }

    /* ── Geo btn ── */
    .btn-geo { background: #fff; border: 1px solid #f0c61d; color: #000; font-size: 0.82rem; font-weight: 600; padding: 8px 16px; border-radius: 8px; transition: all .2s; }
    .btn-geo:hover { background: #f0c61d; }

    /* ── Progress bar ── */
    .form-progress { height: 4px; background: #f0f0f0; border-radius: 2px; margin-bottom: 28px; }
    .form-progress-bar { height: 100%; background: #f0c61d; border-radius: 2px; transition: width .4s ease; }

    @media (max-width: 576px) {
        .step-label { display: none; }
        .step-circle { width: 30px; height: 30px; font-size: 0.75rem; }
    }
</style>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('Ma_boutique') }}" class="btn btn-outline-dark btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h1 class="h2 text-dark fw-bold mb-0">
            <i class="bi bi-shop me-2" style="color:#f0c61d;"></i>
            Créer ma boutique en ligne
        </h1>
        <p class="text-muted mb-0 small">Configurez votre vitrine en quelques étapes</p>
    </div>
</div>

{{-- Barre de progression --}}
<div class="form-progress">
    <div class="form-progress-bar" id="progressBar" style="width:25%"></div>
</div>

{{-- Stepper --}}
<div class="form-stepper">
    <div class="step active" id="step-1">
        <div class="step-circle">1</div>
        <span class="step-label">Identité</span>
    </div>
    <div class="step" id="step-2">
        <div class="step-circle">2</div>
        <span class="step-label">Visuels</span>
    </div>
    <div class="step" id="step-3">
        <div class="step-circle">3</div>
        <span class="step-label">Contacts</span>
    </div>
    <div class="step" id="step-4">
        <div class="step-circle">4</div>
        <span class="step-label">Localisation</span>
    </div>
</div>

<form action="{{ route('Ma_boutique.store') }}" method="POST" enctype="multipart/form-data" id="boutiqueForm">
    @csrf
    <input type="hidden" name="cabine_id" value="{{ auth()->user()->cabine_id }}">

    @if($errors->any())
    <div class="alert alert-danger border-0 mb-4">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    {{-- ── SECTION 1 : Identité ── --}}
    <div class="form-section active" id="section-1">
        <div class="section-title"><i class="bi bi-building"></i> Identité de votre boutique</div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nom de la boutique <span class="text-danger">*</span></label>
                <input type="text" name="nom_site" class="form-control border-dark"
                       value="{{ old('nom_site') }}" placeholder="Ex: Fashion Store, Tech Market..." required>
                <div class="form-text">Le nom affiché sur votre boutique en ligne.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Téléphone professionnel <span class="text-danger">*</span></label>
                <input type="text" name="telephone" class="form-control border-dark"
                       value="{{ old('telephone') }}" placeholder="Ex: +225 0102030405" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Titre principal <span class="text-danger">*</span></label>
                <input type="text" name="titre" class="form-control border-dark"
                       value="{{ old('titre') }}" placeholder="Ex: Votre Partenaire Mode..." required>
                <div class="form-text">Affiché en grand sur votre page d'accueil.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Sous-titre <span class="text-danger">*</span></label>
                <input type="text" name="sous_titre" class="form-control border-dark"
                       value="{{ old('sous_titre') }}" placeholder="Ex: Livraison gratuite..." required>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control border-dark" rows="4"
                          placeholder="Décrivez votre boutique, vos produits, vos valeurs..." required>{{ old('description') }}</textarea>
                <div class="form-text">Aide au référencement et rassure vos clients.</div>
            </div>
        </div>
        <div class="form-nav">
            <span></span>
            <button type="button" class="btn-next" onclick="goToStep(2)">
                Suivant <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </div>

    {{-- ── SECTION 2 : Visuels ── --}}
    <div class="form-section" id="section-2">
        <div class="section-title"><i class="bi bi-palette"></i> Identité visuelle</div>
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Logo <span class="text-danger">*</span></label>
                <div class="img-preview" id="logoPreview" onclick="document.getElementById('logoInput').click()">
                    <div class="placeholder"><i class="bi bi-image"></i>Cliquez pour choisir votre logo</div>
                </div>
                <input type="file" name="logo" id="logoInput" class="d-none" accept="image/*" required>
                <div class="form-text mt-2">Format recommandé : carré, PNG ou JPG, max 4 Mo.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Bannière <span class="text-danger">*</span></label>
                <div class="img-preview" id="bannierePreview" onclick="document.getElementById('banniereInput').click()">
                    <div class="placeholder"><i class="bi bi-image-fill"></i>Cliquez pour choisir votre bannière</div>
                </div>
                <input type="file" name="banniere" id="banniereInput" class="d-none" accept="image/*" required>
                <div class="form-text mt-2">Recommandé : 1200×400 px. Image d'en-tête de votre boutique.</div>
            </div>
        </div>
        <div class="form-nav">
            <button type="button" class="btn-prev" onclick="goToStep(1)">
                <i class="bi bi-arrow-left me-1"></i> Précédent
            </button>
            <button type="button" class="btn-next" onclick="goToStep(3)">
                Suivant <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </div>

    {{-- ── SECTION 3 : Contacts ── --}}
    <div class="form-section" id="section-3">
        <div class="section-title"><i class="bi bi-telephone"></i> Contacts & réseaux sociaux</div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">WhatsApp</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-dark"><i class="bi bi-whatsapp text-success"></i></span>
                    <input type="text" name="whatsapp" class="form-control border-dark"
                           value="{{ old('whatsapp') }}" placeholder="Ex: 0708091011">
                </div>
                <div class="form-text">Numéro sans espaces ni tirets.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Email professionnel</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-dark"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control border-dark"
                           value="{{ old('email') }}" placeholder="contact@votreboutique.com">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Facebook</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-dark"><i class="bi bi-facebook text-primary"></i></span>
                    <input type="url" name="facebook" class="form-control border-dark"
                           value="{{ old('facebook') }}" placeholder="https://facebook.com/votreboutique">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Instagram</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-dark"><i class="bi bi-instagram text-danger"></i></span>
                    <input type="url" name="instagram" class="form-control border-dark"
                           value="{{ old('instagram') }}" placeholder="https://instagram.com/votreboutique">
                </div>
            </div>
        </div>
        <div class="form-nav">
            <button type="button" class="btn-prev" onclick="goToStep(2)">
                <i class="bi bi-arrow-left me-1"></i> Précédent
            </button>
            <button type="button" class="btn-next" onclick="goToStep(4)">
                Suivant <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </div>

    {{-- ── SECTION 4 : Localisation ── --}}
    <div class="form-section" id="section-4">
        <div class="section-title"><i class="bi bi-geo-alt"></i> Localisation de votre boutique</div>

        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <button type="button" class="btn-geo" id="geoBtn">
                <i class="bi bi-crosshair me-1"></i> Utiliser ma position actuelle
            </button>
            <small class="text-muted">ou cliquez directement sur la carte pour placer votre boutique</small>
        </div>

        <div id="map-picker" class="mb-3"></div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Latitude</label>
                <input type="number" step="any" name="latitude" id="latitude"
                       class="form-control border-dark"
                       value="{{ old('latitude') }}" placeholder="Ex: 5.3599517">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Longitude</label>
                <input type="number" step="any" name="longitude" id="longitude"
                       class="form-control border-dark"
                       value="{{ old('longitude') }}" placeholder="Ex: -4.0082563">
            </div>
        </div>
        <div class="form-text mt-1">
            <i class="bi bi-info-circle me-1"></i>
            La localisation permet à vos clients de vous trouver facilement. Vous pouvez la laisser vide.
        </div>

        <div class="mt-4 p-3 rounded" style="background:#fffbea;border:1px solid #f0c61d;">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="est_publiee" id="est_publiee" value="1" checked>
                <label class="form-check-label fw-semibold text-dark" for="est_publiee">
                    <i class="bi bi-globe me-1" style="color:#f0c61d;"></i>
                    Publier ma boutique immédiatement
                </label>
                <div class="form-text">Votre boutique sera visible en ligne dès la création.</div>
            </div>
        </div>

        <div class="form-nav">
            <button type="button" class="btn-prev" onclick="goToStep(3)">
                <i class="bi bi-arrow-left me-1"></i> Précédent
            </button>
            <button type="submit" class="btn-submit">
                <i class="bi bi-check-circle me-1"></i> Créer ma boutique
            </button>
        </div>
    </div>
</form>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
// ── Stepper ──────────────────────────────────────────────────────────────────
const TOTAL_STEPS = 4;
let currentStep = 1;

function goToStep(n) {
    // Validation basique avant d'avancer
    if (n > currentStep && !validateSection(currentStep)) return;

    document.getElementById('section-' + currentStep).classList.remove('active');
    document.getElementById('step-' + currentStep).classList.remove('active');
    document.getElementById('step-' + currentStep).classList.add('done');

    if (n < currentStep) {
        // Retour : enlever "done" de l'étape courante
        document.getElementById('step-' + currentStep).classList.remove('done');
    }

    currentStep = n;
    document.getElementById('section-' + currentStep).classList.add('active');
    document.getElementById('step-' + currentStep).classList.remove('done');
    document.getElementById('step-' + currentStep).classList.add('active');

    // Barre de progression
    document.getElementById('progressBar').style.width = (currentStep / TOTAL_STEPS * 100) + '%';

    // Initialiser la carte quand on arrive à l'étape 4
    if (currentStep === 4 && !window._mapInit) initMap();

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function validateSection(step) {
    const section = document.getElementById('section-' + step);
    const required = section.querySelectorAll('[required]');
    let valid = true;
    required.forEach(el => {
        if (!el.value.trim()) {
            el.classList.add('is-invalid');
            valid = false;
        } else {
            el.classList.remove('is-invalid');
        }
    });
    if (!valid) {
        section.querySelector('.is-invalid')?.focus();
    }
    return valid;
}

// ── Prévisualisation images ───────────────────────────────────────────────────
function setupPreview(inputId, previewId) {
    document.getElementById(inputId).addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById(previewId);
            preview.innerHTML = `<img src="${e.target.result}" alt="preview">`;
        };
        reader.readAsDataURL(file);
    });
}
setupPreview('logoInput', 'logoPreview');
setupPreview('banniereInput', 'bannierePreview');

// ── Carte Leaflet ─────────────────────────────────────────────────────────────
function initMap() {
    window._mapInit = true;
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    const initLat = parseFloat(latInput.value) || 5.3476;
    const initLng = parseFloat(lngInput.value) || -4.0078;
    const initZoom = (latInput.value && lngInput.value) ? 15 : 12;

    const map = L.map('map-picker').setView([initLat, initLng], initZoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    let marker = null;

    function placeMarker(lat, lng) {
        if (!marker) {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', e => {
                const p = e.target.getLatLng();
                latInput.value = p.lat.toFixed(7);
                lngInput.value = p.lng.toFixed(7);
            });
        } else {
            marker.setLatLng([lat, lng]);
        }
        latInput.value = lat.toFixed(7);
        lngInput.value = lng.toFixed(7);
    }

    if (latInput.value && lngInput.value) placeMarker(initLat, initLng);

    map.on('click', e => {
        placeMarker(e.latlng.lat, e.latlng.lng);
        map.setView([e.latlng.lat, e.latlng.lng], 15);
    });

    // Sync inputs → carte
    [latInput, lngInput].forEach(inp => {
        inp.addEventListener('change', () => {
            const la = parseFloat(latInput.value);
            const ln = parseFloat(lngInput.value);
            if (isFinite(la) && isFinite(ln)) { map.setView([la, ln], 15); placeMarker(la, ln); }
        });
    });

    // Bouton géolocalisation
    document.getElementById('geoBtn').addEventListener('click', function () {
        if (!navigator.geolocation) { alert('Géolocalisation non supportée.'); return; }
        this.disabled = true;
        this.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Localisation...';
        const btn = this;
        navigator.geolocation.getCurrentPosition(pos => {
            const { latitude: la, longitude: ln } = pos.coords;
            map.setView([la, ln], 16);
            placeMarker(la, ln);
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-crosshair me-1"></i> Utiliser ma position actuelle';
        }, () => {
            alert("Impossible d'obtenir votre position.");
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-crosshair me-1"></i> Utiliser ma position actuelle';
        });
    });
}

// Auto-complétion URL réseaux sociaux
document.querySelectorAll('input[type="url"]').forEach(inp => {
    inp.addEventListener('blur', function () {
        if (this.value && !this.value.startsWith('http')) this.value = 'https://' + this.value;
    });
});
</script>
@endpush

@endsection
