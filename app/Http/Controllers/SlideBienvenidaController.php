<?php

namespace App\Http\Controllers;

use App\Models\SlideBienvenida;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class SlideBienvenidaController extends Controller
{
    /**
     * Muestra la vista de gestión de Home con listado de slides.
     *
     * @param Request $request Petición HTTP para detectar si estamos en modo edición.
     * @return View Vista con listado de slides y, opcionalmente, slide a editar.
     */
    public function adminHome(Request $request): View
    {
        // Obtenemos los slides ordenados por posicion y, como desempate, por fecha.
        $slidesBienvenida = SlideBienvenida::orderBy('posicion')->orderBy('created_at', 'desc')->get();

        // Por defecto no se está editando ningún slide.
        $slideEditar = null;

        // Si llega ?edit=ID, buscamos ese slide para precargar el formulario.
        if ($request->filled('edit')) {
            $slideEditar = SlideBienvenida::find($request->query('edit'));
        }

        // Renderizamos la misma vista para crear y editar (enfoque DRY).
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarHome', [
            'slidesBienvenida' => $slidesBienvenida,
            'slideEditar' => $slideEditar,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Guarda un nuevo slide de bienvenida.
     *
     * @param Request $request Datos del formulario de creación.
     * @return RedirectResponse Redirección a la pantalla de gestión con mensaje de éxito.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validamos los campos mínimos del formulario para proteger integridad de datos.
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'url' => 'nullable|url|max:255',
            'posicion' => 'nullable|integer|min:1',
        ]);

        // Si el usuario no define posicion, se asigna al final del listado actual.
        $posicionFinal = $validatedData['posicion'] ?? ((SlideBienvenida::max('posicion') ?? 0) + 1);

        // Guardamos la imagen en disco público y persistimos la ruta final para mostrarla.
        $pathImagen = $request->file('imagen')->store('slides-bienvenida', 'public');

        // Creamos el slide con los datos validados usando asignación masiva segura.
        SlideBienvenida::create([
            'titulo' => $validatedData['titulo'],
            'descripcion' => $validatedData['descripcion'],
            'imagen' => 'storage/' . $pathImagen,
            'url' => $validatedData['url'] ?? null,
            'posicion' => $posicionFinal,
        ]);

        return redirect()->route('admin.gestionHome')->with('success', 'Slide creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SlideBienvenida $slideBienvenida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SlideBienvenida $slideBienvenida)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Actualiza un slide existente reutilizando el mismo formulario.
     *
     * @param Request $request Datos del formulario de edición.
     * @param int $id Identificador del slide a actualizar.
     * @return RedirectResponse Redirección a la pantalla de gestión con mensaje de éxito.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Buscamos el slide o devolvemos 404 automáticamente si no existe.
        $slideBienvenida = SlideBienvenida::findOrFail($id);

        // En edición, la imagen es opcional para no obligar a subirla de nuevo.
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'url' => 'nullable|url|max:255',
            'posicion' => 'nullable|integer|min:1',
        ]);

        // Si llega una imagen nueva, borramos la anterior (si era local) y guardamos la nueva.
        if ($request->hasFile('imagen')) {
            if ($slideBienvenida->imagen && str_starts_with($slideBienvenida->imagen, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $slideBienvenida->imagen));
            }

            $pathImagen = $request->file('imagen')->store('slides-bienvenida', 'public');
            $slideBienvenida->imagen = 'storage/' . $pathImagen;
        }

        // Actualizamos datos editables comunes.
        $slideBienvenida->titulo = $validatedData['titulo'];
        $slideBienvenida->descripcion = $validatedData['descripcion'];
        $slideBienvenida->url = $validatedData['url'] ?? null;
        $slideBienvenida->posicion = $validatedData['posicion'] ?? $slideBienvenida->posicion;
        $slideBienvenida->save();

        return redirect()->route('admin.gestionHome')->with('success', 'Slide actualizado correctamente.');
    }

    /**
     * Eliminar un slide de bienvenida de la base de datos.
     * @param int $id Identificador del slide a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito.
     * @effect Elimina el registro del slide en la tabla slide_bienvenidas.
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        // Buscamos el slide por su ID o lanzamos un 404 si no existe.
        $slide = SlideBienvenida::findOrFail($id);

        // Eliminamos el slide de la base de datos.
        $slide->delete();

        return redirect()->back()->with('success', 'Slide eliminado correctamente.');
    }
}
