@extends('layouts.app')

@section('title', 'Préstamos')

@section('content')
    <main class="contenedor prestamosUsuario">
        <section class="prestamosHeader">
            <h1>Préstamos</h1>
            <p>Bienvenido <span>{{ Auth::user()->name }}</span>. Desde aquí podrás revisar el estado de tus préstamos activos y consultar próximas devoluciones.</p>
        </section>

        <section class="prestamosResumen">
            <article class="prestamosCard prestamosCardDestacada">
                <p class="prestamosEtiqueta">Resumen actual</p>
                <h2>Tu actividad de préstamo</h2>
                <p>En esta sección podrás consultar los libros que tienes actualmente prestados, sus fechas importantes y cualquier aviso relacionado.</p>
            </article>

            <article class="prestamosCard">
                <h2>Qué podrás ver aquí</h2>
                <div class="prestamosLista">
                    <p>Libros activos en préstamo.</p>
                    <p>Fecha de inicio y devolución estimada.</p>
                    <p>Estado general de cada préstamo.</p>
                </div>
            </article>
        </section>

        <section class="prestamosGrid">
            <article class="prestamosCard">
                <h2>Próximamente</h2>
                <p>Cuando conectes esta vista con la base de datos, aquí podrás mostrar tarjetas o tablas con los préstamos del usuario en tiempo real.</p>
            </article>

            <article class="prestamosCard">
                <h2>Ideas útiles para esta pantalla</h2>
                <div class="prestamosLista">
                    <p>Avisos de devolución próxima.</p>
                    <p>Historial de préstamos completados.</p>
                    <p>Acceso rápido a renovaciones o incidencias.</p>
                </div>
            </article>
        </section>
    </main>
@endsection