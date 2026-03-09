@extends('layouts.app')

@section('title', 'Actividades y Eventos')

@section('content')
    <main class="contenedor">
        <div class="contentHeader">
        <h1>Actividades y Eventos</h1>
        <p>Bienvenido a la sección de actividades y eventos de la Biblioteca DAW.</p>
    </div>
    <section class="actividadesEventos">
        <!-- Al apuntarse se va a poner un contador de personas que se han apuntado, deben de estar registradas -->
         @foreach($eventos as $evento)
        <div class="actividadEventoCard">
           <h2>{{ $evento->titulo }}</h2>
           <p>{{ $evento->descripcion }}</p>
            <p>Fecha: <strong>{{ date('d/m', strtotime($evento->fecha_hora)) }}</strong></p>
            <p>Hora: <strong>{{ date('H:i', strtotime($evento->fecha_hora)) }}</strong></p>
            <p>{{ $evento->ubicacion }}</p>
            <p>{{ $evento->usuario->name }}</p>
            <button class="btn-base btn-verde">Apuntarse</button>
        </div>
        @endforeach

    </section>
    </main>
@endsection