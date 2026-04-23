<!-- resources/views/produits/form.blade.php -->
<!-- Version avec barre de progression -->

    <div class="d-flex align-items-center justify-content-between p-2 rounded mb-3" style="background-color: #fdfcf8ff;">
        <small class="ms-2 text-muted">🎙️ Guide vocal - Explication de la page</small>
        <audio controls style="max-width: 400px; ">
            <source src="{{ asset('audios/page_ajout_produit.mp3') }}" type="audio/mpeg">
            Votre navigateur ne supporte pas la lecture audio.
        </audio>
    </div>
    
<form id="produit-form" method="POST" action="{{ isset($produit) ? route('produits.update', $produit) : route('produits.store') }}" class="needs-validation bg-white" novalidate enctype="multipart/form-data">
    @csrf
    @if(isset($produit)) @method('PUT') @endif

    <div class="border-0 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-white py-3 border-bottom">
            <h2 class="h4 mb-0 p-3 text-dark fw-bold">
                <i class="bi bi-box me-2" style="color: #fbc926;"></i>
                {{ isset($produit) ? 'Modifier le Produit' : 'Nouveau Produit' }}
            </h2>
            <div class="d-flex gap-2 p-2 rounded">
                <button type="button" 
                    class="btn text-dark fw-bold" 
                    style="background-color: #fbc926;" 
                    data-bs-toggle="modal" data-bs-target="#categorieModal">
                    <i class="bi bi-bookmarks me-1"></i> Créer une catégorie
                </button>
                <a href="{{ route('categories.index') }}" class="btn text-dark fw-bold" style="background-color: #fbc926;" title="Voir la liste des catégories">
                    <i class="bi bi-list-ul fs-5 me-1"></i>
                </a>
            </div>
        </div>
        
        <div class="card-body p-4">   
            <div class="row mb-4">     
                <div class="col-md-6 mb-4">
                    <label for="categorie_id" class="form-label fw-semibold text-black">Catégorie <span class="text-danger">*</span></label>
                    <select id="categorie_id" name="categorie_id" required
                        class="form-select border-1 border-dark">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories->sortBy('nom') as $categorie)
                            <option value="{{ $categorie->id }}" 
                                {{ old('categorie_id', $produit->categorie_id ?? '') == $categorie->id ? 'selected' : '' }}
                                class="py-2">
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('categorie_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label fw-semibold text-black">Nom du produit <span class="text-danger">*</span></label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $produit->nom ?? '') }}"
                        class="form-control border-1 border-dark"
                        placeholder="Nom du produit" required>
                    @error('nom')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Prix et Stock -->
            <h5 class="mb-3 text-dark border-bottom pb-2 mt-4">
                <i class="bi bi-currency-dollar me-2" style="color: #fbc926;"></i>Prix et Stock
            </h5>

            <div class="alert alert-warning mb-4">
    <h6 class="mb-2">
        <i class="bi bi-info-circle me-2"></i>
        informations :
    </h6>
    <p class="small mb-0">
        Pour garder une traçabilité des mouvements de stock, la <strong>quantité en stock</strong> ne peut être modifiée que depuis la section <strong><i class="bi bi-arrow-left-right ms-1"></i> Mouvements stock</strong> (entrée/sortie).
    </p>
</div>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="prix_achat" class="form-label fw-semibold text-black">Prix d'achat <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-dark">FCFA</span>
                        <input type="number" step="0.01" id="prix_achat" name="prix_achat" 
                            value="{{ old('prix_achat', $produit->prix_achat ?? '') }}"
                            class="form-control border-1 border-dark"
                            placeholder="0.00" required>
                    </div>
                    @error('prix_achat')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="prix_vente" class="form-label fw-semibold">Prix de vente <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-dark">FCFA</span>
                        <input type="number" step="0.01" id="prix_vente" name="prix_vente" 
                            value="{{ old('prix_vente', $produit->prix_vente ?? '') }}"
                            class="form-control border-1 border-dark"
                            placeholder="0.00" required>
                    </div>
                    @error('prix_vente')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Stock -->
                <div class="col-md-6 mb-3">
                    <label for="quantite_stock" class="form-label fw-semibold">Quantité en stock <span class="text-danger">*</span></label>
                    <input type="number" id="quantite_stock" name="quantite_stock" 
                        value="{{ old('quantite_stock', $produit->quantite_stock ?? 0) }}"
                        class="form-control border-1 border-dark"
                        required min="0">
                    @error('quantite_stock')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="seuil_alerte" class="form-label fw-semibold">Seuil d'alerte <span class="text-danger">*</span></label>
                    <input type="number" id="seuil_alerte" name="seuil_alerte" 
                        value="{{ old('seuil_alerte', $produit->seuil_alerte ?? 5) }}"
                        class="form-control border-1 border-dark"
                        required min="0">
                    @error('seuil_alerte')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Statut -->
                <div class="col-12 mb-3">
                    <div class="form-check form-switch">
                        <input type="checkbox" id="actif" name="actif" value="1" hidden
                            {{ old('actif', $produit->actif ?? true) ? 'checked' : '' }}
                            class="form-check-input" role="switch">
                    </div>
                    @error('actif')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h5 class="mb-3 text-dark border-bottom pb-2 mt-4">
    <i class="bi bi-card-image me-2" style="color: #fbc926;"></i>
    Publication du produit (optionnel)
</h5>

<div class="alert alert-warning mb-4">
    <h6 class="mb-2">
        <i class="bi bi-info-circle me-2"></i>
        À propos de la publication :
    </h6>
    <p class="small mb-0">
        Cette section vous permet de <strong>rendre votre produit visible aux clients</strong> dans votre boutique en ligne.  
        Vous pouvez également <strong>enregistrer toutes les informations</strong> (image, marque, description, etc.)  
        <u>sans le publier immédiatement</u>, afin de préparer sa mise en ligne plus tard.
    </p>
</div>

<div class="row mb-4">

    <div class="col-md-6 mb-3">
        <label for="images" class="form-label fw-semibold">Selectionner l'image</label>
        <input type="file" id="images" name="images[]" class="form-control border-1 border-dark" accept="image/*" multiple>
        @error('images') 
            <div class="invalid-feedback d-block">{{ $message }}</div> 
        @enderror
        @error('images.*') 
            <div class="invalid-feedback d-block">{{ $message }}</div> 
        @enderror

        <!-- Prévisualisation des nouvelles images -->
        <div id="image-preview" class="mt-3 d-flex gap-2 flex-wrap"></div>

        <!-- Images existantes (en mode édition) -->
        @if(isset($produit) && isset($produit->images) && $produit->images->count())
            <div class="mt-3">
                <label class="form-label fw-semibold">Images actuelles :</label>
                <div class="d-flex gap-2 flex-wrap" id="existing-images">
                    @foreach($produit->images as $img)
                        <div class="position-relative d-inline-block">
                            <img src="{{ asset('storage/' . $img->path) }}" alt="Image produit" 
                                 class="img-thumbnail existing-image" 
                                 style="max-height:120px; max-width:120px; object-fit:cover;"
                                 data-image-id="{{ $img->id }}">
                                <button type="submit" form="delete-image-{{ $img->id }}" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1">
                                    <i class="bi bi-trash fs-6"></i>
                                </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Marque -->
    <div class="col-md-6 mb-3">
        <label for="marque" class="form-label fw-semibold">Marque du produit</label>
        <input type="text" id="marque" name="marque" 
            value="{{ old('marque', $produit->marque ?? '') }}"
            class="form-control border-1 border-dark"
            placeholder="Marque du produit">
        @error('marque')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12 mb-3">
        <label for="description" class="form-label fw-semibold">Description du produit</label>
        <textarea id="description" name="description" class="form-control border-1 border-dark"
            placeholder="Détails du produit, caractéristiques, avantages, etc.">{{ old('description', $produit->description ?? '') }}</textarea>
        @error('description') 
            <div class="invalid-feedback d-block">{{ $message }}</div> 
        @enderror
    </div>
</div>

<!-- Visibilité -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="form-check form-switch">
            <input type="checkbox" id="publier" name="publier" value="1"
                {{ old('publier', $produit->publier ?? false) ? 'checked' : '' }}
                class="form-check-input">
            <label for="publier" class="form-check-label fw-semibold">
                Rendre ce produit visible aux clients
            </label>
        </div>
        <small class="text-muted">
            Activez cette option pour afficher le produit dans votre boutique en ligne.
        </small>
        @error('publier') 
            <div class="invalid-feedback d-block">{{ $message }}</div> 
        @enderror
    </div>
</div>


    <div class="card-footer py-3 d-flex justify-content-end">
            <a href="{{ route('produits.index') }}"
                class="btn btn-outline-dark me-3">
                <i class="bi bi-x-circle me-1"></i>Annuler
            </a>
            <button type="submit" class="btn text-dark fw-bold" style="background-color: #fbc926;">
                <i class="bi bi-check-circle me-1"></i>
                {{ isset($produit) ? 'Mettre à jour' : 'Enregistrer le produit' }}
            </button>
        </div>
    </div>
</form>

@if(isset($produit) && isset($produit->images) && $produit->images->count())
    @foreach($produit->images as $img)
        <form id="delete-image-{{ $img->id }}" action="{{ route('produits.destroyImage', $img->id) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endif

<!-- Modal pour créer une catégorie -->
<div class="modal fade" id="categorieModal" tabindex="-1" aria-labelledby="categorieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="categorieModalLabel">Créer une nouvelle catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nom" class="form-label fw-semibold">Nom de la catégorie *</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Téléphone, Accessoire, PC etc." required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn text-dark fw-bold" style="background-color: #fbc926;">
                            <i class="bi bi-check-lg me-1"></i>Créer la catégorie
                        </button>
                    </div>
                </form>
            </div>
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
    
    .form-control:focus, .form-select:focus {
        border-color: #fbc926;
        box-shadow: 0 0 0 0.25rem rgba(255, 222, 89, 0.25);
    }
    .form-label{
        color: #000000;
    }
    
    .btn:hover {
        opacity: 0.9;
    }
    
    .border-bottom {
        border-color: #fbc926 !important;
    }
</style>

<script>

(function () {
    'use strict'
    
    var forms = document.querySelectorAll('.needs-validation')
    
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false)
        })
})()

