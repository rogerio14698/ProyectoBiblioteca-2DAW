<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\FooterConfig;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
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
     * Inicializar servicios de la aplicación.
     * Aquí compartimos datos globales con todas las vistas.
     */
    public function boot(): void
    {
        // Compartimos la configuración del footer con todas las vistas que usen el partial 'layouts.footer'.
        // firstOrCreate garantiza que siempre exista al menos una fila con valores por defecto.
        View::composer('layouts.footer', function ($view): void {
            $view->with('footerConfig', FooterConfig::firstOrCreate([]));
        });

        Paginator::defaultView('vendor.pagination.biblioteca');
        Paginator::defaultSimpleView('vendor.pagination.biblioteca-simple');

        // Formulario de contacto: 3 envíos por minuto y 15 al día por IP.
        RateLimiter::for('contacto', function (Request $request) {
            return [
                Limit::perMinute(3)->by($request->ip()),
                Limit::perDay(15)->by($request->ip()),
            ];
        });
    }
}
