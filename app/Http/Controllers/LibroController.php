<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
    //Obtener todos los libros para la vista de catálogo
    public function catalogo()
    {

        $libros = Libro::paginate(10); //Paginación de 10 libros por página
        return view('bibliotecaDAW.publicViews.catalogo', [
            'libros' => $libros
        ]);
    }

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
