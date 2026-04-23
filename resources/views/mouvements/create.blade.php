<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Nouveau mouvement de stock</title>

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
  min-width: 0;
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

.badge-stock { 
  font-size:.78rem; 
  padding:.35rem .45rem; 
}

/* Responsive */
@media (max-width: 1199px) {
  :root { --right-width: 33rem; }
  .right-column { width: var(--right-width); }
  .left-column { margin-right: calc(var(--right-width) + 1rem); }
}
@media (max-width: 900px) {
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
    padding-top:120px;
  }
  .app-shell {
    flex-direction: column;
    height: auto;
  }
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

/* Type mouvement badges */
.type-badge-entree {
  background-color: #28a745;
  color: white;
}
.type-badge-sortie {
  background-color: #dc3545;
  color: white;
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
      <a href="/mouvements" class="small-muted">  <i class="bi bi-arrow-left-right me-2"></i>MOUVEMENTS</a>
    </nav>
  </div>

  <div class="d-flex align-items-center gap-2">
    <small class="text-white-50">Raccourci: /</small>
  </div>
</div>

<!-- Shell -->
<div class="app-shell">

  <!-- LEFT: formulaire -->
  <main class="left-column">
    <div class="card border-0 shadow-sm mb-3">
      <div class="card-body">
        <h5 class="section-title">
          <i class="bi bi-arrow-left-right me-2"></i>Nouveau mouvement de stock
        </h5>

        <form id="mouvement-form" method="POST" action="{{ route('mouvements.store') }}">
          @csrf
          
          <!-- Informations mouvement -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="type" class="form-label fw-semibold">Type de mouvement <span class="text-danger">*</span></label>
              <select id="type" name="type" class="form-select" required>
                <option value="entree" {{ old('type') == 'entree' ? 'selected' : '' }}>Entrée de stock</option>
                <option value="sortie" {{ old('type') == 'sortie' ? 'selected' : '' }}>Sortie de stock</option>
              </select>
              @error('type')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="produit_id" class="form-label fw-semibold">Produit sélectionné <span class="text-danger">*</span></label>
              <input type="hidden" id="produit_id" name="produit_id" required>
              <div id="produit-selected" class="form-control bg-light" style="display: flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-box-seam text-muted"></i>
                <span class="text-muted">Aucun produit sélectionné</span>
              </div>
              @error('produit_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="quantite" class="form-label fw-semibold">Quantité <span class="text-danger">*</span></label>
              <div class="quantity-controls">
                <button type="button" class="quantity-btn" id="qty-decrease-form">−</button>
                <input type="number" id="quantite" name="quantite" value="{{ old('quantite', 1) }}"
                    class="form-control text-center" required min="1" style="max-width: 100px;">
                <button type="button" class="quantity-btn" id="qty-increase-form">+</button>
              </div>
              @error('quantite')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
              <div id="stock-info" class="form-text mt-2">
                <i class="bi bi-info-circle"></i> Stock actuel: <span id="stock-actuel" class="fw-semibold">0</span>
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Résumé</label>
              <div class="card bg-light p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span>Type:</span>
                  <span id="type-badge" class="badge">—</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <span>Stock après:</span>
                  <span id="stock-apres" class="fw-bold">—</span>
                </div>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="remarque" class="form-label fw-semibold">Remarque</label>
            <textarea id="remarque" name="remarque" rows="3" class="form-control" 
                placeholder="Motif du mouvement (optionnel)...">{{ old('remarque') }}</textarea>
            @error('remarque')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            <strong>Information:</strong> Les mouvements de stock affectent directement la quantité disponible des produits.
          </div>

          <div class="d-flex gap-2 mt-4">
            <a href="{{ route('mouvements.index') }}" class="btn btn-outline-secondary flex-fill">
              <i class="bi bi-x-circle me-1"></i>Annuler
            </a>
            <button id="submit-btn" type="submit" class="btn btn-yellow flex-fill" disabled>
              <i class="bi bi-check-circle me-1"></i>Enregistrer le mouvement
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <!-- RIGHT: produits (fixe) -->
  <aside class="right-column" aria-label="Liste des produits">
    <div class="d-flex align-items-center mb-3 gap-2">
      <div class="position-relative flex-grow-1">
        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
        <input id="search-produits" type="search" class="form-control ps-5" placeholder="Rechercher un produit..." aria-label="Recherche produit" />
      </div>
      <button id="clear-search" class="btn btn-outline-secondary" title="Effacer la recherche"><i class="bi bi-x-lg"></i></button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="mb-0">Produits disponibles</h5>
      <span class="badge bg-light text-dark" id="products-count">{{ count($produits) }} produits</span>
    </div>

    <div id="search-results" class="product-grid" aria-live="polite"></div>

    <div class="mt-3 small-muted text-center">
      <i class="bi bi-mouse me-1"></i>Cliquez sur un produit pour le sélectionner
    </div>
  </aside>

</div>

<!-- Modal produit -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalProductTitle">Sélectionner un produit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
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
        
        <div class="alert alert-light mb-3">
          <p class="mb-0"><strong>Stock disponible:</strong> <span id="modalProductStock" class="fw-bold"></span></p>
        </div>

        <div class="row g-3">
          <div class="col-12">
            <label class="form-label fw-semibold">Type de mouvement <span class="text-danger">*</span></label>
            <select id="modal-type" class="form-select">
              <option value="entree">Entrée de stock</option>
              <option value="sortie">Sortie de stock</option>
            </select>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Quantité <span class="text-danger">*</span></label>
            <div class="quantity-controls">
              <button id="qty-decrease" type="button" class="quantity-btn">−</button>
              <input id="quantite-selection" type="number" class="form-control text-center" min="1" value="1" style="max-width: 80px;">
              <button id="qty-increase" type="button" class="quantity-btn">+</button>
            </div>
            <div class="form-text mt-2">
              <span id="modal-stock-info"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
        <button id="btn-confirmer-selection" class="btn btn-yellow">
          <i class="bi bi-check-circle me-2"></i>Confirmer la sélection
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
@php
    $productsData = $produits->map(function($p) {
        $image = $p->images->first() ? 'storage/' . $p->images->first()->path : null;
        return [
            'id' => $p->id,
            'nom' => $p->nom,
            'marque' => $p->marque ?? '',
            'reference' => $p->reference ?? '',
            'quantite_stock' => $p->quantite_stock,
            'prix_vente' => $p->prix_vente,
            'image' => $image
        ];
    })->values();
@endphp

let allProducts = @json($productsData);

// État local
let productsState = allProducts.map(p => ({ ...p }));
let selectedProduct = null;

/* DOM */
const searchInput = document.getElementById('search-produits');
const clearSearchBtn = document.getElementById('clear-search');
const searchResults = document.getElementById('search-results');
const productModalEl = document.getElementById('productModal');
const productModal = new bootstrap.Modal(productModalEl);
const modalTitle = document.getElementById('modalProductTitle');
const modalImage = document.getElementById('modalProductImage');
const modalImagePlaceholder = document.getElementById('modalImagePlaceholder');
const modalMarque = document.getElementById('modalProductMarque');
const modalReference = document.getElementById('modalProductReference');
const modalStock = document.getElementById('modalProductStock');
const modalStockInfo = document.getElementById('modal-stock-info');
const quantiteSelection = document.getElementById('quantite-selection');
const modalTypeSelect = document.getElementById('modal-type');
const btnConfirmerSelection = document.getElementById('btn-confirmer-selection');
const qtyIncreaseBtn = document.getElementById('qty-increase');
const qtyDecreaseBtn = document.getElementById('qty-decrease');

// Formulaire
const produitIdInput = document.getElementById('produit_id');
const produitSelectedDiv = document.getElementById('produit-selected');
const typeSelect = document.getElementById('type');
const quantiteInput = document.getElementById('quantite');
const stockInfo = document.getElementById('stock-info');
const stockActuel = document.getElementById('stock-actuel');
const typeBadge = document.getElementById('type-badge');
const stockApres = document.getElementById('stock-apres');
const submitBtn = document.getElementById('submit-btn');
const qtyIncreaseForm = document.getElementById('qty-increase-form');
const qtyDecreaseForm = document.getElementById('qty-decrease-form');

/* -----------------------
   Helpers
   ----------------------- */
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
      `<img src="/${p.image}" alt="${escapeHtml(p.nom)}" style="width:100%;height:100%;object-fit:cover;">` : 
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
            ${stockBadge}
          </div>
        </div>
      </div>
    `;
  }).join('');
}

function updateProductsCount(count) {
  document.getElementById('products-count').textContent = `${count} produit${count !== 1 ? 's' : ''}`;
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
  quantiteSelection.value = 1;
  quantiteSelection.max = selectedProduct.quantite_stock;

  if (selectedProduct.image) {
    modalImage.src = `/${selectedProduct.image}`;
    modalImage.classList.remove('d-none');
    modalImagePlaceholder.classList.add('d-none');
  } else {
    modalImage.classList.add('d-none');
    modalImagePlaceholder.classList.remove('d-none');
  }

  updateModalStockInfo();
  productModal.show();
  setTimeout(() => quantiteSelection.focus(), 140);
}

function updateModalStockInfo() {
  if (!selectedProduct) return;
  const qte = parseInt(quantiteSelection.value) || 0;
  const type = modalTypeSelect.value;
  const stock = selectedProduct.quantite_stock;
  
  if (type === 'sortie') {
    if (qte > stock) {
      modalStockInfo.innerHTML = `<span class="text-danger"><i class="bi bi-exclamation-triangle"></i> Quantité limitée à ${stock}</span>`;
      quantiteSelection.setAttribute('max', stock);
    } else {
      modalStockInfo.innerHTML = `<span class="text-info">Maximum: ${stock} unités</span>`;
    }
  } else {
    modalStockInfo.innerHTML = `<span class="text-success">Stock actuel: ${stock}</span>`;
    quantiteSelection.removeAttribute('max');
  }
}

qtyIncreaseBtn.addEventListener('click', () => {
  let v = parseInt(quantiteSelection.value || 0); 
  v++;
  if (selectedProduct && modalTypeSelect.value === 'sortie' && v > selectedProduct.quantite_stock) { 
    v = selectedProduct.quantite_stock; 
    flashToast('Quantité limitée par le stock disponible','warning'); 
  }
  quantiteSelection.value = v;
  updateModalStockInfo();
});

qtyDecreaseBtn.addEventListener('click', () => {
  let v = parseInt(quantiteSelection.value || 0); 
  v = Math.max(1, v-1); 
  quantiteSelection.value = v;
  updateModalStockInfo();
});

modalTypeSelect.addEventListener('change', updateModalStockInfo);
quantiteSelection.addEventListener('input', updateModalStockInfo);

/* Confirmer sélection */
btnConfirmerSelection.addEventListener('click', () => {
  if (!selectedProduct) return;
  const qte = Math.max(0, parseInt(quantiteSelection.value || 0));
  const type = modalTypeSelect.value;
  
  if (qte <= 0) { 
    flashToast('Quantité invalide','danger'); 
    return; 
  }
  
  if (type === 'sortie' && qte > selectedProduct.quantite_stock) { 
    flashToast('Stock insuffisant','danger'); 
    return; 
  }

  // Mettre à jour le formulaire
  produitIdInput.value = selectedProduct.id;
  produitSelectedDiv.innerHTML = `
    <i class="bi bi-check-circle text-success"></i>
    <strong>${escapeHtml(selectedProduct.nom)}</strong>
    <span class="text-muted ms-2">(Stock: ${selectedProduct.quantite_stock})</span>
  `;
  typeSelect.value = type;
  quantiteInput.value = qte;
  
  updateFormDisplay();
  productModal.hide();
  flashToast('Produit sélectionné avec succès','success');
});

/* -----------------------
   Mise à jour formulaire
   ----------------------- */
function updateFormDisplay() {
  const produitId = produitIdInput.value;
  const type = typeSelect.value;
  const quantite = parseInt(quantiteInput.value) || 0;
  
  if (!produitId) {
    submitBtn.disabled = true;
    return;
  }
  
  const produit = productsState.find(p => p.id == produitId);
  if (!produit) {
    submitBtn.disabled = true;
    return;
  }
  
  const stockActuelVal = produit.quantite_stock;
  stockActuel.textContent = stockActuelVal;
  
  // Badge type
  if (type === 'entree') {
    typeBadge.innerHTML = '<span class="badge type-badge-entree">Entrée</span>';
    stockApres.textContent = (stockActuelVal + quantite) + ' unités';
  } else {
    typeBadge.innerHTML = '<span class="badge type-badge-sortie">Sortie</span>';
    const stockFinal = Math.max(0, stockActuelVal - quantite);
    stockApres.textContent = stockFinal + ' unités';
    if (quantite > stockActuelVal) {
      stockApres.className = 'fw-bold text-danger';
    } else {
      stockApres.className = 'fw-bold text-success';
    }
  }
  
  // Info stock
  if (type === 'sortie') {
    if (quantite > stockActuelVal) {
      stockInfo.innerHTML = `<span class="text-danger"><i class="bi bi-exclamation-triangle"></i> Stock insuffisant! Stock actuel: ${stockActuelVal}</span>`;
      quantiteInput.setAttribute('max', stockActuelVal);
    } else {
      stockInfo.innerHTML = `<i class="bi bi-info-circle"></i> Stock actuel: ${stockActuelVal} <span class="text-warning">(Maximum: ${stockActuelVal})</span>`;
      quantiteInput.setAttribute('max', stockActuelVal);
    }
  } else {
    stockInfo.innerHTML = `<i class="bi bi-info-circle"></i> Stock actuel: ${stockActuelVal}`;
    quantiteInput.removeAttribute('max');
  }
  
  submitBtn.disabled = !produitId || quantite <= 0 || (type === 'sortie' && quantite > stockActuelVal);
}

typeSelect.addEventListener('change', updateFormDisplay);
quantiteInput.addEventListener('input', updateFormDisplay);

qtyIncreaseForm.addEventListener('click', () => {
  let v = parseInt(quantiteInput.value || 0); 
  v++;
  const max = quantiteInput.getAttribute('max');
  if (max && v > parseInt(max)) {
    v = parseInt(max);
    flashToast('Quantité limitée par le stock disponible','warning');
  }
  quantiteInput.value = v;
  updateFormDisplay();
});

qtyDecreaseForm.addEventListener('click', () => {
  let v = parseInt(quantiteInput.value || 0); 
  v = Math.max(1, v-1); 
  quantiteInput.value = v;
  updateFormDisplay();
});

/* -----------------------
   Form submit validation
   ----------------------- */
document.getElementById('mouvement-form').addEventListener('submit', function(ev) {
  const produitId = produitIdInput.value;
  const quantite = parseInt(quantiteInput.value) || 0;
  const type = typeSelect.value;
  
  if (!produitId) { 
    ev.preventDefault(); 
    flashToast('Sélectionnez un produit','danger'); 
    return; 
  }
  
  const produit = productsState.find(p => p.id == produitId);
  if (!produit) {
    ev.preventDefault();
    flashToast('Produit invalide','danger');
    return;
  }
  
  if (quantite <= 0) {
    ev.preventDefault();
    flashToast('Quantité invalide','danger');
    quantiteInput.focus();
    return;
  }
  
  if (type === 'sortie' && quantite > produit.quantite_stock) {
    ev.preventDefault();
    flashToast('Stock insuffisant pour cette sortie','danger');
    return;
  }
  
  // Afficher un indicateur de chargement
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Enregistrement...';
});

/* -----------------------
   Initialisation
   ----------------------- */
document.addEventListener('DOMContentLoaded', () => {
  renderSearchResults(productsState);
  updateProductsCount(productsState.length);
  updateFormDisplay();
  searchInput.focus();
});

</script>

</body>
</html>