<?php
namespace App\Http\Controllers;

use App\Models\Cabine;
use App\Models\Vente;
use App\Models\Produit;
use App\Models\Abonnement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use carbon\carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class CabineController extends Controller
{


    public function toggleCabine(Cabine $cabine)
    {
        if($cabine->type_compte === 'admin'){
            return back()->with('error', "Les comptes de type 'admin' ne peuvent pas être activés ou désactivés.");
        }
        $cabine->update(['est_actif' => !$cabine->est_actif]);

        $message = $cabine->est_actif 
            ? "Cabine {$cabine->nom_cab} activée avec succès" 
            : "Cabine {$cabine->nom_cab} désactivée avec succès";

        return back()->with('success', $message);
    }

    public function updateCabine(Request $request, $id)
    {
        $cabine = Cabine::findOrFail($id);
    
        // 🔒 Interdire la modification d’un compte admin existant
        if ($cabine->type_compte === 'admin') {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', "Les comptes de type 'admin' ne peuvent pas être modifiés.");
        }
    
        // ✅ Validation des données
        $validated = $request->validate([
            'nom_cab'          => 'required|string|max:255',
            'localisation'     => 'required|string|max:255',
            'type_compte'      => 'required|string|in:admin,illimite,standard',
            'max_utilisateurs' => 'required|integer|min:1',
        ]);
    
        // 🔐 Empêcher qu’un compte non-admin devienne admin
        if ($validated['type_compte'] === 'admin') {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', "Impossible de transformer une cabine standard ou illimitée en compte admin.");
        }
    
        try {
            // 🧩 Mise à jour de la cabine
            $cabine->update($validated);
            $cabine->refresh();
    
            // ⚙️ Mise à jour ou création de l’abonnement associé
            $cabine->abonnements()->updateOrCreate(
                ['cabine_id' => $cabine->id],
                [
                    'date_debut' => Carbon::now(),
                    'date_fin'   => in_array($cabine->type_compte, ['admin', 'illimite'])
                                    ? null
                                    : Carbon::now()->addMonth(),
                    'statut'     => 'actif',
                    'montant'    => 0,
                ]
            );
    
            return redirect()
                ->route('admin.dashboard')
                ->with('success', "Cabine {$cabine->nom_cab} mise à jour avec succès.");
    
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_cab' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'type_compte' => 'required|string|max:255|in:admin,illimite,standard',
            'max_utilisateurs' => 'required|integer|min:1',
        ]);
    
        // Générer un code unique pour la cabine
        $validated['code'] = strtoupper(uniqid('BTQ-'));
    
        $cabine = Cabine::create($validated);
    
        // Créer un abonnement en fonction du type de compte
        Abonnement::create([
            'cabine_id'   => $cabine->id,
            'date_debut'  => Carbon::now(),
            'date_fin'    => in_array($cabine->type_compte, ['admin', 'illimite']) ? null : Carbon::now()->addDays(20),
            'statut'      => 'actif',
            'montant'     => 0,
        ]);
        
    
        return redirect()->back()->with('success', "Cabine {$cabine->nom_cab} créée avec succès");
    }
    



    public function getCabineUsers(Cabine $cabine)
    {
        $users = $cabine->users()->latest()->get();
        return response()->json($users);
    }



    public function destroy($id)
    {
            
    if (Auth::user()->role !== 'superadmin') {
        abort(403, 'Action non autorisée');
    }
        $cabine = Cabine::findOrFail($id);

        try {

            if($cabine->type_compte == 'admin'){
                return back()->with('error', 'Impossible de supprimé un compte administrateur');
            }
            // Si tu veux aussi supprimer les abonnements liés :
            $cabine->abonnements()->delete();
            $cabine->delete();

            return back()->with('success', "Cabine {$cabine->nom_cab} supprimée avec succès");
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $cabine = Cabine::with('abonnements', 'users')->findOrFail($id);
        $ventes = Vente::where('cabine_id', $id)->get();
        $produits = Produit::where('cabine_id', $id)->get();
        return view('cabines.show', compact('cabine','ventes','produits'));
    }

    public function downloadQr(Cabine $cabine)
    {
        $url = $cabine->public_url;
        $png = QrCode::format('svg')->size(300)->margin(1)->generate($url);

        $filename = 'qr_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $cabine->code) . '.svg';
        return response($png)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }



    public function edit($id)
    {
        $cabine = Cabine::findOrFail($id);
        return view('cabines.edit', compact('cabine'));
    }

    public function userProfil()
    {
        return view('cabines.profil');
    }
    
}
