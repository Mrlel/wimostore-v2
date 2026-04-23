<!-- Carte principale du formulaire -->
<div class="card mb-4 border-0">
    <div class="card-header py-3 bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="h5 mb-0">
                <i class="fas fa-edit text-primary me-2"></i>
                Informations de la page
            </h3>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Sélection cabine -->
        <div class="mb-4">
            <label for="cabine_id" class="form-label fw-bold">Sélectionner la boutique</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-shop"></i></span>
                <select name="cabine_id" id="cabine_id" class="form-control tom-select" required
                        data-placeholder="Choisir une cabine…">
                    <option value="">-- Sélectionnez une cabine --</option>
                    @foreach($cabines as $cabine)
                        <option value="{{ $cabine->id }}"
                            {{ (string) old('cabine_id', $cabine_page->cabine_id ?? '') === (string) $cabine->id ? 'selected' : '' }}>
                            {{ $cabine->nom_cab }} ({{ $cabine->code }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Informations de base -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label for="nom_site" class="form-label fw-bold">Nom du site</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-globe2"></i></span>
                    <input type="text" class="form-control" name="nom_site" id="nom_site"
                           value="{{ old('nom_site', $cabine_page->nom_site ?? '') }}"
                           placeholder="Nom de votre site">
                </div>
            </div>
            
            <div class="col-md-6">
                <label for="titre" class="form-label fw-bold">Titre principal</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                    <input type="text" class="form-control" name="titre" id="titre"
                           value="{{ old('titre', $cabine_page->titre ?? '') }}"
                           placeholder="Titre de la page">
                </div>
            </div>
        </div>

        <!-- Sous-titre et description -->
        <div class="mb-4">
            <label for="sous_titre" class="form-label fw-bold">Sous-titre</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-text-height"></i></span>
                <input type="text" class="form-control" name="sous_titre" id="sous_titre"
                       value="{{ old('sous_titre', $cabine_page->sous_titre ?? '') }}"
                       placeholder="Sous-titre accrocheur">
            </div>
        </div>

        <div class="mb-4">
            <label for="description" class="form-label fw-bold">Description des services</label>
            <div class="input-group">
                <span class="input-group-text align-items-start pt-3"><i class="fas fa-align-left"></i></span>
                <textarea class="form-control" name="description" id="description" rows="4"
                          placeholder="Décrivez vos services et prestations...">{{ old('description', $cabine_page->description ?? '') }}</textarea>
            </div>
        </div>

        <!-- Fichiers (Logo et Bannière) -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label for="logo" class="form-label fw-bold">Logo</label>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="input-group">
                            <input type="file" class="form-control" name="logo" id="logo">
                        </div>
                        @if(!empty($cabine_page->logo))
                        <div class="mt-3 p-2 bg-light rounded text-center">
                            <img src="{{ asset('storage/' . $cabine_page->logo) }}" width="80" alt="logo actuel" class="mb-2">
                            <div class="small text-muted">Logo actuel</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <label for="banniere" class="form-label fw-bold">Bannière (500x400)</label>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="input-group">
                            <input type="file" class="form-control" name="banniere" id="banniere">
                        </div>
                        @if(!empty($cabine_page->banniere))
                        <div class="mt-3 p-2 bg-light rounded text-center">
                            <img src="{{ asset('storage/' . $cabine_page->banniere) }}" width="120" alt="bannière actuelle" class="mb-2">
                            <div class="small text-muted">Bannière actuelle</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Carte des contacts -->
<div class="card mb-4 border-0">
    <div class="card-header py-3 bg-white">
        <h4 class="h5 mb-0">
            <i class="fas fa-phone text-success me-2"></i>
            Informations de contact
        </h4>
    </div>
    
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="telephone" class="form-label fw-bold">Téléphone professionnel</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    <input type="text" class="form-control" name="telephone" id="telephone"
                           value="{{ old('telephone', $cabine_page->telephone ?? '') }}"
                           placeholder="Numéro de téléphone">
                </div>
            </div>
            
            <div class="col-md-6">
                <label for="whatsapp" class="form-label fw-bold">WhatsApp</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                    <input type="text" class="form-control" name="whatsapp" id="whatsapp" 
                           placeholder="2250100...."
                           value="{{ old('whatsapp', $cabine_page->whatsapp ?? '') }}">
                </div>
            </div>
            
            <div class="col-md-6">
                <label for="email" class="form-label fw-bold">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" name="email" id="email"
                           value="{{ old('email', $cabine_page->email ?? '') }}"
                           placeholder="Adresse email">
                </div>
            </div>
        </div>

        <!-- Réseaux sociaux -->
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label for="facebook" class="form-label fw-bold">Facebook</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                    <input type="text" class="form-control" name="facebook" id="facebook" 
                           placeholder="https://...."
                           value="{{ old('facebook', $cabine_page->facebook ?? '') }}">
                </div>
            </div>
            
            <div class="col-md-6">
                <label for="instagram" class="form-label fw-bold">Instagram</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                    <input type="text" class="form-control" name="instagram" id="instagram" 
                           placeholder="https://..."
                           value="{{ old('instagram', $cabine_page->instagram ?? '') }}">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Carte de localisation -->
<div class="card mb-4 border-0">
    <div class="card-header py-3 bg-white">
        <h4 class="h5 mb-0">
            <i class="fas fa-map-marker-alt text-danger me-2"></i>
            Localisation
        </h4>
    </div>
    
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="latitude" class="form-label fw-bold">Latitude</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                    <input type="number" step="any" class="form-control" name="latitude" id="latitude"
                           value="{{ old('latitude', $cabine_page->latitude ?? '') }}"
                           placeholder="Coordonnée latitude">
                </div>
            </div>
            
            <div class="col-md-6">
                <label for="longitude" class="form-label fw-bold">Longitude</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                    <input type="number" step="any" class="form-control" name="longitude" id="longitude"
                           value="{{ old('longitude', $cabine_page->longitude ?? '') }}"
                           placeholder="Coordonnée longitude">
                </div>
            </div>
        </div>

        <!-- Carte interactive -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold">Sélection sur la carte</span>
                <button type="button" class="btn btn-sm btn-outline-orange" id="use-geolocation">
                    <i class="fas fa-location-crosshairs me-1"></i>Utiliser ma position
                </button>
            </div>
            <small class="text-muted d-block mb-2">Cliquez sur la carte pour définir la position, ou faites glisser le marqueur.</small>
            <div id="map-picker" style="height: 320px; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb;"></div>
        </div>
    </div>
</div>

<!-- Carte de publication -->
<div class="card mb-4 border-0">
    <div class="card-header py-3 bg-white">
        <h4 class="h5 mb-0">
            <i class="fas fa-paper-plane text-warning me-2"></i>
            Publication
        </h4>
    </div>
    
    <div class="card-body">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="est_publiee" id="est_publiee" value="1"
                   {{ old('est_publiee', $cabine_page->est_publiee ?? false) ? 'checked' : '' }}>
            <label class="form-check-label fw-bold" for="est_publiee">
                <i class="fas fa-eye me-1"></i>Publier cette page
            </label>
            <div class="form-text">La page sera visible publiquement si cette case est cochée.</div>
        </div>
    </div>
</div>

<!-- Styles additionnels -->
<style>
    .btn-outline-orange {
        color: #fbc926;
        border-color: #fbc926;
    }
    
    .btn-outline-orange:hover {
        background-color: #fbc926;
        color: #000;
        border-color: #fbc926;
    }
    
    .form-label.fw-bold {
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/brands.min.css">

<!-- Leaflet CSS + JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const geolocBtn = document.getElementById('use-geolocation');

        // Valeurs initiales (Abidjan si vide)
        const initialLat = parseFloat(latInput.value) || 5.3476;
        const initialLng = parseFloat(lngInput.value) || -4.0078;
        const initialZoom = (latInput.value && lngInput.value) ? 16 : 12;

        const map = L.map('map-picker').setView([initialLat, initialLng], initialZoom);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let marker = null;
        function placeOrMoveMarker(lat, lng) {
            if (!marker) {
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                marker.on('dragend', function(e) {
                    const { lat, lng } = e.target.getLatLng();
                    latInput.value = lat.toFixed(7);
                    lngInput.value = lng.toFixed(7);
                });
            } else {
                marker.setLatLng([lat, lng]);
            }
        }

        // Si lat/lng déjà présents
        if (latInput.value && lngInput.value) {
            placeOrMoveMarker(initialLat, initialLng);
        }

        // Clic sur la carte
        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            placeOrMoveMarker(lat, lng);
            latInput.value = lat.toFixed(7);
            lngInput.value = lng.toFixed(7);
        });

        // Bouton "utiliser ma position"
        if (geolocBtn) {
            geolocBtn.addEventListener('click', function() {
                if (!navigator.geolocation) {
                    alert("Votre navigateur ne supporte pas la géolocalisation.");
                    return;
                }
                geolocBtn.disabled = true;
                geolocBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Localisation...';
                navigator.geolocation.getCurrentPosition(function(pos) {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    map.setView([lat, lng], 16);
                    placeOrMoveMarker(lat, lng);
                    latInput.value = lat.toFixed(7);
                    lngInput.value = lng.toFixed(7);
                    geolocBtn.disabled = false;
                    geolocBtn.innerHTML = '<i class="fas fa-location-crosshairs me-1"></i>Utiliser ma position';
                }, function(err) {
                    console.error(err);
                    alert("Impossible d'obtenir la position.");
                    geolocBtn.disabled = false;
                    geolocBtn.innerHTML = '<i class="fas fa-location-crosshairs me-1"></i>Utiliser ma position';
                });
            });
        }

        // Synchronisation si l'utilisateur modifie les inputs manuellement
        function syncFromInputs() {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            if (isFinite(lat) && isFinite(lng)) {
                map.setView([lat, lng], 16);
                placeOrMoveMarker(lat, lng);
            }
        }
        latInput.addEventListener('change', syncFromInputs);
        lngInput.addEventListener('change', syncFromInputs);
    });
</script>