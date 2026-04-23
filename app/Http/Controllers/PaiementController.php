<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Abonnement;
use App\Models\MoneyfusionTransaction;
use App\Models\CertificationPaiement;
use Carbon\Carbon;

class PaiementController extends Controller
{
    public function form()
    {
        return view('paiements.form');
    }

    /**
     * Crée une session de paiement d'abonnement (MoneyFusion renvoie { token, url })
     */
    public function checkout(Request $request)
    {
        $cabine = auth()->user()->cabine;
        if (!$cabine) {
            return back()->with('error', 'Aucune cabine associée.');
        }

        $request->validate([
            'montant' => 'required|integer|min:200',
            'client_numero' => 'required|string',
            'client_nom' => 'required|string',
        ]);

        $montant = (int) $request->montant;
        $numero = trim($request->client_numero);
        $nom = trim($request->client_nom);

        return DB::transaction(function () use ($cabine, $montant, $numero, $nom) {
            $abonnement = Abonnement::create([
                'cabine_id' => $cabine->id,
                'statut' => 'en_attente',
                'montant' => $montant,
                'reference_paiement' => 'txn' . Str::upper(Str::random(16)), // placeholder jusqu’à réception du vrai token
            ]);

            try {
                $payload = [
                    'totalPrice' => $montant,
                    'article' => [['abonnement' => $montant]],
                    'numeroSend' => $numero,
                    'nomclient' => $nom,
                    'personal_Info' => [['userId' => auth()->id()]],
                    'return_url' => env('MONEYFUSION_RETURN_URL'),
                    'webhook_url' => env('MONEYFUSION_WEBHOOK_URL'),
                ];

                $response = Http::moneyfusion()->post(env('MONEYFUSION_API_URL'), $payload);

                if (!$response->successful()) {
                    Log::error("MoneyFusion: Erreur HTTP", [
                        'cabine_id' => $cabine->id,
                        'user_id' => auth()->id(),
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'payload' => $payload,
                    ]);
                    return back()->with('error', 'Erreur technique lors de la création du paiement.');
                }

                $data = $response->json();
                Log::info("MoneyFusion: Réponse checkout abonnement", ['data' => $data]);

                if (!isset($data['url']) || !isset($data['token'])) {
                    Log::error("MoneyFusion: Données invalides (url/token manquants)", ['data' => $data]);
                    return back()->with('error', 'Erreur technique : données paiement invalides.');
                }

                // Le champ à stocker côté DB est le token renvoyé par l’API (correspondra au tokenPay côté webhook)
                $abonnement->update([
                    'reference_paiement' => $data['token'],
                ]);

                return redirect()->away($data['url']);
            } catch (\Throwable $e) {
                Log::error("MoneyFusion: Exception checkout abonnement", [
                    'error' => $e->getMessage(),
                    'cabine_id' => $cabine->id,
                    'user_id' => auth()->id(),
                ]);
                return back()->with('error', 'Erreur technique lors de la création du paiement.');
            }
        });
    }

