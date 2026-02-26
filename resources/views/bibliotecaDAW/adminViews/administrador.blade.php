@extends('layouts.app')

@section('title', 'Administrador')

@section('content')


    <div class="contenedor dashboard">
        <h1>Dashboard</h1>
        <!-- Aquí puedes agregar más secciones o funcionalidades específicas para el administrador -->

        <!-- Aqui la idea ahora es poner varios cards tipo un panel de control 
                                                                    con diferentes secciones -->
        <div class="dashboard-cards">
            <div class="card-contenidoTotal">
                <h5>Contenido Total: <span>12</span></h5>
                <p>Contenidos Totales</p>
                <button>Más info</button>
            </div>
            <div class="card-noticias">
                <h5>Noticias o Destacados: <span>5</span></h5>
                <p>Contenidos de Noticias o Destacados</p>
                <button>Más info</button>
            </div>
            <div class="card-paginas">
                <h5>Páginas: <span>8</span></h5>
                <p>Gestión de Páginas</p>
                <button>Más info</button>
            </div>
            <div class="card-elementosMenu">
                <h5>Elementos del Menú: <span>10</span></h5>
                <p>Gestión de Elementos del Menú</p>
                <button>Más info</button>
            </div>
        </div>
        <div class="dashboard-body">
            <div class="dashboard-nuevoCatalogo">
                <div class="card-head">
                    <h5>Nuevo Catálogo</h5>
                    <button>Crear</button>
                </div>
                <div class="body-nuevoCatalogo">
                    <h3>No hay catálogos disponibles</h3>
                    <p>Crea tu primer catálogo para empezar</p>
                    <button>Crear Catálogo</button>
                </div>
            </div>
            <div class="dashboard-informacionSistema">
                <h5>Informacion del sistema</h5>
                <p>Libros disponibles: 100</p>
                <p>Usuarios registrados: 50</p>
                <p>Préstamos activos: 20</p>
                <p>Reservas activas: 10</p>
                <p>Eventos próximos: 5</p>
                <p>Usuarios en línea: 3</p>
                <hr>
                <h5>Estado del sistema</h5>
                <p>Estado del servidor: Estable</p>
                <p>Último respaldo: Hace 2 horas</p>
                <p>Actualizaciones pendientes: 0</p>
                <p>Rendimiento del sistema: Óptimo</p>
                <p>Alertas de seguridad: Ninguna</p>
            </div>
        </div>
    </div>

@endsection