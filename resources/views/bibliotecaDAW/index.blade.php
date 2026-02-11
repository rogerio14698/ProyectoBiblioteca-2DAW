@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <main>

        <section class="destacados carrusel">
            <!-- Aqui buscamos en la base de datos de libros y ponemos el libro mas nuevo o destacado -->
            @foreach($libros as $libro)
                <div class="libro">
                    <img src="/resources/img/portada-Destacado.jpg" alt="Portada de {{ $libro->titulo }}" class="portada" />
                    <h2>{{ $libro->titulo }}</h2>
                    <p>{{ $libro->descripcion }}</p>
                    <p>Autor: {{ $libro->autor }} | Año: {{ $libro->anio }} | Premios: {{ $libro->premios }} | Precio:
                        {{ $libro->precio }}</p>
                    <button>Buscar en el catálogo</button>
                </div>
            @endforeach
        </section>
        <section>
            <h2>Acceso Rápido</h2>
            <ul>
                <li><a href="{{ url('/catalogo') }}">Catálogo de Libros</a></li>
                <li><a href="{{ url('/actividades') }}">Actividades y Eventos</a></li>
                <li><a href="{{ url('/servicios-digitales') }}">Servicios Digitales</a></li>
                <li><a href="{{ url('/login') }}">Login</a></li>
            </ul>
        </section>
        <section>
            <h2>Agenda</h2>
            <p>Próximos eventos y actividades en la biblioteca</p>
            <ul>
                <li>Club de Lectura - 15 de Octubre</li>
                <li>Taller de Escritura Creativa - 22 de Octubre</li>
                <li>Presentación del Libro "El Mundo de la Fantasía" - 30 de Octubre</li>
            </ul>
        </section>
        <section>
            <h2>Noticias o Destacados</h2>
            <h3>Aviso Importante: Nuevo Horario de Atención</h3>
            <h3>Nuevas instalaciones en la biblioteca</h3>
            <h3>Nuevos Horarios</h3>
        </section>
    </main>
@endsection