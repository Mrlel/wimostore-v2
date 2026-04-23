<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use App\Models\Visits;
use App\Models\Cabine;
use App\Models\CabinePage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class TrackVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $route = $request->route();
            $code = $route ? $route->parameter('code') : null;

            if (!$code) {
                return $next($request);
            }

            // Résolution cabine_id
            $cabineId = Cabine::where('code', $code)->value('id');
            if (!$cabineId) {
                $cabineId = CabinePage::where('code', $code)->value('cabine_id');
            }

            if ($cabineId) {
                $ip = $request->ip();
                $today = now()->format('Y-m-d');
                $cacheKey = "visit_{$ip}_{$today}_{$cabineId}";

                if (!Cache::has($cacheKey)) {
                    $this->recordVisit($request, $cabineId);
                    Cache::put($cacheKey, true, 86400);
                }
            }
        } catch (Exception $e) {
            Log::error('TrackVisits error: '.$e->getMessage(), [
                'url' => $request->fullUrl(),
                'route' => $request->route()?->getName(),
                'params' => $request->route()?->parameters(),
            ]);
            // Ne pas bloquer la requête si erreur
        }

        return $next($request);
    }

    protected function recordVisit(Request $request, int $cabineId)
    {
        try {
            Visits::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url'        => $request->fullUrl(),
                'visited_at' => now(),
                'cabine_id'  => $cabineId,
            ]);
        } catch (Exception $e) {
            Log::error('TrackVisits::recordVisit error: '.$e->getMessage());
        }
    }
}