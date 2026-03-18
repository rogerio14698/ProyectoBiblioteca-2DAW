@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <main>
        <!--Prueba carrusel -->
        <section class="contenedor bienvenida">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @forelse ($slideBienvenidas as $slideBienvenida)
                        <button type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"
                            aria-current="{{ $loop->first ? 'true' : 'false' }}"
                            aria-label="Slide {{ $loop->iteration }}"></button>
                    @empty
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                            class="active" aria-current="true" aria-label="Slide 1"></button>
                    @endforelse
                </div>
                <div class="bienvenida-slides carousel-inner">
                    @forelse ($slideBienvenidas as $slideBienvenida)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="bienvenidaSlideContenido">
                                <h1 class="bienvenidaTitulo">{{ $slideBienvenida->titulo }}</h1>
                                <p class="bienvenidaParrafo">{!! nl2br(e($slideBienvenida->descripcion)) !!}</p>
                                @if ($slideBienvenida->url)
                                    <a href="{{ $slideBienvenida->url }}" class="btn-base btn-primario">Explorar Biblioteca</a>
                                @else
                                    <button class="btn-base btn-primario" type="button" disabled>Explorar Biblioteca</button>
                                @endif
                                <picture class="bienvenida-imagen">
                                    <source media="(min-width: 1200px)"
                                        srcset="{{ \Illuminate\Support\Str::startsWith($slideBienvenida->imagen, ['http://', 'https://']) ? $slideBienvenida->imagen : asset($slideBienvenida->imagen) }}">
                                    <source media="(min-width: 768px)"
                                        srcset="{{ \Illuminate\Support\Str::startsWith($slideBienvenida->imagen, ['http://', 'https://']) ? $slideBienvenida->imagen : asset($slideBienvenida->imagen) }}">
                                    <img src="{{ \Illuminate\Support\Str::startsWith($slideBienvenida->imagen, ['http://', 'https://']) ? $slideBienvenida->imagen : asset($slideBienvenida->imagen) }}"
                                        class="imgPaginaBienvenida" loading="lazy"
                                        alt="Imagen de {{ $slideBienvenida->titulo }}">
                                </picture>
                            </div>
                        </div>
                    @empty
                        <div class="carousel-item active">
                            <div class="bienvenidaSlideContenido">
                                <h1 class="bienvenidaTitulo">Bienvenido a la Biblioteca DAW</h1>
                                <p class="bienvenidaParrafo">Tu portal al conocimiento digital y académico.</p>
                                <button class="btn-base btn-primario" type="button" disabled>Explorar Biblioteca</button>
                                <picture class="bienvenida-imagen">
                                    <source media="(min-width: 1200px)" srcset="{{ asset('img/img-landingPage.png') }}">
                                    <source media="(min-width: 768px)" srcset="{{ asset('img/img-landingPage.png') }}">
                                    <img src="{{ asset('img/img-landingPage.png') }}" class="imgPaginaBienvenida" loading="lazy"
                                        alt="Imagen de bienvenida">
                                </picture>
                            </div>
                        </div>
                    @endforelse
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        </section>
        <!-- Fin de la seccion de bienvenida -->
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
                                                <source media="(min-width: 1200px)"
                                                    srcset="{{ asset('img/elPrincipito.jpg') }}">
                                                <source media="(min-width: 768px)"
                                                    srcset="{{ asset('img/elPrincipito.jpg') }}">
                                                <img src="{{ asset('img/elPrincipito.jpg') }}"
                                                    alt="Imagen de novedad del catálogo">
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
                                <source media="(min-width: 1200px)" srcset="{{ asset($noticia->imagen_url) }}">
                                <source media="(min-width: 768px)" srcset="{{ asset($noticia->imagen_url) }}">
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
    </main>
@endsection
