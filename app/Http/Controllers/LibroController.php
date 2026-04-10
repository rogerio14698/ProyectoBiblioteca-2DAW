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
        ]);

        $searchQuery = trim((string) ($validatedData['query'] ?? ''));
        $searchTitulo = trim((string) ($validatedData['titulo'] ?? ''));
        $searchAutor = trim((string) ($validatedData['autor'] ?? ''));
        $searchGenero = trim((string) ($validatedData['genero'] ?? ''));

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
     * Panel de administración del catálogo.
     */
    public function gestionCatalogo(Request $request)
    {
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
            'filtroTitulo' => $filtroTitulo,
            'filtroAutor' => $filtroAutor,
            'filtroGenero' => $filtroGenero,
            'filtroAnio' => $filtroAnio,
            'filtroEditorial' => $filtroEditorial,
            'filtroDisponibilidad' => $filtroDisponibilidad,
        ]);
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

    public function paginaInternaAlquilar(int $id)
    {
        $libro = Libro::findOrFail($id);
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
