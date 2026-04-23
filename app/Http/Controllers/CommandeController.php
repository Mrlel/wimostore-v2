<?php

namespace App\Http\Controllers;

use App\Models\Cabine;
use App\Models\CabinePage;
use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Produit;
use App\Models\User;
use App\Notifications\NouvelleCommandeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    // ─── Clé de session par boutique ────────────────────────────────────────
    private function cartKey(string $code): string
    {
        return "panier_{$code}";
    }

    // ─── Ajouter au panier ──────────────────────────────────────────────────
    public function ajouterAuPanier(Request $request, string $code)
    {
        $request->validate([
            'produit_id' => 'required|integer|exists:produits,id',
            'quantite'   => 'required|integer|min:1|max:99',
        ]);

        $produit = Produit::findOrFail($request->produit_id);

        // Vérifier que le produit appartient bien à cette cabine et est publié
        $cabine = Cabine::where('code', $code)->firstOrFail();
        abort_if($produit->cabine_id !== $cabine->id || !$produit->publier, 404);

        $qteDisponible = $produit->quantite_stock;
        abort_if($qteDisponible <= 0, 422, 'Produit en rupture de stock.');

        $key  = $this->cartKey($code);
        $cart = session($key, []);

        $qteActuelle = $cart[$produit->id]['quantite'] ?? 0;
        $nouvelleQte = min($qteActuelle + $request->quantite, $qteDisponible);

        $cart[$produit->id] = [
            'produit_id'   => $produit->id,
            'nom'          => $produit->nom,
            'prix_unitaire'=> (float) $produit->prix_vente,
            'quantite'     => $nouvelleQte,
            'image'        => $produit->images->last()?->path,
        ];

        session([$key => $cart]);

        return response()->json([
            'success' => true,
            'message' => 'Produit ajouté au panier',
            'count'   => array_sum(array_column($cart, 'quantite')),
        ]);
    }

    // ─── Mettre à jour la quantité ──────────────────────────────────────────
    public function mettreAJour(Request $request, string $code)
    {
        $request->validate([
            'produit_id' => 'required|integer',
            'quantite'   => 'required|integer|min:0|max:99',
        ]);

        $key  = $this->cartKey($code);
        $cart = session($key, []);

        if ($request->quantite == 0) {
            unset($cart[$request->produit_id]);
        } elseif (isset($cart[$request->produit_id])) {
            $produit = Produit::find($request->produit_id);
            $cart[$request->produit_id]['quantite'] = min($request->quantite, $produit->quantite_stock ?? 99);
        }

        session([$key => $cart]);

        $total = collect($cart)->sum(fn($l) => $l['prix_unitaire'] * $l['quantite']);

        return response()->json([
            'success' => true,
            'count'   => array_sum(array_column($cart, 'quantite')),
            'total'   => $total,
        ]);
    }

    // ─── Supprimer un article ───────────────────────────────────────────────
    public function supprimerDuPanier(Request $request, string $code)
    {
        $key  = $this->cartKey($code);
        $cart = session($key, []);
        unset($cart[$request->produit_id]);
        session([$key => $cart]);

        return response()->json([
            'success' => true,
            'count'   => array_sum(array_column($cart, 'quantite')),
        ]);
    }

    // ─── Vue panier ─────────────────────────────────────────────────────────
    public function voirPanier(string $code)
    {
        $cabine = Cabine::where('code', $code)->firstOrFail();
        $page   = CabinePage::where('cabine_id', $cabine->id)->firstOrFail();
        $cart   = session($this->cartKey($code), []);
        $total  = collect($cart)->sum(fn($l) => $l['prix_unitaire'] * $l['quantite']);

        return view('cabines.public.panier', compact('cabine', 'page', 'cart', 'total'));
    }

    // ─── Vue checkout ───────────────────────────────────────────────────────
    public function checkout(string $code)
    {
        $cabine = Cabine::where('code', $code)->firstOrFail();
        $page   = CabinePage::where('cabine_id', $cabine->id)->firstOrFail();
        $cart   = session($this->cartKey($code), []);

        if (empty($cart)) {
            return redirect()->route('boutique.panier', $code)
                             ->with('error', 'Votre panier est vide.');
        }

        $total = collect($cart)->sum(fn($l) => $l['prix_unitaire'] * $l['quantite']);

        return view('cabines.public.checkout', compact('cabine', 'page', 'cart', 'total'));
    }

    // ─── Passer la commande ─────────────────────────────────────────────────
    public function passerCommande(Request $request, string $code)
    {
        $request->validate([
            'nom_client'       => 'required|string|max:100',
            'telephone_client' => 'required|string|max:20|regex:/^[\d\s\-\+\(\)]+$/',
            'email_client'     => 'nullable|email|max:150',
            'adresse_livraison'=> 'nullable|string|max:300',
            'notes'            => 'nullable|string|max:500',
            'mode_paiement'    => 'required|in:a_la_livraison,mobile_money,autre',
        ]);

        $cabine = Cabine::where('code', $code)->firstOrFail();
        $cart   = session($this->cartKey($code), []);

        if (empty($cart)) {
            return redirect()->route('boutique.panier', $code)
                             ->with('error', 'Votre panier est vide.');
        }

        DB::beginTransaction();
        try {
            $total = collect($cart)->sum(fn($l) => $l['prix_unitaire'] * $l['quantite']);

            $commande = Commande::create([
                'numero_commande'  => Commande::genererNumero($code),
                'nom_client'       => $request->nom_client,
                'telephone_client' => $request->telephone_client,
                'email_client'     => $request->email_client,
                'adresse_livraison'=> $request->adresse_livraison,
                'notes'            => $request->notes,
                'montant_total'    => $total,
                'mode_paiement'    => $request->mode_paiement,
                'cabine_id'        => $cabine->id,
            ]);

            foreach ($cart as $ligne) {
                LigneCommande::create([
                    'commande_id'   => $commande->id,
                    'produit_id'    => $ligne['produit_id'],
                    'quantite'      => $ligne['quantite'],
                    'prix_unitaire' => $ligne['prix_unitaire'],
                    'sous_total'    => $ligne['prix_unitaire'] * $ligne['quantite'],
                ]);
            }

            DB::commit();
            session()->forget($this->cartKey($code));

            // Notifier tous les utilisateurs de la cabine
            $users = User::where('cabine_id', $cabine->id)->get();
            foreach ($users as $user) {
                $user->notify(new NouvelleCommandeNotification($commande));
            }

            return redirect()->route('boutique.commande.confirmation', [
                'code'   => $code,
                'numero' => $commande->numero_commande,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    // ─── Confirmation ───────────────────────────────────────────────────────
    public function confirmation(string $code, string $numero)
    {
        $cabine   = Cabine::where('code', $code)->firstOrFail();
        $page     = CabinePage::where('cabine_id', $cabine->id)->firstOrFail();
        $commande = Commande::with('lignes.produit')
                            ->where('numero_commande', $numero)
                            ->where('cabine_id', $cabine->id)
                            ->firstOrFail();

        return view('cabines.public.confirmation', compact('cabine', 'page', 'commande'));
    }

    // ─── Suivi commande ─────────────────────────────────────────────────────
    public function suivi(Request $request, string $code)
    {
        $cabine   = Cabine::where('code', $code)->firstOrFail();
        $page     = CabinePage::where('cabine_id', $cabine->id)->firstOrFail();
        $commande = null;

        if ($request->filled('numero')) {
            $commande = Commande::with('lignes.produit')
                ->where('numero_commande', $request->numero)
                ->where('cabine_id', $cabine->id)
                ->first();
        }

        return view('cabines.public.suivi', compact('cabine', 'page', 'commande'));
    }

    // ─── API: contenu panier (JSON) ─────────────────────────────────────────
    public function getPanier(string $code)
    {
        $cart  = session($this->cartKey($code), []);
        $total = collect($cart)->sum(fn($l) => $l['prix_unitaire'] * $l['quantite']);
        $count = array_sum(array_column($cart, 'quantite'));

        return response()->json([
            'items' => array_values($cart),
            'total' => $total,
            'count' => $count,
        ]);
    }

    // ─── API: count panier ──────────────────────────────────────────────────
    public function countPanier(string $code)
    {
        $cart = session($this->cartKey($code), []);
        return response()->json(['count' => array_sum(array_column($cart, 'quantite'))]);
    }

    // ─── Admin: liste commandes ──────────────────────────────────────────────
    public function adminIndex(Request $request)
    {
        $cabineId = auth()->user()->cabine_id;

        $query = Commande::with('lignes')
                         ->where('cabine_id', $cabineId);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('numero_commande', 'like', "%{$s}%")
                  ->orWhere('nom_client', 'like', "%{$s}%")
                  ->orWhere('telephone_client', 'like', "%{$s}%");
            });
        }
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $commandes = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        // Stats rapides
        $stats = [
            'total'          => Commande::where('cabine_id', $cabineId)->count(),
            'en_attente'     => Commande::where('cabine_id', $cabineId)->where('statut', 'en_attente')->count(),
            'en_cours'       => Commande::where('cabine_id', $cabineId)->whereIn('statut', ['confirmee','en_preparation','expediee'])->count(),
            'livrees'        => Commande::where('cabine_id', $cabineId)->where('statut', 'livree')->count(),
            'ca_total'       => Commande::where('cabine_id', $cabineId)->whereNotIn('statut', ['annulee'])->sum('montant_total'),
        ];

        return view('commandes.index', compact('commandes', 'stats'));
    }

    // ─── Admin: détail commande ──────────────────────────────────────────────
    public function adminShow(Commande $commande)
    {
        abort_if($commande->cabine_id !== auth()->user()->cabine_id, 403);
        $commande->load('lignes.produit');

        // Marquer les notifications liées comme lues
        auth()->user()->unreadNotifications()
            ->where('data->commande_id', $commande->id)
            ->update(['read_at' => now()]);

        return view('commandes.show', compact('commande'));
    }

    // ─── Admin: changer statut ───────────────────────────────────────────────
    public function updateStatut(Request $request, Commande $commande)
    {
        abort_if($commande->cabine_id !== auth()->user()->cabine_id, 403);

        $request->validate(['statut' => 'required|in:en_attente,confirmee,en_preparation,expediee,livree,annulee']);
        $commande->update(['statut' => $request->statut]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'statut_label' => $commande->statut_label, 'statut_color' => $commande->statut_color]);
        }

        return back()->with('success', 'Statut mis à jour.');
    }

    // ─── API: nouvelles commandes (polling) ──────────────────────────────────
    public function nouvellesCommandes()
    {
        $cabineId = auth()->user()->cabine_id;
        $count    = auth()->user()->unreadNotifications()
                          ->where('data->type', 'nouvelle_commande')
                          ->count();

        return response()->json(['count' => $count]);
    }
}
