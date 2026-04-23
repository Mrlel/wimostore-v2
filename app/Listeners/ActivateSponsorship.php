<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Parrainage;

class ActivateSponsorship
{
    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        $user = $event->user;

        // Vérifier si l'utilisateur est un filleul
        if ($user->parrain_id) {
            $parrainage = Parrainage::where('filleul_id', $user->id)
                                    ->where('statut', 'en_attente')
                                    ->first();

            if ($parrainage) {
                $parrainage->update([
                    'statut' => 'actif',
                    'recompense_parrain' => 500,
                    'recompense_filleul' => 500,
                    'recompense_attribuee_at' => now(),
                ]);
            }
        }
    }
}