@extends('layouts.app')

@section('title', 'Aquilar')

@section('content')
    <div class="contenedor alquilar">
        <div class="contenidoHeader">
            <h1>Alquilar libros</h1>
            <p>Bienvenido <span>{{ Auth::user()->name }}</span>. Consulta el catálogo de alquiler disponible y registra tu
                préstamo en pocos pasos.</p>
        </div>

        @if (session('success'))
            <div class="alquilarMensaje alquilarMensajeExito">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="alquilarMensaje alquilarMensajeError">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <section class="bloqueAlquilar alquilarResumenUsuario">
            <article class="alquilarResumenCard">
                <p class="alquilarResumenEtiqueta">Préstamos activos</p>
                <p class="alquilarResumenNumero">{{ $prestamosActivos->count() }}</p>
            </article>
            <article class="alquilarResumenCard">
                <p class="alquilarResumenEtiqueta">Historial reciente</p>
                <p class="alquilarResumenNumero">{{ $prestamosHistorial->count() }}</p>
            </article>
            <article class="alquilarResumenCard">
                <p class="alquilarResumenEtiqueta">Libros disponibles</p>
                <p class="alquilarResumenNumero">{{ $libros->total() }}</p>
            </article>
        </section>

        <section class="bloqueAlquilar">
            <h2>Buscar y filtrar catálogo de alquiler</h2>
            <form method="GET" action="{{ route('usuario.alquilar') }}" class="formularioAlquilarFiltros">
                <div class="campoFiltroAlquiler campoFiltroAlquilerAmplio">
                    <label for="query">Buscar libro</label>
                    <input type="text" id="query" name="query" value="{{ $searchQuery }}"
                        placeholder="Título, autor, género o ISBN">
                </div>

                <div class="campoFiltroAlquiler">
                    <label for="genero">Género</label>
                    <select id="genero" name="genero">
                        <option value="">Todos</option>
                        @foreach ($generosDisponibles as $genero)
                            <option value="{{ $genero }}" {{ $searchGenero === $genero ? 'selected' : '' }}>
                                {{ $genero }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="campoFiltroAlquiler">
                    <label for="formato">Formato</label>
                    <select id="formato" name="formato">
                        <option value="todos" {{ $searchFormato === 'todos' ? 'selected' : '' }}>Todos</option>
                        <option value="fisico" {{ $searchFormato === 'fisico' ? 'selected' : '' }}>Físico</option>
                        <option value="digital" {{ $searchFormato === 'digital' ? 'selected' : '' }}>Digital</option>
                        <option value="ambos" {{ $searchFormato === 'ambos' ? 'selected' : '' }}>Ambos</option>
                    </select>
                </div>

                <div class="campoFiltroAlquiler">
                    <label for="orden">Orden</label>
                    <select id="orden" name="orden">
                        <option value="reciente" {{ $searchOrden === 'reciente' ? 'selected' : '' }}>Más recientes</option>
                        <option value="antiguo" {{ $searchOrden === 'antiguo' ? 'selected' : '' }}>Más antiguos</option>
                        <option value="titulo_asc" {{ $searchOrden === 'titulo_asc' ? 'selected' : '' }}>Título A-Z</option>
                        <option value="titulo_desc" {{ $searchOrden === 'titulo_desc' ? 'selected' : '' }}>Título Z-A</option>
                    </select>
                </div>

                <div class="accionesFiltroAlquiler">
                    <button type="submit" class="btn-base btn-verde">Aplicar filtros</button>
                    <a href="{{ route('usuario.alquilar') }}" class="btn-base btn-azul">Limpiar</a>
                </div>
            </form>
        </section>

        <section class="bloqueAlquilar">
            <h2>Libros disponibles para alquilar</h2>

            <div class="catalogoAlquilarGrid">
                @forelse($libros as $libro)
                    <article class="alquilarCardLibro">
                        <div class="alquilarCardImagen">
                            <img src="{{ $libro->portada_url }}" alt="Portada del libro: {{ $libro->titulo }}"
                                loading="lazy" width="200" height="300">
                        </div>

                        <div class="alquilarCardContenido">
                            <h3>{{ $libro->titulo }}</h3>
                            <p><strong>Autor:</strong> {{ $libro->autor }}</p>
                            <p><strong>ISBN:</strong> {{ $libro->isbn }}</p>
                            <p><strong>Género:</strong> {{ $libro->genero }}</p>
                            <p><strong>Editorial:</strong> {{ $libro->editorial }}</p>
                            <p><strong>Formato:</strong> {{ ucfirst($libro->formato) }}</p>

                            <form method="POST" action="{{ route('usuario.alquilar.store') }}" class="alquilarFormularioAccion">
                                @csrf
                                <input type="hidden" name="libro_id" value="{{ $libro->id }}">

                                <label for="dias_prestamo_{{ $libro->id }}">Días de préstamo</label>
                                <input type="number" id="dias_prestamo_{{ $libro->id }}" name="dias_prestamo" min="1"
                                    max="60" value="14" required>

                                <button type="submit" class="btn-base btn-alquilar">Solicitar préstamo</button>
                                <a href="{{ route('libro.paginaInterna', $libro->id) }}" class="btn-base btn-verde">Ver ficha</a>
                            </form>
                        </div>
                    </article>
                @empty
                    <article class="alquilarSinResultados">
                        <h3>Sin resultados</h3>
                        <p>No hay libros disponibles para alquilar con los filtros seleccionados.</p>
                    </article>
                @endforelse
            </div>

            <div class="alquilarPaginacion">
                {{ $libros->links('vendor.pagination.bootstrap-5') }}
            </div>
        </section>

        <section class="bloqueAlquilar actividadAlquilerGrid">
            <article class="actividadAlquilerPanel">
                <h2>Tus préstamos activos</h2>
                <div class="actividadListaAlquiler">
                    @forelse($prestamosActivos as $prestamo)
                        <div class="actividadItemAlquiler">
                            <p><strong>{{ $prestamo->libro->titulo ?? 'Libro no disponible' }}</strong></p>
                            <p>Préstamo: {{ $prestamo->fecha_prestamo?->format('d/m/Y') ?? 'N/A' }}</p>
                            <p>Devolución esperada:
                                {{ $prestamo->fecha_devolucion_esperada?->format('d/m/Y') ?? 'Sin fecha' }}</p>
                        </div>
                    @empty
                        <p class="actividadVaciaAlquiler">No tienes préstamos activos.</p>
                    @endforelse
                </div>
            </article>

            <article class="actividadAlquilerPanel">
                <h2>Historial reciente</h2>
                <div class="actividadListaAlquiler">
                    @forelse($prestamosHistorial as $prestamo)
                        <div class="actividadItemAlquiler">
                            <p><strong>{{ $prestamo->libro->titulo ?? 'Libro no disponible' }}</strong></p>
                            <p>Préstamo: {{ $prestamo->fecha_prestamo?->format('d/m/Y') ?? 'N/A' }}</p>
                            <p>Devuelto: {{ $prestamo->fecha_devolucion_real?->format('d/m/Y') ?? 'N/A' }}</p>
                        </div>
                    @empty
                        <p class="actividadVaciaAlquiler">Aún no hay préstamos devueltos en tu historial.</p>
                    @endforelse
                </div>
            </article>
        </section>
    </div>
@endsection
