<!doctype html>
<html lang="es" class="no-js">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#120d0c">

    {{--
        Título y descripción: cada vista puede sobreescribirlos con @section('title', ...)
        y @section('meta_description', ...). Se reutilizan en Open Graph y Twitter Card.
    --}}
    @php
        $tituloPagina = trim($__env->yieldContent('title', 'Biblioteca DAW'));
        $descripcionPagina = trim($__env->yieldContent(
            'meta_description',
            'Biblioteca Digital DAW: catálogo de libros, eventos culturales, préstamos y recursos académicos para la comunidad educativa.'
        ));
        $imagenPagina = trim($__env->yieldContent('og_image', asset('img/coleccion/biblioteca-barroca.webp')));
    @endphp
    <title>{{ $tituloPagina }}</title>
    <meta name="description" content="{{ $descripcionPagina }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Biblioteca Digital DAW">
    <meta property="og:locale" content="es_ES">
    <meta property="og:title" content="{{ $tituloPagina }}">
    <meta property="og:description" content="{{ $descripcionPagina }}">
    <meta property="og:image" content="{{ $imagenPagina }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $tituloPagina }}">
    <meta name="twitter:description" content="{{ $descripcionPagina }}">
    <meta name="twitter:image" content="{{ $imagenPagina }}">

    <link rel="icon" href="{{ asset('img/logoDAW-conTransparencia.png') }}" type="image/png">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @stack('head')
</head>

<body>
    {{-- Ornamento barroco reutilizable: <svg class="ornamento"><use href="#ornamento"/></svg> --}}
    <svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
        <symbol id="ornamento" viewBox="0 0 120 24">
            <path fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                d="M2 12h34c6 0 9-8 15-8 4 0 6 3 6 5s-2 4-4 4-3-1-3-3M118 12H84c-6 0-9-8-15-8-4 0-6 3-6 5s2 4 4 4 3-1 3-3M60 4c2 4 2 12 0 16-2-4-2-12 0-16z" />
            <circle cx="60" cy="12" r="1.6" fill="currentColor" />
        </symbol>
    </svg>

    <a href="#contenido" class="salto">Saltar al contenido principal</a>

    @include('layouts.header')

    @auth('web')
        @if (request()->routeIs('usuario.*'))
            @include('layouts.navUsuario')
        @endif
    @endauth

    <main id="contenido" tabindex="-1">
        @if (session('demo_warning') || session('success') || session('error'))
            <div class="avisos-globales envoltura" role="status">
                @if (session('demo_warning'))
                    <div class="aviso aviso--info"><i class="bi bi-info-circle" aria-hidden="true"></i><p>{{ session('demo_warning') }}</p></div>
                @endif
                @if (session('success'))
                    <div class="aviso aviso--exito"><i class="bi bi-check2-circle" aria-hidden="true"></i><p>{{ session('success') }}</p></div>
                @endif
                @if (session('error'))
                    <div class="aviso aviso--error"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i><p>{{ session('error') }}</p></div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    @include('layouts.footer')

    @stack('scripts')
</body>

</html>