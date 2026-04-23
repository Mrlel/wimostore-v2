<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Abonnement extends Model
{
    use HasFactory;

    protected $fillable = [
        'cabine_id',
        'date_debut',
        'date_fin',
        'statut',
        'montant',
        'reference_paiement',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'montant' => 'decimal:2',
    ];

    public function cabine()
    {
        return $this->belongsTo(Cabine::class);
    }

    public function scopeActif($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopePourCabine($query, $cabineId)
    {
        return $query->where('cabine_id', $cabineId);
    }
}
