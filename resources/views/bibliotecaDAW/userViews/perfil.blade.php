@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    <main class="contenedor perfilUsuario">
        <section class="contenidoHeader">
            <div class="texto-bienvenidaUsuario">
                <h1>Perfil</h1>
                <p>Bienvenido: {{ Auth::user()->name }}</p>
                <a href="#">Editar</a>
                <div class="info-personalFoto">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto de perfil" class="foto-perfil">

                </div>
            </div>
            <div class="info-personalUsuario">

                <div class="info-personalDatos">
                    <h2>Información Personal</h2>
                    <p>Nombre de usuario: <strong>{{ Auth::user()->name }}</strong></p>
                    <p>Correo electrónico: <strong>{{ Auth::user()->email }}</strong></p>
                    <p>Numero de socio: <strong>{{ Auth::user()->nSocio }}</strong></p>
                </div>
            </div>
            <button class="btn-base btn-verde" id="btnConfigUsuario" aria-expanded="false">Config</button>
            <div class="configCuentaUsuario">
                <button type="button" class="btn-base btn-verde"
                    onclick="location.href='{{ route('usuario.perfilEditar') }}'">Editar Perfil</button>
                <button type="button" class="btn-base btn-azul" onclick="location.href='#contenidosHistorial'">Historial de
                    Actividad</button>
            </div>
        </section>

        <!-- Historial de actividad -->
        <button id="contenidosHistorial" class="btn-base btn-verde">Ver historial</button>
        <div class="historialVersionDesktop">
            @include('layouts.historialVersionDesktop')
        </div>
    </main>

    <hr>

@endsection