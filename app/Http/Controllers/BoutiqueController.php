<?php

namespace App\Http\Controllers;

use App\Models\Cabine;
use App\Models\CabinePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Visits;
use App\Models\User;

class BoutiqueController extends Controller
{
    public function Ma_boutique()
    {

        $gestionnaires = User::where('cabine_id', Auth::user()->cabine_id)
            ->where('role', 'user')
            ->get();
        $produits = Produit::where('cabine_id', Auth::user()->cabine_id)->get();
        $boutiques = CabinePage::where('cabine_id', Auth::user()->cabine_id)->first();
    
        $nb_produits_publies = Produit::where('cabine_id', Auth::user()->cabine_id)
            ->where('publier', true)
            ->count();
            
        $nb_produits_non_publies = Produit::where('cabine_id', Auth::user()->cabine_id)
            ->where('publier', false)
            ->count();
    
        $nb_visites = $boutiques?->visites ?? 0;

        
    $today = now()->format('Y-m-d');
    
        return view('Ma_boutique.dashboard', compact('boutiques', 'produits', 'gestionnaires'))
            ->with(['nb_produits_publies' => $nb_produits_publies, 'nb_visites' => $nb_visites])
            ->with(['nb_produits_non_publies' => $nb_produits_non_publies]);
    }


