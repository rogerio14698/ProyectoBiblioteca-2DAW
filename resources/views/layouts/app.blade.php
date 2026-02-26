<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Biblioteca DAW')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Css para sobrescribir el boostrap -->
    <!-- Dar estilos personalizados-->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sobreescribirBoostrap.css') }}">
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

    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>