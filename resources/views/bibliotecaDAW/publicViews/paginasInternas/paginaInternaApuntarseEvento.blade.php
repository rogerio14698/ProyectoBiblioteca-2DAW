@extends('layouts.app')

@section('title', 'Página Interna Apuntarse al Evento')

@section('content')

    <section class="apuntarseEvento separador">
        <header class="headerContenido separador">
            <h1 class="tituloPagina">Inscripción al evento</h1>
            <p class="parrafoTitulo">Completa tus datos para reservar tu plaza en esta actividad.</p>
        </header>

        @if (Auth::check())
            <p class="textoFormulario separador">Bienvenido, {{ Auth::user()->name }}. Aquí puedes apuntarte al evento.</p>

            {{-- Mensajes de feedback tras inscripción --}}
            @if (session('success'))
                <div class="feedbackEmail feedbackExito" role="alert">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="feedbackEmail feedbackError" role="alert">{{ session('error') }}</div>
            @endif

            <div class="apuntarseEventoBloques">
                <article class="apuntarseEventoFormulario">
                    <h2 class="tituloFormulario">Formulario de inscripción</h2>

                    {{-- Formulario principal de inscripción --}}
                    <form class="formApuntarseEvento" id="formApuntarse"
                          action="{{ route('evento.procesarApuntarse', ['id' => $evento->id]) }}" method="POST">
                        @csrf

                        <div class="campoApuntarseEvento">
                            <label class="tituloLabel" for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>

                        <div class="campoApuntarseEvento">
                            <label class="tituloLabel" for="apellido">Apellido</label>
                            <input type="text" id="apellido" name="apellido" required>
                        </div>

                        <div class="campoApuntarseEvento campoCompletoApuntarseEvento">
                            <label class="tituloLabel" for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="campoApuntarseEvento">
                            <label class="tituloLabel" for="nsocio">Nº Socio</label>
                            <input type="text" id="nsocio" name="nsocio" required>
                        </div>

                        <div class="campoApuntarseEvento">
                            <label class="tituloLabel" for="telefono">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" required>
                        </div>

                        <div class="accionesApuntarseEvento campoCompletoApuntarseEvento">
                            {{-- Botón PDF: abre en pestaña nueva --}}
                            <button type="button" id="btnGenerarPdf" class="btn-base btn-azul">Generar ticket PDF</button>
                            {{-- Botón Email: envía PDF al creador del evento --}}
                            <button type="button" id="btnEnviarEmail" class="btn-base btn-amarillo">Enviar ticket por email</button>
                            {{-- Botón Apuntarse: submit normal del formulario --}}
                            <button type="submit" class="btn-base btn-verde">Apuntarse</button>
                        </div>
                    </form>

                    {{-- Formulario oculto para generar PDF en pestaña nueva (target="_blank") --}}
                    <form id="formPdfOculto"
                          action="{{ route('evento.ticketPdf', ['id' => $evento->id]) }}"
                          method="POST" target="_blank" style="display:none;">
                        @csrf
                        <input type="hidden" name="nombre">
                        <input type="hidden" name="apellido">
                        <input type="hidden" name="email">
                        <input type="hidden" name="nsocio">
                        <input type="hidden" name="telefono">
                    </form>
                </article>

                <aside class="ticketPreviewEvento" aria-label="Vista previa del ticket">
                    <h2 class="tituloFormulario">Vista previa del ticket</h2>
                    <p class="textoFormulario"><strong>Evento:</strong> {{ $evento->titulo }}</p>
                    <p class="textoFormulario"><strong>Fecha:</strong> {{ date('d/m/Y', strtotime($evento->fecha_hora)) }}</p>
                    <p class="textoFormulario"><strong>Hora:</strong> {{ date('H:i', strtotime($evento->fecha_hora)) }}</p>
                    <p class="textoFormulario"><strong>Ubicación:</strong> {{ $evento->ubicacion }}</p>
                    {{-- Campos dinámicos que se actualizan con JS --}}
                    <p class="textoFormulario" id="previewNombre"><strong>Nombre:</strong> —</p>
                    <p class="textoFormulario" id="previewApellido"><strong>Apellido:</strong> —</p>
                    <p class="textoFormulario" id="previewEmail"><strong>Email:</strong> —</p>
                    <p class="textoFormulario" id="previewNsocio"><strong>Nº Socio:</strong> —</p>
                    <p class="textoFormulario" id="previewTelefono"><strong>Teléfono:</strong> —</p>
                </aside>
            </div>

            {{-- Mensaje de feedback para envío de email --}}
            <div id="feedbackEmail" class="feedbackEmail" role="alert" style="display:none;"></div>
        @else
            <article class="avisoLoginEvento">
                <h2 class="tituloFormulario">Acceso requerido</h2>
                <p class="textoFormulario">Debes iniciar sesión para apuntarte al evento. También puedes enviar tus datos desde el formulario de contacto.</p>
            </article>
        @endif
    </section>

    {{-- Datos necesarios para el JS (rutas y token CSRF) --}}
    <section id="ticketEventoData"
             data-url-email="{{ route('evento.ticketEmail', ['id' => $evento->id]) }}"
             data-csrf="{{ csrf_token() }}"
             style="display:none;">
    </section>

@endsection