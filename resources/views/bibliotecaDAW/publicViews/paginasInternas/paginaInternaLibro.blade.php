@extends('layouts.app')

@section('title', $libro->titulo . ' - Detalle del Libro')

@section('content')
    <section class="paginaInternaLibro separador">

        <div class="cardPaginaInterna">
            {{-- Columna izquierda: libro 3D interactivo --}}
            <div class="book-container">
                <div class="book" title="Portada del libro {{ $libro->titulo }}">
                    <div class="front">
                        <img src="{{ $portadaUrl }}" alt="Portada del libro {{ $libro->titulo }}">
                    </div>
                    <div class="back"></div>
                    <div class="spine"></div>
                    <div class="left"></div>
                    <div class="right"></div>
                    <div class="top"></div>
                    <div class="bottom"></div>
                </div>
            </div>

            {{-- Columna derecha: información del libro --}}
            <div class="contenidoPaginaInterna">
                <h1 class="libroInternoTitulo">{{ $libro->titulo }}</h1>
                <p class="libroInternoAutor">{{ $libro->autor }}</p>

                {{-- Datos principales organizados en grid --}}
                <div class="libroInternoDatos">
                    <div class="libroInternoDato">
                        <span class="libroInternoDatoLabel">Género</span>
                        <span class="libroInternoDatoValor">{{ $libro->genero }}</span>
                    </div>
                    <div class="libroInternoDato">
                        <span class="libroInternoDatoLabel">Editorial</span>
                        <span class="libroInternoDatoValor">{{ $libro->editorial }}</span>
                    </div>
                    <div class="libroInternoDato">
                        <span class="libroInternoDatoLabel">ISBN</span>
                        <span class="libroInternoDatoValor">{{ $libro->isbn }}</span>
                    </div>
                    <div class="libroInternoDato">
                        <span class="libroInternoDatoLabel">Año</span>
                        <span class="libroInternoDatoValor">{{ $libro->anio }}</span>
                    </div>
                </div>

                {{-- Badges de formato y disponibilidad --}}
                <div class="libroInternoBadges">
                    <div class="infoItem">
                        <span class="infoLabel">Formato:</span>
                        @if ($libro->formato === 'digital')
                            <span class="infoValue formato-digital">Digital</span>
                        @elseif ($libro->formato === 'fisico')
                            <span class="infoValue formato-fisico">Físico</span>
                        @elseif ($libro->formato === 'ambos')
                            <span class="infoValue formato-digital">Digital</span>
                            <span class="infoValue formato-fisico">Físico</span>
                        @endif
                    </div>
                    <div class="infoItem">
                        <span class="infoLabel">Disponibilidad:</span>
                        @if ($libro->disponibilidad === 'disponible')
                            <span class="infoValue stock-disponible">{{ $libro->disponibilidad }}</span>
                        @else
                            <span class="infoValue stock-no-disponible">{{ $libro->disponibilidad }}</span>
                        @endif
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="accionesCatalogo">
                    <a href="#" class="btn-base btn-carrito">
                        <i class="bi bi-cart-plus"></i> Añadir al carrito
                    </a>
                    <a href="#" class="btn-base btn-alquilar">
                        <i class="bi bi-book"></i> Alquilar ahora
                    </a>
                </div>

                {{-- Enlace para volver al catálogo --}}
                <a href="{{ url('/catalogo') }}" class="btn-base btn-azul libroInternoVolver">
                    <i class="bi bi-arrow-left"></i> Volver al catálogo
                </a>
            </div>
        </div>

    </section>
@endsection
