<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Retrait;

class PayoutController extends Controller
{
    // Formulaire retrait
    public function form()
    {
        return view('retraits.form');
    }

    // Initiation d'un retrait
    public function withdraw(Request $request)
    {
        $cabine = auth()->user()->cabine;
        if (!$cabine) {
            return redirect()->back()->with('error', 'Aucune cabine associée.');
        }

        $validated = $request->validate([
            'numeroRetrait' => 'required|string',
            'montant' => 'required|integer|min:5000', // minimum Wave/standard
            'withdraw_mode' => 'required|string',
        ]);

        $numero = $validated['numeroRetrait'];
        $montant = $validated['montant'];
        $mode = $validated['withdraw_mode'];

        // Token unique côté DB pour retracer le retrait
        $tokenPay = 'txn'.strtoupper(\Str::random(18));

        // Crée un retrait en attente
        $retrait = Retrait::create([
            'cabine_id' => $cabine->id,
            'numeroRetrait' => $numero,
            'montant' => $montant,
            'moyen' => $mode,
            'tokenPay' => $tokenPay,
            'statut' => 'en_attente',
        ]);

        try {
            $apiUrl = 'https://pay.moneyfusion.net/api/v1/withdraw';
            $apiKey = env('MONEYFUSION_PRIVATE_KEY');

            $payload = [
                'countryCode' => 'ci', // ajuster si besoin
                'phone' => $numero,
                'amount' => $montant,
                'withdraw_mode' => $mode,
                'webhook_url' => route('retraits.notify', [], true)
            ];

            $response = Http::withHeaders([
                'moneyfusion-private-key' => $apiKey,
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $payload);

            $data = $response->json();

            if (!empty($data['statut']) && $data['statut'] === true) {
                Log::info('Retrait soumis à MoneyFusion', ['payload' => $payload, 'response' => $data]);
                return redirect()->back()->with('success', 'Retrait soumis avec succès. TokenPay: '.$data['tokenPay']);
            }

            Log::warning('Erreur retrait MoneyFusion', ['payload' => $payload, 'response' => $data]);
            return redirect()->back()->with('error', $data['message'] ?? 'Erreur lors du retrait.');

        } catch (\Throwable $e) {
            Log::error('Exception retrait MoneyFusion', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Erreur technique lors du retrait.');
        }
    }

    // Webhook pour notifications Money Fusion
    public function notify(Request $request)
    {
        Log::info('Webhook retrait MoneyFusion', ['payload' => $request->all()]);

        $tokenPay = $request->input('tokenPay');
        $event = $request->input('event');

        $retrait = Retrait::where('tokenPay', $tokenPay)->first();
        if (!$retrait) {
            Log::warning('Webhook retrait inconnu', ['tokenPay' => $tokenPay]);
            return response()->json(['message' => 'Token inconnu'], 404);
        }

        if ($event === 'payout.session.completed') {
            $retrait->update(['statut' => 'effectue']);
            Log::info('Retrait effectué', ['tokenPay' => $tokenPay]);
        } elseif ($event === 'payout.session.cancelled') {
            $retrait->update(['statut' => 'annule']);
            Log::warning('Retrait annulé', ['tokenPay' => $tokenPay]);
        }

        return response()->json(['message' => 'OK'], 200);
    }
}
