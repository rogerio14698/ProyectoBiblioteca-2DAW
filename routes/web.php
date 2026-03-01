<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UsuarioController;
use App\Http\Controllers\Auth\LoginControllerUsuario;
use App\Http\Controllers\Admin\Auth\LoginControllerAdmin;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventosController;

//Redirección a la página de inicio
Route::get('/', function () {
    return redirect('/biblioteca');
})->name('home');

// ===============================================
// RUTAS PÚBLICAS (Accesibles sin autenticación)
// ===============================================

Route::get('/biblioteca', [HomeController::class, 'index']);
Route::get('/librosDestacados', [HomeController::class, 'destacados']);

// Rutas comunes para todas las páginas
Route::get('/actividades', function () {
    return view('bibliotecaDAW.publicViews.actividadesEventos');
});

Route::get('/contacto', function () {
    return view('bibliotecaDAW.publicViews.contacto');
});

Route::get('/catalogo', function () {
    return view('bibliotecaDAW.publicViews.catalogo');
});

Route::get('/buscar', function () {
    return view('bibliotecaDAW.publicViews.buscarLibros');
});

Route::get('/serviciosDigitales', function () {
    return view('bibliotecaDAW.publicViews.serviciosDigitales');
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
        return view('bibliotecaDAW.userViews.inicioLogin');
    })->name('usuario.inicio');

    Route::get('/perfil', function () {
        return view('bibliotecaDAW.userViews.perfil');
    })->name('usuario.perfil');

    Route::get('/alquilar', function () {
        return view('bibliotecaDAW.userViews.alquilar');
    })->name('usuario.alquilar');

    Route::get('/comprar', function () {
        return view('bibliotecaDAW.userViews.comprar');
    })->name('usuario.comprar');

    Route::get('/organizarEvento', function () {
        return view('bibliotecaDAW.userViews.organizarEvento');
    })->name('usuario.organizarEvento');

    Route::get('/vender', function () {
        return view('bibliotecaDAW.userViews.vender');
    })->name('usuario.vender');

    Route::get('/publicar', function () {
        return view('bibliotecaDAW.userViews.publicar');
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
        return view('bibliotecaDAW.adminViews.administrador');
    })->name('admin.dashboard');
    //Gestion de roles y permisos
    Route::get('/admin/gestionRoles', function () {
        return view('bibliotecaDAW.adminViews.GestionarRoles.gestionarRoles');
    })->name('admin.gestionRoles');

    // Fin de roles y permisos


    // =================== Inicio gestion de contenido web ===================
    // Gestión de contenido pagina principal
    Route::get('/admin/gestionHome', function () {
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarHome');
    })->name('admin.gestionHome');
    //Gestion ve la agenda
    Route::get('/admin/gestionAgenda', function () {
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarAgenda');
    })->name('admin.gestionAgenda');
    //Gestion del carrusel-home
    // Vista principal del carrusel (lista + formulario reutilizable crear/editar)
    Route::get('/admin/gestionCarrusel', [EventosController::class, 'adminCarrusel'])->name('admin.gestionCarrusel');
    // Guardar un evento nuevo desde el formulario
    Route::post('/admin/gestionCarrusel', [EventosController::class, 'store'])->name('admin.agregarCarrusel');
    // Actualizar un evento existente desde el mismo formulario
    Route::put('/admin/gestionCarrusel/{id}', [EventosController::class, 'update'])->name('admin.updateCarrusel');
    //Elimar un evento
    Route::delete('/admin/gestionCarrusel/{id}', [EventosController::class, 'destroy'])->name('admin.deleteCarrusel');
    

    
    //Gestión de noticas
    Route::get('/admin/gestionNoticias', function () {
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarNoticias');
    })->name('admin.gestionNoticias');
    //Gestión del catalogo
    Route::get('/admin/gestionCatalogo', function () {
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarCatalogo');
    })->name('admin.gestionCatalogo');
    //Gestion Actividades y eventos
    Route::get('/admin/gestionActividades', function () {
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarActividades');
    })->name('admin.gestionActividades');
    //Gestion Servicios digitales
    Route::get('/admin/gestionServicios', function () {
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarServicios');
    })->name('admin.gestionServicios');
    //Gestion contenido de contacto
    Route::get('/admin/gestionContacto', function () {
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarContacto');
    })->name('admin.gestionContacto');
    //Gestion varios header y footer
    Route::get('/admin/gestionHeader', function () {
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarHeader');
    })->name('admin.gestionHeader');
    Route::get('/admin/gestionFooter', function () {
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarFooter');
    })->name('admin.gestionFooter');

    // =================== Fin gestion de contenido web ===================
    Route::get('/admin/gestionUsuarios', function () {
        return view('bibliotecaDAW.adminViews.GestionarUsuarios.gestionarUsuarios');
    })->name('admin.gestionUsuarios');

    // =================== Inicio gestion de usuarios ===================
    //Gestion de usuarios vista principal
    Route::get('/admin/gestionUsuarios', function () {
        return view('bibliotecaDAW.adminViews.GestionarUsuarios.gestionarUsuarios');
    })->name('admin.gestionUsuarios');
    //Gestion de sanciones
    Route::get('/admin/gestionSanciones', function () {
        return view('bibliotecaDAW.adminViews.GestionarUsuarios.gestionarSanciones');
    })->name('admin.gestionSanciones');
    //Historial de reservas
    Route::get('/admin/historialReservas', function () {
        return view('bibliotecaDAW.adminViews.GestionarUsuarios.historialReservas');
    })->name('admin.historialReservas');
    //Reservas activas
    Route::get('/admin/reservasActivas', function () {
        return view('bibliotecaDAW.adminViews.GestionarUsuarios.reservasActivas');
    })->name('admin.reservasActivas');
    //Publicaciones Usuario
    Route::get('/admin/publicacionesUser', function () {
        return view('bibliotecaDAW.adminViews.GestionarUsuarios.publicacionesUser');
    })->name('admin.publicacionesUser');
    //Dar de baja a un usuario
    Route::post('/admin/darBaja/{id}', function ($id) {
        // Lógica para dar de baja al usuario con el ID proporcionado
        // Por ejemplo, podrías usar el modelo User para actualizar el estado del usuario a "baja"
        // User::where('id', $id)->update(['estado' => 'baja']);
        return redirect()->route('admin.gestionUsuarios')->with('success', 'Usuario dado de baja correctamente.');
    })->name('admin.darBaja');
    //Formulario que muestre las cancelaciones de cada usuario
    Route::get('/admin/gestionarCancelaciones', function () {
        return view('bibliotecaDAW.adminViews.GestionarUsuarios.gestionarCancelaciones');
    })->name('admin.gestionarCancelaciones');


    // =================== Fin gestion de usuarios ===================

    // =================== Gestion de Libros ===================
    //Gestion de libros vista principal
    Route::get('/admin/gestionarLibros', function () {
        return view('bibliotecaDAW.adminViews.GestionarLibros.gestionarLibros');
    })->name('admin.gestionarLibros');
    //Libros Nuevos
    Route::get('/admin/librosNuevos', function () {
        return view('bibliotecaDAW.adminViews.GestionarLibros.gestionarLibrosNuevos');
    })->name('admin.librosNuevos');
    //Libros Perdidos
    Route::get('/admin/librosPerdidos', function () {
        return view('bibliotecaDAW.adminViews.GestionarLibros.gestionarLibrosPerdidos');
    })->name('admin.librosPerdidos');
    //Inventario de libros
    Route::get('/admin/inventario', function () {
        return view('bibliotecaDAW.adminViews.GestionarLibros.gestionarInventario');
    })->name('admin.inventario');
    //Libros prestados
    Route::get('/admin/librosPrestados', function () {
        return view('bibliotecaDAW.adminViews.GestionarLibros.gestionarLibrosPrestados');
    })->name('admin.librosPrestados');
    // =================== Fin gestion de libros ===================


    // Logout de admin
    Route::post('/admin/logout', [LoginControllerAdmin::class, 'logout'])->name('admin.logout');
});
Route::get('/biblioteca/login', [LoginControllerUsuario::class, 'mostrarLogin'])->name('login.mostrar');
Route::post('/biblioteca/login', [LoginControllerUsuario::class, 'login'])->name('login.procesar');
Route::post('/biblioteca/logout', [LoginControllerUsuario::class, 'logout'])->name('logout');