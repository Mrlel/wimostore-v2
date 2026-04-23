<?php

namespace App\Services;

use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ReceiptService
{
    public function generateReceipt(Vente $vente)
    {
        // Générer les numéros si inexistants
        if (!$vente->receipt_number) {
            $vente->update([
                'receipt_number' => $vente->generateReceiptNumber(),
                'receipt_hash' => $vente->generateReceiptHash()
            ]);
        }

        // Générer le QR Code
        $qrCode = $this->generateQrCode($vente);
        
        // Générer le PDF
        $pdf = Pdf::loadView('receipts.pdf', [
            'vente' => $vente,
            'qrCode' => $qrCode,
            'cabine' => $vente->cabine,
            'lignes' => $vente->lignes()->with('produit')->get()
        ])->setPaper('a4', 'portrait');

        return $pdf;
    }

    public function generateQrCode(Vente $vente)
    {
        $url = route('receipts.show', ['hash' => $vente->receipt_hash]);
        
        return QrCode::format('png')
            ->size(200)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($url);
    }

    public function markAsPrinted(Vente $vente)
    {
        $vente->update(['receipt_printed_at' => now()]);
        
        Log::info('Reçu imprimé', [
            'vente_id' => $vente->id,
            'receipt_number' => $vente->receipt_number,
            'user_id' => auth()->id()
        ]);
    }

    public function markAsViewed(Vente $vente)
    {
        $vente->update(['receipt_viewed_at' => now()]);
        
        Log::info('Reçu consulté', [
            'vente_id' => $vente->id,
            'receipt_number' => $vente->receipt_number,
            'ip' => request()->ip()
        ]);
    }

    public function sendByEmail(Vente $vente, string $email)
    {
        try {
            $pdf = $this->generateReceipt($vente);
            
            // Marquer comme envoyé par email
            $vente->update(['receipt_email_sent_at' => now()]);
            
            // TODO: Implémenter l'envoi d'email avec le PDF en pièce jointe
            // Mail::to($email)->send(new ReceiptMail($vente, $pdf));
            
            Log::info('Reçu envoyé par email', [
                'vente_id' => $vente->id,
                'email' => $email,
                'receipt_number' => $vente->receipt_number
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Erreur envoi email reçu', [
                'vente_id' => $vente->id,
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    public function getReceiptStats()
    {
        $cabineId = auth()->user()->cabine_id;
        
        return [
            'total' => Vente::where('cabine_id', $cabineId)->count(),
            'printed' => Vente::where('cabine_id', $cabineId)->whereNotNull('receipt_printed_at')->count(),
            'viewed' => Vente::where('cabine_id', $cabineId)->whereNotNull('receipt_viewed_at')->count(),
            'unviewed' => Vente::where('cabine_id', $cabineId)->whereNull('receipt_viewed_at')->count(),
        ];
    }
}