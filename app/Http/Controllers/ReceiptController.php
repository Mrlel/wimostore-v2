<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Services\ReceiptService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReceiptController extends Controller
{
    protected $receiptService;

    public function __construct(ReceiptService $receiptService)
    {
        $this->receiptService = $receiptService;
    }

    // Afficher le reçu web
    public function show($hash)
    {
        $vente = Vente::where('receipt_hash', $hash)->firstOrFail();
        
        // Charger les relations nécessaires
        $vente->load(['lignes.produit', 'user', 'cabine']);
        
        $qrCode = $this->receiptService->generateQrCode($vente);
        $pdf = $this->receiptService->generateReceipt($vente);

        return view('receipts.show', compact('vente', 'qrCode', 'pdf'));
    }

    // Télécharger le PDF
    public function download($hash)
    {
        $vente = Vente::where('receipt_hash', $hash)->firstOrFail();
        $vente->load(['lignes.produit', 'user', 'cabine']);
        
        $pdf = $this->receiptService->generateReceipt($vente);
        $this->receiptService->markAsPrinted($vente);

        return $pdf->download('reçu-' . $vente->numero_vente . '.pdf');
    }

    // Marquer comme vu
    public function markAsViewed($hash)
    {
        $vente = Vente::where('receipt_hash', $hash)->firstOrFail();
        $this->receiptService->markAsViewed($vente);

        return response()->json(['status' => 'success']);
    }

    // Envoyer par email
    public function sendEmail(Request $request, $hash)
    {
        $request->validate([
            'email' => 'required|email|max:255'
        ]);
        
        $vente = Vente::where('receipt_hash', $hash)->firstOrFail();
        
        $success = $this->receiptService->sendByEmail($vente, $request->email);
        
        if ($success) {
            return back()->with('success', 'Reçu envoyé par email avec succès.');
        } else {
            return back()->with('error', 'Erreur lors de l\'envoi de l\'email.');
        }
    }

    // Afficher les statistiques des reçus
    public function stats()
    {
        $stats = $this->receiptService->getReceiptStats();
        
        return view('receipts.stats', compact('stats'));
    }

    // Lister tous les reçus
    public function index()
    {
        $ventes = Vente::where('cabine_id', auth()->user()->cabine_id)
            ->whereNotNull('receipt_hash')
            ->with(['lignes.produit', 'user'])
            ->latest()
            ->paginate(20);

        return view('receipts.index', compact('ventes'));
    }
}