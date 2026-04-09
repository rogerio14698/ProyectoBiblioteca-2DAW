<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador para la gestión de usuarios y administradores desde el panel de admin.
 * Permite listar, buscar, editar y dar de baja usuarios registrados,
 * así como visualizar el listado de administradores del sistema.
 */
class GestionUsuariosController extends Controller
{
    /**
     * Mostrar la vista principal de gestión de usuarios y administradores.
     * Acepta filtros de búsqueda opcionales para los usuarios.
     *
     * @param Request $request Petición HTTP con posibles filtros (nombre, nSocio, dni, email).
     * @return View Vista con las variables $usuarios, $admins y $usuarioEditar.
     */
    public function index(Request $request): View
    {
        // Iniciamos la consulta base de usuarios.
        $query = Usuario::query();

        // Aplicamos filtros de búsqueda si se proporcionan en la URL.
        if ($request->filled('nombre')) {
            $query->where('name', 'like', '%' . $request->input('nombre') . '%');
        }
        if ($request->filled('nSocio')) {
            $query->where('nSocio', 'like', '%' . $request->input('nSocio') . '%');
        }
        if ($request->filled('dni')) {
            $query->where('dni', 'like', '%' . $request->input('dni') . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }

        // Ordenamos por fecha de creación (más recientes primero).
        $usuarios = $query->orderBy('created_at', 'desc')->get();

        // Obtenemos todos los administradores del sistema.
        $admins = Admin::orderBy('name', 'asc')->get();

        // Si viene el parámetro ?edit=ID, cargamos ese usuario en el formulario de edición.
        $usuarioEditar = null;
        if ($request->has('edit')) {
            $usuarioEditar = Usuario::find($request->input('edit'));
        }

        // Devolvemos la vista con los datos necesarios.
        return view('bibliotecaDAW.adminViews.GestionarUsuarios.gestionarUsuarios', [
            'usuarios'      => $usuarios,
            'admins'        => $admins,
            'usuarioEditar' => $usuarioEditar,
        ]);
    }

    /**
     * Actualizar los datos de un usuario existente.
     * Solo permite modificar nombre, email, móvil y DNI (no contraseña desde aquí).
     *
     * @param Request $request Datos del formulario de edición.
     * @param int $id Identificador del usuario a actualizar.
     * @return RedirectResponse Redirección con mensaje flash.
     * @sideEffect Modifica un registro en la tabla 'usuarios'.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Validamos los campos editables del usuario.
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $id,
            'dni'   => 'required|string|unique:usuarios,dni,' . $id,
            'movil' => 'nullable|string|unique:usuarios,movil,' . $id,
        ]);

        try {
            // Buscamos el usuario por ID. Si no existe, lanza 404.
            $usuario = Usuario::findOrFail($id);

            // Actualizamos solo los campos permitidos.
            $usuario->update([
                'name'  => $request->input('name'),
                'email' => $request->input('email'),
                'dni'   => $request->input('dni'),
                'movil' => $request->input('movil'),
            ]);

            return redirect()->route('admin.gestionUsuarios')->with('success', 'Usuario actualizado correctamente.');

        } catch (\Exception $e) {
            return redirect()->route('admin.gestionUsuarios')->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Dar de baja (eliminar) a un usuario del sistema.
     *
     * @param int $id Identificador del usuario a eliminar.
     * @return RedirectResponse Redirección con mensaje flash.
     * @sideEffect Elimina un registro de la tabla 'usuarios'.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Buscamos el usuario. Si no existe, lanza 404.
            $usuario = Usuario::findOrFail($id);

            // Eliminamos el usuario de la base de datos.
            $usuario->delete();

            return redirect()->route('admin.gestionUsuarios')->with('success', 'Usuario dado de baja correctamente.');

        } catch (\Exception $e) {
            return redirect()->route('admin.gestionUsuarios')->with('error', 'Error al dar de baja al usuario: ' . $e->getMessage());
        }
    }
}
