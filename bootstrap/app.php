<?php

declare(strict_types=1);

use App\Http\Middleware\JsonResponse;
use App\Http\Middleware\TransactionIdMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Sentry\Laravel\Integration;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/V1/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function(Middleware $middleware): void {
        $middleware->api(append: [
            TransactionIdMiddleware::class,
            JsonResponse::class,
        ]);
    })
    ->withExceptions(function(Exceptions $exceptions): void {
        Integration::handles($exceptions);
    })->create();