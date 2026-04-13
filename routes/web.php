<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UsuarioController;
use App\Http\Controllers\Auth\LoginControllerUsuario;
use App\Http\Controllers\Admin\Auth\LoginControllerAdmin;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\SlideBienvenidaController;
use App\Http\Controllers\NoticiasController;
use App\Http\Controllers\FooterConfigController;
use App\Http\Controllers\GestionUsuariosController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PrestamosController;
use App\Http\Controllers\PrestamosUsuarioController;
use App\Http\Controllers\AlquilerController;
use App\Http\Controllers\PublicarUsuarioController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\OrganizarEventoController;
use App\Http\Controllers\TicketEventoController;
use App\Models\Contacto;

//Redirección a la página de inicio
Route::get('/', function () {
    return redirect('/biblioteca');
})->name('home');

// ===============================================
// RUTAS PÚBLICAS (Accesibles sin autenticación)
// ===============================================

Route::get('/biblioteca', [HomeController::class, 'index']);
Route::get('/librosDestacados', [HomeController::class, 'destacados']);

//Ruta para mostrar libro específico, ruta de su pargina interna:
Route::get('/libro/{id}', [LibroController::class, 'paginaInterna'])->name('libro.paginaInterna');
//Ruta para mostrar evento específico, ruta de su propia página interna:
Route::get('/evento/{id}', [EventosController::class, 'paginaInterna'])->name('evento.paginaInterna');
//Ruta para mostrar noticia específica, ruta de su propia página interna:
Route::get('/noticia/{id}', [NoticiasController::class, 'paginaInterna'])->name('noticia.paginaInterna');
//Ruta para mostrar la página de apuntarse a un evento específico:
Route::get('/evento/{id}/apuntarse', [EventosController::class, 'apuntarse'])->name('evento.apuntarse');
//Ruta POST para procesar la inscripción al evento:
Route::post('/evento/{id}/apuntarse', [EventosController::class, 'procesarApuntarse'])->name('evento.procesarApuntarse');
//Ruta para mostrar la página de alquilar un libro específico:
Route::get('/libro/{id}/alquilar', [LibroController::class, 'paginaInternaAlquilar'])->name('libro.paginaInternaAlquilar');

// Rutas comunes para todas las páginas
Route::get('/actividades', function () {
    $eventos = \App\Models\Evento::orderby('created_at', 'desc')->paginate(6); // Obtener todos los eventos y paginarlos de 6 en 6. 
    return view('bibliotecaDAW.publicViews.actividadesEventos', ['eventos' => $eventos]);
});

Route::get('/contacto', [ContactoController::class, 'create'])->name('contacto.create');
Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.store');
Route::get('/catalogo', [LibroController::class, 'catalogo']);
Route::get('/publicaciones', [PublicarUsuarioController::class, 'communityIndex'])->name('publicaciones.index');
Route::get('/publicaciones/{id}/ver', [PublicarUsuarioController::class, 'view'])->name('publicaciones.ver');
// Ruta para aviso legal:
Route::get('/avisoLegal', function () {
    return view('bibliotecaDAW.publicViews.avisoLegal');
});
//Politicas de cookies:
Route::get('/politicasCookies', function () {
    return view('bibliotecaDAW.publicViews.politicasCookies');
});
// ===============================================
// RUTAS DE LOGIN/REGISTRO (Públicas)
// ===============================================

// Usuario - Login
//Ruta solo para demostracion
Route::post('/login/demo', [LoginControllerUsuario::class, 'loginDemo'])->name('usuario.login.demo');
// Rutas para login y registro de usuarios
Route::get('/login', [LoginControllerUsuario::class, 'mostrarLogin'])->name('usuario.login.mostrar');
Route::post('/login', [LoginControllerUsuario::class, 'login'])->name('usuario.login.procesar');

// Usuario - Registro
Route::get('/registro', [UsuarioController::class, 'showRegistro'])->name('usuario.show');
Route::post('/registro', [UsuarioController::class, 'store'])->name('usuario.store');

