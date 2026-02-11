@extends('layouts.app')

@section('title', 'Buscar Libros')

@section('content')
    <h1>Buscar Libros</h1>
    <p>Bienvenido a la sección de búsqueda de libros de la Biblioteca DAW.</p>
    <!-- Aquí cualquiera puede buscar un libro dentro de la base de datos, no hace falta estar registrado para buscar. -->
    <div class="buscar-libros">
        <input type="text" id="search" placeholder="Buscar por título, autor, género...">
        <button type="submit">Buscar</button>
    </div>
    <!-- Aquí se mostrarían los resultados de la búsqueda, con la portada del libro, título
, autor, año de publicación, editorial y un botón para ver más detalles del libro. -->
    <div class="resultados-busqueda">
        <div class="libro">
            <img src="ruta-de-la-portada-del-libro.jpg" alt="Título del Libro">
            <h3>Título del Libro</h3>
            <p>Autor: Nombre del Autor</p>
            <p>Año de Publicación: 2024</p>
            <p>Editorial: Nombre de la Editorial</p>
            <button>Ver Detalles</button>
        </div>
        <!-- Repite el bloque de libro para cada resultado de búsqueda -->
    </div> 
@endsection