@extends('layouts.app')

@section('title', 'Comprar')

@section('content')
    <h1>Comprar</h1>
    <p>Bienvenido @user a la sección de comprar de la Biblioteca DAW.</p>

    <!-- Aquí se mostrarán los libros disponibles para comprar, con su portada, título, autor, año de publicación, editorial y un botón para comprar el libro. -->
    <div class="libros-comprar">
        <div class="libro">
            <img src="ruta-de-la-portada-del-libro.jpg" alt="Título del Libro">
            <h3>Título del Libro</h3>
            <p>Autor: Nombre del Autor</p>
            <p>Año de Publicación: 2024</p>
            <p>Editorial: Nombre de la Editorial</p>
            <button>Comprar</button>
        </div>
        <!-- Repite el bloque de libro para cada libro disponible para comprar -->
@endsection