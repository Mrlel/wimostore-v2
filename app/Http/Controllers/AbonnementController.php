<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Cabine;
use App\Models\User;

class AbonnementController extends Controller
{

     public function userAbonnement(){
        $cabines = Cabine::all();
        $abonnements = Abonnement::with('cabine')->latest('date_fin')->get();
        $users = User::with('cabine')->get();

        return view('admin.abonnements', compact('abonnements','cabines','users'));
    }

    public function renew(Request $request)
    {
        $validated = $request->validate([
            'cabine_id' => ['required','integer','exists:cabines,id'],
            'duree' => ['nullable','integer','min:1'], 
            'montant' => ['required','numeric','min:0'],
            'reference_paiement' => ['nullable','string','max:255'],
        ]);

        $cabineId = (int) $validated['cabine_id'];
        $duree = (int) ($validated['duree'] ?? 31);
        $montant = (float) $validated['montant'];
        $ref = $validated['reference_paiement'] ?? null;

        try {
            $abonnement = Abonnement::where('cabine_id', $cabineId)
                ->orderByDesc('date_fin')
                ->first();

            $today = Carbon::today();

            if (!$abonnement) {
                // Aucun abonnement existant: on en crée un pour respecter la règle “1 par cabine”
                $abonnement = new Abonnement();
                $abonnement->cabine_id = $cabineId;
                $abonnement->date_debut = $today;
                $abonnement->date_fin = (clone $today)->addDays($duree);
                $abonnement->statut = 'actif';
                $abonnement->montant = $montant; // montant du renouvellement initial
                $abonnement->reference_paiement = $ref ?? 'manuel:' . now()->format('YmdHis');
                $abonnement->save();
            } else {
                $isActive = false;
                if ($abonnement->date_fin) {
                    $fin = $abonnement->date_fin instanceof Carbon ? $abonnement->date_fin : Carbon::parse($abonnement->date_fin);
                    $isActive = $abonnement->statut === 'actif' && $fin->endOfDay()->isFuture();
                }

                if ($isActive) {
                    // Prolonger à partir de la date_fin actuelle
                    $base = $abonnement->date_fin instanceof Carbon ? $abonnement->date_fin : Carbon::parse($abonnement->date_fin);
                    $abonnement->date_fin = (clone $base)->addDays($duree);
                } else {
                    // Redémarrer à partir d’aujourd’hui
                    $abonnement->date_debut = $today;
                    $abonnement->date_fin = (clone $today)->addDays($duree);
                }

                // Mettre à jour le même enregistrement
                $abonnement->statut = 'actif';
                // Ici on additionne le montant payé pour conserver le total; si vous préférez remplacer, affectez simplement $montant
                $abonnement->montant = (float) ($abonnement->montant ?? 0) + $montant;
                if ($ref) {
                    $abonnement->reference_paiement = $ref;
                } else {
                    // Marqueur manuel
                    $abonnement->reference_paiement = 'manuel:' . now()->format('YmdHis');
                }
                $abonnement->save();
            }

            return redirect()->back()->with('success', 'Abonnement renouvelé avec succès');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Erreur lors du renouvellement: ' . $e->getMessage());
        }
    }
}
