@extends('layouts.app')

@section('title', 'Actividades y Eventos')

@section('content')


    <div class="headerContenido">
        <h1 class="tituloPagina">Agenda de actividades y eventos</h1>
        <p class="parrafoTitulo">Bienvenido a la sección de actividades y eventos de la Biblioteca DAW.</p>
    </div>
    <section class="actividadesEventos separador">
        <!-- Al apuntarse se va a poner un contador de personas que se han apuntado, deben de estar registradas -->
        @foreach ($eventos as $evento)
            <div class="actividadEventoCard">
                <div class="eventosTitulo">
                    {{-- El título enlaza a la página interna del evento --}}
                    <a href="{{ route('evento.paginaInterna', ['id' => $evento->id]) }}">
                        <h2 class="tituloCard">{{ $evento->titulo }}</h2>
                    </a>
                    <p class="parrafoContenido">{{ $evento->descripcion }}</p>
                </div>
                <div class="eventoImagen">
                    <picture>
                        @php
                        // Comprobamos si la URL ya es un enlace externo.
                        $url = Str::startsWith($evento->imagen_url, ['http://', 'https://'])
                        ? $evento->imagen_url
                        : asset('storage/' . $evento->imagen_url);
                        @endphp    
                        <source srcset="{{ $url }}" type="image/jpeg">
                        <img src="{{ $url }}" alt="Imagen del evento {{ $evento->titulo }}" class="imgEvento">
                    </picture>
                </div>
                <div class="eventosFecha">
                    <p class="fechaEvento">Fecha: <strong>{{ date('d/m', strtotime($evento->fecha_hora)) }}</strong></p>
                    <p class="horaEvento">Hora: <strong>{{ date('H:i', strtotime($evento->fecha_hora)) }}</strong></p>
                </div>
                <div class="eventosPlazas">
                    <p class="aforoEvento">Aforo: <strong>{{ $evento->aforo }}</strong></p>
                    <p class="plazasLibres">Plazas libres: <strong>{{ $evento->plazas_libres }}</strong></p>
                </div>
                <div class="eventosUbicacion">
                    <p class="ubicacionEvento">{{ $evento->ubicacion }}</p>
                    <p class="usuarioEvento">{{ $evento->usuario->name }}</p>
                </div>
                <a href="{{ route('evento.paginaInterna', ['id' => $evento->id]) }}" class="btn-base btn-azul">Ver evento</a>
                {{-- Verifica si el usuario está autenticado --}}

            @if (Auth::check())
                <a href="{{ route('evento.apuntarse', ['id' => $evento->id]) }}" class="btn-base btn-verde">Apuntarse</a>
            @else
                <p>Debes iniciar sesión para apuntarte al evento. O enviar tus datos a través del formulario de contacto.</p>
            @endif
            </div>
        @endforeach
    </section>

    {{-- Enlaces de paginación (6 eventos por página) --}}
    <div class="paginacionEventos paginacionBase paginacionAgenda">
        {{ $eventos->links() }}
    </div>

    <section class="contactarEvento separador">
        <div class="contactarEventoCard">
            <h2 class="tituloContenido">Crea un evento</h2>
            <p class="parrafoContenido">¿Quieres crear un evento pero no quieres registrarte?
                <br> Ponte en contacto con nosotros, lo creamos por ti!
            </p>

            <a href="{{ route('contacto.create') }}" class="btn-base btn-verde">Contactar</a>
        </div>
    </section>

@endsection
