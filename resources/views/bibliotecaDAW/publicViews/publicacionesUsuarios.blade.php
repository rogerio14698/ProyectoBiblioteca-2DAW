@extends('layouts.app')

@section('title', 'Publicaciones de Usuarios')

@section('content')
    <main class="contenedor publicacionesAcademicasPage">
        <section class="headerContenido">
            <h1 class="tituloPagina">Publicaciones de Usuarios</h1>
            <p class="parrafoContenido">Listado académico de documentos y libros digitales compartidos por la comunidad.</p>

            <form method="GET" action="{{ route('publicaciones.index') }}" class="publicacionesAcademicasFiltros">
                <input type="text" name="query" value="{{ $searchQuery }}" class="buscadorInput"
                    placeholder="Buscar por libro, título o resumen" aria-label="Buscar publicaciones">

                <!-- Solo se permite formato PDF, eliminamos el selector de extensión -->
                <input type="hidden" name="extension" value="todos">

                <select name="orden" class="buscadorInput" aria-label="Orden de publicaciones">
                    <option value="reciente" {{ $searchOrden === 'reciente' ? 'selected' : '' }}>Más recientes</option>
                    <option value="antiguo" {{ $searchOrden === 'antiguo' ? 'selected' : '' }}>Más antiguas</option>
                </select>

                <button type="submit" class="btn-base btn-buscar">Filtrar</button>
                <a href="{{ route('publicaciones.index') }}" class="btn-base btn-limpiar">Limpiar</a>
            </form>
        </section>

        <section class="publicacionesAcademicasListaWrap separador">
            <div class="publicacionesAcademicasLista">
                <div class="publicacionesAcademicasHeader" role="row">
                    <span>Nombre</span>
                    <span>Título del archivo</span>
                    <span>Fecha</span>
                    <span>Acción</span>
                </div>

                @forelse($publicaciones as $publicacion)
                    <article class="publicacionesAcademicasItem" role="row">
                        <div class="publicacionesCampoNombre">
                            <strong>{{ $publicacion->nombre_libro }}</strong>
                            <small>{{ strtoupper($publicacion->archivo_extension) }}</small>
                        </div>
                        <div class="publicacionesCampoTitulo">{{ $publicacion->titulo_publicacion }}</div>
                        <div class="publicacionesCampoFecha">{{ $publicacion->fecha_publicacion?->format('d/m/Y') ?? 'N/A' }}</div>
                        <div class="publicacionesCampoAccion">
                            <a href="{{ route('publicaciones.ver', $publicacion->id) }}" target="_blank" rel="noopener"
                                class="btn-base btn-verde">Ver archivo</a>
                        </div>
                    </article>
                @empty
                    <p class="publicacionesAcademicasVacio">No se encontraron publicaciones con los filtros seleccionados.</p>
                @endforelse
            </div>

            <div class="paginacionBase paginacionPublicacionesAcademicas">
                {{ $publicaciones->links('vendor.pagination.bootstrap-5') }}
            </div>
        </section>
    </main>
@endsection
