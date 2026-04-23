<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\CabinePage::class => \App\Policies\CabinePagePolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('manage-gestionnaires', function ($user) {
            return $user && $user->role === 'responsable';
        });

        Gate::define('superadmin', function ($user) {
            return $user && $user->role === 'superadmin';
        });

        Gate::define('manage-certifications', function ($user) {
            return $user && $user->role === 'superadmin';
        });
    }
}
