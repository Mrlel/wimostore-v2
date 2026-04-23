<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Vente - {{ $vente->numero_vente }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="/Wim.png" type="image/x-icon">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;600&display=swap');

        body {
            font-family: "Roboto Mono", monospace;
            background: #f3f4f6;
            margin: 0;
            padding: 20px;
        }

        /* Container global */
        .page-container {
            padding: 32px 16px;
        }

        /* Receipt Box */
        .receipt-container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }

        /* TEXT */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .text-sm { font-size: 14px; }
        .text-xs { font-size: 12px; }
        .text-muted { color: #6b7280; }
        .font-bold { font-weight: 600; }

        /* HEADER */
        .receipt-header {
            text-align: center;
            border-bottom: 2px dashed black;
            padding-bottom: 16px;
            margin-bottom: 16px;
        }

        /* FOOTER */
        .receipt-footer {
            text-align: center;
            border-top: 2px dashed black;
            padding-top: 16px;
            margin-top: 16px;
            font-size: 12px;
            color: #6b7280;
        }

        /* FLEX SYSTEM (remplace Tailwind) */
        .flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .align-center { align-items: center; }

        .w-60 { width: 60%; }
        .w-20 { width: 20%; }
        .w-40 { width: 40%; }

        /* Article Row */
        .item-row {
            display: flex;
            border-bottom: 1px dotted black;
            padding: 8px 0;
            font-size: 14px;
        }

        .total-row {
            border-top: 2px solid black;
            padding-top: 12px;
            font-weight: 600;
            font-size: 16px;
        }

        /* QR Code */
        .qr-code {
            width: 100px;
            height: 100px;
            margin: 16px auto;
            background: #f9fafb;
            padding: 8px;
            border-radius: 6px;
            text-align: center;
        }

        /* BUTTON STYLES */
        .btn {
            padding: 10px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            width: 100%;
        }
        .btn-black { background:black;color:white; }
        .btn-green { background:#16a34a;color:white; }
        .btn-green:hover { background:#15803d; }
        .btn-blue { background:#2563eb;color:white; }
        .btn-blue:hover { background:#1d4ed8; }
        .btn-yellow { background:#fbbf24;color:white; }
        .btn-yellow:hover { background:#f59e0b; }

        /* Card */
        .share-box {
            background: #f3f4f6;
            padding: 16px;
            border-radius: 8px;
            margin-top: 16px;
        }

        /* Hidden */
        .hidden { display:none; }

        /* PRINT */
        @media print {
            body {
                width: 80mm;
                padding: 0;
                margin: 0;
                background: white !important;
            }
            .page-container {
                padding: 0 !important;
            }
            .receipt-container {
                width: 80mm !important;
                max-width: 80mm !important;
                padding: 0;
                margin: 0;
                box-shadow: none !important;
            }
            .no-print { display: none !important; }

            .receipt-container > div {
                padding: 0 5px;
            }

            .qr-code svg {
                width: 120px !important;
                height: 120px !important;
            }
        }
    </style>
</head>

<body>

<div class="page-container">
    <div class="receipt-container">

        <!-- HEADER -->
        <div class="receipt-header">
            <h4 class="font-bold" style="font-size:20px;">{{ $vente->cabine->nom_cab }}</h4>
            <p class="text-sm text-muted">{{ $vente->cabine->localisation }}</p>
        </div>

        <!-- INFO -->
        <div style="margin-bottom: 16px;">
            <div class="flex justify-between text-sm">
                <div><span class="font-bold">Date:</span> {{ $vente->created_at->format('d/m/Y') }}</div>
                <div><span class="font-bold">Heure:</span> {{ $vente->created_at->format('H:i') }}</div>
            </div>
            <div class="text-sm" style="margin-top: 4px;">
                <span class="font-bold">N° Reçu:</span> {{ $vente->numero_vente }}
            </div>
        </div>

        <!-- ARTICLES -->
        <div style="margin-bottom: 16px;">
            <div class="item-row font-bold">
                <div class="w-60">Articles</div>
                <div class="w-20 text-center">Qte</div>
                <div class="w-20 text-right">Total</div>
            </div>

            @foreach($vente->lignes as $ligne)
            <div class="item-row">
                <div class="w-60">{{ $ligne->produit->nom }}</div>
                <div class="w-20 text-center">{{ $ligne->quantite }}</div>
                <div class="w-20 text-right">{{ number_format($ligne->sous_total) }} FCFA</div>
            </div>
            @endforeach
        </div>

        <!-- TOTAL SECTION -->
        <div style="margin-bottom:16px;">
            <div class="flex total-row">
                <div class="w-60">TOTAL</div>
                <div class="w-40 text-right">{{ number_format($vente->montant_total) }} FCFA</div>
            </div>

            <div class="flex text-sm" style="margin-top:6px;">
                <div class="w-60">Montant réglé</div>
                <div class="w-40 text-right">{{ number_format($vente->montant_regle) }} FCFA</div>
            </div>

            @if($vente->montant_du > 0)
            <div class="flex text-sm" style="margin-top:6px;color:red;">
                <div class="w-60">Montant dû</div>
                <div class="w-40 text-right">{{ number_format($vente->montant_du) }} FCFA</div>
            </div>
            @endif

            <div class="flex text-sm" style="margin-top:6px;">
                <div class="w-60">Paiement</div>
                <div class="w-40 text-right">{{ $vente->mode_paiement }}</div>
            </div>
        </div>

        <!-- QR CODE -->
        <div class="qr-code">
            @if(isset($qrCode))
                {!! QrCode::size(100)->generate($cabine->public_url) !!}
            @endif
        </div>

        <!-- FOOTER -->
        <div class="receipt-footer">Merci pour votre achat !</div>

        @if(Auth::user())
        <!-- ACTION BUTTONS -->
        <div class="no-print" style="margin-top: 20px;">

            <button onclick="window.print()" class="btn btn-black">🖨 Imprimer sur ticket</button>

            <div class="share-box">
                <h5 class="font-bold text-sm" style="margin-bottom:8px;">Partager avec le client</h5>

                <button class="btn btn-green" onclick="generateAndShareLink()">📤 Générer & Partager le lien</button>

                <p class="text-xs text-center text-muted" style="margin-top:6px;">
                    Lien public pour consultation du reçu
                </p>

                <div id="generatedLinkContainer" class="hidden" style="margin-top:10px;">
                    <div class="flex align-center" style="gap:6px;">
                        <input id="publicLink" class="text-sm" style="flex:1;padding:8px;border:1px solid #d1d5db;border-radius:6px;" readonly>
                        <button class="btn btn-yellow" style="width:auto" onclick="copyPublicLink()">
                            <i class="bi bi-clipboard"></i> Copier
                        </button>
                    </div>

                    <div class="flex" style="gap:8px;margin-top:8px;">
                        <button onclick="shareViaWhatsApp()" class="btn btn-green">WhatsApp</button>
                        <button onclick="shareViaSMS()" class="btn btn-blue">SMS</button>
                    </div>
                </div>
            </div>

        </div>
        @endif
    </div>
</div>

<script>
function generateAndShareLink() {
    const publicLink = "{{ route('recu.public', $vente) }}";
    document.getElementById('publicLink').value = publicLink;
    document.getElementById('generatedLinkContainer').classList.remove('hidden');
}

function copyPublicLink() {
    const input = document.getElementById('publicLink');
    input.select();
    document.execCommand('copy');
    alert("Lien copié !");
}

function shareViaWhatsApp() {
    const link = document.getElementById('publicLink').value;
    window.open(`https://wa.me/?text=${encodeURIComponent("Voici votre reçu : " + link)}`);
}

function shareViaSMS() {
    const link = document.getElementById('publicLink').value;
    window.location.href = `sms:?body=${encodeURIComponent("Votre reçu : " + link)}`;
}
</script>

</body>
</html>
