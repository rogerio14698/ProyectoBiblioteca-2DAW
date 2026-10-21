@extends('layouts.app')

@section('title', $noticia->titulo . ' | Biblioteca DAW')
@section('og_type', 'article')

@section('content')
    @php
        $imagenNoticia = null;
        if ($noticia->imagen_url) {
            $imagenNoticia = \Illuminate\Support\Str::startsWith($noticia->imagen_url, ['http://', 'https://'])
                ? $noticia->imagen_url
                : asset('storage/' . $noticia->imagen_url);
        }
    @endphp
    <section class="capitulo capitulo--tinta">
        <div class="envoltura envoltura--estrecha">
            <article>
                <header class="portadilla">
                    <ol class="migas"><li><a href="{{ url('/biblioteca') }}">Biblioteca</a></li><li aria-current="page">Noticias</li></ol>
                    <h1>{{ $noticia->titulo }}</h1>
                    @if ($noticia->categoria)<p class="entradilla">{{ $noticia->categoria }}</p>@endif
                    <div class="lectura__meta">
                        @if ($noticia->autor)<span>Por {{ $noticia->autor }}</span>@endif
                        @if ($noticia->fecha_publicacion)<time datetime="{{ $noticia->fecha_publicacion->format('Y-m-d') }}">{{ \Illuminate\Support\Str::ucfirst($noticia->fecha_publicacion->translatedFormat('d \d\e F, Y')) }}</time>@endif
                    </div>
                </header>
                @if ($noticia->imagen_url)
                    <figure class="lamina articulo__figura"><img src="{{ $imagenNoticia }}" alt="Imagen de {{ $noticia->titulo }}" width="1200" height="700"><figcaption>{{ $noticia->titulo }}</figcaption></figure>
                @endif
                <div class="lectura articulo__cuerpo">{!! nl2br(e($noticia->contenido)) !!}</div>
                <footer class="articulo__pie">
                    @if ($noticia->enlace_externo)<a href="{{ $noticia->enlace_externo }}" class="boton" target="_blank" rel="noopener noreferrer">Leer la fuente original</a>@endif
                    <a href="{{ url('/biblioteca') }}#noticias" class="boton boton--linea">Volver a noticias</a>
                </footer>
            </article>
        </div>
    </section>
@endsection