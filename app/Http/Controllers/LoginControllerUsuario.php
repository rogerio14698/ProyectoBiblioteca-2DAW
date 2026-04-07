<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginControllerUsuario extends Controller
{
    //

    //Usuario de demostracion para produccion.
  public function loginDemo(Request $request): \Illuminate\Http\RedirectResponse{
    // Buscamos el usaurio demo en la base de datos

    $usuarioDemo = \App\Models\Usuario::where('is_demo', true)->first();

    if (!$usuarioDemo) {
        // Si no existe el usuario demo, redirigimos al login con un mensaje de error
        return redirect()->route('usuario.login.mostrar')->withErrors(['demo' => 'No se encontró el usuario de demostración.']);
    }

    // Autenticamos al usuario demo
    \Illuminate\Support\Facades\Auth::guard('usuario')->login($usuarioDemo);

    //Regeneramos la sesión para evitar problemas de seguridad
    $request->session()->regenerate();

    // Redirigimos al inicio del usuario
    return redirect()->route('usuario.inicio');
  }
}