    public function visites(){
        $boutiques = CabinePage::where('cabine_id', auth()->user()->cabine_id)->first();
        $today = now()->format('Y-m-d');
    
    // Variables séparées
    $visitsToday = Visits::whereDate('visited_at', $today)->where('cabine_id', auth()->user()->cabine_id)->count();
    $uniqueVisitorsToday = Visits::whereDate('visited_at', $today)
                              ->distinct('ip_address')
                              ->count('ip_address');
    $visitsThisWeek = Visits::where('visited_at', '>=', now()->subWeek())->where('cabine_id', auth()->user()->cabine_id)->count();
    $uniqueVisitorsWeek = Visits::where('visited_at', '>=', now()->subWeek())
                             ->distinct('ip_address')
                             ->count('ip_address');
    $visitsThisMonth = Visits::where('visited_at', '>=', now()->subMonth())->where('cabine_id', auth()->user()->cabine_id)->count();
    $popularPages = Visits::select('url')
                       ->selectRaw('COUNT(*) as count')
                       ->groupBy('url')
                       ->orderBy('count', 'DESC')
                       ->limit(10)
                       ->get();

    // Calcul de l'évolution des 7 derniers jours
    $last7Days = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = now()->subDays($i)->format('Y-m-d');
        $count = Visits::whereDate('visited_at', $date)->where('cabine_id', auth()->user()->cabine_id)->count();
        $last7Days[$date] = $count;
    }
        $visites = Visits::where('cabine_id', auth()->user()->cabine_id)->get();
        return view('Ma_boutique.visites', compact('visites', 'boutiques', 'visitsToday', 'uniqueVisitorsToday', 'visitsThisWeek', 'uniqueVisitorsWeek', 'visitsThisMonth', 'popularPages', 'last7Days'));
    }



    public function Ma_boutique_create(){
        return view('Ma_boutique.create');
    }

    public function Ma_boutique_success(){
        $boutique = CabinePage::where('cabine_id', Auth::user()->cabine_id)->first();
        return view('Ma_boutique.success', compact('boutique'));
    }

    public function Ma_boutique_store(Request $request){
        $validated = $request->validate([
            'logo'        => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'nom_site'    => 'required|string|max:255',
            'titre'       => 'required|string|max:255',
            'sous_titre'  => 'required|string|max:255',
            'description' => 'required|string',
            'banniere'    => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'telephone' => [
                'required',
                'string',
                'max:20',
               'regex:/^[\d\s\-\+\(\)]+$/',
            ],
            'whatsapp'    =>  [
                'required',
                'string',
                'max:20',
               'regex:/^(0[25789][0-9]{8}|3[0-9]{2}[0-9]{6,9})$/'
            ],
            'email'       => 'nullable|email|max:255',
            'facebook'    => 'nullable|url|max:255',
            'instagram'   => 'nullable|url|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
        ]);

        if ($request->hasFile('banniere')) {
            $path = $request->file('banniere')->store('bannieres', 'public');
            $validated['banniere'] = $path;
        }

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        CabinePage::create([
            'cabine_id'   => Auth::user()->cabine_id,
            'logo'        => $validated['logo'],
            'nom_site'    => $validated['nom_site'],
            'titre'       => $validated['titre'],
            'sous_titre'  => $validated['sous_titre'],
            'description' => $validated['description'],
            'banniere'    => $validated['banniere'],
            'telephone'   => $validated['telephone'],
            'whatsapp'    => $validated['whatsapp'],
            'email'       => $validated['email'],
            'facebook'    => $validated['facebook'],
            'instagram'   => $validated['instagram'],
            'latitude'    => $validated['latitude'],
            'longitude'   => $validated['longitude'],
            'est_publiee' => 1
        ]);

        return redirect()->route('Ma_boutique.success')->with('boutique_url', auth()->user()->cabine->public_url ?? '');
    }
    
    public function Ma_boutique_edit(){
        $boutiques = CabinePage::where('cabine_id', Auth::user()->cabine_id)->first();
        return view('Ma_boutique.edit', compact('boutiques'));
    }


    public function Ma_boutique_update(Request $request, CabinePage $boutique){
        $validated = $request->validate([
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'nom_site'    => 'required|string|max:255',
            'titre'       => 'required|string|max:255',
            'sous_titre'  => 'required|string|max:255',
            'description' => 'required|string',
            'banniere'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'telephone'   => 'required|string|max:20',
            'whatsapp'    => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'facebook'    => 'nullable|url|max:255',
            'instagram'   => 'nullable|url|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'est_publiee' => 'sometimes|boolean',
        ]);
    
        // ✅ Gestion mise à jour BANNIÈRE avec suppression ancienne
        if ($request->hasFile('banniere')) {
            // Supprimer l'ancienne si elle existe
            if ($boutique->banniere && Storage::disk('public')->exists($boutique->banniere)) {
                Storage::disk('public')->delete($boutique->banniere);
            }
            $validated['banniere'] = $request->file('banniere')->store('bannieres', 'public');
        } else {
            $validated['banniere'] = $boutique->banniere;
        }
    
        // ✅ Gestion mise à jour LOGO avec suppression ancien
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($boutique->logo && Storage::disk('public')->exists($boutique->logo)) {
                Storage::disk('public')->delete($boutique->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        } else {
            $validated['logo'] = $boutique->logo;
        }
    
        // ✅ Checkbox publication
        $validated['est_publiee'] = $request->boolean('est_publiee');
    
        // ✅ Appliquer mise à jour
        $boutique->update($validated);
    
        return redirect()->route('Ma_boutique')->with('success', 'Page mise à jour avec succès');
    }
    




    public function index()
    {
        $pages = CabinePage::whereHas('cabine')->get();

        return view('cabine_pages.index', compact('pages'));
    }

    public function create()
    {
        // Afficher uniquement les cabines qui n'ont pas encore de pages configurées
        $cabines = Cabine::doesntHave('pages')->get();
        return view('cabine_pages.create', compact('cabines'));
    }

public function edit(CabinePage $cabine_page)
{
    $this->authorize('update', $cabine_page);

    // Nécessaire pour le <select> des cabines dans le formulaire partagé
    $cabines = Cabine::all();

    return view('cabine_pages.edit', compact('cabine_page', 'cabines'));
}
public function store(Request $request)
{
    $validated = $request->validate([
        'cabine_id'   => 'required|exists:cabines,id',
        'logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        'nom_site'    => 'required|string|max:255',
        'titre'       => 'required|string|max:255',
        'sous_titre'  => 'required|string|max:255',
        'description' => 'required|string',
        'banniere'    => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        'telephone'   => 'required|string|max:20',
        'whatsapp'    => 'nullable|string|max:20',
        'email'       => 'nullable|email|max:255',
        'facebook'    => 'nullable|url|max:255',
        'instagram'   => 'nullable|url|max:255',
        'latitude'    => 'nullable|numeric',
        'longitude'   => 'nullable|numeric',
        'est_publiee' => 'nullable|boolean',
    ]);

    if ($request->hasFile('banniere')) {
        $path = $request->file('banniere')->store('bannieres', 'public');
        $validated['banniere'] = $path;
    }

    if ($request->hasFile('logo')) {
        $path = $request->file('logo')->store('logos', 'public');
        $validated['logo'] = $path;
    }

    // Check for duplicate
    if (CabinePage::where('cabine_id', $validated['cabine_id'])
                  ->where('titre', $validated['titre'])
                  ->exists()) {
        return redirect()->route('cabine_pages.index')->with('error', 'Page déjà existante');
    }

    // Create the record
    CabinePage::create($validated);

    return redirect()->route('cabine_pages.index')->with('success', 'Page créée avec succès');
}



    public function update(Request $request, CabinePage $cabine_page)
    {
        $this->authorize('update', $cabine_page);

        $validated = $request->validate([
            'cabine_id'   => 'required|exists:cabines,id',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'nom_site'    => 'required|string|max:255',
            'titre'       => 'required|string|max:255',
            'sous_titre'  => 'required|string|max:255',
            'description' => 'required|string',
            'banniere'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'telephone'   => 'required|string|max:20',
            'whatsapp'    => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'facebook'    => 'nullable|url|max:255',
            'instagram'   => 'nullable|url|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'est_publiee' => 'sometimes|boolean',
        ]);

        // Normaliser le booléen checkbox (non envoyé => false)
        $validated['est_publiee'] = $request->boolean('est_publiee');

        // Upload image si présente
        if ($request->hasFile('banniere')) {
            $path = $request->file('banniere')->store('bannieres', 'public');
            $validated['banniere'] = $path;
        }

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        $cabine_page->update($validated);

        return redirect()->route('cabine_pages.index')->with('success', 'Page mise à jour');
    }

    public function destroy(CabinePage $cabine_page)
    {
        $this->authorize('delete', $cabine_page);

        $cabine_page->delete();

        return redirect()->route('cabine_pages.index')->with('success', 'Page supprimée');
    }


    public function showPublic($code)
    {
        $cabine = Cabine::where('code', $code)->firstOrFail();
    
        $hasActiveSubscription = $cabine->abonnements()
            ->where('statut', 'actif')
            ->where(function ($q) {
                $q->whereNull('date_fin')
                  ->orWhere('date_fin', '>=', Carbon::today()->endOfDay());
            })
            ->exists();
    
        if (!$hasActiveSubscription) {
            abort(403, 'Cette boutique est momentanément indisponible');
        }
    
        $page = CabinePage::where('cabine_id', $cabine->id)
            ->where('est_publiee', true)
            ->orderByDesc('id')
            ->firstOrFail();
    
        $produits = Produit::with('categorie')
            ->where('cabine_id', $cabine->id)
            ->where('publier', true)
            ->get();
        
        $categories = Categorie::where('cabine_id', $cabine->id)->get();
            
        return view('cabines.public.accueil', compact('cabine', 'page', 'produits', 'categories'));
    }

    public function showPublicProduits($code)
    {
        $cabine = Cabine::where('code', $code)->firstOrFail();
    
        $hasActiveSubscription = $cabine->abonnements()
            ->where('statut', 'actif')
            ->where(function ($q) {
                $q->whereNull('date_fin')
                  ->orWhere('date_fin', '>=', Carbon::today()->endOfDay());
            })
            ->exists();
    
        if (!$hasActiveSubscription) {
            abort(403, 'Cette boutique est momentanément indisponible');
        }
    
        $page = CabinePage::where('cabine_id', $cabine->id)
            ->where('est_publiee', true)
            ->orderByDesc('id')
            ->firstOrFail();
    
        $produits = Produit::with('categorie')
            ->where('cabine_id', $cabine->id)
            ->where('publier', true)
            ->get();
    
        $categories = Categorie::where('cabine_id', $cabine->id)->get();
    
        return view('cabines.public.produits', compact('cabine', 'page', 'produits', 'categories'));
    }

    public function showDetailsProduit($code, $id)
    {
        $cabine = Cabine::where('code', $code)->firstOrFail();
    
        $hasActiveSubscription = $cabine->abonnements()
            ->where('statut', 'actif')
            ->where(function ($q) {
                $q->whereNull('date_fin')
                  ->orWhere('date_fin', '>=', Carbon::today()->endOfDay());
            })
            ->exists();
    
        if (!$hasActiveSubscription) {
            abort(403, 'Cette boutique est momentanément indisponible');
        }
    
        $page = CabinePage::where('cabine_id', $cabine->id)
            ->where('est_publiee', true)
            ->orderByDesc('id')
            ->firstOrFail();
    
        $produit = Produit::with('categorie')
            ->where('cabine_id', $cabine->id)
            ->where('publier', true)
            ->findOrFail($id);
    
        $produitsSimilaires = Produit::with('categorie')
            ->where('cabine_id', $cabine->id)
            ->where('publier', true)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();

        $categories = Categorie::where('cabine_id', $cabine->id)->get();

        return view('cabines.public.details_produit', compact('cabine', 'page', 'produit', 'produitsSimilaires','categories'));
    }
}
