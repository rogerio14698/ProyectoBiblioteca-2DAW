<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Usuario;

/**
 * Controlador para la gestión del perfil de usuario.
 * Se encarga de recopilar toda la información necesaria
 * para mostrar el perfil con sus historiales de actividad.
 */
class PerfilController extends Controller
{
    /**
     * Mostrar la vista del perfil del usuario autenticado.
     * Carga préstamos, inscripciones a eventos, compras y publicaciones
     * del usuario actual para mostrar en su historial de actividad.
     *
     * @return View Vista del perfil con los datos del usuario.
     */
    public function index(): View
    {
        // Obtenemos el usuario autenticado y lo casteamos al modelo Usuario.
        /** @var Usuario $usuario */
        $usuario = Auth::user();

        // Cargamos los préstamos del usuario con la relación del libro.
        // Ordenamos por fecha de préstamo descendente (más recientes primero).
        $prestamos = $usuario->prestamos()
            ->with('libro:id,titulo,isbn')
            ->orderBy('fecha_prestamo', 'desc')
            ->get();

        // Cargamos los eventos a los que el usuario se ha inscrito.
        // Accedemos a los datos del evento y al estado de la inscripción vía pivot.
        $eventosInscritos = $usuario->eventosInscritos()
            ->orderBy('fecha_hora', 'desc')
            ->get();

        // Cargamos las compras del usuario con la relación del libro.
        // Ordenamos por fecha de compra descendente.
        $compras = $usuario->compras()
            ->with('libro:id,titulo,isbn')
            ->orderBy('fecha_compra', 'desc')
            ->get();

        // Cargamos las publicaciones del usuario.
        // Ordenamos por fecha de publicación descendente.
        $publicaciones = $usuario->publicaciones()
            ->orderBy('fecha_publicacion', 'desc')
            ->get();

        // Retornamos la vista con todos los datos necesarios para el perfil.
        return view('bibliotecaDAW.userViews.perfil', [
            'prestamos'        => $prestamos,
            'eventosInscritos' => $eventosInscritos,
            'compras'          => $compras,
            'publicaciones'    => $publicaciones,
        ]);
    }

    /**
     * Mostrar el formulario de edición del perfil.
     *
     * @return View Vista del formulario de edición.
     */
    public function edit(): View
    {
        return view('bibliotecaDAW.userViews.perfilEditar');
    }

    /**
     * Actualizar los datos personales y la foto de perfil del usuario.
     * Si se sube una nueva foto, se elimina la anterior del disco
     * y se guarda la nueva con nombre hasheado para seguridad.
     *
     * @param Request $request Datos del formulario de edición.
     * @return RedirectResponse Redirección al formulario con mensaje de éxito.
     * @sideEffect Modifica el registro del usuario en la tabla 'usuarios'.
     * @sideEffect Puede crear/eliminar archivos en storage/app/public/profile-photos.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validamos los campos del formulario (email no se incluye, es de solo lectura).
        $request->validate([
            'name'          => 'required|string|max:255',
            'dni'           => 'required|string|max:20|unique:usuarios,dni,' . Auth::id(),
            'movil'         => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        /** @var Usuario $usuario */
        $usuario = Auth::user();

        // Actualizamos los datos básicos del usuario (email no se modifica).
        $usuario->name  = $request->input('name');
        $usuario->dni   = $request->input('dni');
        $usuario->movil = $request->input('movil');

        // Si el usuario sube una nueva foto de perfil.
        if ($request->hasFile('profile_photo')) {
            // Si ya tenía una foto anterior, la eliminamos del disco.
            if ($usuario->profile_photo_path) {
                Storage::disk('public')->delete($usuario->profile_photo_path);
            }

            // Guardamos la nueva foto con nombre hasheado (hashName() genera un nombre único).
            // Se guarda en storage/app/public/profile-photos/ con enlace simbólico a public/storage/.
            $path = $request->file('profile_photo')->store('profile-photos', 'public');

            // Almacenamos la ruta relativa en la base de datos.
            $usuario->profile_photo_path = $path;
        }

        // Guardamos todos los cambios en la base de datos.
        $usuario->save();

        // Redirigimos de vuelta al formulario con mensaje de éxito.
        return redirect()->route('usuario.perfilEditar')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Cambiar la contraseña del usuario autenticado.
     * Requiere la contraseña actual para verificar la identidad
     * y la nueva contraseña repetida dos veces para confirmar.
     *
     * @param Request $request Datos del formulario de cambio de contraseña.
     * @return RedirectResponse Redirección al formulario con mensaje de éxito o error.
     * @sideEffect Modifica la contraseña en la tabla 'usuarios'.
     */
    public function changePassword(Request $request): RedirectResponse
    {
        // Validamos que la contraseña actual sea correcta y la nueva se confirme.
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:8|confirmed',
        ]);

        /** @var Usuario $usuario */
        $usuario = Auth::user();

        // Verificamos que la contraseña actual proporcionada sea correcta.
        if (!Hash::check($request->input('current_password'), $usuario->password)) {
            // Si no coincide, devolvemos error al campo correspondiente.
            return back()->withErrors([
                'current_password' => 'La contraseña actual no es correcta.',
            ]);
        }

        // Actualizamos la contraseña (el cast 'hashed' del modelo la hashea automáticamente).
        $usuario->password = $request->input('new_password');
        $usuario->save();

        // Redirigimos con mensaje de éxito.
        return redirect()->route('usuario.perfilEditar')
            ->with('password_success', 'Contraseña actualizada correctamente.');
    }
}