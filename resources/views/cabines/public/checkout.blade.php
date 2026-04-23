@extends('layouts.public')

@section('title', 'Commander | ' . $page->cabine->nom_cab)

@section('content')

<style>
/* ===== PAGE CHECKOUT ===== */
.checkout-wrapper {
    padding: 2rem 1.5rem 4rem;
    max-width: 1400px;
    margin: 0 auto;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--warm-gray);
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 1.8rem;
    transition: color .2s;
    font-family: 'DM Sans', sans-serif;
}

.back-link:hover {
    color: var(--charcoal);
}

.back-link i {
    font-size: 12px;
}

/* Grille checkout */
.checkout-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

@media (min-width: 768px) {
    .checkout-grid {
        grid-template-columns: 1fr 380px;
    }
}

/* Cartes formulaire */
.checkout-card {
    
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    padding: 1.8rem;
    margin-bottom: 1.5rem;
    transition: box-shadow .25s;
}

.checkout-card h2 {
    font-family: 'Inter', serif;
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--charcoal);
    margin-bottom: 1.4rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
}

.checkout-card h2 i {
    color: var(--accent);
    font-size: 1.1rem;
}

/* Champs formulaire */
.form-group {
    margin-bottom: 1.2rem;
}

.form-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    color: var(--charcoal);
    margin-bottom: 0.5rem;
}

.form-control-custom {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid var(--border);
    border-radius: 12px;
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    background: #fff;
    color: var(--charcoal);
    transition: border-color .2s, box-shadow .2s;
}

.form-control-custom:focus {
    outline: none;
    border-color: var(--charcoal);
    box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.05);
}

.form-control-custom.error {
    border-color: #C06B5A;
}

textarea.form-control-custom {
    resize: vertical;
    min-height: 80px;
}

.error-msg {
    font-size: 11px;
    color: #C06B5A;
    margin-top: 0.3rem;
    display: none;
}

.error-msg[style*="display:block"] {
    display: block;
}

/* Alertes */
.alert-error {
    background: #FEF2F2;
    border: 1px solid #FECACA;
    color: #C06B5A;
    padding: 0.8rem 1rem;
    border-radius: 14px;
    margin-bottom: 1.5rem;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Radio options */
.radio-group {
    display: flex;
    flex-direction: column;
    gap: 0.7rem;
}

.radio-option {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.9rem 1rem;
    border: 1px solid var(--border);
    border-radius: 14px;
    cursor: pointer;
    transition: all .2s;
    background: #fff;
}

.radio-option:hover {
    border-color: var(--warm-gray);
    background: #fefcf9;
}

.radio-option:has(input:checked) {
    border-color: var(--charcoal);
    background: #f5f2ef;
}

.radio-option input {
    accent-color: var(--charcoal);
    width: 16px;
    height: 16px;
    margin: 0;
    cursor: pointer;
}

.radio-option label {
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    color: var(--charcoal);
    font-family: 'DM Sans', sans-serif;
    flex: 1;
}

.radio-option label i {
    margin-right: 0.4rem;
    font-size: 14px;
}

/* Résumé commande */
.order-summary {
    background: #faf7f7;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
    position: sticky;
    top: 90px;
}

.order-summary h2 {
    font-family: 'Inter', serif;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--charcoal);
    margin-bottom: 1.2rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid var(--border);
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.7rem 0;
    border-bottom: 1px solid var(--border);
    font-size: 13px;
}

.order-item:last-of-type {
    border-bottom: none;
}

.order-item-name {
    color: var(--charcoal);
    font-weight: 500;
    font-family: 'DM Sans', sans-serif;
}

.order-item-qty {
    color: var(--warm-gray);
    font-size: 11px;
    margin-top: 2px;
}

.order-item-price {
    font-weight: 600;
    color: var(--charcoal);
    font-size: 13px;
}

.order-total {
    display: flex;
    justify-content: space-between;
    font-size: 1rem;
    font-weight: 700;
    padding-top: 1rem;
    border-top: 2px solid var(--border);
    margin-top: 0.8rem;
    color: var(--charcoal);
}

.order-total span:last-child {
    font-size: 1.2rem;
}

/* Bouton confirmation */
.btn-confirm {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    width: 100%;
    padding: 14px 20px;
    background: var(--charcoal);
    color: #fff;
    border: none;
    border-radius: 40px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.03em;
    cursor: pointer;
    transition: background .2s, transform .1s;
    margin-top: 1.2rem;
    font-family: 'DM Sans', sans-serif;
}

.btn-confirm:hover {
    background: var(--accent-dark);
}

.btn-confirm:active {
    transform: scale(0.98);
}

.btn-confirm:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.btn-confirm i {
    font-size: 14px;
}

