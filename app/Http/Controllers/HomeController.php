<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Libro;
use App\Models\Noticias;
use App\Models\SlideBienvenida;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obtener eventos ordenados por fecha
        $slideBienvenidas = SlideBienvenida::orderBy('posicion')->orderBy('created_at', 'desc')->get();
        $eventos = Evento::with('usuario:id,name')->orderBy('fecha_hora')->paginate(6, ['*'], 'eventos_page');
        $libros = Libro::all();
        $noticias = Noticias::orderBy('created_at', 'desc')->paginate(4, ['*'], 'noticias_page');

        return view('bibliotecaDAW.index', [
            'slideBienvenidas' => $slideBienvenidas,
            'eventos' => $eventos,
            'libros' => $libros,
            'noticias' => $noticias,
        ]);

        //Aqui se pondría mas informacion para la pagina principal.
        //Los controladores como EventosController y LibroController se encargan de gestionar la lógica específica de cada sección, mientras que HomeController se encarga de la lógica de SU PROPIA sección
        //Es decir. url/eventos; url/libros
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    public function destacados()
    {
        $eventos = Evento::with('usuario:id,name')->orderBy('fecha_hora')->paginate(6, ['*'], 'eventos_page');
        $libros = Libro::where('destacado', true)->get();
        $noticias = Noticias::orderBy('created_at', 'desc')->paginate(4, ['*'], 'noticias_page');
        return view('bibliotecaDAW.index', [
            'eventos' => $eventos,
            'libros' => $libros,
            'noticias' => $noticias,
        ]);
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
