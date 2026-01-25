<?php
// ----------------------------------------------------------------------
// Used to configure the application, middleware, and exception handling.
// ----------------------------------------------------------------------
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Create and configure the application
return Application::configure(basePath: dirname(__DIR__))

    // Where to load routes from
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    // Configure middleware
    ->withMiddleware(function (Middleware $middleware): void {
        // Register middleware aliases here
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })

    // Configure exception handling
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();