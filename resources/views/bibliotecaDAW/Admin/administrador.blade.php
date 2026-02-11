@extends('layouts.app')

@section('title', 'Administrador')

@section('content')
    <h2>Bienvenido al Panel de Administrador</h2>
    <p>Desde aquí puedes gestionar los recursos de la Biblioteca DAW.</p>
    <section>
        <h2>Contenido web</h2>
        <ul>
            <li><a href="#">Contenido Principal</a></li>
            <ul>
                <li><a href="#">Noticias o Destacados</a></li>
                <li><a href="#">Avisos Importantes</a></li>
                <li><a href="#">Horarios</a></li>
            </ul>
            <li><a href="#">Contenido Catálogo</a></li>
            <li><a href="#">Contenido Actividades</a></li>
            <li><a href="#">Contenido Servicios Digitales</a></li>
            <li><a href="#">Contenido Contacto</a></li>

        </ul>
    </section>
    <section>
        <h2>Contenido Usuarios</h2>
        <ul>
            <li><a href="#">Gestionar Libros</a></li>
            <li><a href="#">Gestionar Usuarios</a></li>
            <li><a href="#">Gestionar Préstamos</a></li>
            <li><a href="#">Gestionar Libros Perdidos</a></li>
            <li><a href="#">Gestionar Inventario</a></li>
            <!-- Agrega más enlaces según las funcionalidades que quieras ofrecer -->
        </ul>
    </section>
    <section>
        <h2>Contenido Libro</h2>
        <p>Ver que poner aqui</p>
    </section>

@endsection