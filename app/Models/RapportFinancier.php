<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class RapportFinancier extends Model
{
    use HasFactory;
    protected $table = 'rapports_financiers';

    protected $fillable = [
        'cabine_id',
        'user_id',
        'date_debut',
        'date_fin',
        'type_rapport',
        'chiffre_affaires_total',
        'ventes_especes',
        'ventes_carte',
        'ventes_mobile',
        'ventes_virement',
        'ventes_autre',
        'cout_achats_total',
        'cout_stock_initial',
        'cout_stock_final',
        'loyer',
        'electricite',
        'eau',
        'internet',
        'maintenance',
        'autres_charges',
        'marge_brute',
        'marge_nette',
        'taux_marge_brute',
        'taux_marge_nette',
        'nombre_ventes',
        'nombre_produits_vendus',
        'panier_moyen',
        'produit_moyen_vendu',
        'est_valide',
        'remarques',
        'date_validation',
        'valide_par'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_validation' => 'datetime',
        'est_valide' => 'boolean',
        'chiffre_affaires_total' => 'decimal:2',
        'ventes_especes' => 'decimal:2',
        'ventes_carte' => 'decimal:2',
        'ventes_mobile' => 'decimal:2',
        'ventes_virement' => 'decimal:2',
        'ventes_autre' => 'decimal:2',
        'cout_achats_total' => 'decimal:2',
        'cout_stock_initial' => 'decimal:2',
        'cout_stock_final' => 'decimal:2',
        'loyer' => 'decimal:2',
        'electricite' => 'decimal:2',
        'eau' => 'decimal:2',
        'internet' => 'decimal:2',
        'maintenance' => 'decimal:2',
        'autres_charges' => 'decimal:2',
        'marge_brute' => 'decimal:2',
        'marge_nette' => 'decimal:2',
        'taux_marge_brute' => 'decimal:2',
        'taux_marge_nette' => 'decimal:2',
        'panier_moyen' => 'decimal:2',
        'produit_moyen_vendu' => 'decimal:2',
    ];

    // Relations
    public function cabine(): BelongsTo
    {
        return $this->belongsTo(Cabine::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function validePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'valide_par');
    }

    // Scopes
    public function scopePourCabine($query, $cabineId)
    {
        return $query->where('cabine_id', $cabineId);
    }

    public function scopePourPeriode($query, $dateDebut, $dateFin)
    {
        return $query->whereBetween('date_debut', [$dateDebut, $dateFin]);
    }

    public function scopeValides($query)
    {
        return $query->where('est_valide', true);
    }

    public function scopeParType($query, $type)
    {
        return $query->where('type_rapport', $type);
    }

    // Méthodes de calcul
    public function calculerMargeBrute(): float
    {
        return $this->chiffre_affaires_total - $this->cout_achats_total;
    }

    public function calculerMargeNette(): float
    {
        $coûtsFixes = $this->loyer + $this->electricite + $this->eau + 
                     $this->internet + $this->maintenance + $this->autres_charges;
        return $this->marge_brute - $coûtsFixes;
    }

    public function calculerTauxMargeBrute(): float
    {
        if ($this->chiffre_affaires_total == 0) return 0;
        return ($this->marge_brute / $this->chiffre_affaires_total) * 100;
    }

    public function calculerTauxMargeNette(): float
    {
        if ($this->chiffre_affaires_total == 0) return 0;
        return ($this->marge_nette / $this->chiffre_affaires_total) * 100;
    }

    // Accesseurs
    public function getPeriodeAttribute(): string
    {
        return $this->date_debut->format('d/m/Y') . ' - ' . $this->date_fin->format('d/m/Y');
    }

    public function getCoûtsFixesTotalAttribute(): float
    {
        return $this->loyer + $this->electricite + $this->eau + 
               $this->internet + $this->maintenance + $this->autres_charges;
    }

    public function getStatutAttribute(): string
    {
        return $this->est_valide ? 'Validé' : 'En attente';
    }
}
