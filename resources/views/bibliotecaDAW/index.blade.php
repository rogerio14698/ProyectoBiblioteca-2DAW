@extends('layouts.app')

@section('title', 'Biblioteca Digital DAW | Catálogo, Eventos y Noticias')
@section('meta_description', 'Descubre el catálogo digital de la Biblioteca DAW: libros disponibles para préstamo y compra, agenda de eventos culturales y las últimas noticias de la comunidad educativa.')
@section('og_image', asset('img/coleccion/biblioteca-barroca.webp'))

@php
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Str;

    $hoy = Carbon::now()->locale('es');
    $horarioHoy = match (true) {
        $hoy->isSaturday() => $footerConfig->horario_sabado,
        $hoy->isSunday() => $footerConfig->horario_domingo,
        default => $footerConfig->horario_semana,
    };
    $socio = auth('web')->user();
@endphp

@section('content')
    {{-- 1. Portada: el nombre en dos tintas sobre un grabado de biblioteca barroca --}}
    <section class="capitulo capitulo--tinta portada" aria-labelledby="tituloPortada">
        <img class="portada__grabado grabado" src="{{ asset('img/coleccion/biblioteca-barroca.webp') }}" alt=""
            width="1600" height="1100" fetchpriority="high">
        <div class="envoltura portada__contenido">
            <h1 class="portada__titulo" id="tituloPortada">
                <span class="linea-mascara"><span>Biblioteca</span></span>
                <span class="linea-mascara" style="--retraso: 120ms"><span>DAW</span></span>
                <span class="visually-hidden">, biblioteca digital de la comunidad educativa</span>
            </h1>

            <div class="portada__pie aparecer">
                <p class="portada__horario">
                    <strong>Hoy abrimos {{ $horarioHoy ?: 'consulta el horario' }}</strong>
                    {{ Str::ucfirst($hoy->translatedFormat('l j \d\e F')) }} · {{ $footerConfig->direccion }}
                </p>
                <div>
                    <p class="portada__frase">
                        Libros para prestar, comprar y descubrir. Actividades cada semana y una comunidad que escribe.
                    </p>
                    <div class="acciones">
                        <a href="{{ url('/catalogo') }}" class="boton">Explorar el catálogo</a>
                        @if ($socio)
                            <a href="{{ route('usuario.inicio') }}" class="boton boton--linea">Mi espacio</a>
                        @else
                            <a href="{{ url('/registro') }}" class="boton boton--linea">Hazte socio</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. Declaración con cifras reales --}}
    <section class="capitulo capitulo--oro" aria-labelledby="tituloDeclaracion">
        <div class="envoltura declaracion">
            <div data-revelar>
                <h2 id="tituloDeclaracion" class="visually-hidden">La biblioteca en cifras</h2>
                <p class="declaracion__texto">
                    Un fondo vivo que se presta, se vende y se comenta. <em>Entra, curiosea y llévate algo.</em>
                </p>
                <dl class="cifras-grandes">
                    <div><dt>Títulos en catálogo</dt><dd>{{ number_format($cifras['libros'], 0, ',', '.') }}</dd></div>
                    <div><dt>Actividades próximas</dt><dd>{{ number_format($cifras['eventos'], 0, ',', '.') }}</dd></div>
                    <div><dt>Socios</dt><dd>{{ number_format($cifras['socios'], 0, ',', '.') }}</dd></div>
                </dl>
            </div>
            <figure class="lamina lamina--inclinada declaracion__lamina" data-revelar>
                <img src="{{ asset('img/coleccion/lectora.webp') }}" alt="Mujer leyendo, óleo de Édouard Manet" loading="lazy" width="800" height="1000">
                <figcaption>Édouard Manet, <i>La lectora</i> (c. 1880)</figcaption>
            </figure>
        </div>
    </section>

    {{-- 3. Novedades del catálogo --}}
    <section class="capitulo capitulo--tinta" aria-labelledby="tituloNovedades">
        <div class="envoltura">
            <header class="encabezado" data-revelar>
                <h2 id="tituloNovedades">Novedades <em>del fondo</em></h2>
                <p>Las últimas incorporaciones a la colección, listas para préstamo o compra.</p>
            </header>

            @if ($libros->isEmpty())
                <p class="vacio">Todavía no hay libros en el catálogo.</p>
            @else
                <div class="carrusel" data-carrusel>
                    <ul class="carrusel__pista" role="list" aria-label="Novedades del catálogo">
                        @foreach ($libros as $libro)
                            <li class="carrusel__item">
                                <article class="libro">
                                    <a class="libro__enlace" href="{{ route('libro.paginaInterna', $libro->id) }}">
                                        <div class="libro__portada">
                                            <img src="{{ $libro->portada_url }}" alt="" loading="lazy" width="200" height="300">
                                        </div>
                                        <h3 class="libro__titulo">{{ $libro->titulo }}</h3>
                                    </a>
                                    <p class="libro__autor">{{ $libro->autor }}</p>
                                    @if ($libro->seVende())
                                        <p class="libro__meta"><span class="precio">{{ number_format($libro->precio, 2, ',', '.') }} €</span></p>
                                    @endif
                                </article>
                            </li>
                        @endforeach
                    </ul>
                    <div class="novedades__pie">
                        <div class="carrusel__controles">
                            <button type="button" data-carrusel-anterior aria-label="Libros anteriores"><i class="bi bi-arrow-left" aria-hidden="true"></i></button>
                            <button type="button" data-carrusel-siguiente aria-label="Libros siguientes"><i class="bi bi-arrow-right" aria-hidden="true"></i></button>
                        </div>
                        <a href="{{ url('/catalogo') }}" class="boton boton--linea">Ver todo el catálogo</a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- 4. En portada: piezas gestionadas desde el panel --}}
    @if ($slideBienvenidas->isNotEmpty())
        <section class="capitulo capitulo--burdeos" aria-labelledby="tituloDestacados">
            <div class="envoltura">
                <header class="encabezado" data-revelar>
                    <h2 id="tituloDestacados">En <em>portada</em></h2>
                    <p>Lo que no te puedes perder este mes en la biblioteca.</p>
                </header>

                <div class="carrusel carrusel--uno" data-carrusel>
                    <div class="carrusel__pista">
                        @foreach ($slideBienvenidas as $slide)
                            @php
                                $imagenSlide = Str::startsWith($slide->imagen, ['http://', 'https://']) ? $slide->imagen : asset($slide->imagen);
                            @endphp
                            <article class="carrusel__item destacado" aria-roledescription="diapositiva" aria-label="{{ $loop->iteration }} de {{ $loop->count }}">
                                <figure class="lamina">
                                    <img src="{{ $imagenSlide }}" alt="" loading="lazy" width="800" height="600">
                                </figure>
                                <div>
                                    <h3>{{ $slide->titulo }}</h3>
                                    <p>{!! nl2br(e($slide->descripcion)) !!}</p>
                                    @if ($slide->url)
                                        <a href="{{ $slide->url }}" class="boton">Descubrir</a>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                    @if ($slideBienvenidas->count() > 1)
                        <div class="novedades__pie">
                            <p class="carrusel__contador" aria-live="polite">01 / {{ str_pad((string) $slideBienvenidas->count(), 2, '0', STR_PAD_LEFT) }}</p>
                            <div class="carrusel__controles">
                                <button type="button" data-carrusel-anterior aria-label="Anterior"><i class="bi bi-arrow-left" aria-hidden="true"></i></button>
                                <button type="button" data-carrusel-siguiente aria-label="Siguiente"><i class="bi bi-arrow-right" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- 5. Agenda --}}
    <section id="agenda" class="capitulo capitulo--pergamino" aria-labelledby="tituloAgenda">
        <div class="envoltura">
            <header class="encabezado" data-revelar>
                <h2 id="tituloAgenda">Agenda</h2>
                <p>Presentaciones, clubes de lectura y talleres. Algunas actividades son gratuitas; otras tienen entrada.</p>
            </header>

            @if ($eventos->isEmpty())
                <p class="vacio">No hay actividades programadas por ahora.</p>
            @else
                <ol class="agenda">
                    @foreach ($eventos as $evento)
                        @php $fecha = Carbon::parse($evento->fecha_hora)->locale('es'); @endphp
                        <li class="agenda__fila">
                            <time class="agenda__fecha" datetime="{{ $fecha->toIso8601String() }}">
                                <span class="agenda__dia">{{ $fecha->format('d') }}</span>
                                <span class="agenda__mes">{{ Str::ucfirst($fecha->translatedFormat('M Y')) }}</span>
                            </time>
                            <div class="agenda__cuerpo">
                                <h3><a href="{{ route('evento.paginaInterna', $evento->id) }}">{{ $evento->titulo }}</a></h3>
                                <p class="agenda__lugar">
                                    <span><i class="bi bi-clock" aria-hidden="true"></i> {{ $fecha->format('H:i') }}</span>
                                    <span><i class="bi bi-geo-alt" aria-hidden="true"></i> {{ $evento->ubicacion }}</span>
                                    @if ($evento->aforo)
                                        <span>{{ $evento->aforo }} plazas</span>
                                    @endif
                                </p>
                            </div>
                            <p class="agenda__precio">
                                @if ($evento->esDePago())
                                    <span class="precio">{{ number_format($evento->precio, 2, ',', '.') }} €</span>
                                @else
                                    <span class="insignia insignia--verde">Gratis</span>
                                @endif
                            </p>
                            <span class="agenda__accion" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                        </li>
                    @endforeach
                </ol>
                {{ $eventos->appends(['noticias_page' => $noticias->currentPage()])->fragment('agenda')->links() }}
            @endif
        </div>
    </section>

    {{-- 6. Noticias --}}
    <section id="noticias" class="capitulo capitulo--verde" aria-labelledby="tituloNoticias">
        <div class="envoltura">
            <header class="encabezado" data-revelar>
                <h2 id="tituloNoticias">Noticias</h2>
                <p>Lo que pasa en la biblioteca y en el mundo del libro.</p>
            </header>

            @if ($noticias->isEmpty())
                <p class="vacio">Aún no hay noticias publicadas.</p>
            @else
                <div class="noticias noticias--destacada">
                    @foreach ($noticias as $noticia)
                        <article class="noticia" data-revelar>
                            <img src="{{ $noticia->imagen_url }}" alt="" loading="lazy" width="400" height="300">
                            <h3><a href="{{ route('noticia.paginaInterna', $noticia->id) }}">{{ $noticia->titulo }}</a></h3>
                            <p class="noticia__autor">{{ $noticia->autor }}</p>
                        </article>
                    @endforeach
                </div>
                {{ $noticias->appends(['eventos_page' => $eventos->currentPage()])->fragment('noticias')->links() }}
            @endif
        </div>
    </section>

    {{-- 7. Llamada final --}}
    <section class="capitulo capitulo--oro" aria-labelledby="tituloLlamada">
        <img class="llamada__grabado grabado grabado--tinta" src="{{ asset('img/coleccion/arabescos.webp') }}" alt="" loading="lazy" width="800" height="800">
        <div class="envoltura llamada">
            <h2 id="tituloLlamada">Tu carné, <em>tu biblioteca.</em></h2>
            <div>
                <p>
                    El registro es gratuito y te da acceso a préstamos, actividades y publicaciones.
                    Si quieres apoyarnos, la cuota de socio son {{ number_format((float) config('services.stripe.cuota_socio', 20), 0, ',', '.') }} € al año.
                </p>
                @if ($socio)
                    <a href="{{ route('usuario.pagos') }}" class="boton">Ver mi cuota</a>
                @else
                    <a href="{{ url('/registro') }}" class="boton">Crear mi cuenta</a>
                @endif
            </div>
        </div>
    </section>

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
                    'isAccessibleForFree' => ! $evento->esDePago(),
                    'organizer' => [
                        '@type' => 'Organization',
                        'name' => $footerConfig->titulo ?: 'Biblioteca DAW',
                    ],
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
            </script>
        @endforeach
    @endpush
@endsection