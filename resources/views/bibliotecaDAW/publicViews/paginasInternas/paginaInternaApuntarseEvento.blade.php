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

            <div class="apuntarseEventoBloques">
                <article class="apuntarseEventoFormulario">
                    <h2 class="tituloFormulario">Formulario de inscripción</h2>

                    <form class="formApuntarseEvento" action="{{ route('evento.apuntarse', ['id' => $evento->id]) }}" method="POST">
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
                            <a href="#" class="btn-base btn-azul">Generar ticket PDF</a>
                            <a href="#" class="btn-base btn-amarillo">Enviar ticket por email</a>
                            <button type="submit" class="btn-base btn-verde">Apuntarse</button>
                        </div>
                    </form>
                </article>

                <aside class="ticketPreviewEvento" aria-label="Vista previa del ticket">
                    <h2 class="tituloFormulario">Vista previa del ticket</h2>
                    <p class="textoFormulario"><strong>Evento:</strong> {{ $evento->titulo }}</p>
                    <p class="textoFormulario"><strong>Fecha:</strong> {{ date('d/m/Y', strtotime($evento->fecha_hora)) }}</p>
                    <p class="textoFormulario"><strong>Hora:</strong> {{ date('H:i', strtotime($evento->fecha_hora)) }}</p>
                    <p class="textoFormulario"><strong>Ubicación:</strong> {{ $evento->ubicacion }}</p>
                    <p class="textoFormulario"><strong>Nombre:</strong> [Nombre del usuario]</p>
                    <p class="textoFormulario"><strong>Apellido:</strong> [Apellido del usuario]</p>
                    <p class="textoFormulario"><strong>Email:</strong> [Email del usuario]</p>
                    <p class="textoFormulario"><strong>Nº Socio:</strong> [Número de socio del usuario]</p>
                    <p class="textoFormulario"><strong>Teléfono:</strong> [Teléfono del usuario]</p>
                </aside>
            </div>
        @else
            <article class="avisoLoginEvento">
                <h2 class="tituloFormulario">Acceso requerido</h2>
                <p class="textoFormulario">Debes iniciar sesión para apuntarte al evento. También puedes enviar tus datos desde el formulario de contacto.</p>
            </article>
        @endif
    </section>



@endsection