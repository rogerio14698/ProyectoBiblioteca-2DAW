@extends('layouts.app')

@section('title', 'Historial de Reservas')

@section('content')
    <main class="contenedor">
        <section>
            <h1>Historial de Reservas</h1>
            <p>Desde aquí puedes gestionar el historial de reservas de la Biblioteca DAW.</p>
            <!--Aqui un listado de todos los usuarios existentes -->
            <div class="navHistorial">
                <a href="{{ route('admin.reservasActivas') }}">Reservas Activas</a>
            </div>
        </section>

        <section>
            <h2>CRUD de reserva seleccionada</h2>
        </section>
    </main>

    <!--Listado de reservas históricas -->

    <!--Ver como hace este listado ya que va a ser muy largo -->

@endsection
