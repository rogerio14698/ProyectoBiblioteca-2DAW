@extends('layouts.app')

@section('title', 'Nombre de la Página')

@section('content')
<h2>Gestión de Préstamos</h2>
<p>Desde aquí puedes gestionar los préstamos de la Biblioteca DAW.</p>
<!-- Listado de libros prestados -->
 <hr>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Libro</th>
            <th>Usuario</th>
            <th>Fecha de Préstamo</th>
            <th>Fecha de Devolución</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <!-- Aquí se mostrarían los préstamos existentes -->
        @foreach($prestamos as $prestamo)
        <tr>
            <td>{{ $prestamo->id }}</td>
            <td>{{ $prestamo->libro->titulo }}</td>
            <td>{{ $prestamo->usuario->name }}</td>
            <td>{{ $prestamo->fecha_prestamo }}</td>
            <td>{{ $prestamo->fecha_devolucion }}</td>
            <form action="{{ route('admin.prestamos.delete', $prestamo->id) }}" method="POST">
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
<hr>
<h2>Libros Perdidos</h2>
<p>Desde aquí puedes gestionar los libros perdidos de la Biblioteca DAW.</p>
<!-- Listado de libros perdidos --> 
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Libro</th>
            <th>Usuario</th>
            <th>Fecha de Reporte</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <!-- Aquí se mostrarían los libros perdidos existentes -->
        @foreach($librosPerdidos as $libroPerdido)
        <tr>
            <td>{{ $libroPerdido->id }}</td>
            <td>{{ $libroPerdido->libro->titulo }}</td>
            <td>{{ $libroPerdido->usuario->name }}</td>
            <td>{{ $libroPerdido->fecha_reporte }}</td>
            <form action="{{ route('admin.librosPerdidos.delete', $libroPerdido->id) }}" method="POST">
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