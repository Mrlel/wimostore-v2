<?php

namespace App\Http\Controllers;

use App\Models\Cabine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CertificationController extends Controller
{
    // Afficher la page d'information sur la certification
    public function index()
    {
        $cabine = Auth::user()->cabine;
        
        if (!$cabine) {
            return redirect()->route('dashboard')
                ->with('error', 'Aucune cabine associée à votre compte.');
        }
        
        $statistiques = $cabine->statistiques_certification;
        
        return view('certification.index', compact('cabine', 'statistiques'));
    }
    
    // Demander la certification (vérification automatique) // Demander la certification (vérification automatique)
    public function demander()
    {
        $cabine = Auth::user()->cabine;
        
        if (!$cabine) {
            return redirect()->back()
                ->with('error', 'Aucune cabine associée à votre compte.');
        }
        
        if ($cabine->certifier) {
            return redirect()->back()
                ->with('info', 'Votre cabine est déjà certifiée.');
        }
        
        if ($cabine->demanderCertification()) {
            return redirect()->back()
                ->with('success', 'Félicitations ! Votre cabine a été certifiée avec succès.');
        } else {
            return redirect()->back()
                ->with('error', 'Votre cabine ne remplit pas encore les conditions d\'éligibilité pour la certification.');
        }
    
    }


    public function certifierParAdmin($id)
    {
        Gate::authorize('manage-certifications');
        
        $cabine = Cabine::findOrFail($id);
        $cabine->update([
            'certifier' => true,
            'max_utilisateurs' => 10
        ]);

        return redirect()->back()
            ->with('success', 'La cabine a été certifiée avec succès et peut maintenant accueillir jusqu\'à 10 utilisateurs.');
    }

    public function desertifierParAdmin($id)
    {
        Gate::authorize('manage-certifications');
        
        $cabine = Cabine::findOrFail($id);
        $cabine->update([
            'certifier' => false,
            'max_utilisateurs' => 2
        ]);

        return redirect()->back()
            ->with('success', 'Votre cabine a été descertifiée avec succès.');
    }
    
    // Vérifier l'éligibilité (pour l'admin)
    public function verifierEligibilite($id)
    {
        Gate::authorize('manage-certifications');
        
        $cabine = Cabine::findOrFail($id);
        $statistiques = $cabine->statistiques_certification;
        
        return redirect()->back()
            ->with('success', 'Votre cabine a été certifiée avec succès.');
    }
}