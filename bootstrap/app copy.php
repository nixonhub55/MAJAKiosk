<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckInternetConnection;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) { 
        
        $middleware->append(CheckInternetConnection::class); // disable this for no internet connection

        $middleware->alias(['isAuthenticated' => \App\Http\Middleware\CheckSession::class]);
    }) 
    ->withExceptions(function (Exceptions $exceptions) {
        //remove this for error single track
         $exceptions->report(function (Throwable $e) {

            Log::error($e->getMessage(), [
                'file'   => $e->getFile(),
                'line'   => $e->getLine(),
                'url'    => request()->fullUrl(),
                'method' => request()->method(),
                'ip'     => request()->ip(),
            ]);

            // Prevent Laravel's default logging (which includes the stack trace)
            return false;
        });
    })->create();
