<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // In development, throw an error when a relationship is lazy loaded (N+1 problem)

        Model::shouldBeStrict(! app()->isProduction());

        // Only admins can open the admin panel
        Gate::define('access-admin', function (User $user) {
            return $user->isAdmin();
        });

        $this->configureRateLimiting();
    }

    // All request limits for the website and the API, in one place
    private function configureRateLimiting(): void
    {
        // Every API request: logged-in users get more room than guests
        RateLimiter::for('api', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(120)->by('user:'.$request->user()->id)
                : Limit::perMinute(60)->by('ip:'.$request->ip());
        });

        // Login and register (website and API)
        RateLimiter::for('login', function (Request $request) {
            $email = Str::lower((string) $request->input('email'));

            return [
                // 5 tries per minute for one email from one IP: stops password guessing on one account
                Limit::perMinute(5)->by('login:'.$email.'|'.$request->ip()),
                // 20 tries per minute from one IP in total: stops one attacker trying many accounts
                Limit::perMinute(20)->by('login-ip:'.$request->ip()),
            ];
        });

        // Comments (website and API)
        RateLimiter::for('comments', function (Request $request) {
            return Limit::perMinute(5)->by('comments:'.($request->user()?->id ?? $request->ip()));
        });

        // Contact form (guests can use it, so limit by IP)
        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(3)->by('contact:'.$request->ip());
        });
    }
}
