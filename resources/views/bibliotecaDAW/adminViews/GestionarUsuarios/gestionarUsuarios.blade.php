@extends('layouts.app')

@section('title', 'Nombre de la Página')

@section('content')
<h1>Gestionar Usuarios</h1>
<p>Desde aquí puedes gestionar los usuarios de la Biblioteca DAW.</p>
<!--Aqui un listado de todos los usuarios existentes -->
<table></table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo Electrónico</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
<!--Filtrar usuario, se puede filtrar por nombre, correo, nºSocio, id, libro prestado si tiene, libro comprado si tiene  -->
<tr>
    <td><input type="text" placeholder="ID"></td>
    <td><input type="text" placeholder="Nombre"></td>
    <td><input type="text" placeholder="Nº Socio"></td>
    <td><input type="text" placeholder="Libro Prestado"></td>
    <td><input type="text" placeholder="Libro Comprado"></td>
    <td><input type="text" placeholder="Correo Electrónico"></td>
    <td><button type="submit">Filtrar</button></td>
</tr>
        <!-- Aquí se mostrarían los usuarios existentes -->
        @foreach($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->id }}</td>
            <td>{{ $usuario->name }}</td>
            <td>{{ $usuario->email }}</td>
            <td>{{$usuario->movil}}</td>
            <td>{{ $usuario->nSocio }}</td>
            <td>{{ $usuario->libroPrestado }}</td>
            <td>{{ $usuario->libroComprado }}</td>
            <td>{{ $usuario->telefono }}</td>
            <form action="{{ route('admin.usuarios.delete', $usuario->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <td><button type="submit">Eliminar</button></td>
                @csrf
                @method('EDIT')
                <td><button type="submit">Editar</button></td>
            </form>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection