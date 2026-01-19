<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        // Define rate limiters for public API endpoints
        RateLimiter::for('auth', function (Request $request) {
            // Limit login and register attempts: 20 per minute per IP
            return Limit::perMinute(20)->by($request->ip());
        });

        RateLimiter::for('admissions', function (Request $request) {
            // Limit admission submissions: 20 per minute per IP
            return Limit::perMinute(20)->by($request->ip());
        });

        RateLimiter::for('public-dropdowns', function (Request $request) {
            // Limit dropdown data requests: 60 per minute per IP
            return Limit::perMinute(60)->by($request->ip());
        });
    }
}
