<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\FooterConfig;
use App\Models\Libro;
use App\Models\Noticias;
use App\Models\SlideBienvenida;
use App\Models\Usuario;

class HomeController extends Controller
{
    /**
     * Portada: novedades, agenda, noticias y cifras reales de la biblioteca.
     */
    public function index()
    {
        return view('bibliotecaDAW.index', $this->datosPortada(Libro::latest()->take(12)->get()));
    }

    /**
     * Misma portada, pero el carrusel muestra solo los libros destacados.
     */
    public function destacados()
    {
        return view('bibliotecaDAW.index', $this->datosPortada(Libro::where('destacado', true)->latest()->get()));
    }

    /**
     * Datos comunes de la portada. Las cifras se calculan en vivo para que el
     * capítulo de presentación nunca muestre números inventados.
     */
    private function datosPortada($libros): array
    {
        return [
            'slideBienvenidas' => SlideBienvenida::orderBy('posicion')->orderBy('created_at', 'desc')->get(),
            'eventos' => Evento::with('usuario:id,name')->orderBy('fecha_hora')->paginate(6, ['*'], 'eventos_page'),
            'libros' => $libros,
            'noticias' => Noticias::orderBy('created_at', 'desc')->paginate(4, ['*'], 'noticias_page'),
            // Necesitamos los datos de contacto de la biblioteca para generar el JSON-LD (schema.org) de la vista.
            'footerConfig' => FooterConfig::firstOrCreate([]),
            'cifras' => [
                'libros' => Libro::count(),
                'eventos' => Evento::where('fecha_hora', '>=', now())->count(),
                'socios' => Usuario::count(),
            ],
        ];
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
