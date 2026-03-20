@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    <div class="contenedor perfilUsuario">
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
                <button type="button" class="btn-base btn-azul">Cambiar Contraseña</button>
            </div>
        </section>
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
        <hr>
        <button id="contenidosHistorial" class="btn-base btn-verde">Ver historial</button>
        <section class="contenidoHistorial">
            <div class="historialPrestamos">
                <h4>Historial de prestamos</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Libro</th>
                            <th>Fecha de préstamo</th>
                            <th>Fecha de devolución</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Libro 1</td>
                            <td>01/01/2024</td>
                            <td>15/01/2024</td>
                            <td>Devuelto</td>
                            <td>
                                <button class="btn-base btn-verde">Ver</button>
                                <button class="btn-base btn-rojo">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="historialReservas">
                <h4>Historial de reservas Eventos</h4>
                <table>
                    <thead>
                        <th>Nombre Evento</th>
                        <th>Fecha</th>
                        <th>Ubicación</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Lectura 2</td>
                            <td>01/02/2024</td>
                            <td>Biblioteca Central</td>
                            <td>18:00</td>
                            <td>Asistido</td>
                            <td>
                                <button class="btn-base btn-verde">Ver</button>
                                <button class="btn-base btn-rojo">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="historialCompras">
                <h4>Historial de compras</h4>
                <table>
                    <thead>
                        <th>Libro</th>
                        <th>Isbn</th>
                        <th>Fecha de compra</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Libro 1</td>
                            <td>1234567890</td>
                            <td>01/01/2024</td>
                            <td>15,00 €</td>
                            <td>Completado</td>
                            <td>
                                <button class="btn-base btn-verde">Ver</button>
                                <button class="btn-base btn-rojo">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="historialPublicaciones">
                <h4>Historial de publicaciones</h4>
                <table>
                    <thead>
                        <th>Titulo</th>
                        <th>Resumen</th>
                        <th>Genero</th>
                        <th>Autor</th>
                        <th>Contenido</th>
                        <th>Formato</th>
                        <th>Estado</th>
                        <th>Fecha de publicación</th>
                        <th>Evento Promocional</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Publicacion 1</td>
                            <td>Resumen de la publicación 1</td>
                            <td>Ficción</td>
                            <td>Autor 1</td>
                            <td>Contenido de la publicación 1</td>
                            <td>PDF</td>
                            <td>Publicado</td>
                            <td>01/03/2024</td>
                            <td>Evento 1</td>
                            <td>
                                <button class="btn-base btn-verde">Ver</button>
                                <button class="btn-base btn-rojo">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>


    </div>

@endsection
