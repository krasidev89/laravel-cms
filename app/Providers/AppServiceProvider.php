<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        Gate::define('manage_system', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('sync', function (User $user) {
            return $user->is_admin && config('analytics.property_id');
        });

        Password::defaults(function () {
            return Password::min(6);
        });
    }
}