// Admin - Login
Route::get('/admin/login', [LoginControllerAdmin::class, 'mostrarLogin'])->name('admin.login.mostrar');
Route::post('/admin/login', [LoginControllerAdmin::class, 'login'])->name('admin.login.procesar');
Route::post('/admin/login/demo', [LoginControllerAdmin::class, 'loginDemo'])->name('admin.login.demo');

// ===============================================
// RUTAS DE USUARIO REGISTRADO (Requiere auth:web)
// ===============================================

Route::middleware(['auth:web', 'bloquear.demo'])->group(function () {
    Route::get('/inicioUsuario', function () {
        return view('bibliotecaDAW.userViews.inicioLogin');
    })->name('usuario.inicio');

    Route::get('/perfil', [PerfilController::class, 'index'])->name('usuario.perfil');

    // Editar perfil
    Route::get('/perfilEditar', [PerfilController::class, 'edit'])->name('usuario.perfilEditar');
    Route::put('/perfilEditar', [PerfilController::class, 'update'])->name('usuario.perfilActualizar');
    Route::put('/cambiarPassword', [PerfilController::class, 'changePassword'])->name('usuario.cambiarPassword');

    //Gestionar contacto con la biblioteca
    Route::get('/mis-consultas', [ContactoController::class, 'misConsultas'])->name('usuario.consultas');


    Route::get('/alquilar', [AlquilerController::class, 'index'])->name('usuario.alquilar');
    Route::post('/alquilar', [AlquilerController::class, 'store'])->name('usuario.alquilar.store');

    Route::get('/prestamos', [PrestamosUsuarioController::class, 'index'])->name('usuario.prestamos');

    Route::get('/comprar', function () {
        return view('bibliotecaDAW.userViews.comprar');
    })->name('usuario.comprar');

    Route::get('/organizarEvento', [OrganizarEventoController::class, 'index'])->name('usuario.organizarEvento');
    Route::post('/organizarEvento', [OrganizarEventoController::class, 'store'])->name('usuario.organizarEvento.store');

    Route::get('/vender', function () {
        return view('bibliotecaDAW.userViews.vender');
    })->name('usuario.vender');

    Route::get('/publicar', [PublicarUsuarioController::class, 'index'])->name('usuario.publicar');
    Route::post('/publicar', [PublicarUsuarioController::class, 'store'])->name('usuario.publicar.store');
    Route::get('/publicar/{id}/archivo', [PublicarUsuarioController::class, 'download'])->name('usuario.publicar.archivo');

    // Ticket PDF de eventos: generar y enviar por email
    Route::post('/evento/{id}/ticket-pdf', [TicketEventoController::class, 'generarPdf'])->name('evento.ticketPdf');
    Route::post('/evento/{id}/ticket-email', [TicketEventoController::class, 'enviarPorEmail'])->name('evento.ticketEmail');

    // Logout de usuario
    Route::post('/logout', [LoginControllerUsuario::class, 'logout'])->name('usuario.logout');
});

// ===============================================
// RUTAS DE ADMINISTRADOR (Requiere auth:admin)
// ===============================================

