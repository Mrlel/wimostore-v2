<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{

    protected $except = [
        '/paiement/notify',
        '/paiement/success', // au cas où le PSP renvoie en POST
    ];
}