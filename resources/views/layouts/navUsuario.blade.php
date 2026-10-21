@php
    $pestanas = [
        ['ruta' => 'usuario.inicio', 'icono' => 'house', 'texto' => 'Inicio'],
        ['ruta' => 'usuario.perfil', 'icono' => 'person', 'texto' => 'Perfil'],
        ['ruta' => 'usuario.prestamos', 'icono' => 'journal-bookmark', 'texto' => 'Préstamos'],
        ['ruta' => 'usuario.alquilar', 'icono' => 'bookmark-plus', 'texto' => 'Alquilar'],
        ['ruta' => 'usuario.comprar', 'icono' => 'bag', 'texto' => 'Comprar'],
        ['ruta' => 'usuario.pagos', 'icono' => 'credit-card', 'texto' => 'Pagos'],
        ['ruta' => 'usuario.publicar', 'icono' => 'pen', 'texto' => 'Publicar'],
        ['ruta' => 'usuario.organizarEvento', 'icono' => 'calendar-plus', 'texto' => 'Organizar evento'],
        ['ruta' => 'usuario.consultas', 'icono' => 'envelope', 'texto' => 'Mis consultas'],
    ];
@endphp
<nav class="barra-usuario" aria-label="Área de socio">
    <ul class="envoltura">
        @foreach ($pestanas as $pestana)
            <li>
                <a href="{{ route($pestana['ruta']) }}" @if (request()->routeIs($pestana['ruta']) || ($pestana['ruta'] === 'usuario.perfil' && request()->routeIs('usuario.perfilEditar'))) aria-current="page" @endif>
                    <i class="bi bi-{{ $pestana['icono'] }}" aria-hidden="true"></i>{{ $pestana['texto'] }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>