<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'email',
        'numero',
        'password',
        'role',
        'accept_politique',
        'cabine_id',
        'code_parrain',
        'parrain_id',
        'notification_preferences',
        'password_changed_at'
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'notification_preferences' => 'array',
        'password_changed_at' => 'datetime',
    ];

    
// Pour email verification
public function sendEmailVerificationNotification()
{
    $this->notify(new VerifyEmailNotification);
}

// Pour reset password
public function sendPasswordResetNotification($token)
{
    $this->notify(new ResetPasswordNotification($token));
}


// Méthode sécurisée pour changer le rôle
public function changeRole($newRole)
{
    if (!in_array($newRole, ['user', 'responsable', 'admin', 'superadmin'])) {
        throw new \InvalidArgumentException('Rôle invalide');
    }
    
    $this->attributes['role'] = $newRole;
    return $this->save();
}
    public function getNotificationPreference($type, $default = true)
    {
        return $this->notification_preferences[$type] ?? $default;
    }

    public function setNotificationPreference($type, $value)
    {
        $preferences = $this->notification_preferences ?? [];
        $preferences[$type] = $value;
        $this->update(['notification_preferences' => $preferences]);
    }

    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }
// app/Models/User.php
public function cabine()
{
    return $this->belongsTo(Cabine::class);
}


    public function ventes(): HasMany
    {
        return $this->hasMany(Vente::class);
    }

    public function mouvements(): HasMany
    {
        return $this->hasMany(Mouvement::class);
    }

    public function scopeSameCabine($query)
    {
        return $query->where('cabine_id', auth()->user()->cabine_id);
    }

    /**
     * Vérifie si l'utilisateur doit changer son mot de passe
     */
    public function mustChangePassword()
    {
        return is_null($this->password_changed_at);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];




    // Relations de parrainage
public function parrain()
{
    return $this->belongsTo(User::class, 'parrain_id');
}

public function filleuls()
{
    return $this->hasMany(User::class, 'parrain_id');
}

public function parrainages()
{
    return $this->hasMany(Parrainage::class, 'parrain_id');
}

public function parrainage()
{
    return $this->hasOne(Parrainage::class, 'filleul_id');
}

// Générer un code de parrainage unique
public function genererCodeParrainage(): string
{
    if ($this->code_parrain) {
        return $this->code_parrain;
    }

    do {
        $code = 'REF-' . strtoupper(Str::random(8));
    } while (User::where('code_parrain', $code)->exists());

    $this->update(['code_parrain' => $code]);
    return $code;
}

// Obtenir le code de parrainage
public function getCodeParrainageAttribute(): ?string
{
    return $this->code_parrain ?? $this->genererCodeParrainage();
}

// Compter les filleuls actifs
public function getNombreFilleulsAttribute(): int
{
    return $this->filleuls()
        ->whereHas('parrainage', function($query) {
            $query->where('statut', 'actif');
        })
        ->count();
}

// Obtenir les statistiques de parrainage
public function getStatistiquesParrainageAttribute(): array
{
    $parrainagesActifs = $this->parrainages()->where('statut', 'actif')->get();
    
    return [
        'nombre_filleuls' => $this->nombre_filleuls,
        'recompense_totale' => $parrainagesActifs->sum('recompense_parrain'),
        'filleuls_actifs' => $parrainagesActifs->count(),
    ];
}
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
}
