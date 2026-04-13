@extends('layouts.app')

@section('title', $noticia->titulo . ' - Biblioteca DAW')

@section('content')

    <article class="noticiaInterna separador">

        {{-- Cabecera del artículo: categoría, título, autor y fecha --}}
        <header class="noticiaInternaHeader">
            @if ($noticia->categoria)
                <span class="noticiaInternaCategoria">{{ $noticia->categoria }}</span>
            @endif
            <h1 class="noticiaInternaTitulo">{{ $noticia->titulo }}</h1>
            <div class="noticiaInternaMeta">
                <span class="noticiaInternaAutor">
                    <i class="bi bi-person-circle"></i> {{ $noticia->autor }}
                </span>
                <time class="noticiaInternaFecha" datetime="{{ $noticia->fecha_publicacion->format('Y-m-d') }}">
                    <i class="bi bi-calendar3"></i> {{ $noticia->fecha_publicacion->translatedFormat('d \d\e F, Y') }}
                </time>
            </div>
        </header>

        {{-- Imagen principal del artículo --}}
        @if ($noticia->imagen_url)
            <figure class="noticiaInternaFigura">
                @php
                    // Comprobamos si la URL ya es un enlace externo.
                    $url = Str::startsWith($noticia->imagen_url, ['http://', 'https://'])
                        ? $noticia->imagen_url
                        : asset('storage/' . $noticia->imagen_url);
                @endphp
                <img src="{{ $url }}" alt="Imagen de {{ $noticia->titulo }}" class="noticiaInternaImg"
                    loading="lazy" width="800" height="400">
            </figure>
        @endif

        {{-- Cuerpo del artículo --}}
        <div class="noticiaInternaCuerpo">
            {{-- Primera letra grande estilo periódico (drop cap aplicado por CSS) --}}
            <p class="noticiaInternaTexto">{{ $noticia->contenido }}</p>
        </div>

        {{-- Pie del artículo: enlace externo y navegación --}}
        <footer class="noticiaInternaFooter">
            @if ($noticia->enlace_externo)
                <a href="{{ $noticia->enlace_externo }}" target="_blank" rel="noopener noreferrer" class="btn-base btn-verde noticiaInternaEnlace">
                    <i class="bi bi-box-arrow-up-right"></i> Leer fuente original
                </a>
            @endif
            <a href="{{ url('/biblioteca') }}" class="btn-base btn-azul noticiaInternaVolver">
                <i class="bi bi-arrow-left"></i> Volver al inicio
            </a>
        </footer>

    </article>

@endsection