<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Modifier la Vente #{{ $vente->numero_vente }}</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* ----- Layout général ----- */
:root {
  --right-width: 38rem; /* largeur colonne droite fixe */
}
html,body { 
  height:100%; 
  margin:0; 
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; 
}
body { 
  padding-top: 72px; 
}

/* Topbar */
.topbar {
  position: fixed; 
  top:0; 
  left:0; 
  right:0; 
  height:72px;
  background:#000000; 
  color:#fff; 
  z-index:1100;
  display:flex; 
  align-items:center; 
  justify-content:space-between; 
  padding:0.6rem 1rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.topbar a { 
  color: #fff; 
  text-decoration:none; 
  transition: opacity 0.2s;
}
.topbar a:hover { 
  opacity: 0.8; 
}

/* ----- Conteneur à 2 colonnes ----- */
.app-shell {
  display:flex;
  gap:1.25rem;
  align-items:flex-start;
  padding: 1rem;
  box-sizing: border-box;
  height: calc(100vh - 72px);
}

/* Colonne droite fixe (produits) */
.right-column {
  position: fixed;
  top:72px;
  right:0;
  width: var(--right-width);
  bottom:0;
  overflow-y:auto;
  background:#fff;
  padding:1rem;
  box-shadow: -4px 0 18px rgba(12,12,12,0.02);
}

/* Colonne gauche (contenu principal) */
.left-column {
  margin-right: calc(var(--right-width) + 1rem);
  padding: 1rem;
  width: calc(100% - var(--right-width) - 2rem);
  min-width: 0; /* Permet le flex shrink */
}

/* Produits grid */
.product-grid {
  display:grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  gap: .9rem;
}
.product-card {
  border:1px solid #eef1f4; 
  border-radius:10px; 
  overflow:hidden; 
  background:#fff;
  cursor:pointer; 
  display:flex; 
  flex-direction:column; 
  transition: transform .12s, box-shadow .12s;
}
.product-card:hover, .product-card:focus { 
  transform: translateY(-6px); 
  box-shadow: 0 6px 20px rgba(0,0,0,0.06); 
  outline:none; 
}
.product-media { 
  height:110px; 
  display:flex; 
  align-items:center; 
  justify-content:center; 
  background:#fafafa; 
}
.product-media img { 
  width:100%; 
  height:100%; 
  object-fit:cover; 
}
.product-body { 
  padding:.6rem; 
  display:flex; 
  flex-direction:column; 
  gap:.4rem; 
  flex:1; 
}
.product-name { 
  font-size:.95rem; 
  font-weight:600; 
  color:#111827; 
  white-space:nowrap; 
  overflow:hidden; 
  text-overflow:ellipsis; 
}
.product-meta { 
  font-size:.82rem; 
  color:#6c757d; 
  display:flex; 
  justify-content:space-between; 
  align-items:center; 
  gap:.4rem; 
}

/* Résumé commande / table */
.table thead th { 
  border-bottom:1px solid #e9ecef; 
  background-color: #f8f9fa;
}
.table tbody td { 
  vertical-align: middle; 
}
.cart-table { 
  max-height:42vh; 
  overflow:auto; 
}

/* Sticky left panel (client / paiement) */
.left-panel-sticky { 
  position: sticky; 
  top:88px; 
}

/* Helpers */
.badge-stock { 
  font-size:.78rem; 
  padding:.35rem .45rem; 
}
.btn-green { 
  background:#28a745; 
  color:#fff; 
  border:0; 
}
.btn-green:hover { 
  background:#218838; 
  color:#fff; 
}
.btn-yellow {
  background-color: #fbc926;
  color: #000;
  font-weight: 600;
}
.btn-yellow:hover {
  background-color: #e6b422;
}
.small-muted { 
  font-size:.85rem; 
  color:#6c757d; 
}

/* Modal product image placeholder */
.modal-product-img { 
  width:100%; 
  max-height:220px; 
  object-fit:cover; 
  border-radius:8px; 
}

/* Section styling */
.section-title {
  color: #000000;
  border-bottom: 2px solid #fbc926;
  padding-bottom: 0.5rem;
  margin-bottom: 1rem;
}

/* Quantity controls */
.quantity-controls {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.quantity-btn {
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  background-color: #f8f9fa;
  border: 1px solid #dee2e6;
  cursor: pointer;
}
.quantity-btn:hover {
  background-color: #e9ecef;
}

/* Alert toast */
.toast-container {
  z-index: 1200;
}

/* Responsive */
@media (max-width: 1199px) {
  :root { --right-width: 33rem; }
  .right-column { width: var(--right-width); }
  .left-column { margin-right: calc(var(--right-width) + 1rem); }
}
@media (max-width: 900px) {
  /* Sur mobile on empile: right colonne devient en bas; left dessus */
  .right-column { 
    position: static; 
    width:100%; 
    height:auto; 
    box-shadow:none; 
    border-left:none; 
    border-top:1px solid #e9ecef; 
  }
  .left-column { 
    margin-right:0; 
    width:100%; 
  }
  body { 
    padding-top:120px; /* topbar hauteur + espacement */
  }
  .app-shell {
    flex-direction: column;
    height: auto;
  }
}

/* Scrollbar personnalisée */
.commande-scrollable::-webkit-scrollbar {
  width: 6px;
}
.commande-scrollable::-webkit-scrollbar-thumb {
  background-color: #ccc;
  border-radius: 4px;
}

/* Empty states */
.empty-state {
  text-align: center;
  padding: 2rem;
  color: #6c757d;
}
.empty-state i {
  font-size: 3rem;
  margin-bottom: 1rem;
  display: block;
}

.notification-count {
    position: absolute;
    top: -6px;
    right: -6px;
    background:rgb(197, 23, 0);
    color: white;
    font-size: 10px;
    font-weight: bold;
    border-radius: 50%;
    padding: 2px 5px;
    min-width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 3px rgba(0,0,0,0.3);
    transform-origin: center;
}

</style>
</head>
<body>

<!-- Topbar -->
<div class="topbar">
  <div class="d-flex align-items-center gap-3">
    <img src="/wimo.png" alt="logo" height="36">
    <div>
      <div class="fw-bold"><a href="/ventes"><h2>{{ Auth::user()->cabine->nom_cab }}</h2></a></div>
    </div>
    
    <nav class="d-none d-md-flex ms-3 gap-3">
      <a href="/produits" class="small-muted"> <i class="bi bi-box-seam me-2"></i> MES PRODUITS</a>/
      <a href="/details_inventaire" class="small-muted">  <i class="bi bi-bar-chart me-2"></i>STATISTIQUES</a>/
       <a href="/Ma_boutique" class="nav-link">
                        <i class="bi bi-shop"></i>
                        <span>MA BOUTIQUE</span>
                    </a>
    </nav>
  </div>

  <div class="d-flex align-items-center gap-2">
    <a href="{{ route('ventes.show', $vente) }}" class="btn btn-sm btn-outline-light" title="Retour">
      <i class="bi bi-arrow-left"></i>
    </a>
  </div>
</div>

<!-- Shell -->
<div class="app-shell">

  <!-- LEFT: formulaire + résumé -->
  <main class="left-column">
    <div class="row g-3">
      <div class="col-12 col-lg-8">
        <!-- Récapitulatif principal -->
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="section-title">
              <i class="bi bi-receipt me-2"></i>Récapitulatif de commande
              <span class="badge bg-success ms-2" id="items-count">{{ $vente->lignes->sum('quantite') }}</span>
            </h5>

            <div class="cart-table mb-3">
              <table class="table table-sm align-middle">
                <thead class="table-dark">
                  <tr>
                    <th>Article</th>
                    <th style="width:110px">Qté</th>
                    <th style="width:140px">PU</th>
                    <th style="width:140px">Total</th>
                    <th style="width:60px"></th>
                  </tr>
                </thead>
                <tbody id="produits-list">
                  <!-- Rempli par JavaScript -->
                </tbody>
              </table>
            </div>

            <div class="total-display bg-light rounded p-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-semibold">Sous-total:</span>
                <span id="total-vente" class="fw-bold">{{ number_format($vente->montant_total) }} FCFA</span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Montant à payer:</span>
                <span id="montant-a-payer" class="fw-bold fs-5">{{ number_format($vente->montant_total) }} FCFA</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Client + paiement -->
        <div class="card left-panel-sticky border-0">
          <div class="card-body">
            <h5 class="section-title">
              <i class="bi bi-people me-2"></i>Informations client
            </h5>
            <form id="vente-form" method="POST" action="{{ route('ventes.update', $vente) }}">
              @csrf
              @method('PUT')

              <!-- champ caché pour serialiser les lignes avant envoi -->
              <input type="hidden" id="lignes-input" name="lignes" value="">

              <div class="row g-3">
                <div class="col-md-4">
                  <label for="type_client" class="form-label fw-semibold">Type de client <span class="text-danger">*</span></label>
                  <select id="type_client" name="type_client" class="form-select" required>
                    <option value="particulier" {{ old('type_client', $vente->type_client) == 'particulier' ? 'selected' : '' }}>Particulier</option>
                    <option value="professionnel" {{ old('type_client', $vente->type_client) == 'professionnel' ? 'selected' : '' }}>Professionnel</option>
                    <option value="divers" {{ old('type_client', $vente->type_client) == 'divers' ? 'selected' : '' }}>Divers</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="nom_client" class="form-label fw-semibold">Nom du client</label>
                  <input id="nom_client" name="nom_client" type="text" class="form-control" 
                         value="{{ old('nom_client', $vente->nom_client) }}" placeholder="Nom client">
                </div>
                <div class="col-md-4">
                  <label for="contact_client" class="form-label fw-semibold">Contact</label>
                  <input id="contact_client" name="contact_client" type="text" class="form-control" 
                         value="{{ old('contact_client', $vente->contact_client) }}" placeholder="Téléphone ou email">
                </div>
              </div>

              <hr/>

              <h5 class="section-title">
                <i class="bi bi-credit-card me-2"></i>Informations de paiement
              </h5>
              <div class="row g-3 align-items-end">
                <div class="col-md-6">
                  <label for="mode_paiement" class="form-label fw-semibold">Mode de paiement <span class="text-danger">*</span></label>
                  <select id="mode_paiement" name="mode_paiement" class="form-select" required>
                    <option value="especes" {{ old('mode_paiement', $vente->mode_paiement) == 'especes' ? 'selected' : '' }}>Espèces</option>
                    <option value="carte" {{ old('mode_paiement', $vente->mode_paiement) == 'carte' ? 'selected' : '' }}>Carte</option>
                    <option value="mobile" {{ old('mode_paiement', $vente->mode_paiement) == 'mobile' ? 'selected' : '' }}>Paiement mobile</option>
                    <option value="virement" {{ old('mode_paiement', $vente->mode_paiement) == 'virement' ? 'selected' : '' }}>Virement</option>
                    <option value="autre" {{ old('mode_paiement', $vente->mode_paiement) == 'autre' ? 'selected' : '' }}>Autre</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="montant_regle" class="form-label fw-semibold">Montant réglé <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text">FCFA</span>
                    <input id="montant_regle" name="montant_regle" type="number" step="0.01" class="form-control" 
                           value="{{ old('montant_regle', $vente->montant_regle) }}" required>
                  </div>
                  <div class="form-text text-end">
                    Reste à payer: <span id="reste-a-payer" class="fw-semibold">0 FCFA</span>
                  </div>
                </div>
              </div>

              <div class="mt-3">
                <label for="remarques" class="form-label fw-semibold">Remarques</label>
                <textarea id="remarques" name="remarques" rows="2" class="form-control" 
                          placeholder="Notes supplémentaires...">{{ old('remarques', $vente->remarques) }}</textarea>
              </div>

              <div class="d-flex gap-2 mt-4">
                <a href="{{ route('ventes.show', $vente) }}" class="btn btn-outline-secondary flex-fill">
                  <i class="bi bi-x-circle me-1"></i>Annuler
                </a>
                <button id="submit-btn" type="submit" class="btn btn-yellow flex-fill">
                  <i class="bi bi-check-circle me-1"></i>Enregistrer les modifications
                </button>
              </div>
            </form>
          </div>
        </div>

      </div>

      <!-- Colonne latérale droite (résumé rapide) -->
      <div class="col-12 col-lg-4">
        <div class="card border-0 " style="background-color: #000000; color: #fff;">
          <div class="card-body">
            <h6 class="fw-bold"><i class="bi bi-receipt me-2"></i>Résumé rapide</h6>
            <div class="mb-2 small-muted text-white">Articles: <span id="items-count-2">{{ $vente->lignes->sum('quantite') }}</span></div>
            <div class="fw-semibold fs-4 text-white" id="total-vente-side">{{ number_format($vente->montant_total) }} FCFA</div>
            <div class="mt-2 small text-white">
              <i class="bi bi-info-circle me-1"></i>
              Montant total de la vente
            </div>
          </div>
        </div>
        
        <!-- Aide rapide -->
        <div class="card mt-3 border-0" style="background-color: #fad541ff; color: #000000;">
          <div class="card-body">
            <h6 class="fw-bold"><i class="bi bi-lightbulb me-2"></i>Raccourcis</h6>
            <div class="small text-muted">
              <div><kbd>/</kbd> Rechercher produit</div>
              <div><kbd>+</kbd>/<kbd>-</kbd> Modifier quantité</div>
              <div><kbd>Entrée</kbd> Ajouter produit</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- RIGHT: produits (fixe) -->
  <aside class="right-column" aria-label="Liste des produits">
    <div class="d-flex align-items-center mb-3 gap-2">
      <div class="position-relative flex-grow-1">
        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
        <input id="search-produits" type="search" class="form-control ps-5" placeholder="Rechercher un produit, marque..." aria-label="Recherche produit" />
      </div>
      <button id="clear-search" class="btn btn-outline-secondary" title="Effacer la recherche"><i class="bi bi-x-lg"></i></button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="mb-0">Produits disponibles</h5>
      <span class="badge bg-light text-dark" id="products-count">{{ count($produits) }} produits</span>
    </div>

    <div id="search-results" class="product-grid" aria-live="polite"></div>

    <div class="mt-3 small-muted text-center">
      <i class="bi bi-mouse me-1"></i>Cliquez sur un produit pour l'ajouter au panier
    </div>
  </aside>

</div>

<!-- Modal produit -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white" hidden>
        <h5 class="modal-title fw-bold" id="modalProductTitle">Produit</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div class="text-center mb-3">
          <img id="modalProductImage" src="" alt="image produit" class="modal-product-img d-none" />
          <div id="modalImagePlaceholder" class="d-flex align-items-center justify-content-center bg-light rounded py-4">
            <i class="bi bi-box-seam text-secondary" style="font-size:2.5rem;"></i>
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-6">
            <p class="mb-1"><strong>Marque:</strong> <span id="modalProductMarque">—</span></p>
          </div>
          <div class="col-6">
            <p class="mb-1"><strong>Référence:</strong> <span id="modalProductReference">—</span></p>
          </div>
        </div>
        
        <div class="alert alert-light mb-3"hidden>
          <p class="mb-0"><strong>Stock disponible:</strong> <span id="modalProductStock"></span></p>
        </div>

        <div class="row g-3">
          <div class="col-6">
            <label class="form-label fw-semibold">Prix unitaire (FCFA)</label>
            <input id="prix-selection" type="number" class="form-control" min="0.01" step="0.01" readonly>
          </div>
          <div class="col-6">
            <label class="form-label fw-semibold">Quantité</label>
            <div class="quantity-controls">
              <button id="qty-decrease" type="button" class="quantity-btn">−</button>
              <input id="quantite-selection" type="number" class="form-control text-center" min="1" value="1" style="max-width: 80px;">
              <button id="qty-increase" type="button" class="quantity-btn">+</button>
            </div>
          </div>
        </div>
        
        <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded mt-2">
          <span class="fw-semibold">Sous-total:</span>
          <span id="modal-subtotal" class="fw-bold">0 FCFA</span>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
        <button id="btn-ajouter-produit" class="btn btn-green">
          <i class="bi bi-plus-circle me-2"></i>Ajouter au panier
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* ===========================
   Données fournies par Blade
   =========================== */
let allProducts = @json($produits);
let existingLignes = [
@foreach($vente->lignes as $ligne)
    {
        id: {{ $ligne->id }},
        produit_id: {{ $ligne->produit_id }},
        produit_text: @json($ligne->produit->nom ?? ''),
        quantite: {{ $ligne->quantite }},
        prix_unitaire: {{ $ligne->prix_unitaire }},
        sous_total: {{ $ligne->sous_total }}
    }@if(!$loop->last),@endif
@endforeach
];

// État local
let productsState = allProducts.map(p => ({ ...p }));
let produitsVente = existingLignes.map(l => ({ ...l }));
let nextId = produitsVente.length > 0 ? Math.max(...produitsVente.map(l => l.id || 0)) + 1 : 1;
let selectedProduct = null;

/* DOM */
const searchInput = document.getElementById('search-produits');
const clearSearchBtn = document.getElementById('clear-search');
const searchResults = document.getElementById('search-results');
const produitsListTbody = document.getElementById('produits-list');
const lignesInput = document.getElementById('lignes-input');
const totalCell = document.getElementById('total-vente');
const totalCellSide = document.getElementById('total-vente-side');
const montantAPayer = document.getElementById('montant-a-payer');
const itemsCount = document.getElementById('items-count');
const itemsCount2 = document.getElementById('items-count-2');
const productsCount = document.getElementById('products-count');
const montantRegleInput = document.getElementById('montant_regle');
const resteAPayerSpan = document.getElementById('reste-a-payer');
const submitBtn = document.getElementById('submit-btn');
const productModalEl = document.getElementById('productModal');
const productModal = new bootstrap.Modal(productModalEl);
const modalTitle = document.getElementById('modalProductTitle');
const modalImage = document.getElementById('modalProductImage');
const modalImagePlaceholder = document.getElementById('modalImagePlaceholder');
const modalMarque = document.getElementById('modalProductMarque');
const modalReference = document.getElementById('modalProductReference');
const modalStock = document.getElementById('modalProductStock');
const prixSelection = document.getElementById('prix-selection');
const quantiteSelection = document.getElementById('quantite-selection');
const modalSubtotal = document.getElementById('modal-subtotal');
const btnAjouterProduit = document.getElementById('btn-ajouter-produit');
const qtyIncreaseBtn = document.getElementById('qty-increase');
const qtyDecreaseBtn = document.getElementById('qty-decrease');

/* -----------------------
   Helpers
   ----------------------- */
function formatPrice(n) {
  if (!Number.isFinite(n)) n = Number(n) || 0;
  return new Intl.NumberFormat('fr-FR').format(n);
}
function escapeHtml(s) {
  if (s === null || s === undefined) return '';
  return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}
function flashToast(msg, type='info', duration=2200) {
  const id = 't' + Date.now();
  const to = document.createElement('div');
  to.className = `toast align-items-center text-bg-${type} border-0 position-fixed top-0 end-0 m-3`;
  to.style.zIndex = 1200;
  to.id = id;
  to.innerHTML = `<div class="d-flex"><div class="toast-body small">${escapeHtml(msg)}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
  document.body.appendChild(to);
  const instance = new bootstrap.Toast(to);
  instance.show();
  setTimeout(() => { try{ instance.hide(); }catch(e){} setTimeout(()=>to.remove(),300); }, duration);
}

/* -----------------------
   Recherche / affichage produits
   ----------------------- */
let searchTimeout = null;
function filterProducts(q) {
  q = (q||'').trim().toLowerCase();
  if (!q) return productsState.slice();
  return productsState.filter(p => 
    (p.nom||'').toLowerCase().includes(q) || 
    (p.marque||'').toLowerCase().includes(q) || 
    (p.reference||'').toLowerCase().includes(q) ||
    String(p.id) === q
  );
}

function renderSearchResults(list) {
  if (!list || list.length === 0) {
    searchResults.innerHTML = `
      <div class="empty-state w-100">
        <i class="bi bi-search"></i>
        <p class="mb-0">Aucun produit trouvé</p>
        <small class="text-muted">Essayez de modifier vos critères de recherche</small>
      </div>
    `;
    return;
  }
  
  searchResults.innerHTML = list.map(p => {
    const imageHtml = p.image ? 
      `<img src="/storage/${p.image}" alt="${escapeHtml(p.nom)}" style="width:100%;height:100%;object-fit:cover;">` : 
      `<div class="d-flex align-items-center justify-content-center" style="height:110px;width:100%"><i class="bi bi-box-seam text-secondary" style="font-size:1.8rem"></i></div>`;
    
    const stockBadge = p.quantite_stock > 10 ? 
      `<span class="badge bg-success badge-stock">En stock</span>` : 
      p.quantite_stock > 0 ? 
      `<span class="badge bg-warning text-dark badge-stock">${p.quantite_stock}</span>` : 
      `<span class="badge bg-danger badge-stock">Rupture</span>`;
    
    return `
      <div class="product-card" role="button" tabindex="0" data-id="${p.id}">
        <div class="product-media">${imageHtml}</div>
        <div class="product-body">
          <div class="product-name">${escapeHtml(p.nom)}</div>
          <div class="product-meta">
            <div class="text-muted small">${escapeHtml(p.marque||'—')}</div>
            <div class="d-flex align-items-center gap-2">
              <div class="product-price fw-bold">${formatPrice(p.prix_vente)} FCFA</div>
              ${stockBadge}
            </div>
          </div>
        </div>
      </div>
    `;
  }).join('');
}

function updateProductsCount(count) {
  productsCount.textContent = `${count} produit${count !== 1 ? 's' : ''}`;
}

/* Events search */
searchInput.addEventListener('input', e => {
  const q = e.target.value;
  if (searchTimeout) clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    const filtered = filterProducts(q);
    renderSearchResults(filtered);
    updateProductsCount(filtered.length);
  }, 160);
});

clearSearchBtn.addEventListener('click', () => { 
  searchInput.value=''; 
  renderSearchResults(productsState); 
  updateProductsCount(productsState.length);
  searchInput.focus(); 
});

document.addEventListener('keydown', e => { 
  if (e.key === '/' && !['INPUT','TEXTAREA'].includes(document.activeElement.tagName)) { 
    e.preventDefault(); 
    searchInput.focus(); 
    searchInput.select(); 
  } 
});

/* Delegated click on product cards */
searchResults.addEventListener('click', ev => {
  let node = ev.target;
  while (node && !node.classList.contains('product-card')) node = node.parentElement;
  if (!node) return;
  const id = parseInt(node.getAttribute('data-id'));
  openProductModal(id);
});

searchResults.addEventListener('keydown', ev => {
  if (ev.key === 'Enter') {
    let node = ev.target;
    while (node && !node.classList.contains('product-card')) node = node.parentElement;
    if (node) { 
      const id = parseInt(node.getAttribute('data-id')); 
      openProductModal(id); 
    }
  }
});

/* -----------------------
   Modal produit
   ----------------------- */
function openProductModal(productId) {
  selectedProduct = productsState.find(p => p.id === productId);
  if (!selectedProduct) return;
  
  modalTitle.textContent = selectedProduct.nom;
  modalMarque.textContent = selectedProduct.marque || '—';
  modalReference.textContent = selectedProduct.reference || '—';
  modalStock.textContent = selectedProduct.quantite_stock;
  prixSelection.value = selectedProduct.prix_vente;
  quantiteSelection.value = 1;
  quantiteSelection.max = Math.max(1, selectedProduct.quantite_stock);

  if (selectedProduct.image) {
    modalImage.src = `/storage/${selectedProduct.image}`;
    modalImage.classList.remove('d-none');
    modalImagePlaceholder.classList.add('d-none');
  } else {
    modalImage.classList.add('d-none');
    modalImagePlaceholder.classList.remove('d-none');
  }

  updateModalSubtotal();
  productModal.show();
  setTimeout(() => quantiteSelection.focus(), 140);
}

function updateModalSubtotal() {
  const qte = parseInt(quantiteSelection.value) || 0;
  const prix = parseFloat(prixSelection.value) || 0;
  const subtotal = qte * prix;
  modalSubtotal.textContent = formatPrice(subtotal) + ' FCFA';
}

qtyIncreaseBtn.addEventListener('click', () => {
  let v = parseInt(quantiteSelection.value || 0); 
  v++;
  if (selectedProduct && v > selectedProduct.quantite_stock) { 
    v = selectedProduct.quantite_stock; 
    flashToast('Quantité limitée par le stock disponible','warning'); 
  }
  quantiteSelection.value = v;
  updateModalSubtotal();
});

qtyDecreaseBtn.addEventListener('click', () => {
  let v = parseInt(quantiteSelection.value || 0); 
  v = Math.max(1, v-1); 
  quantiteSelection.value = v;
  updateModalSubtotal();
});

prixSelection.addEventListener('input', updateModalSubtotal);
quantiteSelection.addEventListener('input', updateModalSubtotal);

/* Ajouter produit */
btnAjouterProduit.addEventListener('click', () => {
  if (!selectedProduct) return;
  const qte = Math.max(0, parseInt(quantiteSelection.value || 0));
  const prix = parseFloat(prixSelection.value || 0);
  
  if (qte <= 0 || prix <= 0) { 
    flashToast('Quantité ou prix invalide','danger'); 
    return; 
  }
  
  if (qte > selectedProduct.quantite_stock) { 
    flashToast('Stock insuffisant','danger'); 
    return; 
  }

  // si même produit + même prix existe -> augmenter
  const exist = produitsVente.find(l => l.produit_id === selectedProduct.id && l.prix_unitaire === prix);
  if (exist) {
    if (exist.quantite + qte > selectedProduct.quantite_stock) { 
      flashToast('La quantité totale dépasse le stock','warning'); 
      return; 
    }
    exist.quantite += qte;
    exist.sous_total = exist.quantite * exist.prix_unitaire;
  } else {
    produitsVente.push({
      id: null, // Nouvelle ligne, pas d'ID
      produit_id: selectedProduct.id,
      produit_text: selectedProduct.nom,
      quantite: qte,
      prix_unitaire: prix,
      sous_total: qte * prix
    });
  }

  // mettre à jour stock visuel
  const ps = productsState.find(p => p.id === selectedProduct.id);
  if (ps) ps.quantite_stock = Math.max(0, ps.quantite_stock - qte);

  updateCartDisplay();
  calculateTotal();
  // ❌ Manquant : mise à jour du champ lignes
  updateLignesInput(); // À ajouter !
  
  productModal.hide();
});

// Ajouter cette fonction
function updateLignesInput() {
  lignesInput.value = JSON.stringify(produitsVente);
}

// Et avant la soumission du formulaire
document.getElementById('vente-form').addEventListener('submit', (e) => {
  updateLignesInput(); // ✅ Mettre à jour juste avant submit
});

/* -----------------------
   Cart display / interactions
   ----------------------- */
function updateCartDisplay() {
  if (!produitsVente.length) {
    produitsListTbody.innerHTML = `
      <tr>
        <td colspan="5" class="text-center text-muted py-4">
          <i class="bi bi-cart-x d-block mb-2" style="font-size: 2rem;"></i>
          Aucun produit sélectionné
        </td>
      </tr>
    `;
    itemsCount.textContent = '0';
    itemsCount2.textContent = '0';
  } else {
    produitsListTbody.innerHTML = produitsVente.map((l, idx) => `
      <tr data-ligne-id="${l.id || 'new-' + idx}" data-produit-id="${l.produit_id}">
        <td class="align-middle">${escapeHtml(l.produit_text)}</td>
        <td class="align-middle">
          <div class="quantity-controls">
            <button class="quantity-btn" type="button" onclick="changeQty(${idx}, -1)">−</button>
            <span type="number" class="form-control text-center" style="max-width:60px" 
                   value="${l.quantite}" min="1" 
                   onchange="setQty(${idx}, this.value)">${l.quantite}</span>
            <button class="quantity-btn" type="button" onclick="changeQty(${idx}, 1)">+</button>
          </div>
        </td>
        <td class="text-end align-middle">${formatPrice(l.prix_unitaire)} FCFA</td>
        <td class="text-end align-middle fw-semibold">${formatPrice(l.sous_total)} FCFA</td>
        <td class="align-middle">
          <button class="btn btn-sm btn-outline-danger" type="button" onclick="removeLine(${idx})" title="Supprimer">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>
    `).join('');
    
    const totalItems = produitsVente.reduce((s,x) => s + x.quantite, 0);
    itemsCount.textContent = totalItems;
    itemsCount2.textContent = totalItems;
  }
  
  // Mettre à jour le champ caché avec les lignes formatées pour le formulaire
  const lignesFormatted = produitsVente.map((l, idx) => ({
    id: l.id || null,
    produit_id: l.produit_id,
    quantite: l.quantite,
    prix_unitaire: l.prix_unitaire
  }));
  lignesInput.value = JSON.stringify(lignesFormatted);
  
  renderSearchResults(filterProducts(searchInput.value)); // update badges stock
  updateProductsCount(filterProducts(searchInput.value).length);
}

/* Change qty helpers */
function changeQty(index, delta) {
  const line = produitsVente[index]; 
  if (!line) return;
  
  const prod = productsState.find(p => p.id === line.produit_id);
  // Pour l'édition, on doit tenir compte du stock actuel + la quantité déjà dans la ligne
  const stockActuel = prod ? prod.quantite_stock : 0;
  const quantiteActuelle = line.quantite;
  const disponible = stockActuel + quantiteActuelle; // Stock disponible + quantité déjà vendue
  
  let newQty = Math.max(1, line.quantite + delta);
  
  if (newQty > disponible) { 
    flashToast('Quantité limitée par le stock disponible','warning'); 
    newQty = disponible; 
  }
  
  line.quantite = newQty;
  line.sous_total = line.quantite * line.prix_unitaire;
  
  if (prod) {
    // Ajuster le stock visuel
    prod.quantite_stock = Math.max(0, disponible - newQty);
  }
  
  updateCartDisplay();
  calculateTotal();
}

function setQty(index, value) {
  let v = parseInt(value || 0); 
  if (isNaN(v) || v < 1) v = 1;
  
  const line = produitsVente[index]; 
  if (!line) return;
  
  const prod = productsState.find(p => p.id === line.produit_id);
  const stockActuel = prod ? prod.quantite_stock : 0;
  const quantiteActuelle = line.quantite;
  const disponible = stockActuel + quantiteActuelle;
  
  if (v > disponible) { 
    flashToast('Quantité limitée par le stock disponible','warning'); 
    v = disponible; 
  }
  
  line.quantite = v; 
  line.sous_total = line.quantite * line.prix_unitaire;
  
  if (prod) {
    prod.quantite_stock = Math.max(0, disponible - v);
  }
  
  updateCartDisplay(); 
  calculateTotal();
}

function removeLine(index) {
  const line = produitsVente[index]; 
  if (!line) return;
  
  // Remettre le stock visuel si nécessaire
  const ps = productsState.find(p => p.id === line.produit_id); 
  if (ps) ps.quantite_stock += line.quantite;
  
  produitsVente.splice(index, 1);
  updateCartDisplay(); 
  calculateTotal();
  flashToast('Produit retiré du panier', 'info');
}

/* -----------------------
   Totaux & paiement
   ----------------------- */
let userModifiedMontantRegle = false; // Flag pour savoir si l'utilisateur a modifié manuellement

function calculateTotal() {
  const total = produitsVente.reduce((s,l) => s + (l.sous_total || 0), 0);
  
  totalCell.textContent = formatPrice(total) + ' FCFA';
  totalCellSide.textContent = formatPrice(total) + ' FCFA';
  montantAPayer.textContent = formatPrice(total) + ' FCFA';
  
  // Pré-remplir automatiquement le montant réglé avec le total
  // Sauf si l'utilisateur l'a modifié manuellement
  if (!userModifiedMontantRegle) {
    montantRegleInput.value = total.toFixed(2);
  }
  
  const paid = parseFloat(montantRegleInput.value || 0);
  const reste = Math.max(0, total - paid);
  
  resteAPayerSpan.textContent = formatPrice(reste) + ' FCFA';
  
  if (reste < 0) {
    resteAPayerSpan.className = 'fw-semibold text-success';
  } else if (reste > 0) {
    resteAPayerSpan.className = 'fw-semibold text-danger';
  } else {
    resteAPayerSpan.className = 'fw-semibold';
  }
}

// Détecter si l'utilisateur modifie manuellement le montant réglé
montantRegleInput.addEventListener('focus', () => {
  userModifiedMontantRegle = true;
});

montantRegleInput.addEventListener('input', () => {
  userModifiedMontantRegle = true;
  calculateTotal();
});

/* -----------------------
   Form submit validation (UNIQUE EVENT LISTENER)
   ----------------------- */
document.getElementById('vente-form').addEventListener('submit', function(ev) {
  // ✅ Valider que au moins un produit existe
  if (produitsVente.length === 0) { 
    ev.preventDefault(); 
    flashToast('Ajoutez au moins un produit','danger'); 
    return; 
  }
  
  // ✅ Valider les champs obligatoires
  if (!document.getElementById('type_client').value) {
    ev.preventDefault();
    flashToast('Sélectionnez un type de client', 'danger');
    return;
  }
  
  if (!document.getElementById('mode_paiement').value) {
    ev.preventDefault();
    flashToast('Sélectionnez un mode de paiement', 'danger');
    return;
  }
  
  // ✅ Valider le montant réglé
  const total = produitsVente.reduce((s,l) => s + l.sous_total, 0);
  const paid = parseFloat(montantRegleInput.value || 0);
  
  if (isNaN(paid)) { 
    ev.preventDefault(); 
    flashToast('Entrez le montant réglé','danger'); 
    montantRegleInput.focus(); 
    return; 
  }
  
  // ✅ Mettre à jour le champ lignes juste avant la soumission
  updateLignesInput();
  
  // ✅ Afficher un indicateur de chargement
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Enregistrement...';
});

/* -----------------------
   Initialisation
   ----------------------- */
document.addEventListener('DOMContentLoaded', () => {
  renderSearchResults(productsState);
  updateProductsCount(productsState.length);
  updateCartDisplay();
  calculateTotal(); // Cela pré-remplira le montant réglé avec le total initial
  searchInput.focus();
});

/* -----------------------
   Utility: open product modal from external
   ----------------------- */
function openProductModalById(id) { openProductModal(id); }

/* -----------------------
   Small UX details
   ----------------------- */
productModalEl.addEventListener('hidden.bs.modal', () => {
  selectedProduct = null;
});

/* -----------------------
   Expose some functions to global scope for inline handlers
   ----------------------- */
window.changeQty = changeQty;
window.setQty = setQty;
window.removeLine = removeLine;
window.supprimerProduit = removeLine;
window.selectProduct = (id) => openProductModal(id);

</script>

</body>
</html>
