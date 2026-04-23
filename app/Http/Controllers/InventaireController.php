<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Vente;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class InventaireController extends Controller
{
    public function details_inventaire(Request $request)
{
    try {
        // Validation des dates
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        // Période par défaut : dernier mois
        $start = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date'))->startOfDay() 
            : Carbon::now()->subMonth()->startOfDay();
        
        $end = $request->input('end_date')   
            ? Carbon::parse($request->input('end_date'))->endOfDay()   
            : Carbon::now()->endOfDay();

        $cabineId = auth()->user()->cabine_id;

        // Statistiques par produit avec gestion des coûts nuls
        $perProduct = DB::table('ligne_ventes')
            ->join('ventes', 'ligne_ventes.vente_id', '=', 'ventes.id')
            ->join('produits', 'ligne_ventes.produit_id', '=', 'produits.id')
            ->select(
                'produits.id',
                'produits.nom',
                'produits.marque',
                'produits.prix_achat',
                'produits.quantite_stock',
                DB::raw('SUM(ligne_ventes.quantite) as total_ventes'),
                DB::raw('SUM(ligne_ventes.quantite * ligne_ventes.prix_unitaire) as chiffre_affaires'),
                DB::raw('SUM(ligne_ventes.quantite * COALESCE(produits.prix_achat, 0)) as cout_achat_total'),
                DB::raw('SUM(ligne_ventes.quantite * ligne_ventes.prix_unitaire) - SUM(ligne_ventes.quantite * COALESCE(produits.prix_achat, 0)) as marge_totale'),
                // Calcul du taux de marge en pourcentage
                DB::raw('CASE 
                    WHEN SUM(ligne_ventes.quantite * COALESCE(produits.prix_achat, 0)) > 0 
                    THEN ROUND(((SUM(ligne_ventes.quantite * ligne_ventes.prix_unitaire) - SUM(ligne_ventes.quantite * COALESCE(produits.prix_achat, 0))) / SUM(ligne_ventes.quantite * COALESCE(produits.prix_achat, 0)) * 100), 2)
                    ELSE 0 
                END as taux_marge')
            )
            ->where('produits.cabine_id', $cabineId)
            ->whereBetween('ventes.created_at', [$start, $end])
            ->groupBy('produits.id', 'produits.nom', 'produits.marque', 'produits.prix_achat', 'produits.quantite_stock')
            ->orderByDesc('total_ventes')
            ->get();

        // Calcul des totaux globaux
        $totalCA = $perProduct->sum('chiffre_affaires');
        $totalVentes = $perProduct->sum('total_ventes');
        $totalMarge = $perProduct->sum('marge_totale');
        $tauxMargeGlobal = $totalCA > 0 ? round(($totalMarge / $totalCA) * 100, 2) : 0;

        // Top / least vendus (en excluant les produits sans vente)
        $produitsAvecVentes = $perProduct->where('total_ventes', '>', 0);
        $topVendus = $produitsAvecVentes->first();
        $moinsVendus = $produitsAvecVentes->last();

        // Évolution des ventes avec données complètes
        $trend = DB::table('ligne_ventes')
            ->join('ventes', 'ligne_ventes.vente_id', '=', 'ventes.id')
            ->join('produits', 'ligne_ventes.produit_id', '=', 'produits.id')
            ->select(
                DB::raw('DATE(ventes.created_at) as date'), 
                DB::raw('SUM(ligne_ventes.quantite) as total_ventes'),
                DB::raw('SUM(ligne_ventes.quantite * ligne_ventes.prix_unitaire) as chiffre_affaires')
            )
            ->where('produits.cabine_id', $cabineId)
            ->whereBetween('ventes.created_at', [$start, $end])
            ->groupBy(DB::raw('DATE(ventes.created_at)'))
            ->orderBy('date')
            ->get();

        // Produits sans vente pour analyse complète
        $produitsIdsAvecVentes = $perProduct->pluck('id');
        $produitsSansVente = \App\Models\Produit::where('cabine_id', $cabineId)
            ->whereNotIn('id', $produitsIdsAvecVentes)
            ->orderBy('nom')
            ->get();

        return view('produits.details_inventaire', [
            'produits'           => $perProduct,
            'produitsSansVente'  => $produitsSansVente,
            'topVendus'          => $topVendus,
            'moinsVendus'        => $moinsVendus,
            'trend'              => $trend,
            'start'              => $start->toDateString(),
            'end'                => $end->toDateString(),
            'totalCA'            => $totalCA,
            'totalVentes'        => $totalVentes,
            'totalMarge'         => $totalMarge,
            'tauxMargeGlobal'    => $tauxMargeGlobal,
            'periodeSelectionnee'=> $this->getPeriodeLabel($start, $end)
        ]);

    } catch (\Exception $e) {
        \Log::error('Erreur dans details_inventaire: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erreur lors du chargement des données.');
    }
}

// Méthode helper pour le libellé de période (CORRIGÉE)
private function getPeriodeLabel($start, $end)
{
    $today = Carbon::today();
    $diff = $start->diffInDays($end);
    
    // Aujourd'hui
    if ($start->isSameDay($today) && $end->isSameDay($today)) {
        return 'Aujourd\'hui';
    }
    
    // Cette semaine
    $startOfWeek = Carbon::now()->startOfWeek();
    $endOfWeek = Carbon::now()->endOfWeek();
    if ($start->isSameDay($startOfWeek) && $end->isSameDay($endOfWeek)) {
        return 'Cette semaine';
    }
    
    // Ce mois
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();
    if ($start->isSameDay($startOfMonth) && $end->isSameDay($endOfMonth)) {
        return 'Ce mois';
    }
    
    // Cette année
    $startOfYear = Carbon::now()->startOfYear();
    $endOfYear = Carbon::now()->endOfYear();
    if ($start->isSameDay($startOfYear) && $end->isSameDay($endOfYear)) {
        return 'Cette année';
    }
    
    // Période personnalisée
    return "Du {$start->format('d/m/Y')} au {$end->format('d/m/Y')}";
}
    
    public function inventaire(Request $request)
    {
        $query = Produit::where('cabine_id', auth()->user()->cabine_id)
            ->with('categorie');

        // Filtre état du stock
        if ($request->etat_stock === 'faible') {
            $query->whereColumn('quantite_stock', '<=', 'seuil_alerte')
                  ->where('quantite_stock', '>', 0);
        } elseif ($request->etat_stock === 'rupture') {
            $query->where('quantite_stock', '<=', 0);
        } elseif ($request->etat_stock === 'ok') {
            $query->whereColumn('quantite_stock', '>', 'seuil_alerte');
        }

        // Barre de recherche (nom, marque, imei)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('marque', 'like', "%$search%")
                  ->orWhere('imei', 'like', "%$search%");
            });
        }

        $produits = $query->orderBy('nom')->get();


        return view('produits.inventaire', compact('produits'));
    }


    public function inventairePdf(Request $request)
    {
        $query = Produit::where('cabine_id', auth()->user()->cabine_id)
            ->with('categorie');

        // Appliquer les mêmes filtres que l'écran
        if ($request->etat_stock === 'faible') {
            $query->whereColumn('quantite_stock', '<=', 'seuil_alerte')
                  ->where('quantite_stock', '>', 0);
        } elseif ($request->etat_stock === 'rupture') {
            $query->where('quantite_stock', '<=', 0);
        } elseif ($request->etat_stock === 'ok') {
            $query->whereColumn('quantite_stock', '>', 'seuil_alerte');
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('marque', 'like', "%$search%")
                  ->orWhere('imei', 'like', "%$search%");
            });
        }

        $produits = $query->orderBy('nom')->get();

        $pdf = Pdf::loadView('produits.inventaire_pdf', [
            'produits'    => $produits,
            'etat_stock'  => $request->input('etat_stock'),
            'search'      => $request->input('search'),
            'generatedAt' => now(),
            'user'        => auth()->user(),
        ])->setPaper('a4', 'portrait');

        $filename = 'inventaire_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }
}
