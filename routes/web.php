<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;



Route::get('/biblioteca', [LibroController::class, 'index']);
Route::get('/librosDestacados', [LibroController::class, 'destacados']);

//Rutas comunes para todas las páginas
Route::get('/actividades', function () {
    return view('bibliotecaDAW.actividadesEventos');
});

Route::get('/contacto', function () {
    return view('bibliotecaDAW.contacto');
});

Route::get('/catalogo', function () {
    return view('bibliotecaDAW.catalogo');
});
Route::get('/login', function () {
    return view('bibliotecaDAW.login');
});

Route::get('/registro', function () {
    return view('bibliotecaDAW.registro');
});

Route::get('/buscar', function () {
    return view('bibliotecaDAW.buscarLibros');
});

Route::get('/servicios-digitales', function () {
    return view('bibliotecaDAW.serviciosDigitales');
});

//Aqui va las rutas de los usuarios logeados


//Aqui empiezan la ruta de los administradores de la web
Route::get('/admin', function () {
    return view('bibliotecaDAW.Admin.administrador');
});
Route::get('/admin/libros', function () {
    return view('bibliotecaDAW.Admin.gestionarLibros');
});
Route::get('/admin/usuarios', function () {
    return view('bibliotecaDAW.Admin.gestionarUsuarios');
});
Route::get('/admin/inventario', function () {
    return view('bibliotecaDAW.Admin.gestionarInventario');
});
Route::get('admin/prestamos', function () {
    return view('bibliotecaDAW.Admin.gestionarPrestamos');
});
Route::get('/admin/estadisticas', function () {
    return view('bibliotecaDAW.Admin.estadisticas');
});

//Rutas para gestionar el contenido de la web
Route::get('/admin/contenido', function () {
    return view('bibliotecaDAW.Admin.GestionarContenidoWeb.gestionarContenido');
});

Route::get('/admin/eventos', function () {
    return view('bibliotecaDAW.Admin.GestionarContenidoWeb.gestionarEventos');
});
