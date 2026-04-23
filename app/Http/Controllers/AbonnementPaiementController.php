<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Paiement;
use App\Models\Cabine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use FedaPay\FedaPay;
use FedaPay\Transaction;

class AbonnementPaiementController extends Controller
{
    const PRIX_MENSUEL = 100; 
    
    /**
     * Afficher la page de renouvellement
     */
    public function renouveler($cabineId)
    {
        $cabine = Cabine::findOrFail($cabineId);
        
        // Récupérer l'ancien abonnement
        $ancienAbonnement = Abonnement::where('cabine_id', $cabineId)
            ->latest()
            ->first();
        
        return view('abonnement.renouvellement', compact('cabine', 'ancienAbonnement'));
    }
    
    /**
     * Initier le renouvellement
     */
    public function initierRenouvellement(Request $request, $cabineId)
    {
        $request->validate([
            'email' => 'required|email',
            'telephone' => 'required|string',
            'nom' => 'required|string'
        ]);
        
        $cabine = Cabine::findOrFail($cabineId);
        
        // Créer le NOUVEL abonnement
        $nouvelAbonnement = Abonnement::create([
            'cabine_id' => $cabineId,
            'date_debut' => now(),
            'date_fin' => now()->addMonth(),
            'statut' => 'en_attente',
            'montant' => self::PRIX_MENSUEL,
            'reference_paiement' => null
        ]);
        
        // Créer le paiement associé
        $paiement = Paiement::create([
            'abonnement_id' => $nouvelAbonnement->id,
            'montant' => self::PRIX_MENSUEL,
            'periode' => 'Renouvellement - ' . now()->format('F Y'),
            'statut' => 'en_attente',
            'provider' => 'fedapay'
        ]);
        
        // Stocker les infos client en session
        session()->put('paiement_' . $paiement->id, [
            'email' => $request->email,
            'telephone' => $request->telephone,
            'nom' => $request->nom
        ]);
        
        return redirect()->route('paiement.checkout', $paiement->id);
    }
    
    /**
     * Afficher la page de paiement FedaPay
     */
    public function checkout($paiementId)
    {
        $paiement = Paiement::with('abonnement.cabine')->findOrFail($paiementId);
        $clientInfo = session()->get('paiement_' . $paiement->id);
        
        if (!$clientInfo) {
            return redirect()->route('cabine.show', $paiement->abonnement->cabine_id)
                ->with('error', 'Session expirée, veuillez recommencer');
        }
        
        if ($paiement->estPaye()) {
            return redirect()->route('abonnement.success', $paiement->abonnement->id);
        }
        
        return view('paiement.fedapay', compact('paiement', 'clientInfo'));
    }
    
    /**
     * Vérifier le paiement après retour FedaPay
     */
    public function verify(Request $request)
    {
        $transactionId = $request->query('transaction_id');
        $paiementId = $request->query('paiement_id');
        
        Log::info('Vérification renouvellement', [
            'transaction_id' => $transactionId,
            'paiement_id' => $paiementId
        ]);
        
        if (!$transactionId || !$paiementId) {
            return redirect()->back()->with('error', 'Informations manquantes');
        }
        
        try {
            FedaPay::setApiKey(env('FEDAPAY_SECRET_KEY'));
            FedaPay::setEnvironment(env('FEDAPAY_ENVIRONMENT', 'sandbox'));
            
            $paiement = Paiement::with('abonnement')->findOrFail($paiementId);
            
            if ($paiement->estPaye()) {
                return redirect()->route('abonnement.success', $paiement->abonnement->id);
            }
            
            $transaction = Transaction::retrieve($transactionId);
            
            if ($transaction->status === 'approved') {
                // Marquer le paiement comme payé
                $paiement->marquerCommePaye($transactionId, $transaction->toArray());
                
                // Activer le nouvel abonnement
                $abonnement = $paiement->abonnement;
                $abonnement->update([
                    'statut' => 'actif',
                    'reference_paiement' => $paiement->reference_paiement
                ]);
                
                // Désactiver l'ancien abonnement s'il existe
                Abonnement::where('cabine_id', $abonnement->cabine_id)
                    ->where('id', '!=', $abonnement->id)
                    ->where('statut', 'actif')
                    ->update(['statut' => 'expiré']);
                
                Log::info('Renouvellement réussi', [
                    'cabine_id' => $abonnement->cabine_id,
                    'nouvel_abonnement' => $abonnement->id
                ]);
                
                session()->forget('paiement_' . $paiement->id);
                
                return redirect()->route('abonnement.success', $abonnement->id);
            } else {
                $paiement->marquerCommeEchoue();
                return redirect()->route('paiement.failed', $paiement->id);
            }
            
        } catch (\Exception $e) {
            Log::error('Erreur vérification: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Erreur lors du paiement');
        }
    }
    
    /**
     * Page de succès
     */
    public function success($abonnementId)
    {
        $abonnement = Abonnement::with('cabine')->findOrFail($abonnementId);
        return view('abonnement.success', compact('abonnement'));
    }
    
    /**
     * Page d'échec
     */
    public function failed($paiementId)
    {
        $paiement = Paiement::with('abonnement.cabine')->findOrFail($paiementId);
        return view('paiement.failed', compact('paiement'));
    }
    
    /**
     * Webhook FedaPay
     */
    public function webhook(Request $request)
    {
        $payload = $request->all();
        Log::info('Webhook reçu', $payload);
        
        if (isset($payload['event']) && $payload['event'] === 'transaction.approved') {
            $transactionId = $payload['data']['entity']['id'] ?? null;
            $metadata = $payload['data']['entity']['custom_metadata'] ?? [];
            $paiementId = $metadata['paiement_id'] ?? null;
            
            if ($transactionId && $paiementId) {
                $paiement = Paiement::find($paiementId);
                if ($paiement && !$paiement->estPaye()) {
                    $paiement->marquerCommePaye($transactionId, ['webhook' => $payload]);
                    
                    $abonnement = $paiement->abonnement;
                    $abonnement->update([
                        'statut' => 'actif',
                        'reference_paiement' => $paiement->reference_paiement
                    ]);
                    
                    // Désactiver l'ancien abonnement
                    Abonnement::where('cabine_id', $abonnement->cabine_id)
                        ->where('id', '!=', $abonnement->id)
                        ->where('statut', 'actif')
                        ->update(['statut' => 'expiré']);
                    
                    Log::info('Webhook: Renouvellement activé');
                }
            }
        }
        
        return response()->json(['status' => 'ok']);
    }
}