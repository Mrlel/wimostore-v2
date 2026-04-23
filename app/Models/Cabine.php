<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Cabine extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_cab', 'code', 'localisation','est_actif', 'certifier','type_compte','max_utilisateurs',
    ];

    protected $casts = [
        'max_utilisateurs' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cabine) {
            if (empty($cabine->code)) {
                $cabine->code = static::generateUniqueCode();
            }
        });
    }

    public static function generateUniqueCode()
    {
        // Récupère le dernier code existant
        $lastCode = static::orderBy('id', 'desc')->value('code');
    
        // Extraire le numéro du milieu
        $nextNumber = 1;
        if ($lastCode) {
            // Exemple: BTQ-12-AB86 → on récupère "12"
            preg_match('/BTQ-(\d+)-/', $lastCode, $matches);
            if (!empty($matches[1])) {
                $nextNumber = (int)$matches[1] + 1;
            }
        }
    
        $prefix = 'BTQ-' . $nextNumber . '-';
        $length = 4; 
        $attempts = 0;
        $maxAttempts = 5;
    
        do {
            // Génère un code aléatoire de 4 caractères
            $random = strtoupper(substr(bin2hex(random_bytes($length)), 0, $length));
            $code = $prefix . $random;
            $attempts++;
    
            // Vérifie si le code existe déjà
            if (!static::where('code', $code)->exists()) {
                return $code;
            }
    
        } while ($attempts < $maxAttempts);
    
        // Fallback en cas de collisions
        return $prefix . strtoupper(uniqid());
    }
    


    public function getPublicUrlAttribute()
    {
        return route('cabine.public', $this->code);
    }
    
    public function pages()
    {
        return $this->hasMany(CabinePage::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function produits(): HasMany
    {
        return $this->hasMany(Produit::class);
    }

    public function ventes(): HasMany
    {
        return $this->hasMany(Vente::class);
    }

    public function abonnements(): HasMany
    {
        return $this->hasMany(Abonnement::class, 'cabine_id');
    }

    public function abonnementActuel()
    {
        return $this->hasOne(Abonnement::class, 'cabine_id')
            ->where('statut', 'actif')
            ->latest('date_fin');
    }

    // Abonnement actif basé sur la dernière date_fin
// app/Models/Cabine.php
public function abonnementActif(): bool
{
    $last = $this->abonnements()
        ->where('statut', 'actif')
        ->latest('date_fin')
        ->first();

    if (!$last) {
        return false;
    }

    // Un compte illimité (date_fin null) reste actif
    if (is_null($last->date_fin)) {
        return true;
    }

    $dateFin = $last->date_fin instanceof \Carbon\Carbon
        ? $last->date_fin
        : \Carbon\Carbon::parse($last->date_fin);

    return $dateFin->endOfDay()->isFuture();
}

    public function scopeActive($query)
    {
        return $query->where('est_actif', true);
    }

    public function peutAccepterUtilisateurs(): bool
    {
        // Si la cabine est certifiée, elle peut toujours accepter des utilisateurs
        if ($this->certifier) {
            return true;
        }
        return $this->users()->count() < $this->max_utilisateurs;
    }

    public function estExpiree(): bool
    {
        return $this->date_expiration && $this->date_expiration->isPast();
    }

    public function getStatutAttribute(): string
    {
        if (!$this->est_actif) {
            return 'inactive';
        }

        if ($this->estExpiree()) {
            return 'expiree';
        }

        if (!$this->peutAccepterUtilisateurs()) {
            return 'saturee';
        }

        return 'active';
    }

    public function getNombreUtilisateursAttribute(): int
    {
        return $this->users()->count();
    }

    public function getPourcentageUtilisationAttribute(): float
    {
        if ($this->max_utilisateurs === 0) {
            return 0;
        }

        return min(100, ($this->nombre_utilisateurs / $this->max_utilisateurs) * 100);
    }








    
// Ajouter la relation avec Visits
public function visits(): HasMany
{
    return $this->hasMany(Visits::class);
}
// Calculer le nombre de ventes sur 1 mois (30 derniers jours)
public function getNombreVentesMoisAttribute(): int
{
    $dateDebut = Carbon::now()->subDays(30)->startOfDay();
    $dateFin = Carbon::now()->endOfDay();
    
    return $this->ventes()
        ->whereBetween('created_at', [$dateDebut, $dateFin])
        ->count();
}

// Calculer le nombre de filleuls parrainés par la cabine
public function getNombreFilleulsAttribute(): int
{
    // Vérifier si le modèle Parrainage existe
    if (!class_exists(\App\Models\Parrainage::class)) {
        return 0;
    }

    // Récupérer tous les IDs des utilisateurs de la cabine
    $userIds = $this->users()->pluck('id')->toArray();
    
    if (empty($userIds)) {
        return 0;
    }

    // Compter les filleuls actifs parrainés par les utilisateurs de cette cabine
    return \App\Models\Parrainage::whereIn('parrain_id', $userIds)
        ->count();
}

// Vérifier l'éligibilité à la certification
public function estEligibleCertification(): bool
{
    $nombreVentes = $this->nombre_ventes_mois;
    $nombreFilleuls = $this->nombre_filleuls;
    
    return $nombreVentes >= 500
        && $nombreFilleuls >= 5; 
}

// Obtenir les statistiques de certification
public function getStatistiquesCertificationAttribute(): array
{
    $nombreFilleuls = $this->nombre_filleuls;
    $filleulsRequis = 5;
    
    return [
        'nombre_ventes_mois' => $this->nombre_ventes_mois,
        'nombre_filleuls' => $nombreFilleuls,
        'est_eligible' => $this->estEligibleCertification(),
        'ventes_requises' => 500,
        'filleuls_requis' => $filleulsRequis,
        'progression_ventes' => min(100, ($this->nombre_ventes_mois / 500) * 100),
        'progression_parrainage' => min(100, ($nombreFilleuls / $filleulsRequis) * 100),
    ];
}

// Demander la certification
public function demanderCertification(): bool
{
    if ($this->estEligibleCertification()) {
        $this->update([
            'certifier' => true,
            'max_utilisateurs' => 10 
        ]);
        return true;
    }
    return false;
}
// ...existing code...

// Scope pour les cabines certifiées
public function scopeCertifiees($query)
{
    return $query->where('certifier', true);
}
}