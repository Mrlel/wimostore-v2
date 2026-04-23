<?php

namespace App\Http\Controllers;

use App\Models\Mouvement;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MouvementController extends Controller
{

 public function reapprovisionner(Request $request, Produit $produit): RedirectResponse
{
    $validated = $request->validate([
        'quantite' => 'required|integer|min:1',
    ]);

    $produit->increment('quantite_stock', $validated['quantite']);

    // Enregistrer le mouvement de stock
    Mouvement::create([
        'produit_id' => $produit->id,
        'type' => 'entree',
        'quantite' => $validated['quantite'],
        'remarque' => 'Réapprovisionnement',
        'user_id' => auth()->id(),
        'cabine_id' => auth()->user()->cabine_id,
    ]);

    return redirect()
        ->route('mouvements.index')
        ->with('success', 'Stock réapprovisionné avec succès.');
}


    public function index(Request $request): View
    {
        $query = Mouvement::with(['produit', 'user'])
        ->where('cabine_id', auth()->user()->cabine_id);
        
        // Filtres
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        
        if ($request->has('produit') && $request->produit != '') {
            $query->where('produit_id', $request->produit);
        }

        $mouvements = $query->orderBy('created_at', 'desc')->paginate(30);
        $produits = Produit::where('cabine_id', auth()->user()->cabine_id)->get();

        return view('mouvements.index', compact('mouvements', 'produits'));
    }

    public function create(Request $request ): View
    {
        $query = Mouvement::with(['produit', 'user']);
        
        // Filtres
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        
        if ($request->has('produit') && $request->produit != '') {
            $query->where('produit_id', $request->produit);
        }

        $mouvements = $query->orderBy('created_at', 'desc')->paginate(30);
        $produits = Produit::where('actif', true)->where('cabine_id', auth()->user()->cabine_id)->orderBy('nom', 'asc')->get();
        return view('mouvements.create', compact('produits','mouvements'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'type' => 'required|in:entree,sortie',
            'quantite' => 'required|integer|min:1',
            'remarque' => 'nullable|string'
        ]);

        $produit = Produit::find($validated['produit_id']);

        // Vérification stock pour les sorties
        if ($validated['type'] === 'sortie' && $produit->quantite_stock < $validated['quantite']) {
            return back()->with('error', 'Stock insuffisant pour cette sortie.')
                        ->withInput();
        }

        // Ajuster le stock
        if ($validated['type'] === 'entree') {
            $produit->increment('quantite_stock', $validated['quantite']);
        } else {
            $produit->decrement('quantite_stock', $validated['quantite']);
        }

        // Créer le mouvement
        Mouvement::create([
            'produit_id' => $validated['produit_id'],
            'type' => $validated['type'],
            'quantite' => $validated['quantite'],
            'remarque' => $validated['remarque'],
            'user_id' => auth()->id(),
            'cabine_id' => auth()->user()->cabine_id
        ]);

        return redirect()->route('mouvements.index')
            ->with('success', 'Mouvement enregistré avec succès.');
    }

    public function show(Mouvement $mouvement): View
    {
        $mouvement->load(['produit', 'user']);
        return view('mouvements.show', compact('mouvement'));
    }

    public function destroy(Mouvement $mouvement): RedirectResponse
    {
        // Annuler l'effet du mouvement sur le stock
        $produit = $mouvement->produit;
        
        if ($mouvement->type === 'entree') {
            $produit->decrement('quantite_stock', $mouvement->quantite);
        } else {
            $produit->increment('quantite_stock', $mouvement->quantite);
        }

        $mouvement->delete();

        return redirect()->route('mouvements.index')
            ->with('success', 'Mouvement supprimé et stock ajusté.');
    }
}