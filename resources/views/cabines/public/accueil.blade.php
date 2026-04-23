@extends('layouts.public')
@section('title', $page->nom_site . ' | ' . $page->cabine->nom_cab)

@section('content')
<style>
    /* ══ HERO ══════════════════════════════════════════════════════════════ */
    .hero-wrap { padding: 1.2rem 1.5rem 0; }
    .hero-banner {
        border-radius: 18px; overflow: hidden;
        min-height: 200px; display: flex;
        box-shadow: 0 4px 24px rgba(0,0,0,.07);
    }
    .hero-image-side {
        flex: 0 0 42%;
        background:  url('{{ asset('storage/'.$page->banniere) }}');
        background-repeat : no-repeat;
        background-size : cover;
        background-position : center;
        position: relative; min-height: 200px;
    }
    
    .hero-content {
        flex: 1; padding: 2rem 2.2rem;
        display: flex; flex-direction: column; justify-content: center;
    }
    .hero-label {
        font-size: 10px; letter-spacing: .2em; text-transform: uppercase;
        color: var(--accent); margin-bottom: .5rem;
    }
    .hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem; font-weight: 600; line-height: 1.2; margin-bottom: .6rem;
        color: var(--charcoal);
    }
    .hero-sub { font-size: 12.5px; color: var(--warm-gray); line-height: 1.6; }
    .hero-cta {
        display: inline-flex; align-items: center; gap: .4rem;
        margin-top: 1rem; font-size: 12px; font-weight: 500;
        color: var(--charcoal); text-decoration: none;
        border-bottom: 1px solid var(--charcoal); padding-bottom: 1px;
        width: fit-content; transition: color .2s, border-color .2s;
    }
    .hero-cta:hover { color: var(--accent); border-color: var(--accent); }

    /* ══ SHOP LAYOUT ═══════════════════════════════════════════════════════ */
    .shop-wrapper {
        display: flex; gap: 2rem;
        padding: 2rem 1.5rem 5rem;
        max-width: 1400px; margin: 0 auto;
    }

    /* ══ SIDEBAR DESKTOP ═══════════════════════════════════════════════════ */
    .shop-sidebar {
        flex: 0 0 180px; position: sticky; top: 74px; align-self: flex-start;
    }
    .sidebar-section { margin-bottom: 1.8rem; }
    .store-info h4 {
        font-size: 10px; text-transform: uppercase; letter-spacing: .08em;
        font-weight: 600; margin-bottom: .5rem; color: var(--charcoal);
    }
    .store-info p { font-size: 12px; color: var(--warm-gray); line-height: 1.5; margin-bottom: .7rem; }
    .btn-maps {
        font-size: 11px; color: var(--accent); text-decoration: none;
        display: flex; align-items: center; gap: .4rem; font-weight: 500;
    }
    .btn-maps:hover { color: var(--accent-dark); }
    .sidebar-divider { border: none; border-top: 1px solid var(--border); margin: 1.2rem 0; }

    /* ══ MAIN CONTENT ══════════════════════════════════════════════════════ */
    .shop-main { flex: 1; min-width: 0; }

    .collection-header {
        display: flex; align-items: flex-end; justify-content: space-between;
        margin-bottom: 1.4rem; gap: 1rem; flex-wrap: wrap;
    }
    .breadcrumb-line { font-size: 11px; color: var(--warm-gray); margin-bottom: .3rem; }
    .breadcrumb-line span { color: var(--charcoal); }
    .collection-title {
        font-family: 'Inter', serif;
        font-size: 1.7rem; font-weight: 600; line-height: 1; color: var(--charcoal);
    }
    .sort-bar { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; }
    .result-count { font-size: 12px; color: var(--warm-gray); white-space: nowrap; }
    .btn-filter-mobile {
        background: var(--charcoal); color: #fff; border: none;
        font-size: 11px; letter-spacing: .06em; padding: 7px 16px;
        border-radius: 20px; cursor: pointer; display: none;
        align-items: center; gap: .4rem; transition: background .2s;
    }
    .btn-filter-mobile:hover { background: var(--accent-dark); }

    /* ══ CATEGORIES CHIPS (desktop) ════════════════════════════════════════ */
    .categories-scroll {
        display: flex; gap: .5rem; overflow-x: auto; padding: 0 0 .8rem;
        scrollbar-width: none; margin-bottom: 1.2rem;
    }
    .categories-scroll::-webkit-scrollbar { display: none; }
    .category-chip {
        flex: 0 0 auto; padding: 6px 16px;
        border: 1px solid var(--border); border-radius: 20px;
        background: #fff; color: var(--warm-gray);
        font-size: 12px; font-weight: 500; cursor: pointer;
        transition: all .2s; white-space: nowrap;
        font-family: 'Inter', sans-serif;
    }
    .category-chip:hover, .category-chip.active {
        background: var(--charcoal); color: #fff; border-color: var(--charcoal);
    }

    /* ══ PRODUCT GRID ══════════════════════════════════════════════════════ */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.2rem;
    }
    .product-card {
        background: #faf7f7; border-radius: 12px; overflow: hidden;
        position: relative; cursor: pointer;
        transition: transform .25s, box-shadow .25s;
        animation: fadeUp .5s ease both;
    }
    .product-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,.09); }
    @keyframes fadeUp {
        from { opacity:0; transform:translateY(16px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .product-card:nth-child(1){animation-delay:.05s} .product-card:nth-child(2){animation-delay:.10s}
    .product-card:nth-child(3){animation-delay:.15s} .product-card:nth-child(4){animation-delay:.20s}
    .product-card:nth-child(5){animation-delay:.25s} .product-card:nth-child(6){animation-delay:.30s}
    .product-card:nth-child(7){animation-delay:.35s} .product-card:nth-child(8){animation-delay:.40s}

    .product-image-wrap {
        position: relative; overflow: hidden;
        aspect-ratio: 3/4; background: var(--tag-bg);
    }
    .product-image-wrap img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .45s ease; display: block;
    }
    .product-card:hover .product-image-wrap img { transform: scale(1.06); }

    .price-badge {
        position: absolute; bottom: 10px; left: 10px;
        background: rgba(26,26,26,.85); backdrop-filter: blur(6px);
        color: #fff; font-size: 11px; font-weight: 500;
        padding: 4px 10px; border-radius: 20px; z-index: 2;
    }
    .out-of-stock-overlay {
        position: absolute; inset: 0; background: rgba(26,26,26,.6);
        backdrop-filter: blur(2px); display: flex; align-items: center;
        justify-content: center; color: #fff; font-size: 12px; font-weight: 500;
        letter-spacing: .05em;
    }
    .hover-actions {
        position: absolute; bottom: 10px; right: 10px;
        display: flex; gap: .4rem; opacity: 0; transform: translateY(6px);
        transition: all .25s; z-index: 3;
    }
    .product-card:hover .hover-actions { opacity: 1; transform: translateY(0); }
    .action-btn {
        width: 32px; height: 32px; border-radius: 50%; background: #fff;
        border: none; display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-size: .85rem; color: var(--charcoal);
        box-shadow: 0 2px 8px rgba(0,0,0,.12); transition: all .2s;
    }
    .action-btn:hover { background: var(--charcoal); color: #fff; }

    .product-info { padding: .8rem .9rem .9rem; }
    .product-name {
        font-family: 'Inter', serif;
        font-size: 1rem; font-weight: 600; margin-bottom: .2rem;
        line-height: 1.3; color: var(--charcoal);
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .product-cat {
        font-size: 11px; color: var(--warm-gray); margin-bottom: .6rem;
        display: flex; align-items: center; gap: .3rem;
    }
    .stock-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .stock-dot.in  { background: #10B981; }
    .stock-dot.out { background: #C06B5A; }

    .product-footer {
        display: flex; align-items: center; justify-content: space-between; gap: .4rem;
        padding-top: .6rem; border-top: 1px solid var(--border);
    }
    .product-price { font-size: 13px; font-weight: 500; color: var(--charcoal); }

    .btn-add-cart {
        background: var(--charcoal); color: #fff; border: none;
        border-radius: 20px; padding: 6px 13px; font-size: 11px;
        letter-spacing: .04em; cursor: pointer;
        display: flex; align-items: center; gap: .35rem;
        transition: background .2s; white-space: nowrap;
        font-family: 'DM Sans', sans-serif;
    }
    .btn-add-cart:hover { background: var(--accent-dark); }
    .btn-add-cart:disabled { opacity: .5; cursor: not-allowed; }

    .out-badge {
        font-size: 11px; color: var(--warm-gray);
        display: flex; align-items: center; gap: .3rem;
    }

    /* ══ LOCATION ══════════════════════════════════════════════════════════ */
    .location-section { padding: 3rem 1.5rem 4rem; max-width: 1400px; margin: 0 auto; }

    /* ══ RESPONSIVE ════════════════════════════════════════════════════════ */
    @media (max-width: 1199px) { .product-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 991px) {
        .shop-sidebar { display: none; }
        .btn-filter-mobile { display: flex; }
        .product-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 767px) {
        .hero-banner { min-height: 160px; }
        .hero-image-side { flex: 0 0 36%; }
        .hero-title { font-size: 1.3rem; }
        .hero-sub { display: none; }
        .product-grid { grid-template-columns: repeat(2, 1fr); gap: .9rem; }
        .shop-wrapper { padding: 1.2rem 1rem 4rem; }
        .hero-wrap { padding: 1rem 1rem 0; }
    }
    @media (max-width: 479px) {
        .hero-banner { flex-direction: column; }
        .hero-image-side { flex: 0 0 140px; width: 100%; }
        .hero-image-side::after { background: linear-gradient(to bottom, transparent 55%, #E8E2D8); }
        .hero-content { padding: 1.2rem 1.4rem 1.4rem; }
        .hero-sub { display: block; }
        .product-grid { grid-template-columns: repeat(2, 1fr); gap: .7rem; }
        .product-name { font-size: .9rem; }
        .btn-add-cart { padding: 5px 10px; font-size: 10px; }
    }
</style>

<!-- HERO -->
<div class="hero-wrap p-3">
    <div class="hero-banner">
        <div class="hero-image-side"></div>
        <div class="hero-content">
            <p class="hero-label">— {{ $page->titre }}</p>
            <h1 class="hero-title">{{ $page->sous_titre }}</h1>
            <p class="hero-sub"></p>
            <a href="#productGrid" class="hero-cta">
                Découvrir la collection <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- SHOP WRAPPER -->
<div class="shop-wrapper">

    <!-- Sidebar desktop -->
    <aside class="shop-sidebar">
        <div class="sidebar-section">
            <span class="filter-title">Catégories</span>
            <div class="filter-item active" data-filter="" onclick="filterByCategory('', this)">
                <label>Tous les produits</label>
                <span class="filter-count">{{ $produits->count() }}</span>
            </div>
            @foreach($categories as $cat)
            <div class="filter-item" data-filter="{{ $cat->id }}" onclick="filterByCategory('{{ $cat->id }}', this)">
                <label>{{ $cat->nom }}</label>
                <span class="filter-count">{{ $produits->where('categorie_id', $cat->id)->count() }}</span>
            </div>
            @endforeach
        </div>

        @if($page->latitude && $page->longitude)
        <hr class="sidebar-divider">
        <div class="store-info">
            <h4>Notre boutique</h4>
            @if($page->telephone)
            <p><i class="bi bi-telephone" style="font-size:11px;"></i> {{ $page->telephone }}</p>
            @endif
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $page->latitude }},{{ $page->longitude }}"
               target="_blank" class="btn-maps">
                <i class="bi bi-geo-alt"></i> Voir l'itinéraire
            </a>
        </div>
        @endif
    </aside>

    <!-- Main -->
    <main class="shop-main" id="productGrid">
        <div class="collection-header">
            <div>
                <p class="breadcrumb-line">Accueil › <span>Collection</span></p>
                <h2 class="collection-title">Nos Produits</h2>
            </div>
            <div class="sort-bar">
                <span class="result-count">{{ $produits->count() }} produit(s)</span>
                <button class="btn-filter-mobile" id="filterBtn">
                    <i class="bi bi-sliders"></i> Filtrer
                </button>
            </div>
        </div>

        <!-- Chips catégories (desktop) -->
        <div class="categories-scroll">
            <button class="category-chip active" data-filter="">Tous</button>
            @foreach($categories as $categorie)
            <button class="category-chip" data-filter="{{ $categorie->id }}">
                {{ $categorie->nom }}
            </button>
            @endforeach
        </div>

        @if($produits->count() > 0)
        <div class="product-grid">
            @foreach($produits as $produit)
            <article class="product-card"
                     data-name="{{ strtolower($produit->nom) }}"
                     data-category="{{ $produit->categorie_id }}">

                <a href="{{ route('details.produit', ['code' => $cabine->code, 'id' => $produit->id]) }}"
                   style="text-decoration:none;color:inherit;display:block;">
                    <div class="product-image-wrap">
                        @if($produit->images->last())
                        <img src="{{ asset('storage/' . $produit->images->last()->path) }}"
                             alt="{{ $produit->nom }}" loading="lazy">
                        @else
                        <img src="/image-box.jpeg" alt="Image par défaut" loading="lazy">
                        @endif

                        @if($produit->quantite_stock <= 0)
                        <div class="out-of-stock-overlay">Rupture de stock</div>
                        @endif

                        <div class="price-badge">
                            {{ number_format($produit->prix_vente, 0, ',', ' ') }} FCFA
                        </div>

                        @if($produit->quantite_stock > 0)
                        <div class="hover-actions">
                            <button class="action-btn" title="Voir détails">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @endif
                    </div>

                    <div class="product-info">
                        <div class="product-name">{{ $produit->nom }}</div>
                        <div class="product-cat">
                            <span class="stock-dot {{ $produit->quantite_stock > 0 ? 'in' : 'out' }}"></span>
                            {{ optional($produit->categorie)->nom ?? 'Général' }}
                        </div>
                    </div>
                </a>

                <div style="padding: 0 .9rem .9rem;">
                    <div class="product-footer">
                        <span class="product-price">{{ number_format($produit->prix_vente, 0, ',', ' ') }} FCFA</span>
                        @if($produit->quantite_stock > 0)
                        <button class="btn-add-cart" onclick="addToCart({{ $produit->id }}, 1, this)">
                            <i class="bi bi-bag-plus"></i> Ajouter
                        </button>
                        @else
                        <span class="out-badge"><i class="bi bi-bell"></i> Bientôt dispo</span>
                        @endif
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        @else
        <div style="text-align:center;padding:80px 20px;color:var(--warm-gray);">
            <i class="bi bi-bag" style="font-size:48px;display:block;margin-bottom:16px;opacity:.3;"></i>
            <p style="font-family:'Montserrat',serif;font-size:1.2rem;">Aucun produit disponible</p>
            <p style="font-size:12px;margin-top:8px;">Revenez bientôt pour découvrir nos nouveautés.</p>
        </div>
        @endif
    </main>
</div>

<!-- LOCALISATION -->
@if($page->latitude && $page->longitude)
<div class="location-section">
    <h2 class="section-title" style="margin-bottom:1.2rem;">Notre Localisation</h2>
    <div class="map-container">
        <iframe src="https://www.google.com/maps?q={{ $page->latitude }},{{ $page->longitude }}&hl=fr&z=16&output=embed"
                loading="lazy" allowfullscreen></iframe>
    </div>
    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $page->latitude }},{{ $page->longitude }}"
       target="_blank" class="map-btn">
        <i class="bi bi-geo-alt"></i> Obtenir l'itinéraire
    </a>
</div>
@endif

@push('scripts')
<script>
// Bouton filtre mobile → ouvre le drawer catégories
document.getElementById('filterBtn')?.addEventListener('click', openCatDrawer);
</script>
@endpush
@endsection
