<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias para el middleware que bloquea acciones de escritura a usuarios demo
        $middleware->alias([
            'bloquear.demo' => \App\Http\Middleware\BloquearUsuarioDemo::class,
        ]);

        // Redirigir a la ruta de login correcta según el guard que falle.
        // Si el guard es 'admin', redirige al login de admin; si no, al de usuario.
        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('admin/*') || $request->is('admin')) {
                return route('admin.login.mostrar');
            }
            return route('usuario.login.mostrar');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
