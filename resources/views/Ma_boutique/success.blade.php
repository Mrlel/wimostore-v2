@extends('layouts.app')
@section('title', 'Boutique créée avec succès')

@section('content')
@php
    $url = $boutique?->cabine?->public_url ?? '';
@endphp

<style>
    .success-wrap {
        max-width: 560px;
        margin: 40px auto;
        text-align: center;
    }
    .success-icon {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: rgba(16,185,129,0.1);
        border: 2px solid rgba(16,185,129,0.3);
        display: flex; align-items: center; justify-content: center;
        font-size: 2.2rem;
        margin: 0 auto 24px;
        animation: popIn .5s cubic-bezier(.34,1.56,.64,1);
    }
    @keyframes popIn {
        from { transform: scale(0); opacity: 0; }
        to   { transform: scale(1); opacity: 1; }
    }
    .success-title {
        font-size: 1.8rem; font-weight: 800; color: #111;
        margin-bottom: 10px;
    }
    .success-sub {
        color: #666; font-size: 0.95rem; line-height: 1.6; margin-bottom: 32px;
    }

    /* URL copy box */
    .url-box {
        background: #f8f8f8;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 14px 16px;
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 28px;
        text-align: left;
    }
    .url-box input {
        flex: 1; border: none; background: transparent;
        font-size: 0.85rem; color: #333; outline: none;
        font-family: monospace; min-width: 0;
    }
    .btn-copy {
        background: #111; color: #fff; border: none;
        border-radius: 8px; padding: 8px 16px;
        font-size: 0.82rem; font-weight: 600; cursor: pointer;
        white-space: nowrap; transition: all .2s; flex-shrink: 0;
        display: flex; align-items: center; gap: 6px;
    }
    .btn-copy:hover { background: #333; }
    .btn-copy.copied { background: #10b981; }

    /* Action buttons */
    .action-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 20px;
    }
    .action-btn {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 8px; padding: 18px 12px;
        border-radius: 12px; text-decoration: none;
        font-weight: 600; font-size: 0.85rem;
        transition: all .2s; border: 1px solid transparent;
    }
    .action-btn i { font-size: 1.5rem; }
    .action-btn.primary {
        background: #f0c61d; color: #000;
    }
    .action-btn.primary:hover { background: #e0b800; transform: translateY(-2px); }
    .action-btn.secondary {
        background: #fff; color: #111;
        border-color: #e0e0e0;
    }
    .action-btn.secondary:hover { border-color: #f0c61d; transform: translateY(-2px); }

    .skip-link {
        color: #aaa; font-size: 0.82rem; text-decoration: none;
        display: inline-block; margin-top: 8px;
    }
    .skip-link:hover { color: #666; }

    @media (max-width: 480px) {
        .action-grid { grid-template-columns: 1fr; }
        .success-title { font-size: 1.4rem; }
    }
</style>

<div class="success-wrap">
    <div class="success-icon">🎉</div>

    <h1 class="success-title">Votre boutique est en ligne !</h1>
    <p class="success-sub">
        Félicitations ! Votre boutique a été créée avec succès.<br>
        Partagez votre lien avec vos clients pour commencer à vendre.
    </p>

    {{-- URL + bouton copier --}}
    @if($url)
    <div class="url-box">
        <i class="bi bi-link-45deg text-muted" style="flex-shrink:0;"></i>
        <input type="text" id="boutiqueUrl" value="{{ $url }}" readonly>
        <button class="btn-copy" id="copyBtn" onclick="copyUrl()">
            <i class="bi bi-clipboard" id="copyIcon"></i>
            <span id="copyText">Copier</span>
        </button>
    </div>
    @endif

    {{-- Actions --}}
    <div class="action-grid">
        @if($url)
        <a href="{{ $url }}" target="_blank" class="action-btn primary">
            <i class="bi bi-shop"></i>
            Visiter ma boutique
        </a>
        @endif
        <a href="{{ route('produits.create') }}" class="action-btn secondary">
            <i class="bi bi-box-seam"></i>
            Ajouter des produits
        </a>
        <a href="{{ route('Ma_boutique.edit', ['boutique' => $boutique?->id]) }}" class="action-btn secondary">
            <i class="bi bi-pencil"></i>
            Modifier la boutique
        </a>
        <a href="{{ route('Ma_boutique') }}" class="action-btn secondary">
            <i class="bi bi-grid"></i>
            Tableau de bord
        </a>
    </div>

    <a href="{{ route('dashboard') }}" class="skip-link">
        Aller au tableau de bord →
    </a>
</div>

@push('scripts')
<script>
function copyUrl() {
    const input = document.getElementById('boutiqueUrl');
    const btn   = document.getElementById('copyBtn');
    const icon  = document.getElementById('copyIcon');
    const text  = document.getElementById('copyText');

    navigator.clipboard.writeText(input.value).then(() => {
        btn.classList.add('copied');
        icon.className = 'bi bi-check2';
        text.textContent = 'Copié !';
        setTimeout(() => {
            btn.classList.remove('copied');
            icon.className = 'bi bi-clipboard';
            text.textContent = 'Copier';
        }, 2500);
    }).catch(() => {
        // Fallback pour les navigateurs sans clipboard API
        input.select();
        document.execCommand('copy');
        text.textContent = 'Copié !';
        setTimeout(() => text.textContent = 'Copier', 2000);
    });
}
</script>
@endpush

@endsection
