@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <main>
        <section class="contenedor agenda">
            <div class=" contenedor">
                <h2>Agenda</h2>
                <p>Próximos eventos y actividades en la biblioteca <br>
                    Actualizar - carrusel ya que tiene seeders y no viene de la BD <br>
                    Tambien ver donde poner uan foto del evento y flechas para navegar en el carrusel</p>
            </div>
            <!--
                                                            Aqui ahora tengo que definir una especie de foreach para mostrar los eventos que se crean en la base de datos:
                                                            Entonces primero tengo que definir como es la tabla de eventos en la migracion, 
                                                            relacionarla con el usuario que lo ha creado 
                                                            Mostrar todo en la pagina principal en la seccion de agenda
                                                            Buscar como podria hacer esto
                                                        -->
            <!-- Y todo esto va a formar parte de un carrusel -->
            <div id="eventoCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!--Aqui empezaria el foreach -->
                    @foreach ($eventos as $evento)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <h4>{{ $evento->titulo }}</h4>
                            <p>{{ $evento->descripcion }}</p>
                            <p>Fecha: {{ $evento->fecha_hora }}</p>
                            <p>Organizador: {{ $evento->usuario->name ?? 'Sin organizador' }}</p>
                            <button>Más Información</button>
                            <button>Inscribirse</button>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr>
        </section>
        <hr>


        <section class="noticias container">
            <div class="noticasCarrusel">
                <!-- Aqui va a ser un foreach para mostrar las noticas que se creen en la base de datos -->
                <h2>Noticias</h2>
                <p>Esto tambien va a ser un carrusel</p>
                <p>Últimas noticias y novedades de la biblioteca <br>
                    Actualizar - carrusel ya que tiene seeders y no viene de la BD <br>
                    Tambien ver donde poner uan foto del evento y flechas para navegar en el carrusel</p>
                <img src="#" alt="Imagen-Noticias">
                <a href="#">Ver noticias</a>
            </div>
        </section>
        <hr>
    </main>
@endsection