<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;



Route::get('/biblioteca', [LibroController::class, 'index']);
Route::get('/librosDestacados', [LibroController::class, 'destacados']);


Route::get('/actividades', function(){
    return view('bibliotecaDAW.actividadesEventos');
});

Route::get('/catalogo', function(){
    return view('bibliotecaDAW.catalogo');
});
Route::get('/login', function(){
    return view('bibliotecaDAW.login');
});

Route::get('/registro', function(){
    return view('bibliotecaDAW.registro');
});

Route::get('/buscar', function(){
    return view('bibliotecaDAW.buscarLibros');
});

Route::get('/servicios-digitales', function(){
    return view('bibliotecaDAW.serviciosDigitales');
});