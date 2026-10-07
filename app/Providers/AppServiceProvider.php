<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // In development, throw an error when a relationship is lazy loaded (N+1 problem).
        // On the live site this is switched off, so visitors never see the error.
        Model::preventLazyLoading(! app()->isProduction());
    }
}