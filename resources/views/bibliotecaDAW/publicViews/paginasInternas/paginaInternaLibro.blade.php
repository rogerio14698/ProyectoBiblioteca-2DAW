@extends('layouts.app')

@section('title', $libro->titulo . ' | Biblioteca DAW')

@section('content')
    <section class="capitulo capitulo--tinta">
        <div class="envoltura">
            <header class="portadilla">
                <ol class="migas"><li><a href="{{ url('/biblioteca') }}">Biblioteca</a></li><li><a href="{{ route('catalogo') }}">Catálogo</a></li><li aria-current="page">{{ $libro->titulo }}</li></ol>
            </header>
            <div class="dos-columnas ficha-libro">
                <figure class="lamina ficha-libro__portada">
                    <img src="{{ $portadaUrl }}" alt="Portada de {{ $libro->titulo }}" width="600" height="900">
                    <figcaption>Edición de {{ $libro->editorial }}</figcaption>
                </figure>
                <article>
                    <h1>{{ $libro->titulo }}</h1>
                    <p class="ficha-libro__autor">{{ $libro->autor }}</p>
                    <dl class="ficha">
                        <div><dt>Género</dt><dd>{{ $libro->genero }}</dd></div>
                        <div><dt>Editorial</dt><dd>{{ $libro->editorial }}</dd></div>
                        <div><dt>ISBN</dt><dd>{{ $libro->isbn }}</dd></div>
                        <div><dt>Año</dt><dd>{{ $libro->anio }}</dd></div>
                        <div><dt>Formato</dt><dd>{{ $libro->formato === 'ambos' ? 'Físico y digital' : ucfirst($libro->formato) }}</dd></div>
                        <div><dt>Disponibilidad</dt><dd>@if ($libro->disponibilidad === 'disponible')<span class="insignia insignia--verde">Disponible</span>@else<span class="insignia insignia--neutra">{{ ucfirst($libro->disponibilidad) }}</span>@endif</dd></div>
                    </dl>
                    <div class="ficha-libro__acciones">
                        @if ($libro->seVende())
                            <div class="ficha-libro__compra">
                                <p class="precio">{{ number_format($libro->precio, 2, ',', '.') }} €</p>
                                @auth('web')
                                    <form action="{{ route('pagos.libro', $libro->id) }}" method="POST">@csrf<button type="submit" class="boton">Comprar con tarjeta</button></form>
                                @else
                                    <a href="{{ route('usuario.login.mostrar') }}" class="boton">Inicia sesión para comprar</a>
                                @endauth
                            </div>
                        @endif
                        @if ($libro->opcion_compra === 'prestamo')
                            <a href="{{ route('libro.paginaInternaAlquilar', $libro->id) }}" class="boton boton--linea">Solicitar préstamo</a>
                        @endif
                        <a href="{{ route('catalogo') }}" class="boton boton--texto">Volver al catálogo</a>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection