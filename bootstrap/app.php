<?php

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Use Redis for rate limiting if available, otherwise use default
        if (config('cache.default') === 'redis') {
            $middleware->throttleWithRedis();
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();

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
