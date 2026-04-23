<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyfusionTransaction extends Model
{
    protected $fillable = [
        'token',
        'event',
        'statut',
        'payload',
        'processed',
        'abonnement_id',
        'montant',
    ];

    protected $casts = [
        'payload' => 'array',
        'processed' => 'boolean',
    ];

    public function abonnement()
    {
        return $this->belongsTo(Abonnement::class);
    }
}
