@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    <div class="contenedor ">
        <section class="contenidoHeader">
            <div class="texto-bienvenidaUsuario">
                <h1>Perfil</h1>
                <p>Bienvenido tu perfil de usuario de la Biblioteca DAW.</p>
            </div>
            <div class="info-personalUsuario">
                <div class="info-personalFoto">
                    <img src="{{ Auth::user()->profile_photo_url ?? 'img/default.png' }}" alt="Foto de perfil" class="foto-perfil">
                </div>
                <div class="info-personalDatos">
                    <h2>Información Personal</h2>
                <p>Nombre de usuario: {{ Auth::user()->name }}</p>
                <p>Correo electrónico: {{ Auth::user()->email }}</p>
                <p>Numero de socio: {{Auth::user()->nSocio}}</p>
                </div>
            </div>
            <div class="configCuentaUsuario">
                <h2>Configuración de Cuenta</h2>
                <ul>
                    <li><a href="{{ route('usuario.perfilEditar') }}">Editar Perfil</a></li>
                    <li><a href="#contenidosMetodosPago">Gestionar Métodos de Pago</a></li>
                    <li><a href="#contenidosHistorial">Historial de Actividad</a></li>
                </ul>
                <button type="button" class="btn-base">Cambiar Contraseña</button>
                <button type="button" class="btn-base">Cerrar Sesión</button>
            </div>
        </section>
        <section class="contenidoMetodosPago" id="contenidosMetodosPago">
            <div class="metodosPago">
                <h3>Añadir metodo pago</h3>
                <div class="tarjetaCredito">
                    <h4>Tarjeta de Crédito</h4>
                    <input type="text" id="card_number">
                    <label for="card_number">Número de tarjeta:</label>
                    <button type="button" class="btn-base">Añadir Tarjeta</button>
                </div>
                <div class="paypal">
                    <h4>PayPal</h4>
                    <input type="email" id="paypal_email">
                    <label for="paypal_email">Correo electrónico de PayPal:</label>
                    <button type="button" class="btn-base">Añadir PayPal</button>
                </div>
        </section>
        <hr>
        <section class="contenidoHistorial" id="contenidosHistorial">

            <div class="historialPrestamos">
                <h4>Historial de prestamos</h4>
                <p>No tienes prestamos activos</p>
            </div>

            <div class="historialReservas">
                <h4>Historial de reservas</h4>
                <p>No tienes reservas activas.</p>
            </div>
            <div class="historialReservas">
                <h4>Historial de eventos</h4>
                <p>Aun no te has apunto a ningún evento</p>
            </div>
            <div class="historialCompras">
                <h4>Historial de compras</h4>
                <p>No tienes compras activas.</p>
            </div>
            <div class="historialPublicaciones">
                <h4>Historial de publicaciones</h4>
                <p>No tienes publicaciones aún</p>
            </div>

        </section>


    </div>

@endsection
