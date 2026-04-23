<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mouvement extends Model
{
    use HasFactory;

    protected $fillable = [
        'produit_id', 'type', 'quantite', 'remarque', 'user_id', 'cabine_id'
    ];

    protected $casts = [
        'date_mouvement' => 'datetime'
    ];

    public function scopeSameCabine($query)
    {
        return $query->whereHas('produit', function($q) {
            $q->where('cabine_id', auth()->user()->cabine_id);
        });
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}