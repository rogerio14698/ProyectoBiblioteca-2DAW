<!doctype html>
<html lang="es" class="no-js">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#14100f">
    <title>@yield('title', 'Panel') · Biblioteca DAW</title>
    <link rel="icon" href="{{ asset('img/logoDAW-conTransparencia.png') }}" type="image/png">
    @vite(['resources/scss/admin.scss', 'resources/js/app.js'])
    @stack('head')
</head>

@php
    $grupos = [
        'General' => [
            ['ruta' => 'admin.dashboard', 'icono' => 'grid-1x2', 'texto' => 'Resumen'],
            ['ruta' => 'admin.mensajes.index', 'icono' => 'envelope', 'texto' => 'Mensajes'],
        ],
        'Contenido web' => [
            ['ruta' => 'admin.gestionHome', 'icono' => 'house', 'texto' => 'Portada'],
            ['ruta' => 'admin.gestionCarrusel', 'icono' => 'calendar-event', 'texto' => 'Eventos'],
            ['ruta' => 'admin.gestionCatalogo', 'icono' => 'book', 'texto' => 'Catálogo'],
            ['ruta' => 'admin.gestionActividades', 'icono' => 'easel', 'texto' => 'Actividades'],
            ['ruta' => 'admin.gestionNoticias', 'icono' => 'newspaper', 'texto' => 'Noticias'],
            ['ruta' => 'admin.gestionFooter', 'icono' => 'layout-text-window-reverse', 'texto' => 'Pie de página'],
        ],
        'Socios' => [
            ['ruta' => 'admin.gestionUsuarios', 'icono' => 'people', 'texto' => 'Usuarios'],
            ['ruta' => 'admin.gestionSanciones', 'icono' => 'exclamation-octagon', 'texto' => 'Sanciones'],
            ['ruta' => 'admin.gestionRoles', 'icono' => 'shield-lock', 'texto' => 'Roles y permisos'],
            ['ruta' => 'admin.publicacionesUser', 'icono' => 'pen', 'texto' => 'Publicaciones'],
        ],
        'Préstamos y fondos' => [
            ['ruta' => 'admin.reservasActivas', 'icono' => 'bookmark-check', 'texto' => 'Reservas activas'],
            ['ruta' => 'admin.historialReservas', 'icono' => 'clock-history', 'texto' => 'Historial de reservas'],
            ['ruta' => 'admin.librosPrestados', 'icono' => 'journal-arrow-up', 'texto' => 'Libros prestados'],
            ['ruta' => 'admin.librosPerdidos', 'icono' => 'journal-x', 'texto' => 'Libros perdidos'],
            ['ruta' => 'admin.inventario', 'icono' => 'archive', 'texto' => 'Inventario'],
        ],
    ];
    $paginaActual = trim($__env->yieldContent('title', 'Panel'));
    $administrador = auth('admin')->user();
@endphp

<body class="admin">
    <div class="a-app">
        <aside class="a-lateral" id="aLateral" data-abierto="false" aria-label="Menú del panel">
            <a class="a-marca" href="{{ route('admin.dashboard') }}">Biblioteca <em>DAW</em><span>Panel</span></a>

            <nav class="a-nav">
                @foreach ($grupos as $grupo => $enlaces)
                    <p class="a-nav__grupo">{{ $grupo }}</p>
                    @foreach ($enlaces as $enlace)
                        @php
                            $activo = request()->routeIs($enlace['ruta']) || request()->routeIs($enlace['ruta'] . '.*');
                        @endphp
                        <a class="a-nav__enlace" href="{{ route($enlace['ruta']) }}" @if ($activo) aria-current="page" @endif>
                            <i class="bi bi-{{ $enlace['icono'] }}" aria-hidden="true"></i>{{ $enlace['texto'] }}
                        </a>
                    @endforeach
                @endforeach
            </nav>

            <div class="a-lateral__pie">
                <a class="a-nav__enlace" href="{{ url('/biblioteca') }}" target="_blank" rel="noopener">
                    <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>Ver la web
                </a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="a-nav__enlace"><i class="bi bi-box-arrow-left" aria-hidden="true"></i>Cerrar sesión</button>
                </form>
            </div>
        </aside>
        <div class="a-velo" data-visible="false"></div>

        <header class="a-superior">
            <button type="button" class="a-superior__menu" aria-expanded="false" aria-controls="aLateral" aria-label="Abrir menú">
                <i class="bi bi-list" aria-hidden="true"></i>
            </button>
            <div class="a-superior__ruta">
                <span>Panel</span>
                <i class="bi bi-chevron-right" aria-hidden="true"></i>
                <span>{{ $paginaActual }}</span>
            </div>
            <div class="a-superior__acciones">
                @if ($administrador)
                    <span class="a-avatar" title="{{ $administrador->name }}">{{ mb_strtoupper(mb_substr($administrador->name ?? 'A', 0, 1)) }}</span>
                @endif
            </div>
        </header>

        <main class="a-hoja" id="contenido">
            @if (session('demo_warning'))
                <div class="a-aviso"><i class="bi bi-info-circle" aria-hidden="true"></i><p>{{ session('demo_warning') }}</p></div>
            @endif
            @if (session('success'))
                <div class="a-aviso a-aviso--exito" role="status"><i class="bi bi-check2-circle" aria-hidden="true"></i><p>{{ session('success') }}</p></div>
            @endif
            @if (session('error'))
                <div class="a-aviso a-aviso--error" role="alert"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i><p>{{ session('error') }}</p></div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>