<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'cabine_id', 'categorie_id','fournisseur_id', 'code', 'nom', 'marque','image','description','modele', 
        'imei', 'etat', 'prix_achat', 'prix_vente', 
        'seuil_alerte', 'quantite_stock', 'actif','publier',
    ];

    protected $casts = [
        'prix_achat' => 'decimal:2',
        'prix_vente' => 'decimal:2',
        'actif' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($produit) {
            if (empty($produit->code)) {
                $produit->code = static::generateUniqueCode();
            }
        });
    }


public static function generateUniqueCode()
{
    $cabineId = auth()->user()->cabine_id ?? '0'; // On sécurise
    $prefix = 'ATC-' . $cabineId;
    $length = 6; // Longueur du code aléatoire

    $attempts = 0;
    $maxAttempts = 5;

    do {
        // Génère un code aléatoire sécurisé
        $random = strtoupper(substr(bin2hex(random_bytes($length)), 0, $length));
        $code = $prefix . $random;
        $attempts++;

        // Vérifie si le code existe pour cette cabine
        if (!static::where('code', $code)->where('cabine_id', $cabineId)->exists()) {
            return $code;
        }

    } while ($attempts < $maxAttempts);

    // Fallback ultra sécurisé si collision rare
    return $prefix . strtoupper(uniqid());
}


   public function scopeSameCabine($query)
    {
        return $query->where('cabine_id', auth()->user()->cabine_id);
    }
     public function images()
    {
        return $this->hasMany(ProduitImage::class);
    }

    public function latestImagePath()
    {
        $img = $this->images()->latest()->first();
        return $img ? $img->path : null;
    }

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }
    public function cabine(): BelongsTo
    {
        return $this->belongsTo(Cabine::class);
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function mouvements(): HasMany
    {
        return $this->hasMany(Mouvement::class);
    }

    public function ligneVentes(): HasMany
    {
        return $this->hasMany(LigneVente::class);
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->quantite_stock == 0) {
            return 'rupture';
        } elseif ($this->quantite_stock <= $this->seuil_alerte) {
            return 'faible';
        }
        return 'normal';
    }
}