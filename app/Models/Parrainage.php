<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parrainage extends Model
{
    use HasFactory;

    protected $fillable = [
        'parrain_id',
        'filleul_id',
        'statut',
        'recompense_parrain',
        'recompense_filleul',
        'recompense_attribuee_at',
    ];

    protected $casts = [
        'recompense_parrain' => 'decimal:2',
        'recompense_filleul' => 'decimal:2',
        'recompense_attribuee_at' => 'datetime',
    ];

    public function parrain()
    {
        return $this->belongsTo(User::class, 'parrain_id');
    }

    public function filleul()
    {
        return $this->belongsTo(User::class, 'filleul_id');
    }

    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }
}