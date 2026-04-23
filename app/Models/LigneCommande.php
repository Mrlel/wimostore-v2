<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LigneCommande extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id', 'produit_id', 'quantite', 'prix_unitaire', 'sous_total',
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
        'sous_total'    => 'decimal:2',
    ];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
