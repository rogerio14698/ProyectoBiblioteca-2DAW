@extends('layouts.app')

@section('title', 'Gestionar Actividades y Eventos')

@section('content')
    <main class="contenedor">
        <section class="gestionarActividadesYEvento">
            <h1>Gestionar Eventos</h1>
            <p>Desde aquí puedes gestionar los eventos de la Biblioteca DAW.</p>
            <!-- Aquí puedes agregar un formulario para añadir nuevos eventos, una tabla para mostrar los eventos existentes, y opciones para editar o eliminar eventos -->

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
                    <td>id</td>
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
