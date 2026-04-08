@extends('layouts.app')

@section('title', 'Catálogo')

@section('content')
    <div class="catalogoContenedor">
        <div class="headerContenido">
            <h1 class="tituloPagina">Catálogo de la Biblioteca</h1>
            <form class="catalogoBuscador" method="GET" action="{{ url('/catalogo') }}">
                <input type="text" name="titulo" value="{{ $searchTitulo ?? ($searchQuery ?? '') }}"
                    placeholder="Buscar por titulo" class="buscadorInput"
                    aria-label="Buscar libros por título, autor o género">
                <input type="text" name="autor" value="{{ $searchAutor ?? '' }}" placeholder="Buscar por autor"
                    class="buscadorInput" aria-label="Buscar libros por autor">
                <input type="text" name="genero" value="{{ $searchGenero ?? '' }}" placeholder="Buscar por género"
                    class="buscadorInput" aria-label="Buscar libros por género">

                <button type="submit" class="btn-base btn-buscar">Buscar</button>
                <a href="{{ url('/catalogo') }}" class="btn-base btn-limpiar"
                    aria-label="Limpiar filtros de búsqueda">Limpiar filtros</a>
            </form>
        </div>

        <div class="catalogoBody separador">
            @forelse ($libros as $libro)
                <div class="catalogoCard">
                    <div class="cardImagen">
                        <picture>
                            <source media="(min-width: 1200px)" srcset="{{ $libro->portada_img }}">
                            <source media="(min-width: 768px)" srcset="{{ $libro->portada_img }}">
                            <img src="{{ $libro->portada_img }}" alt="Portada de {{ $libro->titulo }}">
                        </picture>
                    </div>
                    <div class="cardContenido">
                        <h2 class="libroTitulo">{{ $libro->titulo }}</h2>

                        <div class="infoGrid">
                            <div class="infoItem">
                                <span class="infoLabel">Autor:</span>
                                <span class="infoValue">{{ $libro->autor }}</span>
                            </div>
                            <div class="infoItem">
                                <span class="infoLabel">Género:</span>
                                <span class="infoValue">{{ $libro->genero }}</span>
                            </div>
                            <div class="infoItem">
                                <span class="infoLabel">Editorial:</span>
                                <span class="infoValue">{{ $libro->editorial }}</span>
                            </div>
                            <div class="infoItem">
                                <span class="infoLabel">ISBN:</span>
                                <span class="infoValue">{{ $libro->isbn }}</span>
                            </div>
                            <div class="infoItem">
                                <span class="infoLabel">Año:</span>
                                <span class="infoValue">{{ $libro->anio }}</span>
                            </div>
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
                        </div>
                    </div>

                    <div class="accionesCatalogo">
                        <a href="{{ route('libro.paginaInterna', $libro->id) }}" class="btn-base btn-ver">Ver detalles</a>
                        <a href="#" class="btn-base btn-carrito" id="alertaMantenimiento"
                            onclick="mostrarAlertaMantenimiento()">Añadir al carrito</a>
                        <a href="{{ route('libro.paginaInternaAlquilar', $libro->id) }}" class="btn-base btn-alquilar">Alquilar ahora</a>
                    </div>
                </div>
            @empty
                <p>No se encontraron libros que coincidan con tu búsqueda.</p>
            @endforelse
            <div class="alinearCentro">
                <div class="paginacionBase paginacionCatalogo">
                    {{ $libros->links('vendor.pagination.bootstrap-5') }} <!-- Paginación de 10 libros por página -->
                </div>
            </div>
        </div>

    </div>
@endsection