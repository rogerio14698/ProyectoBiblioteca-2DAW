@extends('layouts.app')

@section('title', 'Gestionar Actividades y Eventos')

@section('content')
    <main class="contenedor">
        <section class="gestionarActividadesYEvento">
            <h1>Gestionar Eventos</h1>
            <p>Desde aquí puedes gestionar los eventos de la Biblioteca DAW.</p>
            <!-- Aquí puedes agregar un formulario para añadir nuevos eventos, una tabla para mostrar los eventos existentes, y opciones para editar o eliminar eventos -->
            <div class="formularioEditarEventos">
                <form action="#">
                    <h2>Agregar Nuevo Evento</h2>
                    <div class="labelEditarEventos">
                        <label for="nombreEvento">Nombre del Evento:</label>
                        <input type="text" id="nombreEvento" name="nombreEvento" required>

                    </div>
                    <div class="labelEditarEventos">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" required></textarea>

                    </div>
                    <div class="labelEditarEventos">
                        <label for="lugar">Lugar:</label>
                        <input type="text" id="lugar" name="lugar" required>
                    </div>
                    <div class="labelEditarEventos">
                        <label for="hora">Hora:</label>
                        <input type="time" id="hora" name="hora" required>
                    </div>
                    <div class="labelEditarEventos">
                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" required>
                    </div>
                    <div class="labelEditarEventos">
                        <button class="btn-base btn-verde" type="submit">Añadir / Editar Evento</button>
                    </div>
                </form>
            </div>


        </section>
        <section class="gestionarActividadesYEvento">
            <h1>Listado de Eventos</h1>
            <table>
                <thead>
                    <th>id</th>
                    <th>Nombre Evento</th>
                    <th>Descripción</th>
                    <th>Lugar</th>
                    <th>Hora</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    <td>001</td>
                    <td>Club de Lectura</td>
                    <td>Un espacio para compartir y discutir sobre libros.</td>
                    <td>Sala de Lectura</td>
                    <td>18:00</td>
                    <td>2024-07-15</td>

                    <form action="#">
                        <td>
                            <button type="submit">Editar</button>
                            <button type="submit">Eliminar</button>
                        </td>
                    </form>
                </tbody>
            </table>
        </section>
    </main>

@endsection
