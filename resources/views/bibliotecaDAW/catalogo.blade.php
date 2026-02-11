@extends('layouts.app')

@section('title', 'Catálogo')

@section('content')
    <h1>Catálogo</h1>
    <p>Bienvenido al catálogo de la Biblioteca DAW.</p>
    <p>Esto va a estar dividio entre secciones como las filas de netflix, cada sección va a ser un genero literario y dentro de cada sección van a estar los libros disponibles de ese genero, con su portada, título, autor, año de publicación, editorial y un botón para ver más detalles del libro.
        El boton se intentará abrir una ventana modal con toda la información del libro, sin necesidad de salir de la página del catálogo, para que el usuario pueda seguir navegando por el catálogo sin perder su lugar.
    </p>
    
    <!--Aqui deberia de llamar desde la base de datos a los libros disponibles y mostrarlos segun su genero
    Tambien se podría filtrar por autor, año, editorial... todos los datos necesarios que tiene el libro -->
    <section class="carrusel-fantasia">
        <div class="carrusel">
            <div class="libro">
                <img src="ruta-de-la-portada-del-libro.jpg" alt="Título del Libro">
                <h3>Título del Libro</h3>
                <p>Autor: Nombre del Autor</p>
                <p>Año de Publicación: 2024</p>
                <p>Editorial: Nombre de la Editorial</p>
                <button>Ver Detalles</button>
            </div>
            <!-- Fin del libro -->
             <div class="libro">
                <img src="ruta-de-la-portada-del-libro.jpg" alt="Título del Libro">
                <h3>Título del Libro</h3>
                <p>Autor: Nombre del Autor</p>
                <p>Año de Publicación: 2024</p>
                <p>Editorial: Nombre de la Editorial</p>
                <button>Ver Detalles</button>
            </div>
            <!-- Fin del libro -->
             <div class="libro">
                <img src="ruta-de-la-portada-del-libro.jpg" alt="Título del Libro">
                <h3>Título del Libro</h3>
                <p>Autor: Nombre del Autor</p>
                <p>Año de Publicación: 2024</p>
                <p>Editorial: Nombre de la Editorial</p>
                <button>Ver Detalles</button>
            </div>
            <!-- Repite el bloque de libro para cada libro en el catálogo -->
        </div>
    </section>
    <section class="section-ciencia-ficcion">
        <h2>Ciencia Ficción</h2>
        <!-- Aquí se mostrarían los libros de ciencia ficción -->
        <div class="carrusel">
             <div class="libro">
                <img src="ruta-de-la-portada-del-libro.jpg" alt="Título del Libro">
                <h3>Título del Libro</h3>
                <p>Autor: Nombre del Autor</p>
                <p>Año de Publicación: 2024</p>
                <p>Editorial: Nombre de la Editorial</p>
                <button>Ver Detalles</button>
            </div>
            <!-- Fin del libro -->
             <div class="libro">
                <img src="ruta-de-la-portada-del-libro.jpg" alt="Título del Libro">
                <h3>Título del Libro</h3>
                <p>Autor: Nombre del Autor</p>
                <p>Año de Publicación: 2024</p>
                <p>Editorial: Nombre de la Editorial</p>
                <button>Ver Detalles</button>
            </div>
            <!-- Fin del libro -->
        </div>

    </section>


@endsection