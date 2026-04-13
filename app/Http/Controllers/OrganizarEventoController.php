<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Controlador para la creación de eventos por parte de usuarios autenticados.
 * Gestiona el formulario de /organizarEvento y la subida de imagen del evento.
 */
class OrganizarEventoController extends Controller
{
    /**
     * Mostrar el formulario de creación de evento junto con los eventos del usuario.
     *
     * @return View Vista con el formulario y listado de eventos propios.
     */
    public function index(): View
    {
        // Obtenemos los eventos creados por el usuario autenticado, ordenados por fecha.
        $misEventos = Evento::where('usuario_id', Auth::id())
            ->orderBy('fecha_hora', 'desc')
            ->get();

        // Obtenemos los eventos en los que el usuario está inscrito (tabla pivote).
        $eventosInscritos = Usuario::findOrFail(Auth::id())
            ->eventosInscritos()
            ->orderBy('fecha_hora', 'desc')
            ->get();

        return view('bibliotecaDAW.userViews.organizarEvento', [
            'misEventos'       => $misEventos,
            'eventosInscritos' => $eventosInscritos,
        ]);
    }

    /**
     * Almacenar un nuevo evento creado por el usuario autenticado.
     * Si se sube imagen, se guarda con nombre hasheado en storage/app/public/eventos/.
     *
     * @param Request $request Datos del formulario de creación.
     * @return RedirectResponse Redirección con mensaje de éxito o errores.
     * @sideEffect Crea un registro en la tabla 'eventos'.
     * @sideEffect Puede crear un archivo en storage/app/public/eventos/.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validamos todos los campos del formulario de creación.
        $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'required|string|max:2000',
            'fecha'       => 'required|date|after:today',
            'hora'        => 'required|date_format:H:i',
            'ubicacion'   => 'required|string|max:255',
            'aforo'       => 'required|integer|min:1|max:10000',
            'prioridad'   => 'required|integer|min:1|max:3',
            'imagen'      => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
        ]);

        // Combinamos fecha y hora en un solo campo datetime para la base de datos.
        $fechaHora = $request->input('fecha') . ' ' . $request->input('hora') . ':00';

        // Si el usuario sube una imagen, la guardamos con nombre hasheado.
        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            // store() genera automáticamente un nombre hasheado único (ej: aB3x9Ks...jpg).
            // Se guarda en storage/app/public/eventos/ con enlace simbólico a public/storage/.
            $rutaImagen = $request->file('imagen')->store('eventos', 'public');
        }

        // Creamos el evento asociado al usuario autenticado.
        Evento::create([
            'titulo'      => $request->input('titulo'),
            'descripcion' => $request->input('descripcion'),
            'fecha_hora'  => $fechaHora,
            'ubicacion'   => $request->input('ubicacion'),
            'aforo'       => $request->input('aforo'),
            'prioridad'   => $request->input('prioridad'),
            'imagen_url'  => $rutaImagen,
            'usuario_id'  => Auth::id(),
        ]);

        // Redirigimos al formulario con mensaje de éxito.
        return redirect()->route('usuario.organizarEvento')
            ->with('success', 'Evento creado correctamente. Aparecerá en la sección de actividades.');
    }
}
