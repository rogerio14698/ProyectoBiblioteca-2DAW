<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\Auth\UsuarioController;
use App\Http\Controllers\Auth\LoginControllerUsuario;
use App\Http\Controllers\Admin\Auth\LoginControllerAdmin;
//Redirección a la página de inicio
Route::get('/', function () {
    return redirect('/biblioteca');
})->name('home');

// ===============================================
// RUTAS PÚBLICAS (Accesibles sin autenticación)
// ===============================================

Route::get('/biblioteca', [LibroController::class, 'index']);
Route::get('/librosDestacados', [LibroController::class, 'destacados']);

// Rutas comunes para todas las páginas
Route::get('/actividades', function () {
    return view('bibliotecaDAW.actividadesEventos');
});

Route::get('/contacto', function () {
    return view('bibliotecaDAW.contacto');
});

Route::get('/catalogo', function () {
    return view('bibliotecaDAW.catalogo');
});

Route::get('/buscar', function () {
    return view('bibliotecaDAW.buscarLibros');
});

Route::get('/serviciosDigitales', function () {
    return view('bibliotecaDAW.serviciosDigitales');
});

// ===============================================
// RUTAS DE LOGIN/REGISTRO (Públicas)
// ===============================================

// Usuario - Login
Route::get('/login', [LoginControllerUsuario::class, 'mostrarLogin'])->name('usuario.login.mostrar');
Route::post('/login', [LoginControllerUsuario::class, 'login'])->name('usuario.login.procesar');

// Usuario - Registro
Route::get('/registro', [UsuarioController::class, 'showRegistro'])->name('usuario.show');
Route::post('/registro', [UsuarioController::class, 'store'])->name('usuario.store');

// Admin - Login
Route::get('/admin/login', [LoginControllerAdmin::class, 'mostrarLogin'])->name('admin.login.mostrar');
Route::post('/admin/login', [LoginControllerAdmin::class, 'login'])->name('admin.login.procesar');

// ===============================================
// RUTAS DE USUARIO REGISTRADO (Requiere auth:web)
// ===============================================

Route::middleware(['auth:web'])->group(function () {
    Route::get('/inicio', function () {
        return view('bibliotecaDAW.Login-Servicios.inicioLogin');
    })->name('usuario.inicio');

    Route::get('/perfil', function () {
        return view('bibliotecaDAW.Login-Servicios.perfil');
    })->name('usuario.perfil');

    Route::get('/alquilar', function () {
        return view('bibliotecaDAW.Login-Servicios.alquilar');
    })->name('usuario.alquilar');

    Route::get('/comprar', function () {
        return view('bibliotecaDAW.Login-Servicios.comprar');
    })->name('usuario.comprar');

    Route::get('/organizarEvento', function () {
        return view('bibliotecaDAW.Login-Servicios.organizarEvento');
    })->name('usuario.organizarEvento');

    Route::get('/vender', function () {
        return view('bibliotecaDAW.Login-Servicios.vender');
    })->name('usuario.vender');

    Route::get('/publicar', function () {
        return view('bibliotecaDAW.Login-Servicios.publicar');
    })->name('usuario.publicar');

    // Logout de usuario
    Route::post('/logout', [LoginControllerUsuario::class, 'logout'])->name('usuario.logout');
});

// ===============================================
// RUTAS DE ADMINISTRADOR (Requiere auth:admin)
// ===============================================

Route::middleware(['auth:admin'])->group(function () {
    // Dashboard admin
    Route::get('/admin', function () {
        return view('bibliotecaDAW.Admin.administrador');
    })->name('admin.dashboard');

    // Gestión de contenido
    Route::get('/admin/libros', function () {
        return view('bibliotecaDAW.Admin.gestionarLibros');
    })->name('admin.libros');

    Route::get('/admin/usuarios', function () {
        return view('bibliotecaDAW.Admin.gestionarUsuarios');
    })->name('admin.usuarios');

    Route::get('/admin/inventario', function () {
        return view('bibliotecaDAW.Admin.gestionarInventario');
    })->name('admin.inventario');

    Route::get('/admin/prestamos', function () {
        return view('bibliotecaDAW.Admin.gestionarPrestamos');
    })->name('admin.prestamos');

    Route::get('/admin/estadisticas', function () {
        return view('bibliotecaDAW.Admin.estadisticas');
    })->name('admin.estadisticas');

    // Gesunción de contenido web
    Route::get('/admin/contenido', function () {
        return view('bibliotecaDAW.Admin.GestionarContenidoWeb.gestionarContenido');
    })->name('admin.contenido');

    Route::get('/admin/eventos', function () {
        return view('bibliotecaDAW.Admin.GestionarContenidoWeb.gestionarEventos');
    })->name('admin.eventos');

    // Logout de admin
    Route::post('/admin/logout', [LoginControllerAdmin::class, 'logout'])->name('admin.logout');
});
Route::get('/biblioteca/login', [LoginControllerUsuario::class, 'mostrarLogin'])->name('login.mostrar');
Route::post('/biblioteca/login', [LoginControllerUsuario::class, 'login'])->name('login.procesar');
Route::post('/biblioteca/logout', [LoginControllerUsuario::class, 'logout'])->name('logout');
