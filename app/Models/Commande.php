<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_commande', 'nom_client', 'telephone_client', 'email_client',
        'adresse_livraison', 'notes', 'montant_total', 'statut',
        'mode_paiement', 'cabine_id',
    ];

    public function lignes(): HasMany
    {
        return $this->hasMany(LigneCommande::class);
    }

    public function cabine(): BelongsTo
    {
        return $this->belongsTo(Cabine::class);
    }

    public static function genererNumero(string $cabineCode): string
    {
        $prefix = 'CMD-' . strtoupper($cabineCode);
        $date   = now()->format('Ymd');
        $rand   = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
        return "{$prefix}-{$date}-{$rand}";
    }

    public function getStatutLabelAttribute(): string
    {
        return match ($this->statut) {
            'en_attente'    => 'En attente',
            'confirmee'     => 'Confirmée',
            'en_preparation'=> 'En préparation',
            'expediee'      => 'Expédiée',
            'livree'        => 'Livrée',
            'annulee'       => 'Annulée',
            default         => $this->statut,
        };
    }

    public function getStatutColorAttribute(): string
    {
        return match ($this->statut) {
            'en_attente'    => '#F59E0B',
            'confirmee'     => '#3B82F6',
            'en_preparation'=> '#8B5CF6',
            'expediee'      => '#06B6D4',
            'livree'        => '#10B981',
            'annulee'       => '#EF4444',
            default         => '#6B7280',
        };
    }
}
