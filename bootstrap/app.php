<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check.abonnement'     => \App\Http\Middleware\CheckAbonnement::class,
            'ensure.cabine.exists' => \App\Http\Middleware\EnsureCabineExists::class,
            'force.password.change'=> \App\Http\Middleware\ForcePasswordChange::class,
            'track.visits'         => \App\Http\Middleware\TrackVisits::class,
            'super.admin'          => \App\Http\Middleware\SuperAdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
