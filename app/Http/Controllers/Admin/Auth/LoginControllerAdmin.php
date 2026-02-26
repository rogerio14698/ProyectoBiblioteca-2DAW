<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
