@extends('layouts.app')

@section('title', 'Actividades y Eventos')

@section('content')
    <main class="contenedor actividadesEventosBody">
        <div class="contentHeader">
            <h1>Agenda de actividades y eventos</h1>
            <p>Bienvenido a la sección de actividades y eventos de la Biblioteca DAW.</p>
        </div>
        <section class="actividadesEventos">
            <!-- Al apuntarse se va a poner un contador de personas que se han apuntado, deben de estar registradas -->
            @foreach ($eventos as $evento)
                <div class="actividadEventoCard">
                    <div class="eventosTitulo">
                        <h2 class="tituloEvento">{{ $evento->titulo }}</h2>
                        <p class="descripcionEvento">{{ $evento->descripcion }}</p>
                    </div>
                    <div class="eventosFecha">
                        <p class="fechaEvento">Fecha: <strong>{{ date('d/m', strtotime($evento->fecha_hora)) }}</strong></p>
                        <p class="horaEvento">Hora: <strong>{{ date('H:i', strtotime($evento->fecha_hora)) }}</strong></p>
                    </div>
                    <div class="eventosUbicacion">
                        <p class="ubicacionEvento">{{ $evento->ubicacion }}</p>
                        <p class="usuarioEvento">{{ $evento->usuario->name }}</p>
                    </div>
                    <button class="btn-base btn-verde" id="eventoApuntar{{ $evento->id }}">Apuntarse</button>
                </div>
            @endforeach
        </section>
        <section class="contactarEvento">
            <div class="contactarEventoCard">
                <h2 class="contactarEventoTitulo">Crea un evento</h2>
                <p class="contactarEventoDescripcion">¿Quieres crear un evento pero no quieres registrarte?
                    <br> Ponte en contacto con nosotros, lo creamos por ti!</p>

                <a href="{{ route('contacto.create') }}" class="btn-base btn-verde">Contactar</a>
            </div>
        </section>

    </main>
@endsection
