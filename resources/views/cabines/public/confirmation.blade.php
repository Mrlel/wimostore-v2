@extends('layouts.public')
@section('title', 'Commande confirmée | ' . $page->cabine->nom_cab)

@section('content')
<style>
.confirm-wrapper { padding:48px 0 80px; }
.confirm-card { background:var(--light); border-radius:var(--radius-xl); box-shadow:var(--shadow-md); padding:40px; max-width:640px; margin:0 auto; text-align:center; }
.confirm-icon { width:80px; height:80px; background:#D1FAE5; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 24px; font-size:36px; color:#10B981; }
.confirm-title { font-size:26px; font-weight:800; color:var(--dark); margin-bottom:8px; }
.confirm-subtitle { font-size:15px; color:var(--gray); margin-bottom:32px; }
.order-number { display:inline-flex; align-items:center; gap:8px; background:var(--gray-light); padding:10px 20px; border-radius:var(--radius-md); font-size:14px; font-weight:700; color:var(--dark); margin-bottom:32px; }
.detail-block { background:var(--gray-light); border-radius:var(--radius-md); padding:20px; text-align:left; margin-bottom:24px; }
.detail-row { display:flex; justify-content:space-between; font-size:14px; padding:6px 0; border-bottom:1px solid var(--border-soft); }
.detail-row:last-child { border-bottom:none; }
.detail-row span:first-child { color:var(--gray); }
.detail-row span:last-child { font-weight:600; color:var(--dark); }
.items-list { text-align:left; margin-bottom:24px; }
.items-list h3 { font-size:15px; font-weight:700; margin-bottom:12px; }
.item-row { display:flex; justify-content:space-between; font-size:14px; padding:8px 0; border-bottom:1px solid var(--border-soft); }
.item-row:last-child { border-bottom:none; }
.total-row { display:flex; justify-content:space-between; font-size:16px; font-weight:800; padding-top:12px; }
.btn-track { display:inline-flex; align-items:center; gap:8px; background:var(--dark); color:var(--light); padding:14px 28px; border-radius:var(--radius-md); text-decoration:none; font-weight:700; font-size:15px; margin:8px; transition:opacity .2s; }
.btn-track:hover { opacity:.85; color:var(--light); }
.btn-shop { display:inline-flex; align-items:center; gap:8px; background:transparent; color:var(--dark); border:1px solid var(--border-soft); padding:14px 28px; border-radius:var(--radius-md); text-decoration:none; font-weight:600; font-size:15px; margin:8px; transition:all .2s; }
.btn-shop:hover { background:var(--gray-light); color:var(--dark); }
.status-badge { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:600; background:#FEF3C7; color:#92400E; }
</style>

<div class="container confirm-wrapper">
    <div class="confirm-card">
        <div class="confirm-icon"><i class="fas fa-check"></i></div>
        <h1 class="confirm-title">Commande passée avec succès !</h1>
        <p class="confirm-subtitle">Merci {{ $commande->nom_client }}, votre commande a bien été reçue.</p>

        <div class="order-number">
            <i class="fas fa-hashtag"></i> {{ $commande->numero_commande }}
        </div>

        <div class="detail-block">
            <div class="detail-row">
                <span>Statut</span>
                <span><span class="status-badge"><i class="fas fa-clock"></i> {{ $commande->statut_label }}</span></span>
            </div>
            <div class="detail-row">
                <span>Mode de paiement</span>
                <span>{{ match($commande->mode_paiement) { 'a_la_livraison'=>'À la livraison','mobile_money'=>'Mobile Money',default=>'Autre' } }}</span>
            </div>
            <div class="detail-row">
                <span>Téléphone</span>
                <span>{{ $commande->telephone_client }}</span>
            </div>
            @if($commande->adresse_livraison)
            <div class="detail-row">
                <span>Adresse</span>
                <span>{{ $commande->adresse_livraison }}</span>
            </div>
            @endif
        </div>

        <div class="items-list">
            <h3>Articles commandés</h3>
            @foreach($commande->lignes as $ligne)
            <div class="item-row">
                <span>{{ $ligne->produit->nom ?? 'Produit' }} × {{ $ligne->quantite }}</span>
                <span>{{ number_format($ligne->sous_total,0,',',' ') }} FCFA</span>
            </div>
            @endforeach
            <div class="total-row">
                <span>Total</span>
                <span>{{ number_format($commande->montant_total,0,',',' ') }} FCFA</span>
            </div>
        </div>

        <p style="font-size:13px;color:var(--gray);margin-bottom:24px;">
            <i class="fas fa-info-circle"></i>
            Conservez votre numéro de commande pour suivre votre livraison.
        </p>

        <div>
            <a href="{{ route('boutique.suivi', ['code'=>$cabine->code,'numero'=>$commande->numero_commande]) }}" class="btn-track">
                <i class="fas fa-truck"></i> Suivre ma commande
            </a>
            <a href="{{ route('cabine.public', $cabine->code) }}" class="btn-shop">
                <i class="fas fa-store"></i> Continuer mes achats
            </a>
        </div>
    </div>
</div>
@endsection
