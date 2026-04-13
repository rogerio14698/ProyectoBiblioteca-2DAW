@extends('layouts.app')

@section('title', 'Libros Prestados')

@section('content')

    <main class="contenedor gestionPrestamos">

        <!-- Encabezado con titulo y enlace a libros perdidos -->
        <div class="prestamosEncabezado">
            <div>
                <h1>Prestamos Activos</h1>
                <p>Libros actualmente en manos de usuarios. Registra devoluciones o marca como perdidos.</p>
            </div>
            <div class="prestamosNav">
                <a href="{{ route('admin.librosPerdidos') }}" class="btn-base btn-primario">Ver Libros Perdidos</a>
            </div>
        </div>

        <!-- Mensajes flash de feedback -->
        @if (session('success'))
            <div class="alertaExito">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alertaError">{{ session('error') }}</div>
        @endif

        <!-- Listado de prestamos activos -->
        <section class="prestamosListado">
            <h2>Pendientes de devolucion ({{ $prestamosActivos->count() }})</h2>

            <div class="prestamosListadoCards">
                @forelse($prestamosActivos as $prestamo)
                    <article class="prestamoCard">
                        <!-- Informacion del prestamo -->
                        <div class="prestamoCardInfo">
                            <div class="prestamoCardCabecera">
                                <span class="prestamoCardId">#{{ $prestamo->id }}</span>
                                <h3 class="prestamoCardTitulo">{{ $prestamo->libro->titulo }}</h3>
                            </div>
                            <span class="prestamoCardIsbn">ISBN: {{ $prestamo->libro->isbn }}</span>
                            <p class="prestamoCardUsuario">{{ $prestamo->usuario->name ?? 'Usuario eliminado' }}</p>
                            <div class="prestamoCardMeta">
                                <span class="prestamoCardMetaItem">Prestamo: {{ $prestamo->fecha_prestamo->format('d/m/Y') }}</span>
                                @if ($prestamo->fecha_devolucion_esperada)
                                    <span class="prestamoCardMetaItem">Limite: {{ $prestamo->fecha_devolucion_esperada->format('d/m/Y') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Acciones: devolver o marcar como perdido -->
                        <div class="prestamoCardAcciones">
                            <form action="{{ route('admin.librosPrestados.devolver', $prestamo->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-base btn-verde btnDevolverPrestamo"
                                    onclick="return confirm('¿Registrar la devolucion de este libro?')">
                                    Devolver
                                </button>
                            </form>
                            <form action="{{ route('admin.librosPrestados.perdido', $prestamo->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-base btn-rojo btnPerdidoPrestamo"
                                    onclick="return confirm('¿Marcar este libro como perdido? Se cerrara el prestamo y aparecera en Libros Perdidos.')">
                                    Marcar Perdido
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="prestamoCardVacio">No hay prestamos activos en este momento.</p>
                @endforelse
            </div>
        </section>
    </main>

@endsection
