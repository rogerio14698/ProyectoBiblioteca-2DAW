@extends('layouts.app')

@section('title', 'Actividades y Eventos')

@section('content')
    <h1>Actividades y Eventos</h1>
    <p>Bienvenido a la sección de actividades y eventos de la Biblioteca DAW.</p>
    <p>Aquí podrás encontrar información sobre las actividades y eventos que se llevarán a cabo en la Biblioteca DAW, como talleres, charlas, presentaciones de libros, exposiciones y mucho más. Mantente atento a esta sección para no perderte ninguna de nuestras emocionantes actividades y eventos.</p>
    <p>Próximos eventos:</p>
    <section>
        <!-- Al apuntarse se va a poner un contador de personas que se han apuntado, deben de estar registradas -->
        <ul>
            <li>Club de Lectura - 15 de Octubre <a href="#">Apuntarse</a></li>
            <li>Taller de Escritura Creativa - 22 de Octubre <a href="#">Apuntarse</a></li>
            <li>Presentación del Libro "El Mundo de la Fantasía" - 30 de Octubre <a href="#">Apuntarse</a></li>
        </ul>
    </section>
@endsection