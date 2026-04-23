<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Vente - {{ $vente->receipt_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .receipt-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #000;
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
            font-size: 0.8em;
        }
        .item-row {
            border-bottom: 1px dotted #ccc;
            padding: 5px 0;
        }
        .total-row {
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 10px;
        }
        .qr-code {
            text-align: center;
            margin: 15px 0;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
            }
            .receipt-container {
                border: none;
                padding: 0;
                max-width: 100%;
            }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="receipt-container">
            <!-- En-tête -->
            <div class="receipt-header">
                <h4 class="fw-bold mb-1">{{ $vente->cabine->nom_cab ?? 'DIGITAL SOLUTION' }}</h4>
                <p class="mb-1">{{ $vente->cabine->localisation ?? 'Abidjan, Côte d\'Ivoire' }}</p>
                <p class="mb-1">{{ $vente->cabine->code ?? 'DSP' }}</p>
            </div>

            <!-- Informations de la vente -->
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <strong>Reçu:</strong> {{ $vente->receipt_number }}
                    </div>
                    <div class="col-6 text-end">
                        <strong>Date:</strong> {{ $vente->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-12">
                        <strong>Vendeur:</strong> {{ $vente->user->name }}
                    </div>
                </div>
                @if($vente->nom_client)
                <div class="row mt-1">
                    <div class="col-12">
                        <strong>Client:</strong> {{ $vente->nom_client }}
                    </div>
                </div>
                @endif
                @if($vente->contact_client)
                <div class="row mt-1">
                    <div class="col-12">
                        <strong>Contact:</strong> {{ $vente->contact_client }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Articles -->
            <div class="mb-3">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Article</th>
                            <th class="text-end">Qté</th>
                            <th class="text-end">Prix</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vente->lignes as $ligne)
                        <tr>
                            <td>{{ $ligne->produit->nom }}</td>
                            <td class="text-end">{{ $ligne->quantite }}</td>
                            <td class="text-end">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                            <td class="text-end">{{ number_format($ligne->sous_total, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totaux -->
            <div class="total-row">
                <div class="row">
                    <div class="col-6">
                        <strong>SOUS-TOTAL:</strong>
                    </div>
                    <div class="col-6 text-end">
                        <strong>{{ number_format($vente->montant_total, 0, ',', ' ') }} FCFA</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <strong>MONTANT RÉGLÉ:</strong>
                    </div>
                    <div class="col-6 text-end">
                        <strong>{{ number_format($vente->montant_regle, 0, ',', ' ') }} FCFA</strong>
                    </div>
                </div>
                @if($vente->montant_du > 0)
                <div class="row">
                    <div class="col-6">
                        <strong>MONTANT DÛ:</strong>
                    </div>
                    <div class="col-6 text-end">
                        <strong>{{ number_format($vente->montant_du, 0, ',', ' ') }} FCFA</strong>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-6">
                        <strong>MODE DE PAIEMENT:</strong>
                    </div>
                    <div class="col-6 text-end">
                        <strong>{{ ucfirst($vente->mode_paiement) }}</strong>
                    </div>
                </div>
            </div>

            @if($vente->remarques)
            <div class="mt-2">
                <strong>Remarques:</strong> {{ $vente->remarques }}
            </div>
            @endif

            <!-- QR Code -->
            <div class="qr-code">
                <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" 
                     alt="QR Code du reçu" class="img-fluid">
                <p class="small text-muted mt-2">Scannez pour vérifier ce reçu</p>
            </div>

            <!-- Pied de page -->
            <div class="receipt-footer">
                <p class="mb-1">Merci pour votre achat !</p>
                <p class="mb-1">Garantie: 12 mois sur tous les produits</p>
                <p class="mb-0">Échange sous 14 jours avec ticket</p>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-3 no-print">
                <div class="d-grid gap-2">
                    <button onclick="window.print()" class="btn btn-warning fw-bold">
                        <i class="bi bi-printer me-1"></i>Imprimer le reçu
                    </button>
                    <a href="{{ route('receipts.download', $vente->receipt_hash) }}" 
                       class="btn btn-outline-dark">
                        <i class="bi bi-download me-1"></i>Télécharger PDF
                    </a>
                    <button onclick="shareReceipt()" class="btn btn-outline-dark">
                        <i class="bi bi-share me-1"></i>Partager
                    </button>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#emailModal">
                        <i class="bi bi-envelope me-1"></i>Envoyer par email
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour l'envoi d'email -->
    <div class="modal fade" id="emailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Envoyer le reçu par email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('receipts.email', $vente->receipt_hash) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fonction de partage
        function shareReceipt() {
            if (navigator.share) {
                navigator.share({
                    title: 'Reçu de vente - {{ $vente->receipt_number }}',
                    text: 'Voici votre reçu d\'achat chez {{ $vente->cabine->nom_cab ?? "DIGITAL SOLUTION" }}',
                    url: window.location.href
                })
                .catch(error => {
                    console.log('Erreur de partage:', error);
                });
            } else {
                // Copier le lien dans le presse-papiers
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Lien copié dans le presse-papiers !');
                });
            }
        }

        // Marquer comme vu
        fetch('{{ route("receipts.viewed", $vente->receipt_hash) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        });

        // Auto-impression si demandée
        @if(request()->has('print'))
        window.onload = function() {
            window.print();
        }
        @endif
    </script>
</body>
</html>
