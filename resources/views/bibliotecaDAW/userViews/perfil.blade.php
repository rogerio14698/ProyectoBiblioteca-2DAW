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
                    <img src="{{ Auth::user()->profile_photo_url ?? 'img/default.png' }}" alt="Foto de perfil"
                        class="foto-perfil">

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
                <button type="button" class="btn-base btn-azul" onclick="location.href='#contenidosMetodosPago'">Gestionar
                    Métodos de Pago</button>
                <button type="button" class="btn-base btn-azul" onclick="location.href='#contenidosHistorial'">Historial de
                    Actividad</button>
            </div>
        </section>

        <!-- Métodos de pago -->
        <button class="btn-base btn-azul" id="btnMetodosPago" aria-expanded="false">MetodosPago</button>
        <section class="contenidoMetodosPago">
            <div class="metodosPago">
                <h3>Añadir metodo pago</h3>
                <div class="tarjetaCredito">
                    <h4>Tarjeta de Crédito</h4>
                    <div class="labelTarjetaCredito">
                        <label for="card_number">Número de tarjeta:</label>
                        <input type="text" id="card_number">
                    </div>
                    <div class="labelTarjetaCredito">
                        <label for="expiry_date">Fecha de expiración:</label>
                        <input type="text" id="expiry_date" placeholder="MM/AA">
                    </div>
                    <button type="button" class="btn-base btn-verde">Añadir Tarjeta</button>
                </div>
                <div class="paypal">
                    <h4>PayPal</h4>
                    <div class="labelPaypal">
                        <label for="paypal_email">Correo electrónico de PayPal:</label>
                        <input type="email" id="paypal_email">
                    </div>

                    <button type="button" class="btn-base btn-verde">Añadir PayPal</button>
                </div>
        </section>

        <!-- Historial de actividad -->
        <button id="contenidosHistorial" class="btn-base btn-verde">Ver historial</button>
        <div class="historialVersionDesktop">
            @include('layouts.historialVersionDesktop')
        </div>
        <div class="historialVersionMovil">
            @include('layouts.historialVersionMovil')
        </div>
    </main>

    <hr>

@endsection
