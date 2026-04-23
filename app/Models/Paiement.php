<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'abonnement_id',
        'reference_paiement',
        'montant',
        'periode',
        'statut',
        'transaction_id',
        'provider',
        'provider_data',
        'paye_le'
    ];

    protected $casts = [
        'paye_le' => 'datetime',
        'provider_data' => 'array',
        'montant' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($paiement) {
            if (empty($paiement->reference_paiement)) {
                $paiement->reference_paiement = 'PAY-' . strtoupper(Str::random(12));
            }
        });
    }

    public function abonnement()
    {
        return $this->belongsTo(Abonnement::class);
    }

    public function marquerCommePaye($transactionId, $providerData = null)
    {
        $this->update([
            'statut' => 'payé',
            'transaction_id' => $transactionId,
            'provider_data' => $providerData,
            'paye_le' => now()
        ]);
    }

    public function marquerCommeEchoue()
    {
        $this->update(['statut' => 'échoué']);
    }

    public function estPaye()
    {
        return $this->statut === 'payé';
    }
}