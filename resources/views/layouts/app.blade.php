<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Esto es el Watch de npm para que se actualice el css cada vez que se haga un cambio -->

    {{--
        Título y descripción de la página: cada vista puede sobreescribirlos con @section('title', ...)
        y @section('meta_description', ...). Si no lo hacen, se usan estos valores por defecto.
        Los guardamos en variables PHP porque se reutilizan también en las etiquetas Open Graph y Twitter Card.
    --}}
    @php
        $tituloPagina = trim($__env->yieldContent('title', 'Biblioteca DAW'));
        $descripcionPagina = trim($__env->yieldContent(
            'meta_description',
            'Biblioteca Digital DAW: catálogo de libros, eventos culturales, préstamos y recursos académicos para la comunidad educativa.'
        ));
        $imagenPagina = trim($__env->yieldContent('og_image', asset('img/logoDAW-conTransparencia.png')));
    @endphp
    <title>{{ $tituloPagina }}</title>
    <meta name="description" content="{{ $descripcionPagina }}">

    <!-- Enlace canónico: evita contenido duplicado indexado por buscadores -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph: controla cómo se ve la página al compartirla en redes sociales (Facebook, LinkedIn, WhatsApp...) -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Biblioteca Digital DAW">
    <meta property="og:locale" content="es_ES">
    <meta property="og:title" content="{{ $tituloPagina }}">
    <meta property="og:description" content="{{ $descripcionPagina }}">
    <meta property="og:image" content="{{ $imagenPagina }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Twitter Card: vista previa equivalente para X/Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $tituloPagina }}">
    <meta name="twitter:description" content="{{ $descripcionPagina }}">
    <meta name="twitter:image" content="{{ $imagenPagina }}">
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
    @php
        // main.css solo @importa el resto de ficheros de public/css, no los incluye inline.
        // Si solo cambia un parcial (p.ej. actividadesYEventos.css) el mtime de main.css NO
        // cambia, la query ?v= se queda igual y el navegador/CDN puede seguir sirviendo esa
        // hoja de estilo en caché para siempre. Usamos el mtime más reciente de TODO css/
        // para que cualquier cambio, esté en el fichero que esté, rompa la caché.
        $cssDir = public_path('css');
        $cssVersion = 0;
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($cssDir, \FilesystemIterator::SKIP_DOTS)) as $archivoCss) {
            if ($archivoCss->getExtension() === 'css') {
                $cssVersion = max($cssVersion, $archivoCss->getMTime());
            }
        }
    @endphp
    <link rel="stylesheet" href="{{ asset('css/main.css') }}?v={{ $cssVersion }}">
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