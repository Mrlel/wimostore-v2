<?php

namespace App\Http\Controllers;


use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Cabine;
use App\Models\ProduitImage;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = Produit::with('categorie')->where('cabine_id', Auth::user()->cabine_id)->orderBy('nom', 'asc')->get();
        $categories = Categorie::where('cabine_id', Auth::user()->cabine_id)->orderBy('nom')->get();
            // Calcul de la valeur globale du stock (prix d'achat * quantité)
        $valeur_acquisition = $produits->reduce(function ($carry, $item) {
            $carry += ($item->prix_achat * $item->quantite_stock);
            return $carry;
        }, 0);

           $valeur_revente = $produits->reduce(function ($carry, $item) {
            $carry += ($item->prix_vente * $item->quantite_stock);
            return $carry;
        }, 0);

        return view('produits.index', compact('produits', 'categories', 'valeur_acquisition', 'valeur_revente'));
    }
    public function create(): View
    {
        $categories = Categorie::where('cabine_id', Auth::user()->cabine_id)->get();
        return view('produits.create', compact('categories'));
    }

     public function store(Request $request)
    {

        $request->validate([
            'categorie_id' => ['required', \Illuminate\Validation\Rule::exists('categories', 'id')->where(fn($q) => $q->where('cabine_id', Auth::user()->cabine_id))],
            'nom' => 'required|string|max:255',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:4096',
            'description' => 'nullable|string',
            'marque' => 'nullable|string|max:255',
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0|gte:prix_achat',
            'seuil_alerte' => 'required|integer|min:0',
            'quantite_stock' => 'required|integer|min:0',
            'actif' => 'boolean',
            'publier' => 'boolean'
        ]);

        $produit = Produit::create([
            'categorie_id' => $request->categorie_id,
            'nom' => $request->nom,
            'description' => $request->description,
            'marque' => $request->marque,
            'prix_achat' => $request->prix_achat,
            'prix_vente' => $request->prix_vente,
            'seuil_alerte' => $request->seuil_alerte,
            'quantite_stock' => $request->quantite_stock,
            'actif' => $request->boolean('actif'),
            'publier' => $request->boolean('publier'),
            'cabine_id' => Auth::user()->cabine_id,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('produits', 'public');
                $produit->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('produits.index')->with('success', 'Produit enregistré.');
    }

    public function show(Produit $produit): View
    {
        $produit->load(['categorie', 'cabine', 'mouvements' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }]);

        return view('produits.show', compact('produit'));
    }

    public function edit(Produit $produit): View
    {
        $categories = Categorie::where('cabine_id', Auth::user()->cabine_id)->get();;
        return view('produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, Produit $produit)
    {

        $validated = $request->validate([
            'categorie_id' => ['required', \Illuminate\Validation\Rule::exists('categories', 'id')->where(fn($q) => $q->where('cabine_id', Auth::user()->cabine_id))],
            'nom' => 'required|string|max:255',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:4096',
            'description' => 'nullable|string',
            'marque' => 'nullable|string|max:255',
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0|gte:prix_achat',
            'seuil_alerte' => 'required|integer|min:0',
            'actif' => 'boolean',
            'publier' => 'boolean'
        ]);

        // Supprimer les images marquées pour suppression
        if ($request->has('images_to_delete')) {
            foreach ($request->images_to_delete as $imageId) {
                $image = $produit->images()->find($imageId);
                if ($image) {
                    \Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
        }

        // Remplacement des images si de nouvelles sont fournies
        if ($request->hasFile('images')) {
            // Compter les images existantes restantes
            $remainingImages = $produit->images()->count();
            $newImagesCount = count($request->file('images'));
            
            // Vérifier qu'on ne dépasse pas 3 images au total
            if ($remainingImages + $newImagesCount > 5) {
                return back()->withErrors(['images' => 'Vous ne pouvez pas avoir plus de 3 images au total.']);
            }

            foreach ($request->file('images') as $file) {
                $path = $file->store('produits', 'public');
                $produit->images()->create(['path' => $path]);
            }
        }

        $validated['actif'] = $request->boolean('actif');
        $validated['publier'] = $request->boolean('publier');
        $validated['cabine_id'] = Auth::user()->cabine_id;
        $validated['quantite_stock'] = $produit->quantite_stock; // garder la quantité actuelle

        $produit->update($validated);

        return redirect()->route('produits.index')->with('success', 'Produit mis à jour.');
    }
    

    public function destroyImage(ProduitImage $image): RedirectResponse
    {
        \Storage::disk('public')->delete($image->path);
        $image->delete();
        return redirect()->back()->with('success', 'Image supprimée avec succès.');
    }
    

    public function publier(Produit $produit): RedirectResponse
    {
        $produit->update([
            'publier' => !$produit->publier
        ]);

        return redirect()->back()
            ->with('success', 'Produit publié avec succès.');
    }
    
    public function despublier(Produit $produit): RedirectResponse
    {
        $produit->update([
            'publier' => !$produit->publier
        ]);

        return redirect()->back()
            ->with('success', 'Produit rétiré avec succès.');
    }

    public function destroy(Produit $produit): RedirectResponse
    {
        foreach ($produit->images as $image) {
            \Storage::disk('public')->delete($image->path);
        }
        $produit->images()->delete();
        $produit->delete();

        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }

    public function ajusterStock(Request $request, Produit $produit): RedirectResponse
    {
        $validated = $request->validate([
            'quantite' => 'required|integer',
            'type' => 'required|in:entree,sortie',
            'remarque' => 'nullable|string'
        ]);

        if ($validated['type'] === 'sortie' && $produit->quantite_stock < $validated['quantite']) {
            return back()->with('error', 'Stock insuffisant pour cette sortie.');
        }

        // Ajuster le stock
        if ($validated['type'] === 'entree') {
            $produit->increment('quantite_stock', $validated['quantite']);
        } else {
            $produit->decrement('quantite_stock', $validated['quantite']);
        }

        // Enregistrer le mouvement
        $produit->mouvements()->create([
            'type' => $validated['type'],
            'quantite' => $validated['quantite'],
            'remarque' => $validated['remarque'],
            'user_id' => auth()->id()
        ]);

        return back()->with('success', 'Stock ajusté avec succès.');
    }


}