    /**
     * Webhook MoneyFusion (abonnement ou certification)
     * MoneyFusion envoie tokenPay, statut, event, Montant, etc.
     */
    public function notify(Request $request)
    {
        Log::info("Webhook reçu", $request->all());

        // Route conditionnelle pour certification
        $type = $request->input('type');
        $personalInfo = $request->input('personal_Info');

        if ($type === 'certification' ||
            (is_array($personalInfo) && isset($personalInfo[0]['type']) && $personalInfo[0]['type'] === 'certification')) {
            return $this->notifyCertification($request);
        }

        // Abonnement
        $tokenPay = $request->input('tokenPay');
        if (!$tokenPay) {
            Log::warning("Webhook abonnement: tokenPay manquant", $request->all());
            return response()->json(['error' => 'tokenPay manquant'], 400);
        }

        $abonnement = Abonnement::where('reference_paiement', $tokenPay)->first();
        if (!$abonnement) {
            Log::warning("Webhook abonnement: Abonnement introuvable pour tokenPay", ['tokenPay' => $tokenPay]);
            return response()->json(['error' => 'Abonnement introuvable'], 404);
        }

        // Idempotence: si déjà actif et notification paid → ne rien refaire
        if ($abonnement->statut === 'actif' && $request->input('statut') === 'paid') {
            Log::info("Webhook abonnement: déjà actif, notification ignorée", ['abonnement_id' => $abonnement->id]);
            return response()->json(['message' => 'Déjà traité'], 200);
        }

        $event = $request->input('event'); // e.g. payin.session.completed / pending / cancelled
        $incomingStatus = $request->input('statut'); // e.g. paid / pending / failure / no paid

        // On ne bascule actif que si statut = paid
        if ($incomingStatus !== 'paid') {
            // Si cancelled → marquer annulé
            if ($event === 'payin.session.cancelled') {
                $abonnement->update(['statut' => 'annulé']);
                Log::info("Webhook abonnement: paiement annulé", [
                    'abonnement_id' => $abonnement->id,
                    'tokenPay' => $tokenPay
                ]);
            } else {
                Log::info("Webhook abonnement: statut non payé, en attente", [
                    'abonnement_id' => $abonnement->id,
                    'incomingStatus' => $incomingStatus
                ]);
            }

            // Enregistrer la notification (historique)
            MoneyfusionTransaction::create([
                'token' => $tokenPay,
                'abonnement_id' => $abonnement->id,
                'statut' => $incomingStatus,
                'payload' => $request->all(),
                'montant' => $request->input('Montant'),
            ]);

            return response()->json(['message' => 'En attente'], 200);
        }

        // Statut payé → activer en s’appuyant sur le montant DB (fiable)
        DB::transaction(function () use ($abonnement, $request, $tokenPay) {
            $mois = (int) floor($abonnement->montant / 200);

            $abonnement->update([
                'statut' => 'actif',
                'date_debut' => now(),
                'date_fin' => now()->addMonths(max(1, $mois)), // au moins 1 mois
            ]);

            MoneyfusionTransaction::create([
                'token' => $tokenPay,
                'abonnement_id' => $abonnement->id,
                'statut' => 'paid',
                'payload' => $request->all(),
                'montant' => $request->input('Montant', $abonnement->montant),
            ]);
        });

        Log::info("Webhook abonnement: activation réussie", [
            'abonnement_id' => $abonnement->id,
            'tokenPay' => $tokenPay
        ]);

        return response()->json(['message' => 'OK'], 200);
    }

    /**
     * Création d’une session de paiement pour certification
     */
    public function checkoutCertification(Request $request)
    {
        $cabine = auth()->user()->cabine;
        if (!$cabine) {
            return back()->with('error', 'Aucune cabine associée.');
        }

        if ($cabine->certifier) {
            return back()->with('info', 'Votre cabine est déjà certifiée.');
        }

        $request->validate([
            'client_numero' => 'required|string',
            'client_nom' => 'required|string',
        ]);

        $montant = 10000; // fixe
        $numero = trim($request->client_numero);
        $nom = trim($request->client_nom);

        return DB::transaction(function () use ($cabine, $montant, $numero, $nom) {
            $certificationPaiement = CertificationPaiement::create([
                'cabine_id' => $cabine->id,
                'statut' => 'en_attente',
                'montant' => $montant,
                'reference_paiement' => 'cert' . Str::upper(Str::random(16)), // placeholder
            ]);

            try {
                $payload = [
                    'totalPrice' => $montant,
                    'article' => [['certification' => $montant]],
                    'numeroSend' => $numero,
                    'nomclient' => $nom,
                    'personal_Info' => [['userId' => auth()->id(), 'type' => 'certification']],
                    'return_url' => env('MONEYFUSION_RETURN_URL') . '?type=certification',
                    'webhook_url' => env('MONEYFUSION_WEBHOOK_URL') . '?type=certification',
                ];

                $response = Http::moneyfusion()->post(env('MONEYFUSION_API_URL'), $payload);

                if (!$response->successful()) {
                    Log::error("MoneyFusion Certification: Erreur HTTP", [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'payload' => $payload,
                        'cabine_id' => $cabine->id,
                        'user_id' => auth()->id(),
                    ]);
                    return back()->with('error', 'Erreur technique lors de la création du paiement.');
                }

                $data = $response->json();
                Log::info("MoneyFusion: Réponse checkout certification", ['data' => $data]);

                if (!isset($data['url']) || !isset($data['token'])) {
                    Log::error("MoneyFusion Certification: Données invalides (url/token manquants)", ['data' => $data]);
                    return back()->with('error', 'Erreur technique : données paiement invalides.');
                }

                // Stocker le token (correspondra à tokenPay dans le webhook)
                $certificationPaiement->update([
                    'reference_paiement' => $data['token']
                ]);

                return redirect()->away($data['url']);
            } catch (\Throwable $e) {
                Log::error("MoneyFusion Certification: Exception", [
                    'error' => $e->getMessage(),
                    'cabine_id' => $cabine->id,
                    'user_id' => auth()->id(),
                ]);
                return back()->with('error', 'Erreur technique lors de la création du paiement.');
            }
        });
    }

