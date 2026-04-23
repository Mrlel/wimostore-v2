<?php

// app/Http/Controllers/MarketplaceController.php
namespace App\Http\Controllers;

use App\Models\Cabine;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index()
    {
        $cabinesVedettes = Cabine::withCount('produits')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $produitsPopulaires = Produit::with('cabine')
            ->where('quantite_stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $categoriesCabines = Categorie::withCount('produits')
            ->orderBy('produits_count', 'desc')
            ->take(6)
            ->get();

        return view('marketplace.index', compact(
            'cabinesVedettes',
            'produitsPopulaires',
            'categoriesCabines'
        ));
    }

    public function cabines()
    {
        $cabines = Cabine::withCount('produits')
            ->where('is_active', true)
            ->filter(request(['search', 'categorie', 'ville']))
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $villes = Cabine::where('is_active', true)
            ->distinct('ville')
            ->pluck('ville');

        return view('marketplace.cabines', compact('cabines', 'villes'));
    }

    public function categories()
    {
        $categories = Categorie::withCount(['cabines', 'produits'])
            ->orderBy('cabines_count', 'desc')
            ->get();

        return view('marketplace.categories', compact('categories'));
    }

    public function contact()
    {
        return view('marketplace.contact');
    }
    public function panier()
    {
        return view('marketplace.panier');
    }
}

// app/Http/Controllers/CabineController.php
class CabineController extends Controller
{
    public function show($code)
    {
        $cabine = Cabine::with(['produits' => function($query) {
            $query->where('quantite_stock', '>', 0);
        }, 'produits.categorie'])
            ->where('code', $code)
            ->where('is_active', true)
            ->firstOrFail();

        return view('marketplace.cabine', compact('cabine'));
    }

    public function produits($code)
    {
        $cabine = Cabine::where('code', $code)
            ->where('is_active', true)
            ->firstOrFail();

        $produits = $cabine->produits()
            ->with('categorie')
            ->where('quantite_stock', '>', 0)
            ->filter(request(['search', 'categorie']))
            ->paginate(12);

        return view('marketplace.cabine-produits', compact('cabine', 'produits'));
    }
}

// app/Http/Controllers/ProduitController.php
class ProduitController extends Controller
{
    public function show($cabineCode, $produitId)
    {
        $cabine = Cabine::where('code', $cabineCode)
            ->where('is_active', true)
            ->firstOrFail();

        $produit = $cabine->produits()
            ->with('categorie')
            ->findOrFail($produitId);

        $produitsSimilaires = $cabine->produits()
            ->where('id', '!=', $produit->id)
            ->where('categorie_id', $produit->categorie_id)
            ->where('quantite_stock', '>', 0)
            ->take(4)
            ->get();

        return view('marketplace.produit', compact('cabine', 'produit', 'produitsSimilaires'));
    }
}