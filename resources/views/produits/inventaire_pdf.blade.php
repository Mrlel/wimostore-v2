<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaire - PDF</title>
    <style>
        /* Styles de base pour l'impression en noir et blanc */
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 15px;
            color: #000;
        }

        .content {
            max-width: 800px;
            margin: 0 auto;
        }

        /* En-tête du document */
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 10px;
            border-bottom: 1px solid #000;
        }

        .header h1 {
            font-size: 28px;
            margin: 0;
            font-weight: 300;
        }

        .header h2 {
            font-size: 16px;
            margin: 5px 0 0 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .meta {
            font-size: 10px;
            margin-top: 15px;
            color: #555;
        }

        /* Sections d'information et de résumé */
        .info-section {
            margin-bottom: 30px;
            font-size: 14px;
        }

        .info-section h3 {
            font-size: 15px;
            margin-bottom: 10px;
            text-decoration: underline;
        }
        
        .info-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* Tableau principal avec bordures noires */
        .table-container {
            margin-bottom: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            border: 1px solid black; /* Bordure extérieure du tableau */
        }

        th, td {
            padding: 10px 5px;
            text-align: left;
            border: 1px solid black; /* Bordures de toutes les cellules */
        }

        th {
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #f2f2f2; /* Fond légèrement gris pour les en-têtes */
        }

        .text-end {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .empty-message {
            text-align: center;
            font-style: italic;
            color: #777;
        }

        /* Récapitulatif */
        .summary-stats {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: bold;
        }

        /* Pied de page */
        .footer {
            text-align: center;
            font-size: 10px;
            color: #555;
            padding-top: 20px;
            border-top: 1px solid #000;
        }

        .footer-stats {
            display: flex;
            justify-content: space-between;
        }

        /* Assurer le noir et blanc pour l'impression */
        @media print {
            body {
                background-color: #fff !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            .content, .header, .table-container, .footer {
                page-break-inside: avoid;
            }
            th, td {
                background-color: #fff !important;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="header">
            <h1>{{ auth()->user()->cabine->nom_cab ?? 'NOM DE L\'ENTREPRISE' }}</h1>
            <h2>Inventaire du Stock</h2>
            <div class="meta">
                Document généré le {{ \Carbon\Carbon::parse($generatedAt ?? now())->format('d/m/Y à H:i') }}
            </div>
        </div>

        <!-- @if(!empty($search) || !empty($etat_stock))
        <div class="info-section">
            <h3>Critères de Filtrage Appliqués</h3>
            <ul>
                @if(!empty($search))
                    <li>Recherche textuelle : "{{ $search }}"</li>
                @endif
                @if(!empty($etat_stock))
                    <li>État du stock : {{ ucfirst($etat_stock) }}</li>
                @endif
            </ul>
        </div>
        @endif -->

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 8%">N°</th>
                        <th style="width: 28%">Description</th>
                        <th style="width: 18%">Catégorie</th>
                        <th style="width: 15%">Marque</th>
                        <th style="width: 22%">Prix</th>
                        <th style="width: 8%">Quantité</th>
                        <th style="width: 8%">Seuil</th>
                        <th style="width: 10%">État</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produits ?? [] as $produit)
                        @php
                            $etat = $produit->quantite_stock <= 0 ? 'rupture' : 
                                   ($produit->quantite_stock <= $produit->seuil_alerte ? 'faible' : 'ok');
                        @endphp
                        <tr>
                            <td class="text-center">{{ sprintf('%03d', $loop->iteration) }}</td>
                            <td>{{ $produit->nom }}</td>
                            <td>{{ $produit->categorie->nom ?? 'Non classé' }}</td>
                            <td>{{ $produit->marque ?? '-' }}</td>
                            <td class="text-end">{{ number_format($produit->prix_vente, 0, ',', ' ') }}</td>
                            <td class="text-end">{{ number_format($produit->quantite_stock, 0, ',', ' ') }}</td>
                            <td class="text-end">{{ number_format($produit->seuil_alerte, 0, ',', ' ') }}</td>
                            <td class="text-center">
                                @if($etat === 'rupture')
                                    Rupture
                                @elseif($etat === 'faible')
                                    Stock Faible
                                @else
                                    Disponible
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-message">
                                Aucun produit ne correspond aux critères de recherche.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($produits) && count($produits) > 0)
        <div class="info-section">
            <h3>Récapitulatif de l'Inventaire</h3>
            @php
                $total_produits = count($produits);
                $produits_rupture = collect($produits)->filter(function($p) { return $p->quantite_stock <= 0; })->count();
                $produits_faible = collect($produits)->filter(function($p) { return $p->quantite_stock > 0 && $p->quantite_stock <= $p->seuil_alerte; })->count();
                $produits_ok = $total_produits - $produits_rupture - $produits_faible;
            @endphp
            <div class="summary-stats">
                <div>Produits en rupture de stock : <strong>{{ $produits_rupture }}</strong></div>
                <div>Produits en stock faible : <strong>{{ $produits_faible }}</strong></div>
                <div>Produits disponibles : <strong>{{ $produits_ok }}</strong></div>
            </div>
        </div>
        @endif
    </div>

    <div class="footer">
        <div class="footer-stats">
            <div class="footer-left">
                Nombre total de produits répertoriés : <strong>{{ isset($produits) ? count($produits) : 0 }}</strong>
            </div>
            <div class="footer-right">
                Page 1 sur 1
            </div>
        </div>
    </div>
</body>
</html>