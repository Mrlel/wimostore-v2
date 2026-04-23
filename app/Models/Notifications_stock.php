<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notifications_stock;


class Notifications_stock extends Model
{
    protected $table = 'notifications_stock'; 
    protected $fillable = [
        'cabine_id', 'produit_id', 'type', 'message', 'vu'
    ];
    protected $casts = [
        'vu' => 'boolean',
    ];
}