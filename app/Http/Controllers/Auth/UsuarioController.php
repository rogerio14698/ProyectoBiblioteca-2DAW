<?php

namespace App\Http\Controllers\Auth;

use App\Models\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Mostrar el formulario de registro
     */
    public function showRegistro()
    {
        return view('bibliotecaDAW.publicViews.registro');
    }

    /**
     * Guardar un nuevo usuario en la base de datos
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'dni' => 'required|string|unique:usuarios,dni',
            'movil' => 'nullable|string|unique:usuarios,movil',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // El modelo Usuario se encarga de hashear la contraseña y generar el nSocio
        Usuario::create($validated);

        return redirect('/biblioteca')->with('success', 'Registro completado exitosamente. ¡Bienvenido!');
    }
}
