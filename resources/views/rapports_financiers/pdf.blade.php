<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Financier – {{ $rapport->cabine->nom ?? 'Entreprise' }}</title>
    <style>
        /* ----------  PARAMÈTRES GÉNÉRAUX  ---------- */
        @page { margin: 2cm 1.8cm 2.5cm 1.8cm; size: A4; }
        body{
            font-family: "Times New Roman", serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
        }
        h1,h2,h3{ margin: 0; font-weight: normal; }
        table{ width: 100%; border-collapse: collapse; }
        .text-right{ text-align: right; }
        .mono{ font-family: "Courier New", monospace; letter-spacing: -.3pt; }

        /* ----------  EN-TÊTE  ---------- */
 /* En-tête du document */
        .header {
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
        }

        .company-info {
            flex: 1;
        }

        .company-name {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .company-address {
            font-size: 10px;
            color: #333;
            line-height: 1.6;
        }

        .report-info {
            text-align: right;
            flex: 1;
        }

        .report-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .report-period {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 10px;
            padding: 8px 12px;
            display: inline-block;
        }

        .report-details {
            font-size: 9px;
            color: #666;
            margin-top: 8px;
        }

        .company{ font-size: 14pt; font-weight: 700; letter-spacing: .5pt; }
        .address{ font-size: 8pt; color: #444; margin-top: 4pt; }
        .report-title{ font-size: 18pt; font-weight: 700; letter-spacing: 1pt; }
        .period{
            display: inline-block;
            margin-top: 6pt;
            padding: 4pt 8pt;
            font-size: 9pt;
            font-weight: 600;
        }
        .meta{ font-size: 7pt; color: #666; margin-top: 6pt; }

        /* ----------  SECTIONS  ---------- */
        .section{ margin-bottom: 22pt; page-break-inside: avoid; }
        .section-title{
            font-size: 11pt;
            font-weight: 700;
            text-transform: uppercase;
            padding-bottom: 3pt;
            margin-bottom: 10pt;
            letter-spacing: .5pt;
        }

        /* ----------  KPI  ---------- */
        .kpi-grid{
            display: table;
            width: 100%;
            table-layout: fixed;
            border-spacing: 12pt 0;
            margin: 0 -12pt;
        }
        .kpi-cell{
            display: table-cell;

            padding: 10pt;
            text-align: center;
        }
        .kpi-label{ font-size: 8pt; text-transform: uppercase; letter-spacing: .5pt; }
        .kpi-val{
            font-size: 14pt;
            font-weight: 700;
            margin: 4pt 0 2pt 0;
        }
        .kpi-pct{ font-size: 8pt; color: #555; }

        /* ----------  TABLEAU  ---------- */
        .financial-table td{ padding: 5pt 6pt; }
        .financial-table .cat td{
            background: #000;
            color: #fff;
            font-size: 8pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5pt;
        }
        .financial-table .sub td{ padding-left: 20pt; font-size: 9pt; }
        .financial-table .total td{
            background: #f2f2f2;
            font-weight: 700;
            border-top: 1pt solid #000;
            border-bottom: 1pt solid #000;
        }
        .financial-table .net td{
            background: #000;
            color: #fff;
            font-size: 11pt;
            font-weight: 700;
        }

        /* ----------  MÉTRIQUES 4 COL  ---------- */
        .metrics{
            display: table;
            width: 100%;
            table-layout: fixed;
            border-spacing: 8pt 0;
            margin: 0 -8pt;
        }
        .metric-cell{
            display: table-cell;
            text-align: center;
            border: 1pt solid #000;
            padding: 8pt 4pt;
        }
        .metric-label{ font-size: 7pt; text-transform: uppercase; color: #444; }
        .metric-val{ font-size: 12pt; font-weight: 700; margin-top: 3pt; }

        /* ----------  PAIEMENTS / ANALYSE  ---------- */
        .simple-list{
            border: 1pt solid #000;
            padding: 8pt 10pt;
        }
        .simple-list .row{
            display: flex;
            justify-content: space-between;
            padding: 4pt 0;
            border-bottom: 1pt solid #ddd;
        }
        .simple-list .row:last-child{ border: none; }

        /* ----------  PIED  ---------- */
        .footer{
            margin-top: 30pt;
            border-top: 1pt solid #000;
            padding-top: 12pt;
            page-break-inside: avoid;
        }
        .stamp{
            background: #000;
            color: #fff;
            text-align: center;
            padding: 6pt;
            font-size: 8pt;
            font-weight: 700;
            letter-spacing: .5pt;
            margin-bottom: 16pt;
        }
        .sign-area{
            display: flex;
            justify-content: space-between;
            margin: 20pt 0 10pt 0;
        }
        .sign{
            width: 45%;
            text-align: center;
            padding-top: 40pt;
            border-top: 1pt solid #000;
            font-size: 8pt;
            font-weight: 600;
        }
        .footnote{
            text-align: center;
            font-size: 7pt;
            color: #666;
            font-style: italic;
            margin-top: 4rem;
        }
    </style>
</head>

<body>
    <!-- EN-TÊTE -->
       <!-- En-tête -->
    <div class="header">
        <div class="company-info">
            <div class="company-name">{{ $rapport->cabine->nom_cab ?? 'Nom de l\'Entreprise' }}</div>
            <div class="company-address">{{ $rapport->cabine->localisation ?? 'Adresse' }}</div>
        </div>
        <div class="report-info">
            <div class="report-title">RAPPORT FINANCIER</div>
            <div class="report-period">
                {{ $rapport->date_debut->format('d/m/Y') ?? '01/01/2025' }} - {{ $rapport->date_fin->format('d/m/Y') ?? '31/01/2025' }}
            </div>
            <div class="report-details">
                Généré le {{ now()->format('d/m/Y à H:i') }}<br>
                Par {{ $rapport->user->nom ?? 'Utilisateur' }}
            </div>
        </div>
    </div>

    <!-- KPI -->
    <div class="section">
        <div class="kpi-grid">
            <div class="kpi-cell">
                <div class="kpi-label">Chiffre d’affaires</div>
                <div class="kpi-val mono">{{ number_format($rapport->chiffre_affaires_total ?? 0, 0, ',', ' ') }} FCFA</div>
            </div>
            <div class="kpi-cell">
                <div class="kpi-label">Marge brute</div>
                <div class="kpi-val mono">{{ number_format($rapport->marge_brute ?? 0, 0, ',', ' ') }} FCFA</div>
                <div class="kpi-pct">{{ number_format($rapport->taux_marge_brute ?? 0, 1) }} %</div>
            </div>
            <div class="kpi-cell">
                <div class="kpi-label">Résultat net</div>
                <div class="kpi-val mono">{{ number_format($rapport->marge_nette ?? 0, 0, ',', ' ') }} FCFA</div>
                <div class="kpi-pct">{{ number_format($rapport->taux_marge_nette ?? 0, 1) }} %</div>
            </div>
        </div>
    </div>

    <!-- COMTE DE RÉSULTAT -->
    <div class="section">
        <div class="section-title">Compte de résultat</div>
        <table class="financial-table">
            <tr class="total"><td>Chiffre d’affaires total</td><td class="text-right mono">{{ number_format($rapport->chiffre_affaires_total ?? 0, 0, ',', ' ') }} FCFA</td></tr>
            <tr class="total"><td>Marge brute</td><td class="text-right mono">{{ number_format($rapport->marge_brute ?? 0, 0, ',', ' ') }} FCFA</td></tr>

            <tr class="cat"><td colspan="2">Charges d’exploitation</td></tr>
            @foreach(['loyer'=>'Loyer','electricite'=>'Électricité','eau'=>'Eau','internet'=>'Internet','maintenance'=>'Maintenance','autres_charges'=>'Autres charges'] as $k=>$v)
                @if(($rapport->$k ?? 0) > 0)
                    <tr class="sub"><td>{{ $v }}</td><td class="text-right mono">{{ number_format($rapport->$k, 0, ',', ' ') }} FCFA</td></tr>
                @endif
            @endforeach
            @php
                $totCharge = ($rapport->loyer + $rapport->electricite + $rapport->eau + $rapport->internet + $rapport->maintenance + $rapport->autres_charges) ?? 0;
            @endphp
            <tr class="total"><td>Total charges d’exploitation</td><td class="text-right mono">{{ number_format($totCharge, 0, ',', ' ') }} FCFA</td></tr>

            <tr class="net"><td>RÉSULTAT NET</td><td class="text-right mono">{{ number_format($rapport->marge_nette ?? 0, 0, ',', ' ') }} FCFA</td></tr>
        </table>
    </div>

    <!-- INDICATEURS COMMERCIAUX
    <div class="section">
        <div class="section-title">Indicateurs commerciaux</div>
        <div class="metrics">
            <div class="metric-cell">
                <div class="metric-label">Ventes</div>
                <div class="metric-val mono">{{ $rapport->nombre_ventes ?? 0 }}</div>
            </div>
            <div class="metric-cell">
                <div class="metric-label">Articles vendus</div>
                <div class="metric-val mono">{{ $rapport->nombre_produits_vendus ?? 0 }}</div>
            </div>
            <div class="metric-cell">
                <div class="metric-label">Panier moyen</div>
                <div class="metric-val mono">{{ number_format($rapport->panier_moyen ?? 0, 0, ',', ' ') }} F</div>
            </div>
            <div class="metric-cell">
                <div class="metric-label">Articles / vente</div>
                <div class="metric-val mono">{{ number_format($rapport->produit_moyen_vendu ?? 0, 1) }}</div>
            </div>
        </div>
    </div> -->

    <!-- ENCAISSEMENTS -->
    @if(($rapport->ventes_especes + $rapport->ventes_carte + $rapport->ventes_mobile + $rapport->ventes_virement + $rapport->ventes_autre) > 0)
    <div class="sec">
        <div class="section-title">Répartition des encaissements</div>
        <div class="simple-list">
            @foreach(['especes'=>'Espèces','carte'=>'Carte bancaire','mobile'=>'Mobile money','virement'=>'Virement','autre'=>'Autres'] as $k=>$v)
                @if(($rapport->{'ventes_'.$k} ?? 0) > 0)
                    <div class="row">
                        <span>{{ $v }}</span>
                        <span class="mono">{{ number_format($rapport->{'ventes_'.$k}, 0, ',', ' ') }} FCFA</span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
        <div class="footnote">
            Document confidentiel – {{ $rapport->cabine->nom_cab ?? 'Entreprise' }} – {{ now()->year }}
        </div>
</body>
</html>