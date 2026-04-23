<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Vente - {{ $vente->receipt_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #000;
        }
        
        .receipt-container {
            max-width: 400px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 20px;
            background: white;
        }
        
        .receipt-header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        
        .receipt-footer {
            text-align: center;
            border-top: 2px dashed #000;
            padding-top: 15px;
            margin-top: 15px;
            font-size: 10px;
        }
        
        .item-row {
            border-bottom: 1px dotted #ccc;
            padding: 5px 0;
            display: flex;
            justify-content: space-between;
        }
        
        .total-row {
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .qr-code {
            text-align: center;
            margin: 15px 0;
        }
        
        .company-info {
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .receipt-info {
            margin-bottom: 15px;
        }
        
        .items-table {
            width: 100%;
            margin-bottom: 15px;
        }
        
        .items-table th,
        .items-table td {
            padding: 3px 0;
            text-align: left;
        }
        
        .items-table .text-right {
            text-align: right;
        }
        
        .amount {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- En-tête -->
        <div class="receipt-header">
            <div class="company-info">
                <h3 style="margin: 0; font-size: 18px;">{{ $cabine->nom_cab ?? 'DIGITAL SOLUTION' }}</h3>
                <p style="margin: 5px 0;">{{ $cabine->localisation ?? 'Abidjan, Côte d\'Ivoire' }}</p>
                <p style="margin: 5px 0;">Tél: {{ $cabine->code ?? 'DSP' }}</p>
            </div>
        </div>

        <!-- Informations de la vente -->
        <div class="receipt-info">
            <div class="item-row">
                <span><strong>Reçu:</strong> {{ $vente->receipt_number }}</span>
                <span><strong>Date:</strong> {{ $vente->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="item-row">
                <span><strong>Vendeur:</strong> {{ $vente->user->name }}</span>
            </div>
            @if($vente->nom_client)
            <div class="item-row">
                <span><strong>Client:</strong> {{ $vente->nom_client }}</span>
            </div>
            @endif
            @if($vente->contact_client)
            <div class="item-row">
                <span><strong>Contact:</strong> {{ $vente->contact_client }}</span>
            </div>
            @endif
        </div>

        <!-- Articles -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Article</th>
                    <th class="text-right">Qté</th>
                    <th class="text-right">Prix</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lignes as $ligne)
                <tr>
                    <td>{{ $ligne->produit->nom }}</td>
                    <td class="text-right">{{ $ligne->quantite }}</td>
                    <td class="text-right">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">{{ number_format($ligne->sous_total, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totaux -->
        <div class="total-row">
            <div class="item-row">
                <span><strong>SOUS-TOTAL:</strong></span>
                <span class="amount">{{ number_format($vente->montant_total, 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="item-row">
                <span><strong>MONTANT RÉGLÉ:</strong></span>
                <span class="amount">{{ number_format($vente->montant_regle, 0, ',', ' ') }} FCFA</span>
            </div>
            @if($vente->montant_du > 0)
            <div class="item-row">
                <span><strong>MONTANT DÛ:</strong></span>
                <span class="amount">{{ number_format($vente->montant_du, 0, ',', ' ') }} FCFA</span>
            </div>
            @endif
            <div class="item-row">
                <span><strong>MODE DE PAIEMENT:</strong></span>
                <span class="amount">{{ ucfirst($vente->mode_paiement) }}</span>
            </div>
        </div>

        @if($vente->remarques)
        <div class="item-row">
            <span><strong>Remarques:</strong> {{ $vente->remarques }}</span>
        </div>
        @endif

        <!-- QR Code -->
        <div class="qr-code">
            <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" 
                 alt="QR Code du reçu" style="max-width: 150px;">
            <p style="margin: 5px 0; font-size: 10px;">Scannez pour vérifier ce reçu</p>
        </div>

        <!-- Pied de page -->
        <div class="receipt-footer">
            <p style="margin: 5px 0;"><strong>Merci pour votre achat !</strong></p>
            <p style="margin: 5px 0;">Garantie: 12 mois sur tous les produits</p>
            <p style="margin: 5px 0;">Échange sous 14 jours avec ticket</p>
            <p style="margin: 5px 0;">Reçu généré le {{ now()->format('d/m/Y à H:i') }}</p>
        </div>
    </div>
</body>
</html>