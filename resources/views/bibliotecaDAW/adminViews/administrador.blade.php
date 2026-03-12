@extends('layouts.app')

@section('title', 'Administrador')

@section('content')


    <div class="contenedor dashboard">
        <h1>Dashboard</h1>
        <!-- Aquí puedes agregar más secciones o funcionalidades específicas para el administrador -->

        <!-- Aqui la idea ahora es poner varios cards tipo un panel de control                                  con diferentes secciones -->
        <div class="dashboard-cards">
            <div class="card-contenidoTotal">
                <h5>Contenido Total: <span>12</span></h5>
                <p>Contenidos Totales</p>
                <button>Más info</button>
            </div>
            <div class="card-noticias">
                <h5>Noticias o Destacados: <span>5</span></h5>
                <p>Contenidos de Noticias o Destacados</p>
                <button>Más info</button>
            </div>
            <div class="card-paginas">
                <h5>Páginas: <span>8</span></h5>
                <p>Gestión de Páginas</p>
                <button>Más info</button>
            </div>
            <div class="card-elementosMenu">
                <h5>Elementos del Menú: <span>10</span></h5>
                <p>Gestión de Elementos del Menú</p>
                <button>Más info</button>
            </div>
        </div>
        <div class="bodyDashboard">
            <div class="dashboardListadoMail ">
                <div class="cardHeaderMail">
                    <h5>Listado Mails</h5>
                </div>
                <div class="bodyListadoMail">
                    <div class="tablaListadoMail">
                        <div class="titulosListados">
                            <span class="tituloNombre">Nombre</span>
                            <span class="tituloEmail">Email</span>
                            <span class="tituloAsunto">Asunto</span>
                            <span class="tituloMensaje">Mensaje</span>
                            <span class="tituloFecha">Fecha</span>
                            <span class="tituloEstado">Estado</span>
                            <span class="tituloAcciones">Acciones</span>
                        </div>
                        @foreach ($mensajes as $mail)
                        <div class="dataListadoMail">
                            <span class="dataNombre">{{ $mail->nombre }}</span>
                            <span class="dataEmail">{{ $mail->email }}</span>
                            <span class="dataAsunto">{{ $mail->asunto }}</span>
                            <span class="dataMensaje">{{ $mail->mensaje }}</span>
                            <span class="dataFecha">{{ $mail->fecha }}</span>
                            <span class="dataEstado"><span class="estadoMail estadoPendiente">{{ $mail->estado }}</span></span>
                            <span>
                                <button class="btn-base">Ver</button>
                                <button class="btn-base">Eliminar</button>
                                <button class="btn-base">Marcar como leído</button>
                                <button class="btn-base">Responder</button>
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="dashboard-informacionSistema">
                <h5>Informacion del sistema</h5>
                <p>Libros disponibles: 100</p>
                <p>Usuarios registrados: 50</p>
                <p>Préstamos activos: 20</p>
                <p>Reservas activas: 10</p>
                <p>Eventos próximos: 5</p>
                <p>Usuarios en línea: 3</p>
                <hr>
                <h5>Estado del sistema</h5>
                <p>Estado del servidor: Estable</p>
                <p>Último respaldo: Hace 2 horas</p>
                <p>Actualizaciones pendientes: 0</p>
                <p>Rendimiento del sistema: Óptimo</p>
                <p>Alertas de seguridad: Ninguna</p>
            </div>
        </div>
    </div>

@endsection