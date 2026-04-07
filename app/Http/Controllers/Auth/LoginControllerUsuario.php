<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginControllerUsuario extends Controller
{
    //Validacion
    public function mostrarLogin()
    {
        return view('bibliotecaDAW.publicViews.login');
    }

    //Hacer el login

    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        //Ahora verificamos con el Auth::Guard

        try {
            $logueado = Auth::guard('web')->attempt($credenciales, $request->boolean('recordar'));
        } catch (QueryException $exception) {
            throw ValidationException::withMessages([
                'email' => 'No hay conexión con la base de datos. Inicia MySQL e inténtalo de nuevo.',
            ]);
        }

        if (!$logueado) {
            throw ValidationException::withMessages([
                'email' => 'Credenciales incorrectas.',
            ]);
        }

        $request->session()->regenerate();
        return redirect()->intended(route('usuario.inicio'));
    }

    /**
     * Autenticar automáticamente como usuario demo (solo lectura).
     * Busca al usuario con is_demo = true y lo logea directamente sin contraseña.
     * @param Request $request La petición HTTP actual.
     * @return RedirectResponse Redirige al inicio del perfil de usuario.
     * @throws ValidationException Si el usuario demo no existe en la base de datos.
     */
    public function loginDemo(Request $request): RedirectResponse
    {
        // Buscamos al usuario demo en la base de datos por el campo is_demo
        $usuarioDemo = Usuario::where('is_demo', true)->first();

        // Si no existe el usuario demo, devolvemos un error informativo
        if (!$usuarioDemo) {
            throw ValidationException::withMessages([
                'email' => 'El usuario demo no está disponible en este momento.',
            ]);
        }

        // Autenticamos directamente al usuario demo sin pedir contraseña
        Auth::guard('web')->login($usuarioDemo);

        // Regeneramos la sesión por seguridad (evitar ataques de fijación de sesión)
        $request->session()->regenerate();

        // Redirigimos al inicio del perfil de usuario
        return redirect()->route('usuario.inicio');
    }

    //Hacer el logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('usuario.login.mostrar');
    }
}
