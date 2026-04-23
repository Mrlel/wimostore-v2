<?php
namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardVendeurController extends Controller
{
 public function dashboard(Request $request)
{
    $user = Auth::user();
    $periode = $request->get('periode', 'aujourdhui');

    $periodes = [
        'aujourdhui' => [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()],
        'semaine' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
        'mois' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
        'annee' => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
    ];

    [$debut, $fin] = $periodes[$periode];

    $ventes = Vente::where('cabine_id', $user->cabine_id)
        ->whereBetween('created_at', [$debut, $fin])
        ->selectRaw('COUNT(*) as total_ventes, SUM(montant_total) as chiffre_affaires')
        ->first();

    $produits_faible_stock = Produit::where('cabine_id', $user->cabine_id)
        ->whereColumn('quantite_stock', '<=', 'seuil_alerte')
        ->where('quantite_stock', '>', 0)
        ->count();

    // 📊 Données pour graphique CA journalier
    $ventesParJour = Vente::where('cabine_id', $user->cabine_id)
        ->whereBetween('created_at', [$debut, $fin])
        ->selectRaw('DATE(created_at) as jour, SUM(montant_total) as total')
        ->groupBy('jour')
        ->orderBy('jour', 'asc')
        ->get();

    // 📊 Données pour graphique stock produits
    $stocks = Produit::where('cabine_id', $user->cabine_id)
        ->selectRaw('nom, quantite_stock')
        ->orderBy('quantite_stock', 'asc')
        ->limit(5)
        ->get();

    return view('dashboard', [
        'periode' => $periode,
        'ventes' => $ventes,
        'ventesParJour' => $ventesParJour,
        'stocks' => $stocks,
        'produits_faible_stock' => $produits_faible_stock
    ]);
}

    
}
