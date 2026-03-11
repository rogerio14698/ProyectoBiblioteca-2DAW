@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <main>
        <section class="contenedor bienvenida">
            <div class="bienvenida-texto">
                <h1>Texto Alternativo Aqui</h1>
                <p>Tu portal al conocimiento digital y académico. <br>
                    Explora nuestra amplia colección de libros, recursos digitales y eventos culturales. <br>
                    Conéctate con otros lectores, participa en actividades y descubre un mundo de aprendizaje a tu alcance.
                    <br>
                    ¡Bienvenido a la Biblioteca DAW, donde el conocimiento cobra vida!
                </p>
                <button class="btn-base btn-primario">Explorar Biblioteca</button>
            </div>
            <picture class="bienvenida-imagen">
                <source media="(min-width: 1200px)" srcset="{{ asset('img/img-landingPage.png') }}">
                <!--IMG version mobil -->
                <source media="(min-width: 768px)" srcset="{{ asset('img/img-landingPage.png') }}">
                <img src="{{ asset('img/img-landingPage.png') }}" class="imgPaginaBienvenida" loading="lazy"
                    alt="Imagen-Bienvenida">
            </picture>
        </section>
        <hr>
        <section>
            <div class="contenedor novedadCatalogo">
                <div class="textoNovedadCat">
                    <h2>Novedades del Catálogo</h2>
                    <p>Descubre las últimas incorporaciones a nuestra colección de libros y recursos digitales</p>

                </div>
                <div class="sliderContenedor">
                    <button class="btn-slider swiper-button-prev-custom" type="button">&#10094</button>
                    <div class="swiper novedadesSwiper">
                        <div class="swiper-wrapper">
                            @foreach ($libros as $libro)
                                <div class="swiper-slide">
                                    <div class="novedadCatalogoCard">
                                        <div class="novedadImagen">
                                            <picture>
                                                <source media="(min-width: 1200px)" srcset="{{ asset('img/elPrincipito.jpg') }}">
                                                <source media="(min-width: 768px)" srcset="{{ asset('img/elPrincipito.jpg') }}">
                                                <img src="{{ asset('img/elPrincipito.jpg') }}" alt="Imagen de novedad del catálogo">
                                            </picture>
                                        </div>
                                        <div class="novedadInfo">
                                            <h3>{{ $libro->titulo }}</h3>
                                            <a href="#" class="btn-base btn-verde">Ver Libro</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                     <button class="btn-slider swiper-button-next-custom" type="button">&#10095</button>
                </div>
            </div>


        </section>
        <hr>
        <section class="contenedor agenda">
            <div class="agendaTexto">
                <h2>Agenda de Eventos</h2>
                <p>Agenda de eventos programados</p>
                <!--Ver como poner un carrusel dentro de los cards de eventos. -->
            </div>

            <div class="agendaContenedor">
                @foreach ($eventos as $evento)
                    <div class="eventoCard">
                        <div class="eventoImg">
                            <picture>
                                <source media="(min-width: 1200px)" srcset="{{ asset('img/img-landingPage.png') }}">
                                <source media="(min-width: 768px)" srcset="{{ asset('img/img-landingPage.png') }}">
                                <img src="{{ asset('img/img-landingPage.png') }}" alt="Imagen de {{ $evento->titulo }}">
                            </picture>
                        </div>

                        <div class="eventoInfo">
                            <h3>{{ $evento->titulo }}</h3>
                            <p class="eventoDescripcion">{{ $evento->descripcion }}</p>
                            <div class="eventoDetalles">
                                <p>Fecha<br><strong>{{ date('d/m', strtotime($evento->fecha_hora)) }}</strong></p>
                                <p>Hora<br><strong>{{ date('H:i', strtotime($evento->fecha_hora)) }}</strong></p>
                                <p>Ubicación<br><strong>{{ $evento->ubicacion }}</strong></p>
                                <p>Organizadrx<br><strong>{{ $evento->usuario->name }}</strong></p>
                            </div>
                            <button class="btn-base btn-verde">Ir a evento</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="paginacionBase paginacionAgenda">
                {{ $eventos->links('vendor.pagination.bootstrap-5') }}
            </div>
        </section>
        <hr>
        <section class="contenedor noticias">
            <div class="noticiaTexto">
                <h1>Noticias</h1>
                <p>Noticias relacionadas con la biblioteca y el mundo académico</p>
            </div>
            <div class="noticiasContenedor">
                @foreach ($noticias as $noticia)
                    <div class="noticiasCard">
                        <div class="noticiasImg">
                            <picture>
                                <source media="(min-width: 1200px)" srcset="{{ asset('img/img-landingPage.png') }}">
                                <source media="(min-width: 768px)" srcset="{{ asset('img/img-landingPage.png') }}">
                                <img src="{{ $noticia->imagen_url }}" alt="Imagen de {{ $noticia->titulo }}">
                            </picture>
                        </div>
                        <div class="noticiasInfo">
                            <h2>{{ $noticia->titulo }}</h2>
                            <p>{{ $noticia->contenido }}</p>
                            <div class="noticias-detalles">
                                <p>{{ $noticia->created_at->format('d/m/Y') }}</p>
                                <strong>
                                    <p>{{ $noticia->autor }}</p>
                                </strong>
                            </div>
                            <!--Aqui me va a generar un modal con la noticia completa
                                                                                        Hay que modificar la base de datos y poner un text-area
                                                                                        o ver la mejor forma de hacer esto-->
                            <button class="btn-base btn-verde">Leer más</button>
                        </div>

                    </div>
                @endforeach
            </div>
            <div class="paginacionBase paginacionNoticias">
                {{ $noticias->links('vendor.pagination.bootstrap-5') }}
            </div>
        </section>
        <hr>
    </main>
@endsection