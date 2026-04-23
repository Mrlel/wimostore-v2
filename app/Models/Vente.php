<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Vente extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_vente', 'type_client', 'nom_client', 'contact_client',
        'montant_total', 'montant_regle', 'mode_paiement', 'remarques', 'user_id', 'cabine_id',
        'receipt_number', 
    ];

    protected $casts = [
        'montant_total' => 'decimal:2',
        'montant_regle' => 'decimal:2',
        'receipt_printed_at' => 'datetime',
        'receipt_viewed_at' => 'datetime',
    ];

    // Scope pour filtrer par cabine
    public function scopeSameCabine($query)
    {
        return $query->where('cabine_id', auth()->user()->cabine_id);
    }
    
    // Générer le numéro de reçu
    public function generateReceiptNumber()
    {
        $prefix = 'REC';
        $date = now()->format('Ymd');
        $cabineCode = $this->cabine->code ?? 'DSP';
        $sequence = str_pad($this->id, 4, '0', STR_PAD_LEFT);
        
        return "{$prefix}-{$cabineCode}-{$date}-{$sequence}";
    }

    // Générer le hash du reçu
    public function generateReceiptHash()
    {
        return hash('sha256', $this->id . $this->created_at . config('app.key') . 'receipt');
    }

    // Vérifier si le reçu a été imprimé
    public function isPrinted(): bool
    {
        return !is_null($this->receipt_printed_at);
    }

    // Vérifier si le reçu a été consulté
    public function isViewed(): bool
    {
        return !is_null($this->receipt_viewed_at);
    }

    // Obtenir le statut du reçu
    public function getReceiptStatusAttribute(): string
    {
        if ($this->isPrinted()) {
            return 'imprimé';
        } elseif ($this->isViewed()) {
            return 'consulté';
        } else {
            return 'non consulté';
        }
    }

    // Obtenir l'URL du reçu
    public function getReceiptUrlAttribute(): string
    {
        return route('receipts.show', $this->receipt_hash);
    }

    public function cabine(): BelongsTo
    {
        return $this->belongsTo(Cabine::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lignes(): HasMany
    {
        return $this->hasMany(LigneVente::class);
    }

    public function getMontantDuAttribute(): float
    {
        return $this->montant_total - $this->montant_regle;
    }

    // Scope pour les reçus non consultés
    public function scopeUnviewed($query)
    {
        return $query->whereNull('receipt_viewed_at');
    }

    // Scope pour les reçus non imprimés
    public function scopeUnprinted($query)
    {
        return $query->whereNull('receipt_printed_at');
    }

}