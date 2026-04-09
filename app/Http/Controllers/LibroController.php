<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LibroController extends Controller
{
    /**
     * Mostrar todos los libros en la página principal.
     *
     * @return \Illuminate\View\View Vista del index con todos los libros.
     */
    public function index()
    {
        // Obtenemos todos los libros para la página principal.
        $libros = Libro::all();
        return view('bibliotecaDAW.index', [
            'libros' => $libros
        ]);
    }

    /**
     * Mostrar el catálogo público con búsqueda y paginación.
     *
     * @param Request $request Petición con posibles filtros de búsqueda.
     * @return \Illuminate\View\View Vista del catálogo con los libros filtrados.
     */
    public function catalogo(Request $request)
    {
        // Validamos los parámetros de búsqueda para evitar inyecciones.
        $validatedData = $request->validate([
            'query' => ['nullable', 'string', 'max:120'],
            'titulo' => ['nullable', 'string', 'max:120'],
            'autor' => ['nullable', 'string', 'max:120'],
            'genero' => ['nullable', 'string', 'max:120'],
        ]);

        $searchQuery = trim((string) ($validatedData['query'] ?? ''));
        $searchTitulo = trim((string) ($validatedData['titulo'] ?? ''));
        $searchAutor = trim((string) ($validatedData['autor'] ?? ''));
        $searchGenero = trim((string) ($validatedData['genero'] ?? ''));

        // Construimos la consulta con filtros condicionales.
        $libros = Libro::query()
            ->when($searchQuery !== '', fn($query) => $query->where(function ($subQuery) use ($searchQuery) {
                $subQuery->where('titulo', 'like', "%{$searchQuery}%")
                    ->orWhere('autor', 'like', "%{$searchQuery}%")
                    ->orWhere('genero', 'like', "%{$searchQuery}%");
            }))
            ->when($searchTitulo !== '', fn($query) => $query->where('titulo', 'like', "%{$searchTitulo}%"))
            ->when($searchAutor !== '', fn($query) => $query->where('autor', 'like', "%{$searchAutor}%"))
            ->when($searchGenero !== '', fn($query) => $query->where('genero', 'like', "%{$searchGenero}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('bibliotecaDAW.publicViews.catalogo', [
            'libros' => $libros,
            'searchQuery' => $searchQuery,
            'searchTitulo' => $searchTitulo,
            'searchAutor' => $searchAutor,
            'searchGenero' => $searchGenero,
        ]);
    }

    /**
     * Panel de administración del catálogo con filtros y paginación.
     * Muestra el formulario de creación (izquierda) y el listado de libros (derecha).
     *
     * @param Request $request Petición con posibles filtros de búsqueda.
     * @return \Illuminate\View\View Vista de gestión del catálogo.
     */
    public function gestionCatalogo(Request $request)
    {
        // Validamos los filtros de búsqueda del administrador.
        $validatedData = $request->validate([
            'filtroTitulo' => ['nullable', 'string', 'max:120'],
            'filtroAutor' => ['nullable', 'string', 'max:120'],
            'filtroGenero' => ['nullable', 'string', 'max:120'],
            'filtroAnio' => ['nullable', 'string', 'max:10'],
            'filtroEditorial' => ['nullable', 'string', 'max:120'],
            'filtroDisponibilidad' => ['nullable', 'string', 'in:disponible,prestado'],
        ]);

        // Extraemos cada filtro, limpiando espacios en blanco.
        $filtroTitulo = trim((string) ($validatedData['filtroTitulo'] ?? ''));
        $filtroAutor = trim((string) ($validatedData['filtroAutor'] ?? ''));
        $filtroGenero = trim((string) ($validatedData['filtroGenero'] ?? ''));
        $filtroAnio = trim((string) ($validatedData['filtroAnio'] ?? ''));
        $filtroEditorial = trim((string) ($validatedData['filtroEditorial'] ?? ''));
        $filtroDisponibilidad = trim((string) ($validatedData['filtroDisponibilidad'] ?? ''));

        // Construimos la consulta aplicando solo los filtros que el admin ha rellenado.
        $libros = Libro::query()
            ->when($filtroTitulo !== '', fn($q) => $q->where('titulo', 'like', "%{$filtroTitulo}%"))
            ->when($filtroAutor !== '', fn($q) => $q->where('autor', 'like', "%{$filtroAutor}%"))
            ->when($filtroGenero !== '', fn($q) => $q->where('genero', 'like', "%{$filtroGenero}%"))
            ->when($filtroAnio !== '', fn($q) => $q->where('anio', $filtroAnio))
            ->when($filtroEditorial !== '', fn($q) => $q->where('editorial', 'like', "%{$filtroEditorial}%"))
            ->when($filtroDisponibilidad !== '', fn($q) => $q->where('disponibilidad', $filtroDisponibilidad))
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Pasamos los libros paginados y los filtros actuales a la vista.
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarContenidoCatalogo', [
            'libros' => $libros,
            'filtroTitulo' => $filtroTitulo,
            'filtroAutor' => $filtroAutor,
            'filtroGenero' => $filtroGenero,
            'filtroAnio' => $filtroAnio,
            'filtroEditorial' => $filtroEditorial,
            'filtroDisponibilidad' => $filtroDisponibilidad,
        ]);
    }

    /**
     * Mostrar libros destacados en la página principal.
     *
     * @return \Illuminate\View\View Vista del index con libros destacados.
     */
    public function destacados()
    {
        // Filtramos solo libros marcados como destacados.
        $libros = Libro::where('destacado', true)->get();
        return view('bibliotecaDAW.index', [
            'libros' => $libros
        ]);
    }

    /**
     * Mostrar la página interna de un libro específico.
     *
     * @param int $id ID del libro a mostrar.
     * @return \Illuminate\View\View Vista de detalle del libro.
     */
    public function paginaInterna(int $id)
    {
        // Buscamos el libro o lanzamos 404 si no existe.
        $libro = Libro::findOrFail($id);

        // Usamos el accessor portada_url del modelo que decide si es URL o archivo local.
        $portadaUrl = $libro->portada_url;

        return view('bibliotecaDAW.publicViews.paginasInternas.paginaInternaLibro', [
            'libro' => $libro,
            'portadaUrl' => $portadaUrl,
        ]);
    }

    /**
     * Mostrar la página de alquiler de un libro específico.
     *
     * @param int $id ID del libro a alquilar.
     * @return \Illuminate\View\View Vista de alquiler del libro.
     */
    public function paginaInternaAlquilar(int $id)
    {
        $libro = Libro::findOrFail($id);

        return view('bibliotecaDAW.publicViews.paginasInternas.paginaInternaAlquilarLibro', [
            'libro' => $libro,
        ]);
    }

    /**
     * Guardar un nuevo libro en la base de datos con la portada subida.
     * La imagen se hashea para evitar conflictos de nombres.
     *
     * @param Request $request Datos del formulario de creación.
     * @return \Illuminate\Http\RedirectResponse Redirige al panel con mensaje de éxito o error.
     *
     * @efectos Inserta 1 registro en la tabla 'libros'. Almacena archivo en storage/app/public/portadas/.
     */
    public function store(Request $request)
    {
        // Validamos todos los campos del formulario.
        $validatedData = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'autor' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'string', 'max:100'],
            'anio' => ['required', 'integer', 'min:1000', 'max:' . date('Y')],
            'editorial' => ['required', 'string', 'max:255'],
            'disponibilidad' => ['required', 'in:disponible,prestado'],
            'formato' => ['required', 'in:fisico,digital,ambos'],
            'opcion_compra' => ['required', 'in:compra,prestamo'],
            'cantidad_ejemplares' => ['required', 'integer', 'min:0'],
            'isbn' => ['required', 'string', 'max:20', 'unique:libros,isbn'],
            'portada_img' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        try {
            // Si se ha subido una imagen, la guardamos con nombre hasheado.
            if ($request->hasFile('portada_img')) {
                // store() genera un nombre hasheado automáticamente y guarda en storage/app/public/portadas/.
                $validatedData['portada_img'] = $request->file('portada_img')->store('portadas', 'public');
            }

            // Creamos el libro con los datos validados.
            Libro::create($validatedData);

            return redirect()->route('admin.gestionCatalogo')->with('success', 'Libro añadido correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.gestionCatalogo')->with('error', 'Error al añadir el libro: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un libro del catálogo y su imagen de portada si es local.
     *
     * @param int $id ID del libro a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirige al panel con mensaje de éxito.
     *
     * @efectos Elimina 1 registro de la tabla 'libros'. Borra archivo de portada de storage si es local.
     */
    public function destroy(int $id)
    {
        try {
            $libro = Libro::findOrFail($id);

            // Si la portada es un archivo local (no URL externa), la eliminamos del almacenamiento.
            if (!empty($libro->portada_img) && !Str::startsWith($libro->portada_img, ['http://', 'https://'])) {
                Storage::disk('public')->delete($libro->portada_img);
            }

            $libro->delete();

            return redirect()->route('admin.gestionCatalogo')->with('success', 'Libro eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.gestionCatalogo')->with('error', 'Error al eliminar el libro: ' . $e->getMessage());
        }
    }

    /**
     * Cargar el panel de gestión con el formulario pre-rellenado para editar un libro.
     * Reutiliza la misma vista pero pasa $libroEditar para distinguir modo edición.
     *
     * @param Request $request Petición con posibles filtros activos.
     * @param int $id ID del libro a editar.
     * @return \Illuminate\View\View Vista de gestión con el libro a editar cargado en el formulario.
     */
    public function edit(Request $request, int $id)
    {
        // Buscamos el libro que queremos editar.
        $libroEditar = Libro::findOrFail($id);

        // Validamos los filtros para mantenerlos activos mientras se edita.
        $validatedData = $request->validate([
            'filtroTitulo' => ['nullable', 'string', 'max:120'],
            'filtroAutor' => ['nullable', 'string', 'max:120'],
            'filtroGenero' => ['nullable', 'string', 'max:120'],
            'filtroAnio' => ['nullable', 'string', 'max:10'],
            'filtroEditorial' => ['nullable', 'string', 'max:120'],
            'filtroDisponibilidad' => ['nullable', 'string', 'in:disponible,prestado'],
        ]);

        $filtroTitulo = trim((string) ($validatedData['filtroTitulo'] ?? ''));
        $filtroAutor = trim((string) ($validatedData['filtroAutor'] ?? ''));
        $filtroGenero = trim((string) ($validatedData['filtroGenero'] ?? ''));
        $filtroAnio = trim((string) ($validatedData['filtroAnio'] ?? ''));
        $filtroEditorial = trim((string) ($validatedData['filtroEditorial'] ?? ''));
        $filtroDisponibilidad = trim((string) ($validatedData['filtroDisponibilidad'] ?? ''));

        $libros = Libro::query()
            ->when($filtroTitulo !== '', fn($q) => $q->where('titulo', 'like', "%{$filtroTitulo}%"))
            ->when($filtroAutor !== '', fn($q) => $q->where('autor', 'like', "%{$filtroAutor}%"))
            ->when($filtroGenero !== '', fn($q) => $q->where('genero', 'like', "%{$filtroGenero}%"))
            ->when($filtroAnio !== '', fn($q) => $q->where('anio', $filtroAnio))
            ->when($filtroEditorial !== '', fn($q) => $q->where('editorial', 'like', "%{$filtroEditorial}%"))
            ->when($filtroDisponibilidad !== '', fn($q) => $q->where('disponibilidad', $filtroDisponibilidad))
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarContenidoCatalogo', [
            'libros' => $libros,
            'libroEditar' => $libroEditar,
            'filtroTitulo' => $filtroTitulo,
            'filtroAutor' => $filtroAutor,
            'filtroGenero' => $filtroGenero,
            'filtroAnio' => $filtroAnio,
            'filtroEditorial' => $filtroEditorial,
            'filtroDisponibilidad' => $filtroDisponibilidad,
        ]);
    }

    /**
     * Actualizar un libro existente con los datos del formulario.
     * Si se sube nueva portada, elimina la anterior y guarda la nueva hasheada.
     *
     * @param Request $request Datos del formulario de edición.
     * @param int $id ID del libro a actualizar.
     * @return \Illuminate\Http\RedirectResponse Redirige al panel con mensaje de éxito o error.
     *
     * @efectos Actualiza 1 registro en la tabla 'libros'. Puede borrar/crear archivo en storage.
     */
    public function update(Request $request, int $id)
    {
        $libro = Libro::findOrFail($id);

        // Validamos los campos, el ISBN debe ser único salvo para el libro actual.
        $validatedData = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'autor' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'string', 'max:100'],
            'anio' => ['required', 'integer', 'min:1000', 'max:' . date('Y')],
            'editorial' => ['required', 'string', 'max:255'],
            'disponibilidad' => ['required', 'in:disponible,prestado'],
            'formato' => ['required', 'in:fisico,digital,ambos'],
            'opcion_compra' => ['required', 'in:compra,prestamo'],
            'cantidad_ejemplares' => ['required', 'integer', 'min:0'],
            'isbn' => ['required', 'string', 'max:20', 'unique:libros,isbn,' . $id],
            'portada_img' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        try {
            // Si se sube nueva imagen, eliminamos la anterior (si es local) y guardamos la nueva.
            if ($request->hasFile('portada_img')) {
                if (!empty($libro->portada_img) && !Str::startsWith($libro->portada_img, ['http://', 'https://'])) {
                    Storage::disk('public')->delete($libro->portada_img);
                }
                $validatedData['portada_img'] = $request->file('portada_img')->store('portadas', 'public');
            }

            $libro->update($validatedData);

            return redirect()->route('admin.gestionCatalogo')->with('success', 'Libro actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.gestionCatalogo')->with('error', 'Error al actualizar el libro: ' . $e->getMessage());
        }
    }
}
