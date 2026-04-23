@extends('layouts.public')

@section('title', $produit->nom . ' | ' . $page->cabine->nom_cab)

@section('content')

<style>
/* ===== PAGE DÉTAIL PRODUIT ===== */

/* Breadcrumb */
.detail-breadcrumb {
    padding: 1.2rem 1.5rem 0;
}

.breadcrumb-modern {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 11px;
    font-family: 'DM Sans', sans-serif;
}

.breadcrumb-modern li a {
    color: var(--warm-gray);
    text-decoration: none;
    transition: color .2s;
}

.breadcrumb-modern li a:hover {
    color: var(--accent);
}

.breadcrumb-modern li.active {
    color: var(--charcoal);
    font-weight: 500;
}

.breadcrumb-separator {
    color: var(--border);
    font-size: 8px;
}

/* Layout principal */
.detail-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 1.5rem 1.5rem 4rem;
}

/* Galerie */
.gallery-section {
    padding-right: 1.5rem;
}

.main-image-container {
    position: relative;
    background: #faf7f7;
    border-radius: 18px;
    overflow: hidden;
    aspect-ratio: 3/4;
    cursor: pointer;
    margin-bottom: 1rem;
}

.main-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity .3s, transform .3s;
}

.zoom-indicator {
    position: absolute;
    bottom: 12px;
    right: 12px;
    background: rgba(26, 26, 26, 0.7);
    backdrop-filter: blur(4px);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 14px;
    opacity: 0;
    transition: opacity .25s;
}

.main-image-container:hover .zoom-indicator {
    opacity: 1;
}

/* Miniatures */
.thumbnails-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.8rem;
}

.thumbnail-box {
    background: #faf7f7;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 3/4;
    cursor: pointer;
    border: 2px solid transparent;
    transition: border-color .2s, transform .2s;
}

.thumbnail-box:hover {
    transform: translateY(-2px);
}

.thumbnail-box.active {
    border-color: var(--charcoal);
}

.thumbnail-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Informations produit */
.info-section {
    padding-left: 1.5rem;
}

.product-category-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: var(--tag-bg);
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--warm-gray);
    margin-bottom: 1rem;
}

.product-main-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    font-weight: 600;
    color: var(--charcoal);
    line-height: 1.2;
    margin-bottom: 1rem;
}

/* Prix */
.price-container {
    display: flex;
    align-items: baseline;
    gap: 0.8rem;
    flex-wrap: wrap;
    margin-bottom: 1.2rem;
}

.current-price {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--charcoal);
    font-family: 'DM Sans', sans-serif;
}

.original-price {
    font-size: 1rem;
    color: var(--warm-gray);
    text-decoration: line-through;
}

.discount-badge {
    background: #C06B5A;
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 20px;
}

/* Stock */
.stock-container {
    display: flex;
    align-items: center;
    gap: 1.2rem;
    flex-wrap: wrap;
    margin-bottom: 1.2rem;
}

.stock-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 12px;
    font-weight: 500;
}

.stock-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.stock-status.in-stock .stock-dot {
    background: #10B981;
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
}

.stock-status.out-stock .stock-dot {
    background: #C06B5A;
}

.stock-status.in-stock {
    color: #10B981;
}

.stock-status.out-stock {
    color: #C06B5A;
}

.product-code {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 11px;
    color: var(--warm-gray);
    font-family: monospace;
}

.divider {
    height: 1px;
    background: var(--border);
    margin: 1.2rem 0;
}

/* Blocs info */
.info-block {
    margin-bottom: 1.5rem;
}

.info-block-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: 'Inter', serif;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--charcoal);
    margin-bottom: 0.8rem;
}

.info-block-title i {
    color: var(--accent);
    font-size: 0.9rem;
}

.info-block-content {
    font-size: 13px;
    line-height: 1.6;
    color: var(--warm-gray);
    font-family: 'DM Sans', sans-serif;
}

/* Liste caractéristiques */
.features-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.features-list li {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 13px;
    color: var(--warm-gray);
    padding: 0.4rem 0;
}

.features-list li i {
    color: #10B981;
    font-size: 12px;
}

/* Actions */
.action-buttons-container {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    margin-top: 1.5rem;
    flex-wrap: wrap;
}

.btn-add-cart-detail {
    flex: 1;
    background: var(--charcoal);
    color: #fff;
    border: none;
    border-radius: 40px;
    padding: 14px 24px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.03em;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    transition: background .2s;
    font-family: 'DM Sans', sans-serif;
}

