<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#120d0c">
    <title>@yield('title') | Biblioteca DAW</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <main class="error-page" id="contenido">
        <p class="error-page__codigo" aria-label="Error @yield('code')">@yield('code')</p>
        <h1 class="visually-hidden">@yield('title')</h1>
        <h2>@yield('heading')</h2>
        <p>@yield('message')</p>
        <a href="/biblioteca" class="boton">Volver a la biblioteca</a>
    </main>
</body>
</html>