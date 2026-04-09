<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Noticias;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador CRUD para la gestión de noticias desde el panel de administración.
 * Permite listar, crear, editar y eliminar noticias almacenadas en la tabla 'noticias'.
 */
class NoticiasController extends Controller
{
    /**
     * Mostrar la vista de gestión de noticias con el listado completo.
     * Si se recibe el parámetro ?edit=ID, se carga esa noticia en el formulario para editarla.
     *
     * @param Request $request Petición HTTP con posible parámetro 'edit'.
     * @return View Vista de gestión con las variables $noticias y $noticiaEditar.
     */
    public function gestionNoticias(Request $request): View
    {
        // Obtenemos todas las noticias ordenadas por fecha de publicación (más recientes primero).
        $noticias = Noticias::orderBy('fecha_publicacion', 'desc')->get();

        // Si viene el parámetro ?edit=ID, buscamos esa noticia para rellenar el formulario.
        $noticiaEditar = null;
        if ($request->has('edit')) {
            $noticiaEditar = Noticias::find($request->input('edit'));
        }

        // Devolvemos la vista con las noticias y la noticia en edición (si existe).
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarNoticias', [
            'noticias'      => $noticias,
            'noticiaEditar' => $noticiaEditar,
        ]);
    }

    /**
     * Mostrar la página interna (pública) de una noticia específica.
     *
     * @param int $id Identificador de la noticia.
     * @return View Vista pública de la noticia.
     */
    public function paginaInterna(int $id): View
    {
        // Buscamos la noticia por su ID. Si no existe, lanza un 404 automático.
        $noticia = Noticias::findOrFail($id);

        return view('bibliotecaDAW.publicViews.paginasInternas.paginaInternaNoticias', compact('noticia'));
    }

    /**
     * Almacenar una nueva noticia en la base de datos.
     * Valida los datos del formulario antes de guardar.
     *
     * @param Request $request Datos del formulario de creación.
     * @return RedirectResponse Redirección a la vista de gestión con mensaje de éxito o error.
     * @sideEffect Crea un nuevo registro en la tabla 'noticias'.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validamos los campos obligatorios y opcionales del formulario.
        $request->validate([
            'titulo'            => 'required|string|max:255',
            'contenido'         => 'required|string',
            'autor'             => 'nullable|string|max:255',
            'categoria'         => 'nullable|string|max:100',
            'fecha_publicacion' => 'required|date',
            'imagen_url'        => 'nullable|url|max:500',
            'enlace_externo'    => 'nullable|url|max:500',
            'destacado'         => 'nullable|boolean',
        ]);

        try {
            // Creamos la noticia usando asignación masiva con los campos $fillable del modelo.
            Noticias::create([
                'titulo'            => $request->input('titulo'),
                'contenido'         => $request->input('contenido'),
                'autor'             => $request->input('autor'),
                'categoria'         => $request->input('categoria'),
                'fecha_publicacion' => $request->input('fecha_publicacion'),
                'imagen_url'        => $request->input('imagen_url'),
                'enlace_externo'    => $request->input('enlace_externo'),
                'destacado'         => $request->has('destacado'),
                'admin_id'          => auth('admin')->id(),
            ]);

            // Redirigimos con un mensaje flash de éxito.
            return redirect()->route('admin.gestionNoticias')->with('success', 'Noticia creada correctamente.');

        } catch (\Exception $e) {
            // Si ocurre un error inesperado, redirigimos con mensaje de error.
            return redirect()->route('admin.gestionNoticias')->with('error', 'Error al crear la noticia: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar una noticia existente en la base de datos.
     *
     * @param Request $request Datos del formulario de edición.
     * @param int $id Identificador de la noticia a actualizar.
     * @return RedirectResponse Redirección a la vista de gestión con mensaje de éxito o error.
     * @sideEffect Modifica un registro existente en la tabla 'noticias'.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Validamos los campos (mismas reglas que en store).
        $request->validate([
            'titulo'            => 'required|string|max:255',
            'contenido'         => 'required|string',
            'autor'             => 'nullable|string|max:255',
            'categoria'         => 'nullable|string|max:100',
            'fecha_publicacion' => 'required|date',
            'imagen_url'        => 'nullable|url|max:500',
            'enlace_externo'    => 'nullable|url|max:500',
            'destacado'         => 'nullable|boolean',
        ]);

        try {
            // Buscamos la noticia por su ID. Si no existe, lanza un 404 automático.
            $noticia = Noticias::findOrFail($id);

            // Actualizamos los campos de la noticia con los datos del formulario.
            $noticia->update([
                'titulo'            => $request->input('titulo'),
                'contenido'         => $request->input('contenido'),
                'autor'             => $request->input('autor'),
                'categoria'         => $request->input('categoria'),
                'fecha_publicacion' => $request->input('fecha_publicacion'),
                'imagen_url'        => $request->input('imagen_url'),
                'enlace_externo'    => $request->input('enlace_externo'),
                'destacado'         => $request->has('destacado'),
            ]);

            // Redirigimos con un mensaje flash de éxito.
            return redirect()->route('admin.gestionNoticias')->with('success', 'Noticia actualizada correctamente.');

        } catch (\Exception $e) {
            // Si ocurre un error inesperado, redirigimos con mensaje de error.
            return redirect()->route('admin.gestionNoticias')->with('error', 'Error al actualizar la noticia: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar una noticia de la base de datos.
     *
     * @param int $id Identificador de la noticia a eliminar.
     * @return RedirectResponse Redirección a la vista de gestión con mensaje de éxito o error.
     * @sideEffect Elimina un registro de la tabla 'noticias'.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Buscamos la noticia por su ID. Si no existe, lanza un 404 automático.
            $noticia = Noticias::findOrFail($id);

            // Eliminamos la noticia de la base de datos.
            $noticia->delete();

            // Redirigimos con un mensaje flash de éxito.
            return redirect()->route('admin.gestionNoticias')->with('success', 'Noticia eliminada correctamente.');

        } catch (\Exception $e) {
            // Si ocurre un error inesperado, redirigimos con mensaje de error.
            return redirect()->route('admin.gestionNoticias')->with('error', 'Error al eliminar la noticia: ' . $e->getMessage());
        }
    }
}
