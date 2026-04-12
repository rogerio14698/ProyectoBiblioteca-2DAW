<?php
/**
 * @property-read \Illuminate\Contracts\Auth\StatefulGuard $guard
 */

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class LoginControllerAdmin extends Controller
{
    //Mostrar el login
    public function mostrarLogin()
    {
        return view('admin.auth.login');
    }


    //Hacer el login
    public function login(Request $request)
    {
        //Validacion estricta 
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        //Intento de hacer login como Admin
        try {
            $logueado = Auth::guard('admin')->attempt($credenciales, $request->boolean('recordar'));
        } catch (QueryException $exception) {
            throw ValidationException::withMessages([
                'email' => 'No hay conexión con la base de datos. Inicia MySQL e inténtalo de nuevo.',
            ]);
        }

        if (!$logueado) {
            throw ValidationException::withMessages([
                'email' => 'Las credenciales no son válidas.',
            ]);
        }

        //Regenerar Sesión para evitar fixación "fixation attacks"
        $request->session()->regenerate();

        //Actualizar last_login
        $admin = Auth::guard('admin')->user();
        if ($admin) {
            Admin::where('id', $admin->id)->update(['last_login' => now()]);
        }

        //Redirección a dashboard del admin
        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Autenticar automáticamente como administrador demo (solo lectura).
     * Busca al admin con is_demo = true y lo logea directamente sin contraseña.
     * @param Request $request La petición HTTP actual.
     * @return RedirectResponse Redirige al dashboard del admin.
     * @throws ValidationException Si el admin demo no existe en la base de datos.
     */
    public function loginDemo(Request $request): RedirectResponse
    {
        // Buscamos al administrador demo en la base de datos
        $adminDemo = Admin::where('is_demo', true)->first();

        // Si no existe el admin demo, devolvemos un error informativo
        if (!$adminDemo) {
            throw ValidationException::withMessages([
                'email' => 'El administrador demo no está disponible en este momento.',
            ]);
        }

        // Autenticamos directamente al admin demo con el guard 'admin'
        Auth::guard('admin')->login($adminDemo);

        // Regeneramos la sesión por seguridad (evitar ataques de fijación de sesión)
        $request->session()->regenerate();

        // Redirigimos al dashboard del administrador
        return redirect()->route('admin.dashboard');
    }

    //Cerrar sesion

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        //Una vez se cierre la sesion ir a la biblioteca pagina del login
        return redirect()->route('admin.login.mostrar');
    }
}
