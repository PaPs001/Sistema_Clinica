<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\rolesMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Additional route configuration if needed
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);
        $middleware->validateCsrfTokens(except: [
            '/api/*',
        ]);
        $middleware->alias([
            'role' => rolesMiddleware::class,
            'auth' => Authenticate::class,
        ]);
        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $Exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('app:recordatorios-citas')->dailyAt('07:00');
    })->create();