// Gestion des images (max 3)
(function() {
    const imagesInput = document.getElementById('images');
    const imagePreview = document.getElementById('image-preview');
    const imageCount = document.getElementById('image-count');
    const maxImages = 3;
    let selectedImages = [];
    let existingImagesCount = {{ isset($produit) && isset($produit->images) ? $produit->images->count() : 0 }};

    // Fonction pour mettre à jour le compteur
    function updateImageCount() {
        const total = selectedImages.length + existingImagesCount;
        imageCount.textContent = total;
        imageCount.className = total > maxImages ? 'text-danger fw-bold' : 'text-muted';
        
        // Désactiver l'input si on atteint la limite
        if (total >= maxImages) {
            imagesInput.disabled = true;
            if (imagePreview) {
                imagePreview.insertAdjacentHTML('afterend', 
                    '<small class="text-danger d-block">Vous avez atteint la limite de 3 images.</small>');
            }
        } else {
            imagesInput.disabled = false;
        }
    }

    // Fonction pour afficher la prévisualisation
    function displayPreview(files) {
        if (!imagePreview) return;
        
        Array.from(files).forEach((file, index) => {
            // Vérifier la limite
            if (selectedImages.length + existingImagesCount >= maxImages) {
                alert('Vous ne pouvez ajouter que ' + maxImages + ' images maximum.');
                return;
            }

            // Vérifier le type de fichier
            if (!file.type.startsWith('image/')) {
                alert('Veuillez sélectionner uniquement des images.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const imageId = 'preview-' + Date.now() + '-' + index;
                const imageWrapper = document.createElement('div');
                imageWrapper.className = 'position-relative d-inline-block';
                imageWrapper.id = imageId;
                imageWrapper.innerHTML = `
                    <img src="${e.target.result}" 
                         alt="Aperçu" 
                         class="img-thumbnail" 
                         style="max-height:120px; max-width:120px; object-fit:cover;">
                    <button type="button" 
                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-preview-image" 
                            data-preview-id="${imageId}"
                            style="border-radius: 50%; width: 24px; height: 24px; padding: 0; line-height: 1;">
                        <i class="bi bi-x"></i>
                    </button>
                `;
                
                imagePreview.appendChild(imageWrapper);
                selectedImages.push({
                    id: imageId,
                    file: file,
                    element: imageWrapper
                });
                
                updateImageCount();
            };
            reader.readAsDataURL(file);
        });
    }

    // Écouter les changements sur l'input file
    if (imagesInput) {
        imagesInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            
            // Limiter à 3 images au total
            const remainingSlots = maxImages - existingImagesCount - selectedImages.length;
            if (files.length > remainingSlots) {
                alert(`Vous ne pouvez sélectionner que ${remainingSlots} image(s) supplémentaire(s).`);
                const limitedFiles = files.slice(0, remainingSlots);
                e.target.files = createFileList(limitedFiles);
                displayPreview(limitedFiles);
            } else {
                displayPreview(files);
            }
        });
    }

    // Fonction helper pour créer un FileList (approximation)
    function createFileList(files) {
        const dt = new DataTransfer();
        files.forEach(file => dt.items.add(file));
        return dt.files;
    }

    // Supprimer une image de prévisualisation
    if (imagePreview) {
        imagePreview.addEventListener('click', function(e) {
            if (e.target.closest('.remove-preview-image')) {
                const btn = e.target.closest('.remove-preview-image');
                const previewId = btn.getAttribute('data-preview-id');
                const imageIndex = selectedImages.findIndex(img => img.id === previewId);
                
                if (imageIndex !== -1) {
                    selectedImages[imageIndex].element.remove();
                    selectedImages.splice(imageIndex, 1);
                    
                    // Mettre à jour l'input file
                    const dt = new DataTransfer();
                    selectedImages.forEach(img => dt.items.add(img.file));
                    imagesInput.files = dt.files;
                    
                    updateImageCount();
                }
            }
        });
    }

    // Supprimer une image existante (en mode édition)
    const existingImagesContainer = document.getElementById('existing-images');
    if (existingImagesContainer) {
        existingImagesContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-existing-image')) {
                const btn = e.target.closest('.remove-existing-image');
                const imageId = btn.getAttribute('data-image-id');
                
                if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
                    // Créer un champ caché pour indiquer la suppression
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'images_to_delete[]';
                    hiddenInput.value = imageId;
                    document.getElementById('produit-form').appendChild(hiddenInput);
                    
                    // Retirer visuellement
                    btn.closest('.position-relative').remove();
                    existingImagesCount--;
                    updateImageCount();
                }
            }
        });
    }

    // Initialiser le compteur au chargement
    updateImageCount();
})();
</script>