/* Sécurité */
.security-note {
    font-size: 11px;
    color: var(--warm-gray);
    text-align: center;
    margin-top: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
}

/* Responsive */
@media (max-width: 767px) {
    .checkout-wrapper {
        padding: 1.2rem 1rem 3rem;
    }
    
    .checkout-card {
        padding: 1.2rem;
    }
    
    .order-summary {
        padding: 1.2rem;
    }
    
    .checkout-card h2 {
        font-size: 1rem;
    }
}

@media (max-width: 479px) {
    .order-item {
        flex-wrap: wrap;
        gap: 0.3rem;
    }
    
    .order-item-price {
        width: 100%;
        text-align: right;
    }
}
</style>

<div class="checkout-wrapper">
    <a href="{{ route('boutique.panier', $cabine->code) }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Retour au panier
    </a>

    @if(session('error'))
    <div class="alert-error">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    </div>
    @endif

    <div class="checkout-grid">
        <!-- Formulaire -->
        <div>
            <form method="POST" action="{{ route('boutique.commande.passer', $cabine->code) }}" id="checkoutForm" novalidate>
                @csrf

                <!-- Informations client -->
                <div class="checkout-card">
                    <h2><i class="bi bi-person"></i> Vos informations</h2>

                    <div class="form-group">
                        <label class="form-label" for="nom_client">Nom complet *</label>
                        <input type="text" id="nom_client" name="nom_client" 
                               class="form-control-custom @error('nom_client') error @enderror"
                               value="{{ old('nom_client') }}" 
                               placeholder="Votre nom" required>
                        @error('nom_client')
                        <div class="error-msg" style="display:block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="telephone_client">Téléphone *</label>
                        <input type="tel" id="telephone_client" name="telephone_client" 
                               class="form-control-custom @error('telephone_client') error @enderror"
                               value="{{ old('telephone_client') }}" 
                               placeholder="+225 XX XX XX XX XX" required>
                        @error('telephone_client')
                        <div class="error-msg" style="display:block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email_client">Email <span style="font-weight:normal;">(optionnel)</span></label>
                        <input type="email" id="email_client" name="email_client" 
                               class="form-control-custom @error('email_client') error @enderror"
                               value="{{ old('email_client') }}" 
                               placeholder="votre@email.com">
                        @error('email_client')
                        <div class="error-msg" style="display:block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="adresse_livraison">Adresse de livraison</label>
                        <textarea id="adresse_livraison" name="adresse_livraison" 
                                  class="form-control-custom" rows="2"
                                  placeholder="Quartier, rue, description...">{{ old('adresse_livraison') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="notes">Notes <span style="font-weight:normal;">(optionnel)</span></label>
                        <textarea id="notes" name="notes" 
                                  class="form-control-custom" rows="2"
                                  placeholder="Instructions particulières...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <!-- Mode de paiement -->
                <div class="checkout-card">
                    <h2><i class="bi bi-credit-card"></i> Mode de paiement</h2>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="pay_livraison" name="mode_paiement" 
                                   value="a_la_livraison" 
                                   {{ old('mode_paiement','a_la_livraison') === 'a_la_livraison' ? 'checked' : '' }}>
                            <label for="pay_livraison">
                                <i class="bi bi-cash-stack"></i> Paiement à la livraison
                            </label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="pay_mobile" name="mode_paiement" 
                                   value="mobile_money" 
                                   {{ old('mode_paiement') === 'mobile_money' ? 'checked' : '' }}>
                            <label for="pay_mobile">
                                <i class="bi bi-phone"></i> Mobile Money
                            </label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="pay_autre" name="mode_paiement" 
                                   value="autre" 
                                   {{ old('mode_paiement') === 'autre' ? 'checked' : '' }}>
                            <label for="pay_autre">
                                <i class="bi bi-three-dots"></i> Autre
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Résumé commande -->
        <div>
            <div class="order-summary">
                <h2>Votre commande</h2>
                
                @foreach($cart as $item)
                <div class="order-item">
                    <div>
                        <div class="order-item-name">{{ $item['nom'] }}</div>
                        <div class="order-item-qty">× {{ $item['quantite'] }}</div>
                    </div>
                    <div class="order-item-price">
                        {{ number_format($item['prix_unitaire'] * $item['quantite'], 0, ',', ' ') }} FCFA
                    </div>
                </div>
                @endforeach
                
                <div class="order-total">
                    <span>Total</span>
                    <span>{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                </div>
                
                <button type="submit" form="checkoutForm" class="btn-confirm" id="submitBtn">
                    <i class="bi bi-check-circle"></i> Confirmer la commande
                </button>
                
                <div class="security-note">
                    <i class="bi bi-shield-check"></i> Vos données sont sécurisées
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat bi-spin"></i> Traitement en cours...';
});
</script>
@endpush

@endsection