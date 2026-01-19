<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Use Redis for rate limiting if CACHE_DRIVER is set to redis
        $cacheDriver = getenv('CACHE_DRIVER') ?: ($_ENV['CACHE_DRIVER'] ?? $_SERVER['CACHE_DRIVER'] ?? null);
        if ($cacheDriver === 'redis') {
            $middleware->throttleWithRedis();
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
