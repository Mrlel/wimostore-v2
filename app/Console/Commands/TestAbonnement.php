<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cabine;

class TestAbonnement extends Command
{
    protected $signature = 'test:abonnement';
    protected $description = 'Test abonnement status';


    public function handle()
    {
        $cabines = Cabine::with('abonnements')->get();
        
        foreach ($cabines as $cabine) {
            $this->info("Cabine: {$cabine->nom_cab} (ID: {$cabine->id})");
            $this->info("Abonnements: " . $cabine->abonnements->count());
            
            if ($cabine->abonnements->count() > 0) {
                $last = $cabine->abonnements->sortByDesc('date_fin')->first();
                $this->info("Dernier abonnement: {$last->date_debut} -> {$last->date_fin}");
                $this->info("Statut: {$last->statut}");
            }
            
            $this->info("Abonnement actif: " . ($cabine->abonnementActif() ? 'OUI' : 'NON'));
            $this->info("---");
        }
    }
}
