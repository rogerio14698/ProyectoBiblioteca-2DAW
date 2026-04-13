<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LibroController extends Controller
{
    /**
     * Mostrar todos los libros marcados como perdidos.
     */
    public function librosPerdidos()
    {
        // Obtenemos libros que NO están perdidos para el buscador/selector
        $librosParaDarDeBaja = Libro::where('perdido', false)->get();

        // Obtenemos los que YA están perdidos para el listado
        $librosPerdidos = Libro::where('perdido', true)->orderBy('updated_at', 'desc')->get();

        return view('bibliotecaDAW.adminViews.GestionarLibros.gestionarLibrosPerdidos', [
            'libros' => $librosParaDarDeBaja,
            'librosPerdidos' => $librosPerdidos
        ]);
    }

    /**
     * Marcar un libro como perdido (baja) y registrar el motivo.
     */
    public function marcarPerdido(Request $request)
    {
        $request->validate([
            'libro_identificador' => ['required', 'exists:libros,isbn'], // Validamos por ISBN
            'motivo_baja' => ['required', 'string', 'max:255'],
        ]);

        $libro = Libro::where('isbn', $request->libro_identificador)->firstOrFail();
        $libro->perdido = true;
        $libro->motivo_baja = $request->motivo_baja;
        $libro->save();

        return redirect()->back()->with('success', 'Libro dado de baja.');
    }

    /**
     * Mostrar todos los libros en la página principal.
     */
    public function index()
    {
        $libros = Libro::all();
        return view('bibliotecaDAW.index', ['libros' => $libros]);
    }

    /**
     * Mostrar el catálogo público con búsqueda y paginación.
     */
    public function catalogo(Request $request)
    {
        $validatedData = $request->validate([
            'query' => ['nullable', 'string', 'max:120'],
            'titulo' => ['nullable', 'string', 'max:120'],
            'autor' => ['nullable', 'string', 'max:120'],
            'genero' => ['nullable', 'string', 'max:120'],
            'opcion' => ['nullable', 'string', 'in:compra,prestamo'],
        ]);

        $searchQuery = trim((string) ($validatedData['query'] ?? ''));
        $searchTitulo = trim((string) ($validatedData['titulo'] ?? ''));
        $searchAutor = trim((string) ($validatedData['autor'] ?? ''));
        $searchGenero = trim((string) ($validatedData['genero'] ?? ''));
        $searchOpcion = trim((string) ($validatedData['opcion'] ?? ''));

        $libros = Libro::query()
            ->when($searchQuery !== '', fn($query) => $query->where(function ($subQuery) use ($searchQuery) {
                $subQuery->where('titulo', 'like', "%{$searchQuery}%")
                    ->orWhere('autor', 'like', "%{$searchQuery}%")
                    ->orWhere('genero', 'like', "%{$searchQuery}%");
            }))
            ->when($searchTitulo !== '', fn($query) => $query->where('titulo', 'like', "%{$searchTitulo}%"))
            ->when($searchAutor !== '', fn($query) => $query->where('autor', 'like', "%{$searchAutor}%"))
            ->when($searchGenero !== '', fn($query) => $query->where('genero', 'like', "%{$searchGenero}%"))
            ->when($searchOpcion !== '', fn($query) => $query->where('opcion_compra', $searchOpcion))
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('bibliotecaDAW.publicViews.catalogo', [
            'libros' => $libros,
            'searchQuery' => $searchQuery,
            'searchTitulo' => $searchTitulo,
            'searchAutor' => $searchAutor,
            'searchGenero' => $searchGenero,
            'searchOpcion' => $searchOpcion,
        ]);
    }

    /**
     * Panel de administración del catálogo.
     *
     * @param Request $request Parámetros de filtrado del listado.
     * @return \Illuminate\View\View Vista de gestión con listado paginado.
     */
    public function gestionCatalogo(Request $request): \Illuminate\View\View
    {
        return $this->vistaGestionCatalogo($request);
    }

    /**
     * Cargar el panel de gestión con un libro precargado para edición.
     *
     * Reutiliza la misma vista que gestionCatalogo, pasando $libroEditar
     * para que el formulario cambie a modo edición.
     *
     * @param Request $request Parámetros de filtrado del listado.
     * @param int $id Identificador del libro a editar.
     * @return \Illuminate\View\View Vista de gestión con formulario en modo edición.
     */
    public function edit(Request $request, int $id): \Illuminate\View\View
    {
        // Buscamos el libro que se quiere editar o lanzamos 404.
        $libroEditar = Libro::findOrFail($id);

        return $this->vistaGestionCatalogo($request, $libroEditar);
    }

    /**
     * Construir la vista de gestión del catálogo con filtros y paginación.
     *
     * Método privado reutilizado por gestionCatalogo() y edit() para evitar
     * duplicar la lógica de filtrado y consulta (principio DRY).
     *
     * @param Request $request Parámetros de filtrado del listado.
     * @param Libro|null $libroEditar Libro a editar (null = modo creación).
     * @return \Illuminate\View\View Vista renderizada con datos del catálogo.
     */
    private function vistaGestionCatalogo(Request $request, ?Libro $libroEditar = null): \Illuminate\View\View
    {
        // Validamos filtros permitidos para controlar valores de entrada.
        $validatedData = $request->validate([
            'filtroTitulo' => ['nullable', 'string', 'max:120'],
            'filtroAutor' => ['nullable', 'string', 'max:120'],
            'filtroGenero' => ['nullable', 'string', 'max:120'],
            'filtroAnio' => ['nullable', 'string', 'max:10'],
            'filtroEditorial' => ['nullable', 'string', 'max:120'],
            'filtroDisponibilidad' => ['nullable', 'string', 'in:disponible,prestado'],
        ]);

        // Normalizamos valores de filtro con defaults vacíos.
        $filtroTitulo = trim((string) ($validatedData['filtroTitulo'] ?? ''));
        $filtroAutor = trim((string) ($validatedData['filtroAutor'] ?? ''));
        $filtroGenero = trim((string) ($validatedData['filtroGenero'] ?? ''));
        $filtroAnio = trim((string) ($validatedData['filtroAnio'] ?? ''));
        $filtroEditorial = trim((string) ($validatedData['filtroEditorial'] ?? ''));
        $filtroDisponibilidad = trim((string) ($validatedData['filtroDisponibilidad'] ?? ''));

        // Construimos consulta con filtros dinámicos aplicados condicionalmente.
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

        // Preparamos datos base para la vista.
        $viewData = [
            'libros' => $libros,
            'filtroTitulo' => $filtroTitulo,
            'filtroAutor' => $filtroAutor,
            'filtroGenero' => $filtroGenero,
            'filtroAnio' => $filtroAnio,
            'filtroEditorial' => $filtroEditorial,
            'filtroDisponibilidad' => $filtroDisponibilidad,
        ];

        // Si hay libro a editar, lo incluimos para que la vista cambie a modo edición.
        if ($libroEditar !== null) {
            $viewData['libroEditar'] = $libroEditar;
        }

        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarContenidoCatalogo', $viewData);
    }

    public function destacados()
    {
        $libros = Libro::where('destacado', true)->get();
        return view('bibliotecaDAW.index', ['libros' => $libros]);
    }

    public function paginaInterna(int $id)
    {
        $libro = Libro::findOrFail($id);
        return view('bibliotecaDAW.publicViews.paginasInternas.paginaInternaLibro', [
            'libro' => $libro,
            'portadaUrl' => $libro->portada_url,
        ]);
    }

    /**
     * Mostrar la página interna de alquiler de un libro.
     *
     * Solo permite acceso a libros cuyo tipo de operación sea 'prestamo'.
     * Si el libro es de tipo 'compra', redirige al catálogo con mensaje de error.
     *
     * @param int $id Identificador del libro a alquilar.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse Vista de alquiler o redirección.
     */
    public function paginaInternaAlquilar(int $id): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        // Buscamos el libro por su ID o lanzamos 404 si no existe.
        $libro = Libro::findOrFail($id);

        // Verificamos que el libro sea de tipo préstamo; los de compra no se alquilan.
        if ($libro->opcion_compra !== 'prestamo') {
            return redirect()->route('catalogo')->with('error', 'Este libro solo está disponible para compra, no para alquiler.');
        }

        return view('bibliotecaDAW.publicViews.paginasInternas.paginaInternaAlquilarLibro', ['libro' => $libro]);
    }

    public function store(Request $request)
    {
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
            if ($request->hasFile('portada_img')) {
                $validatedData['portada_img'] = $request->file('portada_img')->store('portadas', 'public');
            }
            Libro::create($validatedData);
            return redirect()->route('admin.gestionCatalogo')->with('success', 'Libro añadido correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.gestionCatalogo')->with('error', 'Error al añadir el libro: ' . $e->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $libro = Libro::findOrFail($id);
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

    public function destroy(int $id)
    {
        try {
            $libro = Libro::findOrFail($id);
            if (!empty($libro->portada_img) && !Str::startsWith($libro->portada_img, ['http://', 'https://'])) {
                Storage::disk('public')->delete($libro->portada_img);
            }
            $libro->delete();
            return redirect()->route('admin.gestionCatalogo')->with('success', 'Libro eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.gestionCatalogo')->with('error', 'Error al eliminar el libro: ' . $e->getMessage());
        }
    }
}
