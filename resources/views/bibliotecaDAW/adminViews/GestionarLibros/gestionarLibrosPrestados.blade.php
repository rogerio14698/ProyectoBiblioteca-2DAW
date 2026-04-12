@extends('layouts.app')

@section('title', 'Libros Prestados')

@section('content')
    <main class="gestionarLibrosPrestadosContenedor">
    <h1 class="tituloPagina">Gestión de Préstamos Activos</h1>
    <p class="descripcionPagina">Visualiza y gestiona los libros que están actualmente en manos de los usuarios.</p>

    <section class="tablaContenedor">
        <div class="tablaCabecera">
            <div class="celdaHeader">Libro (ISBN)</div>
            <div class="celdaHeader">Usuario</div>
            <div class="celdaHeader textCenter">Fecha Préstamo</div>
            <div class="celdaHeader textCenter">Acciones</div>
        </div>

        <div class="tablaCuerpo">
            @forelse($prestamosActivos as $prestamo)
                <article class="tablaFila">
                    <div class="celdaBody tituloPrincipal" data-label="Libro">
                        {{ $prestamo->libro->titulo }} 
                        <span class="subTexto">({{ $prestamo->libro->isbn }})</span>
                    </div>
                    <div class="celdaBody" data-label="Usuario">
                        {{ $prestamo->usuario->name }}
                    </div>
                    <div class="celdaBody textCenter" data-label="Fecha">
                        {{ $prestamo->fecha_prestamo->format('d/m/Y') }}
                    </div>
                    <div class="celdaBody textCenter" data-label="Acciones">
                        <form action="{{ route('admin.prestamos.devolver', $prestamo->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="botonDevolver">Registrar Devolución</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="sinResultados">No hay préstamos activos en este momento.</div>
            @endforelse
        </div>
    </section>

    <h1 class="tituloPagina secundaria">Gestión de Devoluciones</h1>
    <p>Utiliza el botón superior para finalizar un préstamo o consulta el historial de libros devueltos.</p>
</main>
    @endsection
