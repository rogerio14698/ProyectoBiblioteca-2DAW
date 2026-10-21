@extends('layouts.app')

@section('title', 'Solicitar préstamo: ' . $libro->titulo)

@section('content')
    <section class="capitulo capitulo--tinta">
        <div class="envoltura">
            <header class="portadilla">
                <ol class="migas"><li><a href="{{ url('/biblioteca') }}">Biblioteca</a></li><li><a href="{{ route('catalogo') }}">Catálogo</a></li><li><a href="{{ route('libro.paginaInterna', $libro->id) }}">{{ $libro->titulo }}</a></li><li aria-current="page">Préstamo</li></ol>
                <h1>Llevarlo <em>en préstamo</em></h1>
                <p class="entradilla">Confirma las condiciones del préstamo de este ejemplar.</p>
            </header>
            <div class="dos-columnas ficha-libro">
                <figure class="lamina ficha-libro__portada"><img src="{{ $libro->portada_url }}" alt="Portada de {{ $libro->titulo }}" width="600" height="900"><figcaption>{{ $libro->titulo }} · {{ $libro->autor }}</figcaption></figure>
                <div>
                    <h2>{{ $libro->titulo }}</h2>
                    <p class="ficha-libro__autor">{{ $libro->autor }}</p>
                    <dl class="ficha">
                        <div><dt>Editorial</dt><dd>{{ $libro->editorial }}</dd></div>
                        <div><dt>ISBN</dt><dd>{{ $libro->isbn }}</dd></div>
                        <div><dt>Género</dt><dd>{{ $libro->genero }}</dd></div>
                        <div><dt>Año</dt><dd>{{ $libro->anio }}</dd></div>
                        <div><dt>Formato</dt><dd>{{ $libro->formato === 'ambos' ? 'Físico y digital' : ucfirst($libro->formato) }}</dd></div>
                        <div><dt>Ejemplares</dt><dd>{{ $libro->cantidad_ejemplares }}</dd></div>
                    </dl>
                    @auth('web')
                        <section class="panel">
                            <h2 class="panel__titulo">Solicitud de préstamo</h2>
                            <p>Hola, {{ Auth::guard('web')->user()->name }}. El préstamo bibliotecario es gratuito.</p>
                            @if ($libro->disponibilidad === 'disponible')
                                <form action="{{ route('usuario.alquilar.store') }}" method="POST" class="formulario">
                                    @csrf
                                    <input type="hidden" name="libro_id" value="{{ $libro->id }}">
                                    <div class="campo"><label for="diasPrestamo">Duración del préstamo (1–60 días)</label><input type="number" id="diasPrestamo" name="dias_prestamo" min="1" max="60" value="{{ old('dias_prestamo', 14) }}" required></div>
                                    <div class="campo"><label for="formatoAlquiler">Formato preferido</label><select id="formatoAlquiler" name="formato">@if ($libro->formato === 'fisico' || $libro->formato === 'ambos')<option value="fisico">Físico</option>@endif @if ($libro->formato === 'digital' || $libro->formato === 'ambos')<option value="digital">Digital</option>@endif</select></div>
                                    <button type="submit" class="boton">Confirmar alquiler</button>
                                </form>
                            @else
                                <p class="aviso aviso--info">Este libro no está disponible actualmente.</p>
                            @endif
                        </section>
                    @else
                        <div class="panel">
                            <h2 class="panel__titulo">Acceso de socio</h2>
                            <p>Inicia sesión para solicitar el préstamo. El registro es gratuito.</p>
                            <div class="acciones"><a href="{{ route('usuario.login.mostrar') }}" class="boton">Iniciar sesión</a><a href="{{ route('usuario.show') }}" class="boton boton--linea">Crear una cuenta</a></div>
                        </div>
                    @endauth
                    <p class="articulo__pie"><a href="{{ route('libro.paginaInterna', $libro->id) }}">Volver a la ficha del libro</a></p>
                </div>
            </div>
        </div>
    </section>
@endsection