@extends('layouts.app')

@section('title', 'Organizar Evento')

@section('content')
    <h1>Organizar Evento</h1>
    <p>Bienvenido @user a la sección de organizar eventos de la Biblioteca DAW.</p>
    <!-- Aqui los usuarios podran organizar eventos que se mostrará en la pagina de actividadesEventos
, entonces se necesita de un lugar, fecha, hora y descripción del evento y capacidad máxima de asistentes -->

    <h2>Crear Evento</h2>
    <input type="text" id="lugar" placeholder="Lugar del evento">
    <input type="date" id="fecha">
    <input type="time" id="hora">
    <textarea id="descripcion" placeholder="Descripción del evento"></textarea>
    <input type="number" id="capacidad" placeholder="Capacidad máxima de asistentes">
    <button type="submit">Crear Evento</button> 

    
@endsection