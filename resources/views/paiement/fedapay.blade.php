<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement — Renouvellement abonnement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #faf8f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .pay-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,.10);
            max-width: 420px;
            width: 100%;
            overflow: hidden;
        }
        .pay-header {
            background: #1A2E35;
            padding: 2rem;
            text-align: center;
            color: #fff;
        }
        .pay-amount {
            font-size: 2.4rem;
            font-weight: 800;
            line-height: 1;
            margin: .5rem 0 .25rem;
        }
        .pay-body { padding: 1.8rem; }
        .info-row {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .6rem 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }
        .info-row:last-child { border-bottom: none; }
        .info-row i { color: #fbc926; font-size: 16px; flex-shrink: 0; }
        .btn-pay {
            background: #fbc926;
            color: #1A1A1A;
            border: none;
            padding: 14px;
            width: 100%;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            margin-top: 1.5rem;
        }
        .btn-pay:hover { background: #e6b520; transform: translateY(-1px); }
        .btn-pay:active { transform: translateY(0); }
        .secure-badge {
            text-align: center;
            font-size: 11px;
            color: #aaa;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="pay-card">
        <div class="pay-header">
            <p style="font-size:11px;letter-spacing:.1em;text-transform:uppercase;opacity:.7;margin:0 0 .3rem;">
                Renouvellement mensuel
            </p>
            <div class="pay-amount">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</div>
            <p style="font-size:12px;opacity:.6;margin:.3rem 0 0;">30 jours d'accès complet</p>
        </div>

        <div class="pay-body">
            <div class="info-row">
                <i class="bi bi-person-circle"></i>
                <span><strong>{{ $clientInfo['nom'] }}</strong></span>
            </div>
            <div class="info-row">
                <i class="bi bi-envelope"></i>
                <span>{{ $clientInfo['email'] }}</span>
            </div>
            <div class="info-row">
                <i class="bi bi-phone"></i>
                <span>{{ $clientInfo['telephone'] }}</span>
            </div>

            <button id="pay-btn" class="btn-pay">
                <i class="bi bi-credit-card me-2"></i>
                Payer et renouveler
            </button>

            <p class="secure-badge">
                <i class="bi bi-shield-lock me-1"></i> Paiement sécurisé par FedaPay
            </p>
        </div>
    </div>

    <script>
        const paiementId = {{ $paiement->id }};

        FedaPay.init('#pay-btn', {
            public_key: '{{ env("FEDAPAY_PUBLIC_KEY") }}',
            transaction: {
                amount: {{ $paiement->montant }},
                description: 'Renouvellement abonnement mensuel',
                custom_metadata: { paiement_id: paiementId }
            },
            customer: {
                email: '{{ $clientInfo["email"] }}',
                firstname: '{{ $clientInfo["nom"] }}',
                phone_number: {
                    number: '{{ $clientInfo["telephone"] }}',
                    country: 'CI'
                }
            },
            onComplete: function(response) {
                try {
                    const status = response && response.transaction && response.transaction.status;
                    if (status === 'approved') {
                        window.location.href = '/paiement/verify?transaction_id='
                            + response.transaction.id + '&paiement_id=' + paiementId;
                    } else if (status) {
                        // transaction existe mais non approuvée (declined, cancelled...)
                        window.location.href = '/paiement/failed/' + paiementId;
                    }
                    // si pas de transaction (modal fermé sans payer), on ne redirige pas
                } catch(e) {
                    console.error('FedaPay onComplete error:', e);
                }
            }
        });
    </script>
</body>
</html>
