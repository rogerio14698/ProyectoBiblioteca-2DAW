@extends('layouts.app')

@section('title', 'Gestionar Actividades y Eventos')

@section('content')
    <!-- Contenedor principal de la página de gestión de eventos -->
    <main class="contenedor gestionarActividadesYEventos">

        <!-- Título principal de la sección -->
        <div class="eventosEncabezado">
            <h1>Gestionar Eventos</h1>
            <p>Desde aquí puedes gestionar los eventos de la Biblioteca DAW.</p>
        </div>

        <!-- Layout de dos columnas: formulario (izquierda) + listado (derecha) -->
        <div class="eventosLayout">

            <!-- ========== COLUMNA IZQUIERDA: FORMULARIO ========== -->
            <div class="eventosFormulario">
                <form action="#" class="eventosFormularioInner">
                    <h2>Agregar Nuevo Evento</h2>

                    <!-- Campo: Nombre del evento -->
                    <div class="eventosGrupoFormulario">
                        <label for="nombreEvento">Nombre del Evento</label>
                        <input type="text" id="nombreEvento" name="nombreEvento" placeholder="Ej: Club de Lectura" required>
                    </div>

                    <!-- Campo: Descripción del evento -->
                    <div class="eventosGrupoFormulario">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="4"
                            placeholder="Describe brevemente el evento..." required></textarea>
                    </div>

                    <!-- Campo: Lugar donde se celebra -->
                    <div class="eventosGrupoFormulario">
                        <label for="lugar">Lugar</label>
                        <input type="text" id="lugar" name="lugar" placeholder="Ej: Sala de Lectura" required>
                    </div>

                    <!-- Campo: Hora del evento -->
                    <div class="eventosGrupoFormulario">
                        <label for="hora">Hora</label>
                        <input type="time" id="hora" name="hora" required>
                    </div>

                    <!-- Campo: Fecha del evento -->
                    <div class="eventosGrupoFormulario">
                        <label for="fecha">Fecha</label>
                        <input type="date" id="fecha" name="fecha" required>
                    </div>

                    <!-- Botón de envío del formulario -->
                    <button class="eventosBotonEnvio" type="submit">Añadir / Editar Evento</button>
                </form>
            </div>

            <!-- ========== COLUMNA DERECHA: LISTADO DE EVENTOS ========== -->
            <div class="eventosListado">
                <h2>Listado de Eventos</h2>

                <!-- Contenedor con scroll para las tarjetas de eventos -->
                <div class="eventosListadoCards">

                    <!-- Tarjeta de evento de ejemplo -->
                    <article class="eventoCard">
                        <div class="eventoCardInfo">
                            <div class="eventoCardCabecera">
                                <span class="eventoCardId">#001</span>
                                <h3 class="eventoCardNombre">Club de Lectura</h3>
                            </div>
                            <p class="eventoCardDescripcion">Un espacio para compartir y discutir sobre libros.</p>
                            <div class="eventoCardMeta">
                                <span class="eventoCardMetaItem">Sala de Lectura</span>
                                <span class="eventoCardMetaItem">18:00</span>
                                <span class="eventoCardMetaItem">2024-07-15</span>
                            </div>
                        </div>
                        <div class="eventoCardAcciones">
                            <button class="btn-base btn-azul btnEditarEvento" type="button">Editar</button>
                            <form action="#" method="POST" style="display:inline">
                                <button class="btn-base btn-rojo btnEliminarEvento" type="submit">Eliminar</button>
                            </form>
                        </div>
                    </article>

                    <!-- Segunda tarjeta de ejemplo para visualizar el scroll -->
                    <article class="eventoCard">
                        <div class="eventoCardInfo">
                            <div class="eventoCardCabecera">
                                <span class="eventoCardId">#002</span>
                                <h3 class="eventoCardNombre">Taller de Escritura Creativa</h3>
                            </div>
                            <p class="eventoCardDescripcion">Aprende técnicas de escritura con profesionales del sector.</p>
                            <div class="eventoCardMeta">
                                <span class="eventoCardMetaItem">Aula Magna</span>
                                <span class="eventoCardMetaItem">10:00</span>
                                <span class="eventoCardMetaItem">2024-08-20</span>
                            </div>
                        </div>
                        <div class="eventoCardAcciones">
                            <button class="btn-base btn-azul btnEditarEvento" type="button">Editar</button>
                            <form action="#" method="POST" style="display:inline">
                                <button class="btn-base btn-rojo btnEliminarEvento" type="submit">Eliminar</button>
                            </form>
                        </div>
                    </article>

                </div>
            </div>

        </div>
    </main>
@endsection