.btn-add-cart-detail:hover {
    background: var(--accent-dark);
}

.btn-add-cart-detail:active {
    transform: scale(0.98);
}

.btn-add-cart-detail:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.btn-whatsapp-detail {
    background: #25D366;
    color: #fff;
    border: none;
    border-radius: 40px;
    padding: 14px 20px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: background .2s;
    font-family: 'DM Sans', sans-serif;
}

.btn-whatsapp-detail:hover {
    background: #128C7E;
}

.btn-share-detail {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #faf7f7;
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .2s;
    color: var(--warm-gray);
    font-size: 1rem;
}

.btn-share-detail:hover {
    background: var(--charcoal);
    color: #fff;
    border-color: var(--charcoal);
}

/* Modal image */
.image-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(8px);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity .3s, visibility .3s;
}

.image-modal.active {
    opacity: 1;
    visibility: visible;
}

.modal-content-wrapper {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
}

.modal-close-btn {
    position: absolute;
    top: -40px;
    right: 0;
    background: none;
    border: none;
    color: #fff;
    font-size: 24px;
    cursor: pointer;
    padding: 8px;
    transition: opacity .2s;
}

.modal-close-btn:hover {
    opacity: 0.7;
}

.modal-image-full {
    max-width: 90vw;
    max-height: 85vh;
    object-fit: contain;
    border-radius: 12px;
}

/* Responsive */
@media (max-width: 991px) {
    .gallery-section {
        padding-right: 0;
        margin-bottom: 2rem;
    }
    
    .info-section {
        padding-left: 0;
    }
    
    .product-main-title {
        font-size: 1.6rem;
    }
    
    .current-price {
        font-size: 1.5rem;
    }
}

@media (max-width: 767px) {
    .detail-container {
        padding: 1rem 1rem 3rem;
    }
    
    .thumbnails-grid {
        gap: 0.5rem;
    }
    
    .action-buttons-container {
        flex-wrap: wrap;
    }
    
    .btn-add-cart-detail {
        flex: 1 1 100%;
    }
    
    .btn-whatsapp-detail {
        flex: 1;
    }
}

@media (max-width: 479px) {
    .product-main-title {
        font-size: 1.3rem;
    }
    
    .price-container {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.4rem;
    }
    
    .stock-container {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>

<!-- BREADCRUMB -->
<section class="detail-breadcrumb">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb-modern">
                <li>
                    <a href="{{ route('cabine.public', $page->cabine->code) }}">
                        <i class="bi bi-house"></i> Accueil
                    </a>
                </li>
                <li class="breadcrumb-separator">
                    <i class="bi bi-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('cabine.public', $page->cabine->code) }}#productGrid">Produits</a>
                </li>
                <li class="breadcrumb-separator">
                    <i class="bi bi-chevron-right"></i>
                </li>
                <li class="active">{{ $produit->nom }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- PRODUCT DETAIL -->
<div class="detail-container">
    <div class="row g-0">
        <!-- GALLERY -->
        <div class="col-lg-6">
            <div class="gallery-section">
                @php
                    $hasImages = isset($produit->images) && $produit->images->count() > 0;
                    $mainSrc = $hasImages
                        ? asset('storage/' . $produit->images->first()->path)
                        : ($produit->image ? asset('storage/'.$produit->image) : '/image-box.jpeg');
                @endphp

                <div class="main-image-container" onclick="openImageModal('{{ $mainSrc }}')">
                    <img id="main-product-image" src="{{ $mainSrc }}" alt="{{ $produit->nom }}" loading="lazy">
                    <div class="zoom-indicator">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </div>

                @if($hasImages && $produit->images->count() > 1)
                <div class="thumbnails-grid">
                    @foreach($produit->images as $index => $img)
                        @php $src = asset('storage/' . $img->path); @endphp
                        <div class="thumbnail-box {{ $index === 0 ? 'active' : '' }}" 
                             onclick="changeMainImage('{{ $src }}', this)">
                            <img src="{{ $src }}" alt="Image {{ $index + 1 }}" loading="lazy">
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- INFO -->
        <div class="col-lg-6">
            <div class="info-section">
                <!-- Category -->
                <div class="product-category-tag">
                    <i class="bi bi-tag"></i>
                    {{ optional($produit->categorie)->nom ?? 'Général' }}
                </div>

                <!-- Title -->
                <h1 class="product-main-title">{{ $produit->nom }}</h1>

                <!-- Price -->
                @php
                    $prix_promo = $produit->prix_vente + ($produit->prix_achat * 0.2);
                    $discount = round((($prix_promo - $produit->prix_vente) / $prix_promo) * 100);
                @endphp
                <div class="price-container">
                    <span class="current-price">{{ number_format($produit->prix_vente, 0, ',', ' ') }} FCFA</span>
                    @if($discount > 0)
                    <span class="original-price">{{ number_format($prix_promo, 0, ',', ' ') }} FCFA</span>
                    <span class="discount-badge">-{{ $discount }}%</span>
                    @endif
                </div>

                <!-- Stock & Code -->
                <div class="stock-container">
                    <div class="stock-status {{ $produit->quantite_stock > 0 ? 'in-stock' : 'out-stock' }}">
                        <span class="stock-dot"></span>
                        <span>{{ $produit->quantite_stock > 0 ? 'En stock' : 'Rupture de stock' }}</span>
                    </div>
                    <div class="product-code">
                        <i class="bi bi-upc-scan"></i>
                        <span>{{ $produit->code }}</span>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Description -->
                @if($produit->description)
                <div class="info-block">
                    <h2 class="info-block-title">
                        <i class="bi bi-text-paragraph"></i>
                        <span>Description</span>
                    </h2>
                    <p class="info-block-content">{{ $produit->description }}</p>
                </div>
                @endif

                <!-- Features -->
                @if(isset($produit->descriptions) && count($produit->descriptions) > 0)
                <div class="info-block">
                    <h2 class="info-block-title">
                        <i class="bi bi-check2-square"></i>
                        <span>Caractéristiques</span>
                    </h2>
                    <ul class="features-list">
                        @foreach($produit->descriptions as $description)
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ $description }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons-container">
                    @if($produit->quantite_stock > 0)
                    <button type="button" class="btn-add-cart-detail"
                            onclick="addToCart({{ $produit->id }}, 1, this)">
                        <i class="bi bi-bag-plus"></i>
                        <span>Ajouter au panier</span>
                    </button>
                    @endif
                    <a href="https://wa.me/225{{ $page->whatsapp }}?text={{ urlencode('Bonjour, je suis intéressé(e) par votre produit : ' . $produit->nom . ' (Code : ' . $produit->code . ') au prix de ' . number_format($produit->prix_vente, 0, ',', ' ') . ' FCFA. Pouvez-vous me donner plus d\'informations ? Merci.') }}"
                       target="_blank" 
                       class="btn-whatsapp-detail">
                        <i class="bi bi-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                    <button type="button" 
                            class="btn-share-detail" 
                            onclick="shareProduct('{{ route('details.produit', ['code' => $cabine->code, 'id' => $produit->id]) }}')">
                        <i class="bi bi-share"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL IMAGE -->
<div class="image-modal" id="imageModal" onclick="closeImageModal(event)">
    <div class="modal-content-wrapper">
        <button class="modal-close-btn" onclick="closeImageModal(event)">
            <i class="bi bi-x-lg"></i>
        </button>
        <img id="modalImage" src="" alt="" class="modal-image-full">
    </div>
</div>

@push('scripts')
<script>
// Change main image
function changeMainImage(src, element) {
    const mainImage = document.getElementById('main-product-image');
    if (!mainImage) return;
    
    mainImage.style.opacity = '0';
    
    setTimeout(() => {
        mainImage.src = src;
        mainImage.onload = () => {
            mainImage.style.opacity = '1';
        };
    }, 150);
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail-box').forEach(thumb => {
        thumb.classList.remove('active');
    });
    if (element) {
        element.classList.add('active');
    }
}

// Open image modal
function openImageModal(src) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    if (!modal || !modalImage) return;
    
    modalImage.src = src;
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Close image modal
function closeImageModal(event) {
    if (event.target.classList.contains('image-modal') || 
        event.target.classList.contains('modal-close-btn') ||
        event.target.closest('.modal-close-btn')) {
        const modal = document.getElementById('imageModal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Share product
function shareProduct(url) {
    if (navigator.share) {
        navigator.share({
            title: '{{ $produit->nom }}',
            text: 'Découvrez ce super produit ! 👇',
            url: url
        }).catch(() => {
            fallbackShare(url);
        });
    } else {
        fallbackShare(url);
    }
}

function fallbackShare(url) {
    const message = `Découvrez ce super produit ! 👇\n${url}`;
    window.open(`https://wa.me/?text=${encodeURIComponent(message)}`, '_blank');
}

// Keyboard navigation for modal
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const modal = document.getElementById('imageModal');
        if (modal && modal.classList.contains('active')) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
});
</script>
@endpush

@endsection