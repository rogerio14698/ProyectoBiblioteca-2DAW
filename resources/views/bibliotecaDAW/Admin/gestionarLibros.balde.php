@extends('layouts.app')

@section('title', 'Gestionar Libros')

@section('content')
    <h1>Gestionar Libros</h1>
    <p>Desde aquí puedes gestionar los libros de la Biblioteca DAW.</p>
    <!-- Aquí puedes agregar un formulario para añadir nuevos libros, una tabla para mostrar los libros existentes, y opciones para editar o eliminar libros -->
     <form action="{{ route('admin.libros.store') }}" method="POST">
        @csrf
        <div>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
        </div>
        <div>
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" required>
        </div>
        <div>
            <label for="genero">Género:</label>
            <input type="text" id="genero" name="genero" required>
        </div>
        <div>
            <label for="anio">Año de Publicación:</label>
            <input type="number" id="anio" name="anio" required>
        </div>
        <div class="editorial">
            <label for="editorial">Editorial:</label>
            <input type="text" id="editorial" name="editorial" required>
        </div>
        <div class="disponnilidad">
            <label for="disponibilidad">Disponibilidad:</label>
            <select id="disponibilidad" name="disponibilidad" required>
                <option value="disponible">Disponible</option>
                <option value="prestado">Prestado</option>
            </select>
        </div>
        <div class="formato">
            <label for="formato">Formato:</label>
            <select id="formato" name="formato" required>
                <option value="fisico">Físico</option>
                <option value="digital">Digital</option>
            </select>
        </div>
        <div class="opcion-compra">
            <label for="opcion_compra">Opción de Compra:</label>
            <select id="opcion_compra" name="opcion_compra" required>
                <option value="compra">Compra</option>
                <option value="prestamo">Préstamo</option>
            </select>
        </div>
        <div class="cantidad-ejemplares">
            <label for="cantidad_ejemplares">Cantidad de Ejemplares:</label>
            <input type="number" id="cantidad_ejemplares" name="cantidad_ejemplares" required>
        </div>

        <button type="submit">Añadir Libro</button>
@endsection