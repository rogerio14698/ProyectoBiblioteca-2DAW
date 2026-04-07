<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware que bloquea las acciones de escritura (POST, PUT, PATCH, DELETE)
 * para los usuarios demo, tanto del guard 'web' (usuario) como del guard 'admin'.
 * Solo permite peticiones GET (navegar y ver) y POST al logout (para que pueda cerrar sesión).
 */
class BloquearUsuarioDemo
{
    /**
     * Intercepta la petición y comprueba si el usuario autenticado es demo.
     * Si es demo y la petición es de escritura (no GET), la bloquea con un mensaje.
     * @param Request $request La petición HTTP entrante.
     * @param Closure $next El siguiente middleware en la cadena.
     * @return Response La respuesta HTTP.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Comprobamos si hay un usuario autenticado en el guard 'web' (usuario normal)
        $usuario = Auth::guard('web')->user();

        // Comprobamos si hay un usuario autenticado en el guard 'admin' (administrador)
        $admin = Auth::guard('admin')->user();

        // Determinamos si el usuario actual es demo (en cualquiera de los dos guards)
        $esDemo = false;

        if ($usuario && $usuario->is_demo) {
            $esDemo = true;
        }

        if ($admin && $admin->is_demo) {
            $esDemo = true;
        }

        // Si no es usuario demo, dejamos pasar la petición sin restricciones
        if (!$esDemo) {
            return $next($request);
        }

        // Si es demo, solo permitimos peticiones GET (navegar) y POST al logout
        // para que el usuario demo pueda cerrar sesión sin problemas
        $esLogout = $request->routeIs('usuario.logout') || $request->routeIs('admin.logout') || $request->routeIs('logout');

        // Si la petición NO es GET y NO es un logout, la bloqueamos
        if (!$request->isMethod('GET') && !$esLogout) {
            // Redirigimos de vuelta con un mensaje flash de advertencia
            return redirect()->back()->with('demo_warning', 'Función no disponible en modo demostración. Esta cuenta es solo de lectura.');
        }

        // Si es GET o logout, dejamos pasar la petición
        return $next($request);
    }
}
