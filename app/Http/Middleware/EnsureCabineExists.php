<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCabineExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Vérifier si l'utilisateur est connecté et n'a pas de cabine
        if ($user && !$user->cabine) {
            // Si la route actuelle n'est pas la création de cabine, on redirige
            if (!$request->routeIs('cabines.create') && !$request->routeIs('cabines.store')) {
                return redirect()->route('cabines.create')
                    ->with('warning', 'Veuillez d\'abord créer une cabine pour accéder à cette page.');
            }
        }
        
        return $next($request);
    }
}
