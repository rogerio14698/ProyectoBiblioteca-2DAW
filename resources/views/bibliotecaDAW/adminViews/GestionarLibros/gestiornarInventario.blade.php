@extends('layouts.app')

@section('title', 'Nombre de la Página')

@section('content')
<h1>Gestión de Inventario</h1>
<p>Desde aquí puedes gestionar el inventario de la Biblioteca DAW.</p>

<!-- Todos los libros dispobibles para venta -->
<hr>
<table></table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Libro</th>
            <th>Editorial</th>
            <th>Disponibles</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <!-- Aquí se mostrarían los libros disponibles -->
        @foreach($libros as $libro)
        <tr>
            <td>{{ $libro->id }}</td>
            <td>{{ $libro->titulo }}</td>
            <td>{{ $libro->editorial }}</td>
            <td>{{ $libro->disponibles }}</td>
            <form action="{{ route('admin.inventario.delete', $libro->id) }}" method="POST">
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

<!-- Genar informe pdf de los libros disponibles para venta -->
<p><a href="{{ route('admin.inventario.pdf') }}">Generar Informe PDF</a>Ver como se hace esto aun</p>
@endsection