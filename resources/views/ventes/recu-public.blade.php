<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Vente - {{ $vente->numero_vente }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="/Wim.png" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;600&display=swap');
        
        .receipt-container {
            max-width: 400px;
            margin: 2rem auto;
            padding: 1.5rem;
            background: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-radius: 0.5rem;
        }
        
        .receipt-header {
            text-align: center;
            border-bottom: 2px dashed #9ca3af;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }
        
        .receipt-footer {
            text-align: center;
            border-top: 2px dashed #9ca3af;
            padding-top: 1rem;
            margin-top: 1rem;
            font-size: 0.75rem;
            color: #6b7280;
        }
        
        .item-row {
            border-bottom: 1px dotted #e5e7eb;
            padding: 0.5rem 0;
        }
        
        .total-row {
            font-weight: 600;
            border-top: 2px solid #111827;
            padding-top: 0.75rem;
        }
        
        .qr-code {
            text-align: center;
            margin: 1rem 0;
            padding: 0.5rem;
            background-color: #f9fafb;
            border-radius: 0.375rem;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: none;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }
        
        /* MODE IMPRESSION THERMIQUE */
@media print {
    body {
        width: 80mm;
        margin: 0;
        padding: 0;
        font-family: "Roboto Mono", monospace;
        font-size: 11px;
        line-height: 1.2;
    }

    .receipt-container {
        width: 80mm !important;
        max-width: 80mm !important;
        margin: 0;
        padding: 0;
        box-shadow: none !important;
        border: none !important;
    }

    .no-print {
        display: none !important;
    }

    /* Enlever les gros paddings */
    .receipt-container > div {
        padding: 0 5px;
    }

    /* Réduire la taille du QR */
    .qr-code svg {
        width: 120px !important;
        height: 120px !important;
        margin: auto;
    }
}

    </style>
</head>
<body>
    <div class="container py-8 px-4">
        <div class="receipt-container">
            <!-- En-tête -->
            <div class="receipt-header">
                <h3 class="font-bold text-xl mb-1">{{ $vente->cabine->nom_cab }}</h3>
                <span class="font-semibold">N° :</span> {{ $vente->numero_vente }}
            </div>
   <!-- Informations client -->
            <div class="flex justify-between">
                    @if($vente->nom_client)
                    <div class="text-sm text-left">
                        <span class="font-semibold">Client:</span> {{ $vente->nom_client ?? 'Non spécifié' }}
                    </div>
                    @endif
                    @if($vente->contact_client)
                    <div class="text-sm text-right">
                        <span class="font-semibold">Contact:</span> {{ $vente->contact_client ?? 'Non renseigné' }}
                    </div>
                    @endif
                </div>
            <!-- Informations de la vente -->
            <div class="mb-4">
                <div class="flex justify-between">
                    <div class="text-sm text-left">
                        <span class="font-semibold">Date:</span> {{ $vente->created_at->format('d/m/Y') }}
                    </div>
                    <div class="text-sm text-right">
                        <span class="font-semibold">Heure:</span> {{ $vente->created_at->format('H:i') }}
                    </div>
                </div>
            </div>

            <!-- Articles -->
            <div class="mb-4">
                <div class="flex font-semibold item-row text-sm">
                    <div class="w-3/5">Article(s)</div>
                    <div class="w-1/5 text-center">Qte</div>
                    <div class="w-1/5 text-right">Total</div>
                </div>
                
                @foreach($vente->lignes as $ligne)
                <div class="flex item-row text-sm py-1">
                    <div class="w-3/5">{{ $ligne->produit->nom }}</div>
                    <div class="w-1/5 text-center">{{ $ligne->quantite }}</div>
                    <div class="w-1/5 text-right">{{ number_format($ligne->sous_total) }} FCFA</div>
                </div>
                @endforeach
            </div>

            <!-- Total -->
            <div class="mb-4">
                <div class="flex total-row">
                    <div class="w-3/5">TOTAL</div>
                    <div class="w-2/5 text-right font-semibold">{{ number_format($vente->montant_total) }} FCFA</div>
                </div>
                <div class="flex mt-1 text-sm">
                    <div class="w-3/5">Montant réglé</div>
                    <div class="w-2/5 text-right">{{ number_format($vente->montant_regle) }} FCFA</div>
                </div>
                @if($vente->montant_du > 0)
                <div class="flex mt-1 text-sm text-red-600">
                    <div class="w-3/5">Montant dû</div>
                    <div class="w-2/5 text-right">{{ number_format($vente->montant_du) }} FCFA</div>
                </div>
                @endif
                <div class="flex mt-1 text-sm">
                    <div class="w-3/5">Paiement</div>
                    <div class="w-2/5 text-right capitalize">{{ $vente->mode_paiement }}</div>
                </div>
            </div>

            <!-- QR Code -->
            <div class="qr-code">
                @if(isset($qrCode))
                    <div class="flex justify-center">
                         {!! QrCode::size(150)->generate($cabine->public_url) !!}
                    </div>
                @endif
            </div>

            <div class="receipt-footer">
                <p class="thank-you">🎉 Merci pour votre confiance !</p>
                <p class="generated-info">Reçu émis le {{ now()->format('d/m/Y à H:i') }}</p>
                <p class="contact-info">Pour toute question, contactez-nous</p>
            </div>
            
        </div>
    </div>
</body>
</html>