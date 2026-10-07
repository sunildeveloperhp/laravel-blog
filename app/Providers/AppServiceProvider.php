<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // In development, throw an error when a relationship is lazy loaded (N+1 problem)
        Model::preventLazyLoading(! app()->isProduction());

        // Only admins can open the admin panel
        Gate::define('access-admin', function (User $user) {
            return $user->isAdmin();
        });
    }
}
