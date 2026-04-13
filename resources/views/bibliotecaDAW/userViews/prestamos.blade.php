@extends('layouts.app')

@section('title', 'Préstamos')

@section('content')
    <main class="contenedor prestamosUsuario">
        <section class="prestamosHeader">
            <h1>Préstamos</h1>
            <p>Bienvenido <span>{{ Auth::user()->name }}</span>. Revisa todos tus préstamos, filtra por estado y ordena de más
                recientes a más antiguos.</p>
        </section>

        <section class="prestamosResumenCards">
            <article class="prestamosCardResumen">
                <p class="prestamosResumenEtiqueta">Total</p>
                <p class="prestamosResumenNumero">{{ $resumen['total'] }}</p>
            </article>
            <article class="prestamosCardResumen">
                <p class="prestamosResumenEtiqueta">Activos</p>
                <p class="prestamosResumenNumero">{{ $resumen['activos'] }}</p>
            </article>
            <article class="prestamosCardResumen">
                <p class="prestamosResumenEtiqueta">Devueltos</p>
                <p class="prestamosResumenNumero">{{ $resumen['devueltos'] }}</p>
            </article>
            <article class="prestamosCardResumen prestamosCardResumenAlerta">
                <p class="prestamosResumenEtiqueta">Vencidos</p>
                <p class="prestamosResumenNumero">{{ $resumen['vencidos'] }}</p>
            </article>
        </section>

        <section class="prestamosPanelFiltros">
            <h2 class="tituloContenido">Filtros de consulta</h2>
            <form method="GET" action="{{ route('usuario.prestamos') }}" class="prestamosFormularioFiltros">
                <div class="prestamosCampoFiltro">
                    <label for="buscar">Buscar libro</label>
                    <input type="text" id="buscar" name="buscar" value="{{ $buscarTexto }}"
                        placeholder="Título, autor, ISBN o género">
                </div>

                <div class="prestamosCampoFiltro">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado">
                        <option value="todos" {{ $estadoSeleccionado === 'todos' ? 'selected' : '' }}>Todos</option>
                        <option value="activos" {{ $estadoSeleccionado === 'activos' ? 'selected' : '' }}>Activos</option>
                        <option value="devueltos" {{ $estadoSeleccionado === 'devueltos' ? 'selected' : '' }}>Devueltos</option>
                        <option value="vencidos" {{ $estadoSeleccionado === 'vencidos' ? 'selected' : '' }}>Vencidos</option>
                    </select>
                </div>

                <div class="prestamosCampoFiltro">
                    <label for="orden">Orden</label>
                    <select id="orden" name="orden">
                        <option value="reciente" {{ $ordenSeleccionado === 'reciente' ? 'selected' : '' }}>Más reciente primero</option>
                        <option value="antiguo" {{ $ordenSeleccionado === 'antiguo' ? 'selected' : '' }}>Más antiguo primero</option>
                    </select>
                </div>

                <div class="prestamosAccionesFiltro">
                    <button type="submit" class="btn-base btn-verde">Aplicar filtros</button>
                    <a href="{{ route('usuario.prestamos') }}" class="prestamosBtnLimpiar">Limpiar</a>
                </div>
            </form>
        </section>

        <section class="prestamosListadoCards">
            @forelse($prestamos as $prestamo)
                @php
                    $estaDevuelto = $prestamo->fecha_devolucion_real !== null;
                    $estaVencido =
                        !$estaDevuelto &&
                        $prestamo->fecha_devolucion_esperada !== null &&
                        $prestamo->fecha_devolucion_esperada->lt(now());
                @endphp
                <article class="prestamoCardItem">
                    <header class="prestamoCardCabecera">
                        <h3>{{ $prestamo->libro->titulo ?? 'Libro sin título' }}</h3>

                        @if ($estaDevuelto)
                            <span class="prestamoEstado prestamoEstadoDevuelto">Devuelto</span>
                        @elseif ($estaVencido)
                            <span class="prestamoEstado prestamoEstadoVencido">Vencido</span>
                        @else
                            <span class="prestamoEstado prestamoEstadoActivo">Activo</span>
                        @endif
                    </header>

                    <div class="prestamoDatosGrid">
                        <p><strong>Autor:</strong> {{ $prestamo->libro->autor ?? 'No disponible' }}</p>
                        <p><strong>ISBN:</strong> {{ $prestamo->libro->isbn ?? 'No disponible' }}</p>
                        <p><strong>Género:</strong> {{ $prestamo->libro->genero ?? 'No disponible' }}</p>
                        <p><strong>Editorial:</strong> {{ $prestamo->libro->editorial ?? 'No disponible' }}</p>
                        <p><strong>Formato:</strong> {{ ucfirst($prestamo->libro->formato ?? 'No disponible') }}</p>
                        <p><strong>Año:</strong> {{ $prestamo->libro->anio ?? 'No disponible' }}</p>
                        <p><strong>Fecha de préstamo:</strong> {{ $prestamo->fecha_prestamo?->format('d/m/Y') ?? 'No disponible' }}</p>
                        <p><strong>Devolución estimada:</strong>
                            {{ $prestamo->fecha_devolucion_esperada?->format('d/m/Y') ?? 'No definida' }}</p>
                        <p><strong>Devolución real:</strong>
                            {{ $prestamo->fecha_devolucion_real?->format('d/m/Y') ?? 'Pendiente' }}</p>
                        <p><strong>Disponibilidad actual:</strong>
                            {{ ucfirst($prestamo->libro->disponibilidad ?? 'No disponible') }}</p>
                    </div>

                    <div class="prestamoCardAcciones">
                        <a href="{{ route('libro.paginaInterna', $prestamo->libro->id) }}" class="btn-base btn-verde">Ver libro</a>
                    </div>
                </article>
            @empty
                <article class="prestamoSinResultados">
                    <h3>Sin resultados</h3>
                    <p>No se encontraron préstamos con los filtros seleccionados.</p>
                </article>
            @endforelse
        </section>

        <section class="prestamosPaginacion">
            {{ $prestamos->links('vendor.pagination.bootstrap-5') }}
        </section>
    </main>
@endsection