<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
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

    //Hacer el logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('usuario.login.mostrar');
    }
}
