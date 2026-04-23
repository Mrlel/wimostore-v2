<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CategorieController extends Controller
{
    public function index(): View
{
    $categories = Categorie::withCount('produits')
        ->where('cabine_id', Auth::user()->cabine_id)
        ->orderBy('nom')
        ->get();
        
    return view('categories.index', compact('categories'));
}

    public function create(): View
    {
        return view('categories.create');
    }

 public function store(Request $request): RedirectResponse
    {
        // 🔐 VALIDATION RENFORCÉE
        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
                'min:2',
                'regex:/^[a-zA-Z0-9\s\-_àâäéèêëïîôöùûüçÀÂÄÉÈÊËÏÎÔÖÙÛÜÇ&@°+]+$/u'
            ],
        ], [
            'nom.regex' => 'Le nom ne peut contenir que des lettres, chiffres, espaces et les caractères spéciaux autorisés (-_&@°+).',
            'nom.min' => 'Le nom doit contenir au moins 2 caractères.',
        ]);

        // 🔐 CRÉATION SÉCURISÉE (Eloquent protège SQL)
        Categorie::create([
            'nom' => $validated['nom'],
            'cabine_id' => Auth::user()->cabine_id
        ]);

        // 🔐 JOURNALISATION
        \Log::channel('security')->info('Nouvelle catégorie créée', [
            'user_id' => Auth::id(),
            'cabine_id' => Auth::user()->cabine_id,
            'nom_categorie' => $validated['nom'],
            'ip' => $request->ip()
        ]);

        return redirect()->back()->with('success', 'Catégorie créée avec succès.');
    }

    public function edit($id){
        $categorie = Categorie::findOrFail($id);
        return view('categories.edit', compact('categorie'));
    }
    public function update(Request $request, Categorie $categorie): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,' . $categorie->id . ',id,cabine_id,' . Auth::user()->cabine_id,
        ]);
    
        // Ajouter la vérification de sécurité
        if ($categorie->cabine_id !== Auth::user()->cabine_id) {
            abort(403, 'Accès non autorisé');
        }
    
        $categorie->update($validated);
    
        return redirect()->route('categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Categorie $categorie): RedirectResponse
    {
        // Vérifier que la catégorie appartient à la cabine de l'utilisateur
        if ($categorie->cabine_id !== Auth::user()->cabine_id) {
            abort(403, 'Accès non autorisé');
        }
    
        if ($categorie->produits()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer: la catégorie contient des produits.');
        }
    
        $categorie->delete();
    
        return redirect()->back()
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}