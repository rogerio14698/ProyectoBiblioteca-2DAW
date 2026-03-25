@extends('layouts.app')

@section('title', 'Nombre de la Página')

@section('content')
    <main class="contenedor">
        <h1>Gestionar Usuarios</h1>
        <p>Desde aquí puedes gestionar los usuarios de la Biblioteca DAW.</p>
        <!--Aqui un listado de todos los usuarios existentes -->
        <div class="buscadorUsuario">
            <input type="text" id="buscador" name="buscador" placeholder="Ingrese el nombre del usuario">
            <input type="text" placeholder="nº socio">
            <input type="dni" placeholder="DNI">
            <input type="email" placeholder="Correo Eletronico">
            <button type="submit">Buscar</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Nº Socio</th>
                    <th>Libros prestados</th>
                    <th>Correo Electrónico</th>
                    <th>Ultimo login</th>
                    <th>Eventos registrados</th>
                    <th>Eventos Organizados</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Juan Pérez</td>
                    <td>12345</td>
                    <td>3</td>
                    <td>juan.perez@example.com</td>
                    <td>2024-06-01 10:00:00</td>
                    <td>2</td>
                    <td>1</td>
                    <td>
                        <!--Este btn me lleva a otra pagina para una edicion más fina y completa -->
                        <a href="{{ route('admin.editarUsuario', ['id' => 1]) }}">Editar</a>
                    </td>
                </tr>
            </tbody>
        </table>

    </main>

@endsection
