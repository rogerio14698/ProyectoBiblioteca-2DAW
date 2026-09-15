@extends('layouts.app')

{{-- SEO: título y descripción específicos de la landing, más útiles para buscadores que "Home" --}}
@section('title', 'Biblioteca Digital DAW | Catálogo, Eventos y Noticias')
@section('meta_description', 'Descubre el catálogo digital de la Biblioteca DAW: libros disponibles para préstamo y compra, agenda de eventos culturales y las últimas noticias de la comunidad educativa.')
@section('og_image', asset('img/img-landingPage.png'))

@section('content')
    {{--
        Único <h1> real de la página (necesario para el SEO y la jerarquía semántica correcta).
        Se usa "visually-hidden" (clase ya provista por Bootstrap) para no alterar el diseño visual:
        el texto grande que se ve en el carrusel sigue siendo el de cada slide, ahora como <h2>.
    --}}
    <h1 class="visually-hidden">Bienvenido a la Biblioteca Digital DAW</h1>

    <!--Slides de carrusel bienvenida -->

    <section class="bienvenida separador">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @forelse ($slideBienvenidas as $slideBienvenida)
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $loop->index }}"
                        class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"
                        aria-label="Slide {{ $loop->iteration }}"></button>
                @empty
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                @endforelse
            </div>
            <div class="bienvenida-slides carousel-inner">
                @forelse ($slideBienvenidas as $slideBienvenida)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="bienvenidaSlideContenido">
                            <h2 class="tituloPagina">{{ $slideBienvenida->titulo }}</h2>
                            <p class="bienvenidaParrafo parrafoTitulo">{!! nl2br(e($slideBienvenida->descripcion)) !!}</p>
                            @if ($slideBienvenida->url)
                                <a href="{{ $slideBienvenida->url }}" class="btn-base btn-verde">Explorar
                                    Biblioteca</a>
                            @else
                                <button class="btn-base btn-verde" type="button" disabled>Explorar Biblioteca</button>
                            @endif
                            @php
                                $slideUrl = \Illuminate\Support\Str::startsWith($slideBienvenida->imagen, ['http://', 'https://'])
                                    ? $slideBienvenida->imagen
                                    : asset($slideBienvenida->imagen);
                            @endphp
                            <div class="bienvenida-imagen">
                                <img src="{{ $slideUrl }}"
                                    class="imgPaginaBienvenida" loading="eager" fetchpriority="high"
                                    width="680" height="420"
                                    alt="Imagen del slide de bienvenida: {{ $slideBienvenida->titulo }}">
                            </div>
                        </div>
                    </div>
                @empty
                    <!--Slide por defecto de inicio-->
                    <div class="carousel-item active">
                        <div class="bienvenidaSlideContenido">
                            <h2 class="bienvenidaTitulo">Bienvenido a la Biblioteca DAW</h2>
                            <p class="bienvenidaParrafo">Tu portal al conocimiento digital y académico.</p>
                            <button class="btn-base btn-primario" type="button" disabled>Explorar Biblioteca</button>
                            <div class="bienvenida-imagen">
                                <img src="{{ asset('img/img-landingPage.png') }}" class="imgPaginaBienvenida"
                                    loading="eager" fetchpriority="high" width="680" height="420"
                                    alt="Imagen de bienvenida a la Biblioteca DAW">
                            </div>
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
    <!-- Novedades del Catálogo  -->

    <section class="novedadCatalogo separador">

        <!-- Título y descripción de la sección -->
        <div class="headerContenido">
            <h2 class="tituloContenido">Novedades del Catálogo</h2>
            <p class="parrafoContenido">Descubre las últimas incorporaciones a nuestra colección de libros y recursos
                digitales</p>
        </div>

        <!-- Contenedor grid: columna 1 = btn prev, columna 2 = slider, columna 3 = btn next -->
        <div class="sliderContenedor">
            <!-- Columna 1: Botón retroceder -->
            <button class="btn-slider sliderBtnPrev" type="button" aria-label="Anterior">&#10094;</button>

            <!-- Columna 2: Ventana visible del slider (overflow hidden) -->
            <div class="sliderVentana">
                <!-- Pista que se desplaza con translateX -->
                <div class="sliderPista">
                    @foreach ($libros as $libro)
                        <div class="sliderItem">
                            <div class="novedadCatalogoCard">
                                <!-- Imagen del libro -->
                                <div class="novedadImagen">
                                    <img src="{{ $libro->portada_url }}" alt="Portada de {{ $libro->titulo }}"
                                        loading="lazy" width="200" height="300">
                                </div>
                                <!-- Título y enlace -->
                                <div class="novedadInfo">
                                    <h3 class="tituloCard">{{ $libro->titulo }}</h3>
                                    <a href="{{ route('libro.paginaInterna', $libro->id) }}" class="btn-base btn-verde">Ver
                                        Libro</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Columna 3: Botón avanzar -->
            <button class="btn-slider sliderBtnNext" type="button" aria-label="Siguiente">&#10095;</button>
        </div>
    </section>
    <!-- Fin de la sección de novedades del catálogo -->
    <!-- Agenda de eventos -->
    <section id="agenda" class="agenda separador separador">
        <div class="headerContenido">
            <h2 class="tituloContenido">Agenda de Eventos</h2>
            <p class="parrafoContenido">Agenda de eventos programados</p>
            <!--Ver como poner un carrusel dentro de los cards de eventos. -->
        </div>
        <div class="agendaContenedor">
            @foreach ($eventos as $evento)
                <div class="eventoCard">
                    <div class="eventoImg">
                        <img src="{{ $evento->imagen_url }}" alt="Cartel del evento: {{ $evento->titulo }}"
                            loading="lazy" width="400" height="250">
                    </div>

                    <div class="eventoInfo">
                        <h3 class="tituloCard">{{ $evento->titulo }}</h3>
                        <div class="eventoDetalles">
                            <p>Fecha<br><strong>{{ date('d/m', strtotime($evento->fecha_hora)) }}</strong></p>
                            <p>Ubicación<br><strong>{{ $evento->ubicacion }}</strong></p>
                        </div>
                        <a href="{{ route('evento.paginaInterna', $evento->id) }}" class="btn-base btn-verde">Ir a evento</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="paginacionBase paginacionAgenda">
            {{ $eventos->appends(['noticias_page' => $noticias->currentPage()])->fragment('agenda')->links('vendor.pagination.bootstrap-5') }}
        </div>
    </section>

    <section id="noticias" class="noticias separador">
        <div class="headerContenido">
            <h2 class="tituloContenido">Noticias</h2>
            <p class="parrafoContenido">Noticias relacionadas con la biblioteca y el mundo académico</p>
        </div>
        <div class="noticiasContenedor">
            @foreach ($noticias as $noticia)
                <div class="noticiasCard">
                    <div class="noticiasImg">
                        <img src="{{ $noticia->imagen_url }}" alt="Imagen de la noticia: {{ $noticia->titulo }}"
                            loading="lazy" width="400" height="250">
                    </div>
                    <div class="noticiasInfo">
                        {{-- h3 y no h2: es el título de una tarjeta individual, dentro de la sección "Noticias" (h2) --}}
                        <h3 class="tituloCard">{{ $noticia->titulo }}</h3>
                        <div class="noticias-detalles">
                            <strong>
                                <p class="parrafoContenido">{{ $noticia->autor }}</p>
                            </strong>
                        </div>
                        <!--Aqui me va a generar un modal con la noticia completa, Hay que modificar la base de datos y poner un text-area o ver la mejor forma de hacer esto-->
                        <a href="{{ route('noticia.paginaInterna', $noticia->id) }}" class="btn-base btn-verde">Leer más</a>
                    </div>

                </div>
            @endforeach
        </div>
        <div class="paginacionBase paginacionNoticias">
            {{ $noticias->appends(['eventos_page' => $eventos->currentPage()])->fragment('noticias')->links('vendor.pagination.bootstrap-5') }}
        </div>
    </section>

    {{--
        Datos estructurados JSON-LD (schema.org): ayudan a los buscadores a entender qué es la página
        (una biblioteca) y qué eventos organiza, sin afectar nada visual. No se toca el diseño ni la lógica.
    --}}
    @push('head')
        <script type="application/ld+json">
            {!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'Library',
                'name' => $footerConfig->titulo ?: 'Biblioteca Digital DAW',
                'url' => url('/biblioteca'),
                'image' => asset('img/logoDAW-conTransparencia.png'),
                'telephone' => $footerConfig->telefono,
                'email' => $footerConfig->email_contacto,
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $footerConfig->direccion,
                ],
                'sameAs' => array_values(array_filter([
                    $footerConfig->instagram_url,
                    $footerConfig->linkedin_url,
                    $footerConfig->twitter_url,
                    $footerConfig->youtube_url,
                ])),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>

        {{-- Un bloque JSON-LD de tipo Event por cada evento mostrado en la agenda de la página actual --}}
        @foreach ($eventos as $evento)
            <script type="application/ld+json">
                {!! json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Event',
                    'name' => $evento->titulo,
                    'description' => $evento->descripcion,
                    'startDate' => \Illuminate\Support\Carbon::parse($evento->fecha_hora)->toIso8601String(),
                    'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
                    'eventStatus' => 'https://schema.org/EventScheduled',
                    'image' => $evento->imagen_url,
                    'url' => route('evento.paginaInterna', $evento->id),
                    'location' => [
                        '@type' => 'Place',
                        'name' => $evento->ubicacion,
                        'address' => $evento->ubicacion,
                    ],
                    'organizer' => [
                        '@type' => 'Organization',
                        'name' => $footerConfig->titulo ?: 'Biblioteca Digital DAW',
                    ],
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
            </script>
        @endforeach
    @endpush
@endsection