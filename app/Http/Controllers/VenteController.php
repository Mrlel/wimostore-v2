<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\LigneVente;
use App\Models\Produit;
use App\Models\Mouvement;
use App\Models\Categorie;
use App\Models\NotificationStock;
use App\Services\VenteService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Services\ReceiptService;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;

class VenteController extends Controller
{
    protected $venteService;

    public function __construct(VenteService $venteService)
    {
        $this->venteService = $venteService;
    }

    public function index(Request $request): View
    {
        $query = Vente::with(['user', 'lignes'])
            ->where('cabine_id', auth()->user()->cabine_id);
        
        // Filtres
        if ($request->has('date_debut') && $request->date_debut != '') {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        
        if ($request->has('date_fin') && $request->date_fin != '') {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        // Filtre par utilisateur
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $ventes = $query->orderBy('created_at', 'desc')->paginate(30);
        
        // Calcul CA mensuel (applique le filtre utilisateur si présent)
        $debutMois = Carbon::now()->startOfMonth();
        $finMois = Carbon::now()->endOfMonth();
        $caQuery = Vente::where('cabine_id', auth()->user()->cabine_id)
            ->whereBetween('created_at', [$debutMois, $finMois]);
        if ($request->filled('user_id')) {
            $caQuery->where('user_id', $request->user_id);
        }
        $caMensuel = $caQuery->sum('montant_total');

        // Liste des utilisateurs de la cabine pour le filtre
        $users = User::where('cabine_id', auth()->user()->cabine_id)
            ->orderBy('nom')
            ->get(['id', 'nom']);
      
        return view('ventes.index', compact('ventes', 'caMensuel', 'users'));
    }

    public function create(): View
    {
        $produits = Produit::with('images')
                          ->where('actif', true)
                          ->where('quantite_stock', '>', 0)
                          ->where('cabine_id', auth()->user()->cabine_id)
                          ->orderBy('nom', 'asc')
                          ->get()
                          ->map(function ($produit) {
                              $produit->image = $produit->latestImagePath();
                              return $produit;
                          });
        
        return view('ventes.create', compact('produits'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Décoder le JSON du champ caché 'lignes'
        $lignes = json_decode($request->input('lignes'), true);
        $request->merge(['lignes' => $lignes]);

        $request->validate([
            // ...autres règles...
            'lignes' => 'required|array|min:1',
            'lignes.*.produit_id' => 'required|exists:produits,id',
            'lignes.*.quantite' => 'required|integer|min:1',
            'lignes.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        try {
            $vente = $this->venteService->creerVente($request->all());
            
                    
            return redirect()->route('ventes.show', $vente)
                ->with('success', 'Vente enregistrée avec succès.');
                
                if ($vente) {
                    // Générer le reçu
                    $receiptService = new ReceiptService();
                    $receiptService->generateReceipt($vente);
            
                    // Rediriger vers la page de reçu
                    return redirect()->route('receipts.show', $vente->receipt_hash)
                        ->with('success', 'Vente enregistrée avec succès.');
                }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())
                        ->withInput();
        }

    }

    public function edit(Vente $vente)
{
    // Vérifier que la vente appartient à la cabine de l'utilisateur
    if ($vente->cabine_id !== auth()->user()->cabine_id) {
        abort(403, 'Accès non autorisé');
    }

    $vente->load(['lignes.produit', 'user']);
    
    // Charger les produits disponibles pour la recherche
    $produits = Produit::with('images')
                      ->where('actif', true)
                      ->where('cabine_id', auth()->user()->cabine_id)
                      ->orderBy('nom', 'asc')
                      ->get()
                      ->map(function ($produit) {
                          $produit->image = $produit->latestImagePath();
                          return $produit;
                      });
    
    return view('ventes.edit', compact('vente', 'produits'));
}

public function update(Request $request, Vente $vente)
{
    // Vérifier les permissions
    if ($vente->cabine_id !== auth()->user()->cabine_id) {
        abort(403, 'Accès non autorisé');
    }

    // Décoder JSON des lignes (si envoyé comme champ caché JSON)
    $lignesInput = $request->input('lignes');
    if (is_string($lignesInput)) {
        $decoded = json_decode($lignesInput, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $request->merge(['lignes' => $decoded]);
        }
    }

    $request->validate([
        'type_client' => 'required|in:particulier,professionnel,divers',
        'nom_client' => 'nullable|string|max:255',
        'contact_client' => 'nullable|string|max:255',
        'montant_regle' => 'required|numeric|min:0',
        'mode_paiement' => 'required|in:especes,carte,mobile,virement,autre',
        'remarques' => 'nullable|string',
        'lignes' => 'required|array|min:1',
        'lignes.*.id' => 'nullable|exists:ligne_ventes,id',
        'lignes.*.produit_id' => 'required|exists:produits,id',
        'lignes.*.quantite' => 'required|integer|min:1',
        'lignes.*.prix_unitaire' => 'required|numeric|min:0',
    ]);

    try {
        DB::beginTransaction();

        // Mettre à jour les informations de base
        $vente->update($request->only([
            'type_client', 'nom_client', 'contact_client',
            'montant_regle', 'mode_paiement', 'remarques'
        ]));

        $montantTotal = 0;
        $lignesTraitees = [];

        foreach ($request->lignes as $ligneData) {
            // Ligne existante : mise à jour et ajustement stock
            if (!empty($ligneData['id'])) {
                $ligne = LigneVente::lockForUpdate()->with('produit')->find($ligneData['id']);
                if (!$ligne) {
                    throw new \Exception("Ligne introuvable (id: {$ligneData['id']}).");
                }

                $ancienneQte = $ligne->quantite;
                $nouvelleQte = (int) $ligneData['quantite'];
                $difference = $nouvelleQte - $ancienneQte;

                if ($difference !== 0) {
                    // Si on augmente, vérifier stock disponible
                    if ($difference > 0) {
                        $stockDisponible = $ligne->produit->quantite_stock;
                        if ($stockDisponible < $difference) {
                            throw new \Exception("Stock insuffisant pour: {$ligne->produit->nom}. Disponible: {$stockDisponible}, demandé en plus: {$difference}");
                        }
                    }
                    // Appliquer ajustement stock (décrément si difference>0, incrément si difference<0)
                    $ligne->produit->decrement('quantite_stock', $difference);
                    Mouvement::create([
                        'produit_id' => $ligne->produit_id,
                        'type' => $difference > 0 ? 'sortie' : 'entree',
                        'quantite' => abs($difference),
                        'remarque' => 'Ajustement vente #' . $vente->numero_vente,
                        'user_id' => auth()->id(),
                        'cabine_id' => auth()->user()->cabine_id
                    ]);
                }

                $sousTotal = $nouvelleQte * (float) $ligneData['prix_unitaire'];
                $ligne->update([
                    'quantite' => $nouvelleQte,
                    'prix_unitaire' => (float) $ligneData['prix_unitaire'],
                    'sous_total' => $sousTotal
                ]);

                $montantTotal += $sousTotal;
                $lignesTraitees[] = $ligne->id;
            } else {
                // Nouvelle ligne : création + vérification stock
                $produit = Produit::lockForUpdate()->find($ligneData['produit_id']);
                if (!$produit) {
                    throw new \Exception('Produit introuvable : ' . ($ligneData['produit_id'] ?? ''));
                }

                $quantite = (int) $ligneData['quantite'];
                if ($quantite <= 0) {
                    throw new \Exception("Quantité invalide pour le produit {$produit->nom}.");
                }

                if ($produit->quantite_stock < $quantite) {
                    throw new \Exception("Stock insuffisant pour {$produit->nom}. Disponible : {$produit->quantite_stock}.");
                }

                $prixUnitaire = (float) $ligneData['prix_unitaire'];
                $prixAchat = (float) $produit->prix_achat;
                $sousTotal = $prixUnitaire * $quantite;

                $nouvelleLigne = LigneVente::create([
                    'vente_id' => $vente->id,
                    'produit_id' => $produit->id,
                    'quantite' => $quantite,
                    'prix_unitaire' => $prixUnitaire,
                    'prix_achat' => $prixAchat,
                    'sous_total' => $sousTotal,
                ]);

                // Ajuster le stock
                $produit->decrement('quantite_stock', $quantite);
                Mouvement::create([
                    'produit_id' => $produit->id,
                    'type' => 'sortie',
                    'quantite' => $quantite,
                    'remarque' => 'Vente #' . $vente->numero_vente,
                    'user_id' => auth()->id(),
                    'cabine_id' => auth()->user()->cabine_id,
                ]);

                $montantTotal += $sousTotal;
                $lignesTraitees[] = $nouvelleLigne->id;
            }
        }

        // Supprimer les lignes non traitées (retirées par l'utilisateur)
        $lignesASupprimer = $vente->lignes()->whereNotIn('id', $lignesTraitees)->get();

        foreach ($lignesASupprimer as $ligne) {
            // Remettre le stock
            $ligne->produit->increment('quantite_stock', $ligne->quantite);

            // Enregistrer le mouvement
            Mouvement::create([
                'produit_id' => $ligne->produit_id,
                'type' => 'entree',
                'quantite' => $ligne->quantite,
                'remarque' => 'Annulation vente #' . $vente->numero_vente,
                'user_id' => auth()->id(),
                'cabine_id' => auth()->user()->cabine_id
            ]);

            $ligne->delete();
        }

        // Mettre à jour le montant total
        $vente->update(['montant_total' => $montantTotal]);

        // Vérification du montant réglé
        if ($request->montant_regle < $montantTotal) {
            throw new \Exception("Le montant réglé doit être supérieur ou égal au montant total.");
        }

        DB::commit();

        return redirect()->route('ventes.show', $vente)
            ->with('success', 'Vente modifiée avec succès.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Erreur lors de la modification: ' . $e->getMessage())
                    ->withInput();
    }
}

    public function show(Vente $vente): View
    {
        $vente->load(['lignes.produit', 'user']);
        return view('ventes.show', compact('vente'));
    }

    public function destroy(Vente $vente): RedirectResponse
    {
        // Annuler la vente et réapprovisionner le stock
        foreach ($vente->lignes as $ligne) {
            $ligne->produit->increment('quantite_stock', $ligne->quantite);
        }

        $vente->delete();

        return redirect()->route('ventes.index')
            ->with('success', 'Vente annulée et stock réapprovisionné.');
    }

    public function voirRecuPublic(Vente $vente )
{
    // Charger les relations nécessaires
    $vente->load(['lignes.produit', 'cabine']);
    
    // Générer le QR code
    $qrContent = "N° Vente: " . $vente->numero_vente . "\n";
    $qrContent .= "Montant: " . number_format($vente->montant_total) . " FCFA\n";
    $qrContent .= "Date: " . $vente->created_at->format('d/m/Y H:i');

    $qrCode = QrCode::format('svg')
        ->size(150)
        ->errorCorrection('H')
        ->generate($qrContent);
    
    return view('ventes.recu-public', [
        'vente' => $vente,
        'qrCode' => $qrCode,
        'cabine' => $vente->cabine
    ]);
}

public function imprimer(Vente $vente)
{
    $cabine = auth()->user()->cabine;
    $vente->load(['lignes.produit', 'user', 'cabine']);
    
    $qrContent = "N° Vente: " . $vente->numero_vente . "\n";
    $qrContent .= "Montant: " . number_format($vente->montant_total) . " FCFA\n";
    $qrContent .= "Date: " . $vente->created_at->format('d/m/Y H:i');

    $qrCode = QrCode::format('svg')
        ->size(150)
        ->errorCorrection('H')
        ->generate($qrContent);
    
    if(request()->has('download')) {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('ventes.imprimer', [
            'vente' => $vente,
            'qrCode' => $qrCode
        ]);
        
        return $pdf->download('recu-' . $vente->numero_vente. '.pdf');
    }
    
    return view('ventes.imprimer', [
        'vente' => $vente,
        'qrCode' => $qrCode,
        'cabine' => $cabine
    ]);
}
}