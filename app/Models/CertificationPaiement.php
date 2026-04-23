<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationPaiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'cabine_id',
        'montant',
        'statut',
        'reference_paiement',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
    ];

    public function cabine()
    {
        return $this->belongsTo(Cabine::class);
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopePaye($query)
    {
        return $query->where('statut', 'paye');
    }
}
