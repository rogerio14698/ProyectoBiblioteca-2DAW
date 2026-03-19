<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Esto es el Watch de npm para que se actualice el css cada vez que se haga un cambio -->

    <title>@yield('title', 'Biblioteca DAW')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/logoDAW-conTransparencia.png') }}" type="image/png">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!--Swiper Layout (carga local para evitar bloqueos de CDN en iOS) -->
    <link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" />


    <!-- Dar estilos personalizados-->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}?v={{ filemtime(public_path('css/main.css')) }}">
    @stack('head')
</head>

<body>
    @include('layouts.header')
    <!-- Aqui voy a poner el layout de usuario, pero hay que verificar. si el usuario ha ingresado mediante login -->
    @auth('web')
        <!--auth hace exactamente esto, valida si el usuario ha iniciado sesión
                                            y luego renderiza el contenido dentro del bloque auth -->
        @include('layouts.navUsuario')
    @endauth
    <!-- con esto especificando el guard, me aseguro que solo se renderice el navUsuario para los usuarios autenticados con el guard web, que es el guard por defecto para los usuarios normales en Laravel -->
    @auth('admin')
        @include('layouts.navAdmin')
    @endauth



    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    <!-- DEBUG TEMPORAL iOS: muestra info de diagnóstico en pantalla (ELIMINAR después) -->
    <script>
        (function() {
            var d = document.createElement('div');
            d.id = 'iosDebug';
            d.style.cssText = 'position:fixed;bottom:0;left:0;right:0;background:rgba(0,0,0,0.85);color:#0f0;font:12px monospace;padding:8px;z-index:99999;max-height:40vh;overflow:auto;';
            d.innerHTML = '<b>DEBUG iOS</b><br>';
            document.body.appendChild(d);
            window._dbg = function(msg) { d.innerHTML += msg + '<br>'; };
            window.onerror = function(m, u, l) { window._dbg('ERR: ' + m + ' L:' + l); };
            window._dbg('1. Scripts cargando...');
        })();
    </script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>window._dbg && window._dbg('2. Bootstrap OK');</script>
    <!-- Swiper JS (carga local para evitar bloqueos de CDN en iOS) -->
    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script>window._dbg && window._dbg('3. Swiper: ' + (typeof Swiper !== 'undefined' ? 'OK' : 'NO CARGADO'));</script>
    @stack('scripts')
</body>

</html>