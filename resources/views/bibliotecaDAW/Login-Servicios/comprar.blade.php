@extends('layouts.app')

@section('title', 'Comprar')

@section('content')
    <h1>Comprar</h1>
    <p>Bienvenido @user a la sección de tienda de la Biblioteca DAW.</p>

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
        <div class="arte">
            <h3>Sección de Arte</h3>
            <p>En esta sección podrás encontrar libros relacionados con el arte, incluyendo historia del arte, técnicas
                artísticas, biografías de artistas y mucho más. Explora nuestra selección de libros de arte y encuentra
                inspiración para tus proyectos creativos.</p>
        </div>
        <div class="ciencia">
            <h3>Sección de Ciencia</h3>
            <p>En esta sección podrás encontrar libros relacionados con la ciencia, incluyendo física, química, biología,
                astronomía y mucho más. Explora nuestra selección de libros de ciencia y amplía tus conocimientos sobre el
                mundo que nos rodea.</p>
        </div>
        <div class="literatura">
            <h3>Sección de Literatura</h3>
            <p>En esta sección podrás encontrar libros relacionados con la literatura, incluyendo novelas, poesía, teatro y
                mucho más. Explora nuestra selección de libros de literatura y sumérgete en historias fascinantes y
                emocionantes.</p>
        </div>
    </div>
    <div class="soporte">
        <h2>Soporte</h2>
        <p>Si tienes alguna pregunta o necesitas ayuda con el proceso de compra, no dudes en contactarnos a través de
            nuestro soporte via mail.</p>
    </div>
    <div class="historial-compras">
        <h2>Historial de compras</h2>
        <p>Aquí podrás ver el historial de tus compras anteriores, incluyendo los libros comprados, las fechas de compra y
            el estado de cada compra.</p>
    </div>
    <div class="recomendaciones">
        <h2>Recomendaciones de libros</h2>
        <p>Basado en tus compras anteriores, aquí te recomendamos algunos libros que podrían interesarte.</p>
        <form action=""> <input type="text" placeholder="Libro"> <input type="text" placeholder="Autor"> <textarea name=""
                id="" aria-placeholder="Comentario a cerca del libro"></textarea> </form>
    </div>
@endsection