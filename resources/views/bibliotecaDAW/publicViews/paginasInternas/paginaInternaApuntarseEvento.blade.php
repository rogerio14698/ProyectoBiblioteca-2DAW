@extends('layouts.app')

@section('title', 'Página Interna Apuntarse al Evento')

@section('content')

<section class="paginaInternaApuntarseAlEvento separador">
    <h1>Hola desde la página interna de Apuntarse al Evento</h1>
    <!--Aqui va un pequeño form para que se puedan apuntar al evento con su numero de socio o su teléfono -->
    <form action="{{ route('evento.apuntarse', ['id' => $evento->id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="nsocio">NSocio:</label>
            <input type="text" id="nsocio" name="nsocio" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" class="form-control" required>
        </div>

        <a href="#">Generar Ticket PDF</a>
        <a href="#">Enviar Ticket al Email</a>
        

        <button type="submit" class="btn-base btn-verde">Apuntarse</button>
    </form>

    <!-- Aqui una vista previa del ticket que se va a generar con los datos del evento y del usuario -->
    <div class="ticketPreview">
        <h2>Vista previa del ticket</h2>
        <p>Evento: {{ $evento->titulo }}</p>
        <p>Fecha: {{ date('d/m/Y', strtotime($evento->fecha_hora)) }}</p>
        <p>Hora: {{ date('H:i', strtotime($evento->fecha_hora)) }}</p>
        <p>Ubicación: {{ $evento->ubicacion }}</p>
        <p>Nombre: [Nombre del usuario]</p>
        <p>Apellido: [Apellido del usuario]</p>
        <p>Email: [Email del usuario]</p>
        <p>NSocio: [NSocio del usuario]</p>
        <p>Teléfono: [Teléfono del usuario]</p>
    </div>

</section>



@endsection