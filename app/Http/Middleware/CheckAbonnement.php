<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckAbonnement
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login.form');
        }

        $cabine = $user->cabine ?? null;

        // Laisser passer si pas de cabine (au cas où) ou si paiement / auth / logout
        if (!$cabine) {
            return $next($request);
        }

        // Autoriser routes de paiement et de lecture publique
        if ($request->routeIs([
            'paiements.form',
            'paiements.checkout',
            'paiements.notify',
            'paiements.success',
            'paiements.cancel',
            'logout',
            'profile.show',
            'off',
            'guide',
        ])) {
            return $next($request);
        }

        // Debug temporaire
        $abonnements = $cabine->abonnements()->get();
        $lastAbonnement = $cabine->abonnements()->latest('date_fin')->first();
        $isActive = $cabine->abonnementActif();
        
        Log::info('Debug abonnement', [
            'cabine_id' => $cabine->id,
            'abonnements_count' => $abonnements->count(),
            'last_abonnement' => $lastAbonnement ? [
                'id' => $lastAbonnement->id,
                'date_debut' => $lastAbonnement->date_debut,
                'date_fin' => $lastAbonnement->date_fin,
                'statut' => $lastAbonnement->statut,
            ] : null,
            'is_active' => $isActive,
        ]);

        // Autoriser si abonnement actif
        if ($isActive) {
            return $next($request);
        }

        // Sinon, rediriger vers page d'info/blocage
        return redirect()->route('comptebloque')
            ->with('error', "Votre abonnement a expiré. Veuillez contacter le support pour réactiver votre compte.");
    }
}
