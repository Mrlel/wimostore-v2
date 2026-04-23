<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Visits extends Model
{
    use HasFactory;
    protected $table = 'visits';
    protected $fillable = [
        'ip_address',
        'user_agent',
        'url',
        'visited_at',
        'cabine_id',
    ];

    public function cabine(): BelongsTo
{
    return $this->belongsTo(Cabine::class);
}
}
