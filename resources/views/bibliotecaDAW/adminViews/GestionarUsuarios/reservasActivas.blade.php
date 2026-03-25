@extends('layouts.app')

@section('title', 'Historial de Reservas')

@section('content')
    <main class="contenedor">

        <h1>Historial de Reservas</h1>
    <p>Desde aquí puedes gestionar el historial de reservas de la Biblioteca DAW.</p>
    <!--Aqui un listado de todos los usuarios existentes -->
       <div class="navHistorial">
        <a href="{{ route('admin.historialReservas') }}">Volver a Historial Reservas</a>
       </div>
       
    </main>


@endsection