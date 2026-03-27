@extends('layouts.app')

@section('title', 'Pagina Interna del Libro: ' . $libro->titulo)

@section('content')
    <section class="paginaInternaLibro separador">
        <h1>Hola desde la pagina interna del Libro {{ $libro->titulo }}</h1>
        <div class="cardPaginaInterna">
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
            <div class="contenidoPaginaInterna">
                <h2>{{ $libro->titulo }}</h2>
                <p><strong>Autor:</strong> {{ $libro->autor }}</p>
                <p><strong>Género:</strong> {{ $libro->genero }}</p>
                <p><strong>Editorial:</strong> {{ $libro->editorial }}</p>
                <p><strong>ISBN:</strong> {{ $libro->isbn }}</p>
                <p><strong>Año de publicación:</strong> {{ $libro->anio }}</p>
                <div class="infoItem">
                    <span class="infoLabel">Formatos:</span>
                    @if ($libro->formato === 'digital')
                        <span class="infoValue formato-digital">{{ $libro->formato }}</span>
                    @elseif ($libro->formato === 'fisico')
                        <span class="infoValue formato-fisico">{{ $libro->formato }}</span>
                    @elseif ($libro->formato === 'ambos')
                        <span class="infoValue formato-digital">{{ 'digital' }}</span>
                        <span class="infoValue formato-fisico">{{ 'físico' }}</span>
                    @endif
                </div>
                <div class="infoItem">
                    <span class="infoLabel">Disponibilidad:</span>
                    <!--Aqui evaluo el contennido de disponibilidad para dar estilos a la etiqueta
                                            Entonces, si esta disponible se muestra en verde, si esta prestado en rojo -->
                    @if ($libro->disponibilidad === 'disponible')
                        <span class="infoValue stock-disponible">{{ $libro->disponibilidad }}</span>
                    @else
                        <span class="infoValue stock-no-disponible">{{ $libro->disponibilidad }}</span>
                    @endif
                </div>
                <div class="accionesCatalogo">
                        <a href="#" class="btn-base btn-carrito">Añadir al carrito</a>
                        <a href="#" class="btn-base btn-alquilar">Alquilar ahora</a>
                    </div>
            </div>
    </section>
@endsection
