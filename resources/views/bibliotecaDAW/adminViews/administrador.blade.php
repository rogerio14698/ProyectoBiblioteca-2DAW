@extends('layouts.app')

@section('title', 'Administrador')

@section('content')


    <div class="contenedor dashboard">
        <h1>Dashboard</h1>
        <!-- Aquí puedes agregar más secciones o funcionalidades específicas para el administrador -->

        <!-- Aqui la idea ahora es poner varios cards tipo un panel de control                                  con diferentes secciones -->
        <div class="dashboard-cards">
            <div class="cardElementosDashboard">
                <h2>Libros disponibles: {{ $librosDisponibles }}</h2>
                <p>Contenidos Totales (publicaciones)</p>
                <a href="{{ route('admin.gestionCatalogo') }}" class="btn-base btn-verde">Más info</a>
            </div>
            <div class="cardElementosDashboard">
                <h2>Eventos próximos: {{ $eventosProximos }}</h2>
                <p>Próximos eventos en la biblioteca</p>
                <a href="{{ route('admin.gestionCarrusel') }}" class="btn-base btn-verde">Más info</a>
            </div>
            <div class="cardElementosDashboard">
                <h2>Usuarios registrados: {{ $usuariosRegistrados }}</h2>
                <p>Total de usuarios registrados en el sistema</p>
                <a href="{{ route('admin.gestionUsuarios') }}" class="btn-base btn-verde">Más info</a>
            </div>
            <div class="cardElementosDashboard">
                <h2>Noticias o Destacados: <span>{{ $totalNoticias }}</span></h2>
                <p>Contenidos de Noticias o Destacados</p>
                <a href="{{ route('admin.gestionNoticias') }}" class="btn-base btn-verde">Más info</a>
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
                                <!--Poner solo el dia en la fecha -->
                                <span class="dataFecha">{{ $mail->created_at->format('d/m/Y') }}</span>
                                <!--Mostramos el estado real guardado en base de datos para evitar inconsistencias visuales. -->
                                <span class="dataEstado">
                                    <span
                                        class="estadoMail {{ $mail->estado === 'pendiente' ? 'estadoPendiente' : ($mail->estado === 'en_proceso' ? 'estadoProceso' : 'estadoLeido') }}">
                                        {{ $mail->estado === 'pendiente' ? 'Pendiente' : ($mail->estado === 'en_proceso' ? 'En proceso' : 'Leido') }}
                                    </span>
                                </span>

                                <!--Elimina el mensaje de la base de datos pero no del email-->
                                <div class="btnsAccionesDashboard">
                                    <form action="{{ route('admin.mensajes.delete', $mail->id) }}" method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('¿Estas seguro que quieres eliminar este mensaje?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-base btnEliminarMail">Eliminar</button>
                                    </form>
                                    <!--Cambia las etiquetas de estado-->
                                    <form action="{{ route('admin.mensajes.update', $mail->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <select class="selectEstadoMail" name="estado" id="estado_{{ $mail->id }}">
                                            <option value="pendiente" {{ $mail->estado === 'pendiente' ? 'selected' : '' }}>
                                                Pendiente</option>
                                            <option value="en_proceso" {{ $mail->estado === 'en_proceso' ? 'selected' : '' }}>
                                                En proceso</option>
                                            <option value="leido" {{ $mail->estado === 'leido' ? 'selected' : '' }}>Leido
                                            </option>
                                        </select>
                                        <button type="submit" class="btn-base btnCambiarEstadoMail">Cambiar Estado</button>
                                    </form>
                                    <!--Este btn abre el formulario de respuesta al email recibido -->
                                    <button type="button" class="btn-base btnResponderMail"
                                        onclick="document.getElementById('formResponder_{{ $mail->id }}').classList.toggle('oculto')">Responder</button>

                                    <!--Formulario de respuesta que se muestra/oculta al pulsar Responder -->
                                    <div id="formResponder_{{ $mail->id }}" class="formResponderMail oculto">
                                        <form action="{{ route('admin.mensajes.responder', $mail->id) }}" method="POST">
                                            @csrf
                                            <label for="respuesta_{{ $mail->id }}">Respuesta para
                                                <strong>{{ $mail->nombre }}</strong>:</label>
                                            <textarea class="textareaResponderMail" name="respuesta"
                                                id="respuesta_{{ $mail->id }}" rows="3" required
                                                placeholder="Escribe tu respuesta aquí..."></textarea>
                                            <button type="submit" class="btn-base btnCambiarEstadoMail">Enviar
                                                respuesta</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection