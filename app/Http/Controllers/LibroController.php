<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obtener todos los libros para página principal
        $libros = Libro::all();
        return view('bibliotecaDAW.index', [
            'libros' => $libros
        ]);

    }
    //Obtener libros para la vista de catálogo (con búsqueda opcional)
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
    //Obtener todos los libros para la vista de gestion Catalago admin. con busqueda

    /**
     * Display highlighted books
     */
    public function destacados()
    {
        //Filtrar libros Destacados
        $libros = Libro::where('destacado', true)->get();
        return view('bibliotecaDAW.index', [
            'libros' => $libros
        ]);
    }
    //Obetner un libro específico para su página interna
    public function paginaInterna($id)
    {
        $libro = Libro::findOrFail($id);

        $portadaUrl = 'img/elPrincipito.jpg';

        if (!empty($libro->portada_img)) {
            $portadaUrl = Str::startsWith($libro->portada_img, ['http://', 'https://'])
                ? $libro->portada_img
                : asset($libro->portada_img);
        } else {
            $portadaUrl = asset($portadaUrl);
        }

        return view('bibliotecaDAW.publicViews.paginasInternas.paginaInternaLibro', [
            'libro' => $libro,
            'portadaUrl' => $portadaUrl,
        ]);
    }
    //Obtener un libro específico para su página interna de alquiler
    public function paginaInternaAlquilar($id)
    {
        $libro = Libro::findOrFail($id);

        return view('bibliotecaDAW.publicViews.paginasInternas.paginaInternaAlquilarLibro', [
            'libro' => $libro,
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
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
