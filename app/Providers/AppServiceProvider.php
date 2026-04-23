<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notifications_stock;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

public function boot(): void
{
    // Ajouter ici le View Composer
    View::composer(['layouts.app', 'layouts.base', 'ventes.create'], function ($view) {
        if (auth()->check()) {
            $notifications = \App\Models\Notifications_stock::where('cabine_id', auth()->user()->cabine_id)
                ->where('vu', false)
                ->latest()
                ->get();
            $view->with('notifications', $notifications);
        }
    });

    if ($this->app->environment('local')) {
        Http::macro('moneyfusion', function () {
            return Http::withoutVerifying()->acceptJson()->timeout(30);
        });
    } else {
        Http::macro('moneyfusion', function () {
            return Http::acceptJson()->timeout(30);
        });
    }

}



}
