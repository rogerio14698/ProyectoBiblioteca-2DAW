<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Esto es el Watch de npm para que se actualice el css cada vez que se haga un cambio -->

    <title>@yield('title', 'Biblioteca DAW')</title>
    <meta name="description" content="Biblioteca Digital DAW: catalogo de libros, eventos culturales, prestamos y recursos academicos para la comunidad educativa.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/logoDAW-conTransparencia.png') }}" type="image/png">
    <!-- Preconexion al CDN de Bootstrap para acelerar la descarga -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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



    <main class="contenedor">
        {{-- Alerta para usuarios demo cuando intentan realizar una acción bloqueada --}}
        @if (session('demo_warning'))
            <div class="alertLogin alert-dangerLogin">
                <p>{{ session('demo_warning') }}</p>
            </div>
        @endif
        @yield('content')
    </main>

    @include('layouts.footer')

    <!-- Bootstrap Bundle JS (defer para no bloquear el renderizado) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    @stack('scripts')
</body>

</html>