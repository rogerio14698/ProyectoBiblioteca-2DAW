<?php

namespace App\Http\Controllers;

use App\Models\Noticias;
use Illuminate\Http\Request;

class NoticiasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       /* //Obtener noticias ordenadas por fecha
        $noticias = Noticias::orderBy('created_at', 'desc')->paginate(6);
        
        //Aqui devuelve $notiacias a las vistas donde quiera mostrar las noticias.
        return view('bibliotecaDAW.index', [
            'noticias' => $noticias,
        ]); */


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
    public function show(Noticias $noticias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Noticias $noticias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Noticias $noticias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Noticias $noticias)
    {
        //
    }
}
