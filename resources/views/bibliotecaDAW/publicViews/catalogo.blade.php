@extends('layouts.app')

@section('title', 'Catálogo | Biblioteca DAW')
@section('meta_description', 'Explora y filtra los libros disponibles para préstamo o compra en la Biblioteca DAW.')

@section('content')
    <section class="capitulo capitulo--tinta">
        <div class="envoltura">
            <header class="portadilla">
                <ol class="migas"><li><a href="{{ url('/biblioteca') }}">Biblioteca</a></li><li aria-current="page">Catálogo</li></ol>
                <h1>El <em>catálogo</em></h1>
                <p class="entradilla">Libros para consultar, llevar en préstamo o incorporar a tu biblioteca.</p>
            </header>

            <div class="catalogo__cabecera">
                <p>Busca por título, autor o género y encuentra tu próxima lectura.</p>
                <a href="{{ route('publicaciones.index') }}" class="boton boton--linea">Publicaciones de la comunidad</a>
            </div>

            <div class="catalogo__filtros">
                <form method="GET" action="{{ route('catalogo') }}" aria-label="Filtrar catálogo">
                    <div class="campo">
                        <label for="titulo">Título</label>
                        <input type="search" id="titulo" name="titulo" value="{{ $searchTitulo ?? '' }}" placeholder="Buscar título">
                    </div>
                    <div class="campo">
                        <label for="autor">Autor</label>
                        <input type="search" id="autor" name="autor" value="{{ $searchAutor ?? '' }}" placeholder="Buscar autor">
                    </div>
                    <div class="campo">
                        <label for="genero">Género</label>
                        <input type="search" id="genero" name="genero" value="{{ $searchGenero ?? '' }}" placeholder="Buscar género">
                    </div>
                    <div class="campo">
                        <label for="opcion">Modalidad</label>
                        <select id="opcion" name="opcion">
                            <option value="">Compra y préstamo</option>
                            <option value="compra" @selected(($searchOpcion ?? '') === 'compra')>Solo compra</option>
                            <option value="prestamo" @selected(($searchOpcion ?? '') === 'prestamo')>Solo préstamo</option>
                        </select>
                    </div>
                    <div class="catalogo__acciones">
                        <button type="submit" class="boton">Aplicar filtros</button>
                        <a href="{{ route('catalogo') }}" class="boton boton--texto">Limpiar</a>
                    </div>
                </form>
            </div>

            <p class="catalogo__resultados" aria-live="polite">{{ $libros->total() }} {{ $libros->total() === 1 ? 'libro encontrado' : 'libros encontrados' }}</p>
            @if ($libros->isEmpty())
                <p class="vacio">No encontramos libros con estos filtros. Prueba con otro término.</p>
            @else
                <div class="rejilla-libros">
                    @foreach ($libros as $libro)
                        <article class="libro">
                            <a class="libro__enlace" href="{{ route('libro.paginaInterna', $libro->id) }}">
                                <div class="libro__portada"><img src="{{ $libro->portada_url }}" alt="Portada de {{ $libro->titulo }}" loading="lazy" width="200" height="300"></div>
                                <h2 class="libro__titulo">{{ $libro->titulo }}</h2>
                            </a>
                            <p class="libro__autor">{{ $libro->autor }}</p>
                            <p class="libro__meta">
                                @if ($libro->seVende())
                                    <span class="precio">{{ number_format($libro->precio, 2, ',', '.') }} €</span>
                                @endif
                                @if ($libro->disponibilidad === 'disponible')
                                    <span class="insignia insignia--verde">Disponible</span>
                                @else
                                    <span class="insignia insignia--neutra">{{ ucfirst($libro->disponibilidad) }}</span>
                                @endif
                            </p>
                        </article>
                    @endforeach
                </div>
                <nav class="catalogo__paginacion" aria-label="Páginas del catálogo">{{ $libros->links() }}</nav>
            @endif
        </div>
    </section>
@endsection