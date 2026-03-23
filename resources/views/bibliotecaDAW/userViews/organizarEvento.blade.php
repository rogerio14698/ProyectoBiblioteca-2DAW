@extends('layouts.app')

@section('title', 'Organizar Evento')

@section('content')
    <main class="contenedor organizarEvento">
        <section class="organizarEventoHeader">
            <h1>Organizar Evento</h1>
            <p>Bienvenido <span>{{ Auth::user()->name }}</span> a la sección de organización de eventos de la Biblioteca DAW.</p>
        </section>

        <section class="organizarEventoBloque" aria-labelledby="crearEventoTitulo">
            <div class="organizarEventoIntro">
                <h2 id="crearEventoTitulo">Crear Evento</h2>
                <p>
                    Desde aquí podrás proponer un nuevo evento para la biblioteca indicando lugar, fecha,
                    hora, descripción y la capacidad máxima de asistentes.
                </p>
            </div>

            <form action="" class="formOrganizarEvento">
                <div class="campoOrganizarEvento">
                    <label for="lugar">Lugar del evento</label>
                    <input type="text" id="lugar" name="lugar" placeholder="Lugar del evento">
                </div>

                <div class="campoOrganizarEvento">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" name="fecha">
                </div>

                <div class="campoOrganizarEvento">
                    <label for="hora">Hora</label>
                    <input type="time" id="hora" name="hora">
                </div>

                <div class="campoOrganizarEvento campoCompletoOrganizarEvento">
                    <label for="descripcion">Descripción del evento</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Descripción del evento"></textarea>
                </div>

                <div class="campoOrganizarEvento">
                    <label for="capacidad">Capacidad máxima de asistentes</label>
                    <input type="number" id="capacidad" name="capacidad" placeholder="Capacidad máxima de asistentes" min="1">
                </div>

                <div class="accionesOrganizarEvento campoCompletoOrganizarEvento">
                    <button type="submit" class="btn-base btn-verde">Crear Evento</button>
                </div>
            </form>
        </section>
    </main>
@endsection