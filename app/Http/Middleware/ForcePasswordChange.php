<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (auth()->check()) {
            $user = auth()->user();
            
            // Vérifier si l'utilisateur doit changer son mot de passe
            if ($user->mustChangePassword()) {
                // Exclure certaines routes pour éviter les boucles infinies
                $excludedRoutes = [
                    'password.change',
                    'password.update',
                    'logout'
                ];
                
                // Si la route actuelle n'est pas dans les exclusions, rediriger
                if (!in_array($request->route()->getName(), $excludedRoutes)) {
                    return redirect()->route('password.change');
                }
            }
        }
        
        return $next($request);
    }
}
