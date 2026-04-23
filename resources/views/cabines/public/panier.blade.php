@extends('layouts.public')
@section('title', 'Panier | ' . $page->cabine->nom_cab)

@section('content')
<style>
.page-header { padding:1.5rem 1.5rem .8rem; max-width:1400px; margin:0 auto; }
.page-title {
    font-family:'Cormorant Garamond',serif;
    font-size:1.8rem; font-weight:600; color:var(--charcoal); margin:0;
}
.back-link {
    display:inline-flex; align-items:center; gap:6px;
    color:var(--warm-gray); text-decoration:none; font-size:12px; margin-bottom:10px;
    transition:color .2s;
}
.back-link:hover { color:var(--charcoal); }
.cart-page-grid { display:grid; grid-template-columns:1fr; gap:1.5rem; padding:0 1.5rem 5rem; max-width:1400px; margin:0 auto; }
@media(min-width:768px) { .cart-page-grid { grid-template-columns:1fr 320px; } }
.cart-table { background:#fff; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; }
.cart-table-header { display:grid; grid-template-columns:1fr 120px 120px 40px; gap:12px; padding:14px 20px; background:var(--tag-bg); font-size:11px; font-weight:600; color:var(--warm-gray); letter-spacing:.06em; text-transform:uppercase; }
.cart-row { display:grid; grid-template-columns:1fr 120px 120px 40px; gap:12px; align-items:center; padding:14px 20px; border-bottom:1px solid var(--border); }
.cart-row:last-child { border-bottom:none; }
.cart-prod { display:flex; align-items:center; gap:12px; }
.cart-prod img { width:52px; height:64px; border-radius:8px; object-fit:cover; background:var(--tag-bg); }
.cart-prod-name { font-family:'Cormorant Garamond',serif; font-size:15px; font-weight:600; color:var(--charcoal); }
.cart-prod-price { font-size:11px; color:var(--warm-gray); }
.qty-control { display:flex; align-items:center; gap:6px; }
.qty-control button { width:26px; height:26px; border:1px solid var(--border); background:#fff; border-radius:6px; cursor:pointer; font-size:13px; display:flex; align-items:center; justify-content:center; transition:all .2s; }
.qty-control button:hover { background:var(--charcoal); color:#fff; border-color:var(--charcoal); }
.qty-control span { font-size:13px; font-weight:600; min-width:22px; text-align:center; }
.row-total { font-size:13px; font-weight:600; color:var(--charcoal); }
.btn-remove { background:none; border:none; color:#c0bbb5; cursor:pointer; font-size:15px; padding:4px; transition:color .2s; }
.btn-remove:hover { color:#C06B5A; }
.cart-empty-page { text-align:center; padding:80px 20px; }
.cart-empty-page i { font-size:48px; color:var(--border); margin-bottom:16px; display:block; }
.summary-card { background:#fff; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.05); padding:20px; position:sticky; top:80px; }
.summary-title { font-family:'Cormorant Garamond',serif; font-size:1.2rem; font-weight:600; margin-bottom:16px; }
.summary-row { display:flex; justify-content:space-between; font-size:12px; color:var(--warm-gray); margin-bottom:10px; }
.summary-total { display:flex; justify-content:space-between; font-family:'Cormorant Garamond',serif; font-size:1.2rem; font-weight:600; padding-top:14px; border-top:1px solid var(--border); margin-top:6px; }
.btn-primary-full { display:flex; align-items:center; justify-content:center; gap:8px; width:100%; padding:13px; background:var(--charcoal); color:#fff; border:none; border-radius:30px; font-size:13px; font-weight:500; text-decoration:none; margin-top:14px; transition:background .2s; letter-spacing:.04em; }
.btn-primary-full:hover { background:var(--accent-dark); color:#fff; }
.btn-outline-full { display:flex; align-items:center; justify-content:center; gap:8px; width:100%; padding:11px; background:transparent; color:var(--charcoal); border:1px solid var(--border); border-radius:30px; font-size:12px; font-weight:500; text-decoration:none; margin-top:8px; transition:all .2s; }
.btn-outline-full:hover { background:var(--tag-bg); color:var(--charcoal); }
@media(max-width:767px) { .cart-table-header { display:none; } .cart-row { grid-template-columns:1fr auto; } }
</style>

<div class="page-header">
    <a href="{{ route('cabine.public', $cabine->code) }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Continuer mes achats
    </a>
    <h1 class="page-title">Mon Panier
        @if(count($cart) > 0)
        <span style="font-size:14px;font-weight:400;color:var(--warm-gray);font-family:'DM Sans',sans-serif;">({{ array_sum(array_column($cart,'quantite')) }} article(s))</span>
        @endif
    </h1>
</div>

    @if(count($cart) > 0)
    <div class="cart-page-grid">
        <div>
            <div class="cart-table">
                <div class="cart-table-header">
                    <span>Produit</span>
                    <span>Quantité</span>
                    <span>Sous-total</span>
                    <span></span>
                </div>
                @foreach($cart as $item)
                <div class="cart-row" id="row-{{ $item['produit_id'] }}">
                    <div class="cart-prod">
                        <img src="{{ $item['image'] ? asset('storage/'.$item['image']) : '/image-box.jpeg' }}" alt="{{ $item['nom'] }}">
                        <div>
                            <div class="cart-prod-name">{{ $item['nom'] }}</div>
                            <div class="cart-prod-price">{{ number_format($item['prix_unitaire'],0,',',' ') }} FCFA</div>
                        </div>
                    </div>
                    <div class="qty-control">
                        <button onclick="changeQty({{ $item['produit_id'] }}, -1)">−</button>
                        <span id="qty-{{ $item['produit_id'] }}">{{ $item['quantite'] }}</span>
                        <button onclick="changeQty({{ $item['produit_id'] }}, 1)">+</button>
                    </div>
                    <div class="row-total" id="sub-{{ $item['produit_id'] }}">
                        {{ number_format($item['prix_unitaire'] * $item['quantite'],0,',',' ') }} FCFA
                    </div>
                    <button class="btn-remove" onclick="removeItem({{ $item['produit_id'] }})" aria-label="Supprimer">
                        <i class="bi bi-trash3"></i>
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        <div>
            <div class="summary-card">
                <div class="summary-title">Récapitulatif</div>
                @foreach($cart as $item)
                <div class="summary-row">
                    <span>{{ $item['nom'] }} × {{ $item['quantite'] }}</span>
                    <span>{{ number_format($item['prix_unitaire'] * $item['quantite'],0,',',' ') }} FCFA</span>
                </div>
                @endforeach
                <div class="summary-total">
                    <span>Total</span>
                    <span id="pageTotal">{{ number_format($total,0,',',' ') }} FCFA</span>
                </div>
                <a href="{{ route('boutique.checkout', $cabine->code) }}" class="btn-primary-full">
                    <i class="fas fa-lock"></i> Passer la commande
                </a>
                <a href="{{ route('cabine.public', $cabine->code) }}" class="btn-outline-full">
                    <i class="fas fa-arrow-left"></i> Continuer mes achats
                </a>
            </div>
        </div>
    </div>
    @else
    <div style="padding:0 1.5rem 5rem;max-width:1400px;margin:0 auto;">
    <div class="cart-empty-page">
        <i class="bi bi-bag"></i>
        <p style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;margin-bottom:8px;">Votre panier est vide</p>
        <p style="color:var(--warm-gray);margin-bottom:24px;font-size:12px;">Découvrez nos produits et ajoutez-les à votre panier.</p>
        <a href="{{ route('cabine.public', $cabine->code) }}" class="btn-primary-full" style="max-width:240px;margin:0 auto;">
            <i class="bi bi-bag"></i> Voir les produits
        </a>
    </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function changeQty(id, delta) {
    const qtyEl = document.getElementById('qty-' + id);
    const current = parseInt(qtyEl.textContent);
    const newQty = Math.max(0, current + delta);
    fetch(`/boutique/${CABINE_CODE}/panier/mettre-a-jour`, {
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF_TOKEN},
        body:JSON.stringify({produit_id:id, quantite:newQty})
    }).then(r=>r.json()).then(data=>{
        if(data.success) {
            if(newQty===0) { document.getElementById('row-'+id)?.remove(); }
            else { qtyEl.textContent = newQty; }
            updateBadge(data.count);
            if(data.total !== undefined) document.getElementById('pageTotal').textContent = new Intl.NumberFormat('fr-FR').format(Math.round(data.total)) + ' FCFA';
            if(newQty===0) setTimeout(()=>location.reload(),300);
        }
    });
}
function removeItem(id) {
    fetch(`/boutique/${CABINE_CODE}/panier/supprimer`, {
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF_TOKEN},
        body:JSON.stringify({produit_id:id})
    }).then(r=>r.json()).then(data=>{
        if(data.success) { updateBadge(data.count); location.reload(); }
    });
}
</script>
@endpush
@endsection
