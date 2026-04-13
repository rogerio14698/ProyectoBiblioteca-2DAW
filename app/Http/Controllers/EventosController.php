<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class EventosController extends Controller
{
    /**
     * Muestra la pantalla de gestión del carrusel.
     *
     * - Siempre carga el listado de eventos para pintarlo en la tabla.
     * - Si llega ?edit=ID en la URL, también carga ese evento para reutilizar
     *   el mismo formulario en modo edición.
     */
    public function adminCarrusel(Request $request)
    {
        // Obtenemos todos los eventos con su usuario para evitar consultas extra en Blade.
        $eventos = Evento::with('usuario')->latest()->get();

        // Por defecto no estamos editando ningún evento.
        $eventoEditar = null;

        // Si la URL trae ?edit=ID, intentamos cargar ese evento para rellenar el formulario.
        if ($request->filled('edit')) {
            $eventoEditar = Evento::find($request->query('edit'));
        }

        // Enviamos las dos variables a la misma vista.
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarCarruselHome', [
            'eventos' => $eventos,
            'eventoEditar' => $eventoEditar,
        ]);  
    }
    // Método para mostrar la página interna de un evento específico.
    public function paginaInterna($id)
    {
        $evento = Evento::findOrFail($id);
        return view('bibliotecaDAW.publicViews.paginasInternas.paginaInternaEvento', compact('evento'));
    }
    // Método para mostrar la página de apuntarse a un evento específico.
    public function apuntarse($id)
    {
        $evento = Evento::findOrFail($id);
        return view('bibliotecaDAW.publicViews.paginasInternas.paginaInternaApuntarseEvento', compact('evento'));
    }

    /**
     * Procesar la inscripción de un usuario autenticado a un evento.
     * Registra la relación en la tabla pivote 'evento_usuario' e incrementa asistentes.
     *
     * @param Request $request Datos del formulario (nombre, apellido, email, nsocio, telefono).
     * @param int     $id      ID del evento al que inscribirse.
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito o error.
     * @sideEffect Inserta registro en tabla pivote 'evento_usuario'.
     * @sideEffect Incrementa el campo 'asistentes' del evento.
     */
    public function procesarApuntarse(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        // Validamos los campos del formulario de inscripción.
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'nsocio'   => 'required|string|max:50',
            'telefono' => 'required|string|max:20',
        ]);

        // Buscamos el evento o lanzamos 404.
        $evento = Evento::findOrFail($id);

        // Verificamos que haya plazas libres antes de inscribir.
        if ($evento->plazas_libres <= 0) {
            return redirect()->back()->with('error', 'No quedan plazas disponibles para este evento.');
        }

        // Obtenemos el ID del usuario autenticado.
        $usuarioId = \Illuminate\Support\Facades\Auth::id();

        // Verificamos que el usuario no esté ya inscrito (evitar duplicados).
        if ($evento->usuariosInscritos()->where('usuario_id', $usuarioId)->exists()) {
            return redirect()->back()->with('error', 'Ya estás inscrito en este evento.');
        }

        // Registramos la inscripción en la tabla pivote con fecha actual y estado 'inscrito'.
        $evento->usuariosInscritos()->attach($usuarioId, [
            'fecha_inscripcion' => now(),
            'estado'            => 'inscrito',
        ]);

        // Incrementamos el contador de asistentes del evento.
        $evento->increment('asistentes');

        return redirect()->back()->with('success', 'Te has inscrito correctamente al evento «' . $evento->titulo . '».');
    }

    /**
     * Dar de baja a un usuario autenticado de un evento.
     * Elimina el registro de la tabla pivote 'evento_usuario' y decrementa asistentes.
     * La columna 'plazas_libres' se recalcula automáticamente (storedAs en la migración).
     *
     * @param int $id ID del evento del que darse de baja.
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito o error.
     * @sideEffect Elimina registro en tabla pivote 'evento_usuario'.
     * @sideEffect Decrementa el campo 'asistentes' del evento.
     */
    public function darseDeBaja(int $id): \Illuminate\Http\RedirectResponse
    {
        // Buscamos el evento o lanzamos 404.
        $evento = Evento::findOrFail($id);

        // Obtenemos el ID del usuario autenticado.
        $usuarioId = \Illuminate\Support\Facades\Auth::id();

        // Verificamos que el usuario esté inscrito antes de intentar desvincularlo.
        if (!$evento->usuariosInscritos()->where('usuario_id', $usuarioId)->exists()) {
            return redirect()->back()->with('error', 'No estás inscrito en este evento.');
        }

        // Eliminamos la inscripción de la tabla pivote.
        $evento->usuariosInscritos()->detach($usuarioId);

        // Decrementamos el contador de asistentes (plazas_libres se recalcula solo).
        $evento->decrement('asistentes');

        return redirect()->back()->with('success', 'Te has dado de baja del evento «' . $evento->titulo . '».');
    }

    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.gestionCarrusel');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Detectamos en tiempo real si la columna existe para no romper en BD antiguas.
        $hasPrioridadColumn = Schema::hasColumn('eventos', 'prioridad');

        $rules = [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_hora' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ubicacion' => 'required|string|max:255',
        ];

        if ($hasPrioridadColumn) {
            $rules['prioridad'] = 'nullable|integer|min:1|max:3';
        }

        $request->validate($rules);
        //Generamos el evento
        $nuevoEvento = new Evento();
        $nuevoEvento->titulo = $request->titulo;
        $nuevoEvento->descripcion = $request->descripcion;
        $nuevoEvento->fecha_hora = $request->fecha_hora;
        $nuevoEvento->ubicacion = $request->ubicacion;

        // Solo guardamos prioridad cuando la columna existe realmente en la tabla.
        if ($hasPrioridadColumn) {
            $nuevoEvento->prioridad = $request->prioridad ?? 1;
        }

        // Si el usuario ha subido imagen, la almacenamos en disco publico y guardamos la ruta.
        if ($request->hasFile('imagen')) {
            $pathImagen = $request->file('imagen')->store('eventos', 'public');
            $nuevoEvento->imagen_url = $pathImagen;
        }

        // Cambio aplicado: usuario_id se toma de tabla usuarios (no del guard admin) para respetar la FK
        $usuarioId = Usuario::query()->value('id');
        if (!$usuarioId) {
            return back()->withErrors(['usuario_id' => 'No hay usuarios registrados para asociar el evento.'])->withInput();
        }

        $nuevoEvento->usuario_id = $usuarioId;

        $nuevoEvento->save();
        return redirect()->route('admin.gestionCarrusel');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Detectamos en tiempo real si la columna existe para no romper en BD antiguas.
        $hasPrioridadColumn = Schema::hasColumn('eventos', 'prioridad');

        // Validamos exactamente los mismos campos que en creación para mantener coherencia.
        $rules = [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_hora' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ubicacion' => 'required|string|max:255',
        ];

        if ($hasPrioridadColumn) {
            $rules['prioridad'] = 'nullable|integer|min:1|max:3';
        }

        $request->validate($rules);

        // Buscamos el evento por ID; si no existe Laravel lanza 404 automáticamente.
        $evento = Evento::findOrFail($id);

        // Actualizamos los datos editables del evento.
        $evento->titulo = $request->titulo;
        $evento->descripcion = $request->descripcion;
        $evento->fecha_hora = $request->fecha_hora;
        $evento->ubicacion = $request->ubicacion;

        // Solo guardamos prioridad cuando la columna existe realmente en la tabla.
        if ($hasPrioridadColumn) {
            $evento->prioridad = $request->prioridad ?? 1;
        }

        // Si llega una imagen nueva, borramos la anterior del disco y guardamos la nueva.
        if ($request->hasFile('imagen')) {
            // Eliminamos la imagen anterior si existia en almacenamiento local.
            if ($evento->imagen_url) {
                Storage::disk('public')->delete($evento->imagen_url);
            }
            $pathImagen = $request->file('imagen')->store('eventos', 'public');
            $evento->imagen_url = $pathImagen;
        }

        // Guardamos los cambios en base de datos.
        $evento->save();

        // Volvemos a la pantalla principal del carrusel con mensaje de confirmación.
        return redirect()->route('admin.gestionCarrusel')->with('success', 'Evento actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Busca el evento o devuevle 404 si falla
        $evento = Evento::findOrFail($id);

        // Eliminamos la imagen del disco si existia antes de borrar el registro.
        if ($evento->imagen_url) {
            Storage::disk('public')->delete($evento->imagen_url);
        }

        //Eliminar registros de la base de datos.
        $evento->delete();

        return redirect()->route('admin.gestionCarrusel')->with('success', 'Evento eliminado con éxito.');
    }
}