    /**
     * Webhook pour paiements de certification
     */
    public function notifyCertification(Request $request)
    {
        Log::info("Webhook Certification reçu", $request->all());

        $tokenPay = $request->input('tokenPay');
        if (!$tokenPay) {
            Log::warning("Webhook certification: tokenPay manquant", $request->all());
            return response()->json(['error' => 'tokenPay manquant'], 400);
        }

        $certificationPaiement = CertificationPaiement::where('reference_paiement', $tokenPay)->first();
        if (!$certificationPaiement) {
            Log::warning("CertificationPaiement introuvable", ['tokenPay' => $tokenPay]);
            return response()->json(['error' => 'Paiement certification introuvable'], 404);
        }

        // Idempotence: déjà payé + notification paid
        if ($certificationPaiement->statut === 'paye' && $request->input('statut') === 'paid') {
            Log::info("Webhook certification: déjà traité", ['certification_paiement_id' => $certificationPaiement->id]);
            return response()->json(['message' => 'Déjà traité'], 200);
        }

        $incomingStatus = $request->input('statut');
        $event = $request->input('event');

        if ($incomingStatus !== 'paid') {
            // Enregistrer l’événement et éventuellement marquer annulé si cancelled
            if ($event === 'payin.session.cancelled') {
                $certificationPaiement->update(['statut' => 'annule']);
                Log::info("Webhook certification: paiement annulé", ['id' => $certificationPaiement->id]);
            }

            MoneyfusionTransaction::create([
                'token' => $tokenPay,
                'statut' => $incomingStatus,
                'payload' => $request->all(),
                'montant' => $request->input('Montant'),
            ]);

            return response()->json(['message' => 'En attente'], 200);
        }

        // paid → activer la certification
        DB::transaction(function () use ($certificationPaiement, $request, $tokenPay) {
            $cabine = $certificationPaiement->cabine;

            if ($cabine) {
                $cabine->update(['certifier' => true]);

                // Augmenter max_utilisateurs si nécessaire
                if ($cabine->max_utilisateurs < 2) {
                    $cabine->update(['max_utilisateurs' => 2]);
                }
            }

            $certificationPaiement->update([
                'statut' => 'paye',
            ]);

            MoneyfusionTransaction::create([
                'token' => $tokenPay,
                'statut' => 'paid',
                'payload' => $request->all(),
                'montant' => $request->input('Montant', $certificationPaiement->montant),
            ]);
        });

        Log::info("Certification activée avec succès", [
            'cabine_id' => $certificationPaiement->cabine->id ?? null,
            'tokenPay' => $tokenPay
        ]);

        return response()->json(['message' => 'Certification activée'], 200);
    }
}