Route::middleware(['auth:admin', 'bloquear.demo'])->group(function () {
    // Dashboard admin
    Route::get('/admin', function () {
        $mensajes = Contacto::orderBy('created_at', 'desc')->paginate(10);
        $totalPublicaciones = \App\Models\Publicacion::count();
        $totalNoticias = \App\Models\Noticias::count();
        $totalPaginas = 0; // Si tienes modelo de páginas, reemplaza aquí
        $totalMenu = 0; // Si tienes modelo de menú, reemplaza aquí
        $librosDisponibles = \App\Models\Libro::where('disponibilidad', true)->count();
        $usuariosRegistrados = \App\Models\Usuario::count();
        $prestamosActivos = \App\Models\Prestamos::whereNull('fecha_devolucion_real')->count();
        $reservasActivas = \App\Models\Reserva::where('estado', 'activa')->count();
        $eventosProximos = \App\Models\Evento::where('fecha_hora', '>', now())->count();
        return view('bibliotecaDAW.adminViews.administrador', compact(
            'mensajes',
            'totalPublicaciones',
            'totalNoticias',
            'totalPaginas',
            'totalMenu',
            'librosDisponibles',
            'usuariosRegistrados',
            'prestamosActivos',
            'reservasActivas',
            'eventosProximos'
        ));
    })->name('admin.dashboard');
    //Gestion de roles y permisos
    Route::get('/admin/gestionRoles', function () {
        return view('bibliotecaDAW.adminViews.GestionarRoles.rolesYpermisos');
    })->name('admin.gestionRoles');

    // Fin de roles y permisos


    // =================== Inicio gestion de contenido web ===================
    // Gestión de contenido pagina principal
    Route::get('/admin/gestionHome', [SlideBienvenidaController::class, 'adminHome'])->name('admin.gestionHome');
    Route::post('/admin/gestionHome', [SlideBienvenidaController::class, 'store'])->name('admin.slide.store');
    Route::put('/admin/gestionHome/{id}', [SlideBienvenidaController::class, 'update'])->name('admin.slide.update');
    Route::delete('/admin/gestionHome/{id}', [SlideBienvenidaController::class, 'destroy'])->name('admin.slide.destroy');

    //Gestion del carrusel-home
    // Vista principal del carrusel (lista + formulario reutilizable crear/editar)
    Route::get('/admin/gestionCarrusel', [EventosController::class, 'adminCarrusel'])->name('admin.gestionCarrusel');
    // Guardar un evento nuevo desde el formulario
    Route::post('/admin/gestionCarrusel', [EventosController::class, 'store'])->name('admin.agregarCarrusel');
    // Actualizar un evento existente desde el mismo formulario
    Route::put('/admin/gestionCarrusel/{id}', [EventosController::class, 'update'])->name('admin.updateCarrusel');
    //Elimar un evento
    Route::delete('/admin/gestionCarrusel/{id}', [EventosController::class, 'destroy'])->name('admin.deleteCarrusel');



    //Gestión de noticias (GET con listado, POST crear, PUT actualizar, DELETE eliminar)
    Route::get('/admin/gestionNoticias', [NoticiasController::class, 'gestionNoticias'])->name('admin.gestionNoticias');
    Route::post('/admin/gestionNoticias', [NoticiasController::class, 'store'])->name('admin.gestionNoticias.store');
    Route::put('/admin/gestionNoticias/{id}', [NoticiasController::class, 'update'])->name('admin.gestionNoticias.update');
    Route::delete('/admin/gestionNoticias/{id}', [NoticiasController::class, 'destroy'])->name('admin.gestionNoticias.destroy');
    //Gestión del catalogo (GET con filtros y paginación, POST para crear, GET edit, PUT update, DELETE para eliminar)
    Route::get('/admin/gestionCatalogo', [LibroController::class, 'gestionCatalogo'])->name('admin.gestionCatalogo');
    Route::post('/admin/gestionCatalogo', [LibroController::class, 'store'])->name('admin.gestionCatalogo.store');
    Route::get('/admin/gestionCatalogo/{id}/edit', [LibroController::class, 'edit'])->name('admin.gestionCatalogo.edit');
    Route::put('/admin/gestionCatalogo/{id}', [LibroController::class, 'update'])->name('admin.gestionCatalogo.update');
    Route::delete('/admin/gestionCatalogo/{id}', [LibroController::class, 'destroy'])->name('admin.gestionCatalogo.destroy');
    //Gestion Actividades y eventos
    Route::get('/admin/gestionActividades', function () {
        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarActividades');
    })->name('admin.gestionActividades');
    //Gestion contenido de contacto

    //Gestión de los emails de contacto
    // Gestión de mensajes de contacto para el Admin
    Route::get('/admin/mensajes', [ContactoController::class, 'index'])->name('admin.mensajes.index');
    Route::patch('/admin/mensajes/{id}/estado', [ContactoController::class, 'updateEstado'])->name('admin.mensajes.update');
    Route::delete('/admin/mensajes/{contacto}', [ContactoController::class, 'destroy'])->name('admin.mensajes.delete');
    Route::post('/admin/mensajes/{id}/responder', [ContactoController::class, 'responder'])->name('admin.mensajes.responder');
    /*Fin de la gestión de emails */

    //Gestion varios header y footer
    Route::get('/admin/gestionFooter', [FooterConfigController::class, 'edit'])->name('admin.gestionFooter');
    Route::put('/admin/gestionFooter', [FooterConfigController::class, 'update'])->name('admin.gestionFooter.update');

    // =================== Fin gestion de contenido web ===================

    // =================== Inicio gestion de usuarios ===================
    //Gestion de usuarios vista principal (GET con filtros + edición inline)
    Route::get('/admin/gestionUsuarios', [GestionUsuariosController::class, 'index'])->name('admin.gestionUsuarios');
    //Actualizar usuario (PUT desde formulario de edición)
    Route::put('/admin/gestionUsuarios/{id}', [GestionUsuariosController::class, 'update'])->name('admin.gestionUsuarios.update');
    //Dar de baja (eliminar) un usuario
    Route::delete('/admin/gestionUsuarios/{id}', [GestionUsuariosController::class, 'destroy'])->name('admin.gestionUsuarios.destroy');

    //Gestion de sanciones
    Route::get('/admin/gestionSanciones', function () {
        return view('bibliotecaDAW.adminViews.GestionarUsuarios.gestionarSanciones');
    })->name('admin.gestionSanciones');
    //Historial de reservas (CRUD completo)
    Route::get('/admin/historialReservas', [ReservaController::class, 'historial'])->name('admin.historialReservas');
    Route::post('/admin/historialReservas', [ReservaController::class, 'store'])->name('admin.reservas.store');
    Route::put('/admin/historialReservas/{id}', [ReservaController::class, 'update'])->name('admin.reservas.update');
    Route::delete('/admin/historialReservas/{id}', [ReservaController::class, 'destroy'])->name('admin.reservas.destroy');
    //Marcar una reserva como devuelta (atajo rápido)
    Route::patch('/admin/reservas/{id}/devolver', [ReservaController::class, 'devolver'])->name('admin.reservas.devolver');
    //Reservas activas (solo activas y vencidas)
    Route::get('/admin/reservasActivas', [ReservaController::class, 'activas'])->name('admin.reservasActivas');
    //Publicaciones Usuario
    Route::get('/admin/publicacionesUser', [PublicacionController::class, 'index'])->name('admin.publicacionesUser');
    Route::post('/admin/publicacionesUser', [PublicacionController::class, 'store'])->name('admin.publicacionesUser.store');
    //Dar de baja a un usuario (deprecated: usar DELETE /admin/gestionUsuarios/{id})
    //Formulario que muestre las cancelaciones de cada usuario


    // =================== Fin gestion de usuarios ===================

    // =================== Gestion de Libros ===================
    //Gestion de libros vista principal
    //Libros Nuevos
    //Libros Perdidos
    Route::get('/admin/librosPerdidos', [LibroController::class, 'librosPerdidos'])->name('admin.librosPerdidos');
    Route::post('/admin/librosPerdidos/marcar', [LibroController::class, 'marcarPerdido'])->name('admin.librosPerdidos.marcar');
    //Inventario de libros
    Route::get('/admin/inventario', [InventarioController::class, 'index'])->name('admin.inventario');
    //Generar PDF de inventario con filtros personalizados
    Route::get('/admin/inventario/pdf', [InventarioController::class, 'generarPdf'])->name('admin.inventario.pdf');
    //Libros prestados
    // Ruta para VER el listado de libros prestados
    Route::get('/admin/librosPrestados', [PrestamosController::class, 'index'])
        ->name('admin.librosPrestados');

    // Ruta para PROCESAR la devolución (usamos PATCH porque estamos actualizando un campo existente)
    Route::patch('/admin/librosPrestados/{id}/devolver', [PrestamosController::class, 'update'])
        ->name('admin.librosPrestados.devolver');

    // =================== Fin gestion de libros ===================


    // Logout de admin
    Route::post('/admin/logout', [LoginControllerAdmin::class, 'logout'])->name('admin.logout');
});
Route::get('/biblioteca/login', [LoginControllerUsuario::class, 'mostrarLogin'])->name('login.mostrar');
Route::post('/biblioteca/login', [LoginControllerUsuario::class, 'login'])->name('login.procesar');
Route::post('/biblioteca/logout', [LoginControllerUsuario::class, 'logout'])->name('logout');
