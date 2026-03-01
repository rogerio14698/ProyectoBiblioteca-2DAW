<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obtener todos los eventos
        $eventos = Evento::all();
        return view('eventos.index', [
            'eventos' => $eventos
        ]);
    }

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

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_hora' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ubicacion' => 'required|string|max:255',
            'prioridad' => 'nullable|integer|min:1|max:3',
        ]);
        //Generamos el evento
        $nuevoEvento = new Evento();
        $nuevoEvento->titulo = $request->titulo;
        $nuevoEvento->descripcion = $request->descripcion;
        $nuevoEvento->fecha_hora = $request->fecha_hora;
        $nuevoEvento->ubicacion = $request->ubicacion;
        $nuevoEvento->prioridad = $request->prioridad ?? 1;
        //Vamos a dejar un espacio para la imagen, eso luego la gestionamos

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
        // Validamos exactamente los mismos campos que en creación para mantener coherencia.
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_hora' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ubicacion' => 'required|string|max:255',
            'prioridad' => 'nullable|integer|min:1|max:3',
        ]);

        // Buscamos el evento por ID; si no existe Laravel lanza 404 automáticamente.
        $evento = Evento::findOrFail($id);

        // Actualizamos los datos editables del evento.
        $evento->titulo = $request->titulo;
        $evento->descripcion = $request->descripcion;
        $evento->fecha_hora = $request->fecha_hora;
        $evento->ubicacion = $request->ubicacion;
        $evento->prioridad = $request->prioridad ?? 1;

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

        //Deja un espacio para borrar la imagen en un futuro.


        //Eliminar registros de la base de datos.
        $evento->delete();

        return redirect()->route('admin.gestionCarrusel')->with('success', 'Evento eliminado con éxito.');
    }
}