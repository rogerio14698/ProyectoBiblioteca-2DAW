@php
    $enlacesPrincipales = [
        ['url' => url('/biblioteca'), 'texto' => 'Inicio', 'activo' => request()->is('biblioteca') || request()->is('/') || request()->is('librosDestacados')],
        ['url' => url('/catalogo'), 'texto' => 'Catálogo', 'activo' => request()->is('catalogo') || request()->is('libro/*')],
        ['url' => url('/actividades'), 'texto' => 'Actividades', 'activo' => request()->is('actividades') || request()->is('evento/*')],
        ['url' => route('publicaciones.index'), 'texto' => 'Publicaciones', 'activo' => request()->is('publicaciones*')],
        ['url' => url('/contacto'), 'texto' => 'Contacto', 'activo' => request()->is('contacto*')],
    ];
@endphp
<header class="cabecera" data-desplazada="false">
    <div class="envoltura cabecera__barra">
        <a class="marca" href="{{ url('/biblioteca') }}" aria-label="Biblioteca DAW, inicio">Biblioteca <em>DAW</em></a>

        <nav class="navegacion" id="navegacion" aria-label="Principal" data-abierta="false">
            <ul class="navegacion__lista">
                @foreach ($enlacesPrincipales as $enlace)
                    <li>
                        <a href="{{ $enlace['url'] }}" class="navegacion__enlace" @if ($enlace['activo']) aria-current="page" @endif>{{ $enlace['texto'] }}</a>
                    </li>
                @endforeach
            </ul>

            <form class="buscador" role="search" method="GET" action="{{ url('/catalogo') }}">
                <label for="buscadorCabecera" class="visually-hidden">Buscar en el catálogo</label>
                <input id="buscadorCabecera" type="search" name="query" placeholder="Buscar un libro" value="{{ request('query', '') }}">
                <button type="submit" aria-label="Buscar"><i class="bi bi-search" aria-hidden="true"></i></button>
            </form>
        </nav>

        <div class="cabecera__acciones">
            @auth('web')
                @php $socio = auth('web')->user(); @endphp
                <div class="cuenta">
                    <button type="button" class="cuenta__boton" aria-expanded="false" aria-controls="menuCuenta" aria-label="Mi cuenta: {{ $socio->name }}">
                        <img src="{{ $socio->profile_photo_url }}" alt="" width="36" height="36">
                        <span>{{ \Illuminate\Support\Str::of($socio->name)->explode(' ')->first() }}</span>
                        <i class="bi bi-chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="cuenta__menu" id="menuCuenta" hidden>
                        <div class="cuenta__cabecera">
                            <strong>{{ $socio->name }}</strong>
                            Socio n.º {{ $socio->nSocio }}
                        </div>
                        <a href="{{ route('usuario.inicio') }}"><i class="bi bi-house" aria-hidden="true"></i>Mi espacio</a>
                        <a href="{{ route('usuario.perfil') }}"><i class="bi bi-person" aria-hidden="true"></i>Perfil</a>
                        <a href="{{ route('usuario.prestamos') }}"><i class="bi bi-journal-bookmark" aria-hidden="true"></i>Préstamos</a>
                        <a href="{{ route('usuario.pagos') }}"><i class="bi bi-credit-card" aria-hidden="true"></i>Pagos y cuota</a>
                        <a href="{{ route('usuario.publicar') }}"><i class="bi bi-pen" aria-hidden="true"></i>Publicar</a>
                        <hr>
                        <form method="POST" action="{{ route('usuario.logout') }}">
                            @csrf
                            <button type="submit"><i class="bi bi-box-arrow-right" aria-hidden="true"></i>Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            @elseauth('admin')
                <a href="{{ url('/admin') }}" class="boton boton--pequeno">Panel</a>
            @else
                <a href="{{ url('/login') }}" class="enlace-cuenta">Entrar</a>
                <a href="{{ url('/registro') }}" class="boton boton--pequeno">Hazte socio</a>
            @endauth

            <button type="button" class="cabecera__menu" aria-expanded="false" aria-controls="navegacion">
                <span></span><span></span>
                <span class="visually-hidden">Menú</span>
            </button>
        </div>
    </div>
</header>