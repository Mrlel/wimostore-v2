@extends('layouts.public')
@section('title', 'Suivi de commande | ' . $page->cabine->nom_cab)

@section('content')
<style>
.suivi-wrapper { padding:40px 0 80px; }
.suivi-card { background:var(--light); border-radius:var(--radius-xl); padding:32px; max-width:640px; margin:0 auto; }
.suivi-card h1 { font-size:22px; font-weight:800; margin-bottom:8px; }
.suivi-card p { color:var(--gray); font-size:14px; margin-bottom:24px; }
.search-form { display:flex; gap:10px; margin-bottom:32px; }
.search-input { flex:1; padding:12px 16px; border:1px solid var(--border-soft); border-radius:var(--radius-sm); font-size:14px; font-family:inherit; }
.search-input:focus { outline:none; border-color:var(--dark); }
.btn-search { padding:12px 20px; background:var(--dark); color:var(--light); border:none; border-radius:var(--radius-sm); font-size:14px; font-weight:600; cursor:pointer; white-space:nowrap; }
.btn-search:hover { opacity:.85; }
/* Timeline */
.timeline { position:relative; padding-left:32px; }
.timeline::before { content:''; position:absolute; left:10px; top:0; bottom:0; width:2px; background:var(--border-soft); }
.timeline-step { position:relative; margin-bottom:24px; }
.timeline-step:last-child { margin-bottom:0; }
.step-dot {
    position:absolute; left:-32px; top:2px;
    width:20px; height:20px; border-radius:50%;
    background:var(--gray-medium); border:2px solid var(--border-soft);
    display:flex; align-items:center; justify-content:center; font-size:9px; color:var(--gray);
}
.step-dot.done { background:var(--dark); border-color:var(--dark); color:var(--light); }
.step-dot.current { background:var(--accent-color); border-color:var(--accent-color); color:var(--dark); animation:pulse 2s infinite; }
@keyframes pulse { 0%,100%{box-shadow:0 0 0 0 rgba(255,184,77,.4);} 50%{box-shadow:0 0 0 6px rgba(255,184,77,0);} }
.step-label { font-size:14px; font-weight:600; color:var(--dark); }
.step-label.inactive { color:var(--gray); font-weight:400; }
.step-date { font-size:12px; color:var(--gray); margin-top:2px; }
.order-info { background:var(--gray-light); border-radius:var(--radius-md); padding:20px; margin-bottom:24px; }
.info-row { display:flex; justify-content:space-between; font-size:14px; padding:6px 0; border-bottom:1px solid var(--border-soft); }
.info-row:last-child { border-bottom:none; }
.info-row span:first-child { color:var(--gray); }
.info-row span:last-child { font-weight:600; }
.not-found { text-align:center; padding:40px 20px; color:var(--gray); }
.not-found i { font-size:48px; margin-bottom:16px; display:block; color:var(--gray-medium); }
.status-pill { display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; }
</style>

<div class="container suivi-wrapper">
    <div class="suivi-card">
        <h1><i class="fas fa-truck" style="margin-right:8px;"></i>Suivi de commande</h1>
        <p>Entrez votre numéro de commande pour suivre l'état de votre livraison.</p>

        <form method="GET" action="{{ route('boutique.suivi', $cabine->code) }}" class="search-form">
            <input type="text" name="numero" class="search-input"
                   placeholder="Ex: CMD-ABC-20251025-XY123"
                   value="{{ request('numero') }}" required>
            <button type="submit" class="btn-search">
                <i class="fas fa-search"></i>
            </button>
        </form>

        @if(request('numero') && !$commande)
        <div class="not-found">
            <i class="fas fa-search"></i>
            <p>Aucune commande trouvée avec ce numéro.</p>
            <p style="font-size:13px;">Vérifiez le numéro et réessayez.</p>
        </div>
        @elseif($commande)
        @php
            $steps = [
                'en_attente'     => ['label'=>'Commande reçue',    'icon'=>'fa-inbox'],
                'confirmee'      => ['label'=>'Commande confirmée','icon'=>'fa-check'],
                'en_preparation' => ['label'=>'En préparation',    'icon'=>'fa-box'],
                'expediee'       => ['label'=>'Expédiée',          'icon'=>'fa-truck'],
                'livree'         => ['label'=>'Livrée',            'icon'=>'fa-house'],
            ];
            $order = array_keys($steps);
            $currentIdx = array_search($commande->statut, $order);
            if($commande->statut === 'annulee') $currentIdx = -1;
        @endphp

        <div class="order-info">
            <div class="info-row">
                <span>Numéro</span>
                <span>{{ $commande->numero_commande }}</span>
            </div>
            <div class="info-row">
                <span>Client</span>
                <span>{{ $commande->nom_client }}</span>
            </div>
            <div class="info-row">
                <span>Total</span>
                <span>{{ number_format($commande->montant_total,0,',',' ') }} FCFA</span>
            </div>
            <div class="info-row">
                <span>Date</span>
                <span>{{ $commande->created_at->format('d/m/Y à H:i') }}</span>
            </div>
            <div class="info-row">
                <span>Statut</span>
                <span>
                    <span class="status-pill" style="background:{{ $commande->statut_color }}22;color:{{ $commande->statut_color }};">
                        {{ $commande->statut_label }}
                    </span>
                </span>
            </div>
        </div>

        @if($commande->statut === 'annulee')
        <div style="background:#FEF2F2;border:1px solid #FECACA;color:#DC2626;padding:16px;border-radius:var(--radius-md);text-align:center;">
            <i class="fas fa-times-circle" style="font-size:24px;margin-bottom:8px;display:block;"></i>
            <strong>Commande annulée</strong>
            <p style="font-size:13px;margin-top:4px;">Cette commande a été annulée. Contactez-nous pour plus d'informations.</p>
        </div>
        @else
        <div class="timeline">
            @foreach($steps as $key => $step)
            @php
                $stepIdx = array_search($key, $order);
                $isDone    = $stepIdx < $currentIdx;
                $isCurrent = $stepIdx === $currentIdx;
            @endphp
            <div class="timeline-step">
                <div class="step-dot {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}">
                    <i class="fas {{ $isDone ? 'fa-check' : $step['icon'] }}"></i>
                </div>
                <div class="step-label {{ (!$isDone && !$isCurrent) ? 'inactive' : '' }}">
                    {{ $step['label'] }}
                </div>
                @if($isCurrent)
                <div class="step-date">En cours</div>
                @elseif($isDone)
                <div class="step-date">Complété</div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <div style="margin-top:28px;padding-top:20px;border-top:1px solid var(--border-soft);">
            <p style="font-size:13px;color:var(--gray);margin-bottom:12px;">
                <i class="fas fa-question-circle"></i> Des questions ? Contactez-nous :
            </p>
            @if($page->whatsapp)
            <a href="https://wa.me/{{ $page->whatsapp }}?text={{ urlencode('Bonjour, je voudrais des informations sur ma commande : ' . $commande->numero_commande) }}"
               target="_blank"
               style="display:inline-flex;align-items:center;gap:8px;background:#25D366;color:#fff;padding:10px 20px;border-radius:var(--radius-sm);text-decoration:none;font-size:14px;font-weight:600;">
                <i class="fab fa-whatsapp"></i> Contacter via WhatsApp
            </a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
