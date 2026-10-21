@extends('layouts.app')

@section('title', 'Publicaciones de la comunidad | Biblioteca DAW')

@section('content')
    <section class="capitulo capitulo--tinta">
        <div class="envoltura">
            <header class="portadilla">
                <ol class="migas"><li><a href="{{ url('/biblioteca') }}">Biblioteca</a></li><li aria-current="page">Publicaciones</li></ol>
                <h1>Lecturas <em>compartidas</em></h1>
                <p class="entradilla">Documentos y publicaciones digitales aportados por la comunidad.</p>
            </header>
            <form class="publicaciones__filtros" method="GET" action="{{ route('publicaciones.index') }}">
                <div class="campo"><label for="query">Buscar en las publicaciones</label><input type="search" id="query" name="query" value="{{ $searchQuery ?? '' }}" placeholder="Libro, título o resumen"></div>
                <input type="hidden" name="extension" value="{{ $searchExtension ?? 'todos' }}">
                <div class="campo"><label for="orden">Orden</label><select name="orden" id="orden"><option value="reciente" @selected(($searchOrden ?? 'reciente') === 'reciente')>Más recientes</option><option value="antiguo" @selected(($searchOrden ?? '') === 'antiguo')>Más antiguas</option></select></div>
                <button type="submit" class="boton">Filtrar</button>
                <a href="{{ route('publicaciones.index') }}" class="boton boton--texto">Limpiar</a>
            </form>
            @if ($publicaciones->isEmpty())
                <p class="vacio">No hay publicaciones que coincidan con la búsqueda.</p>
            @else
                <div class="tabla-envoltura">
                    <table class="publicaciones__tabla">
                        <thead><tr><th scope="col">Libro</th><th scope="col">Publicación</th><th scope="col">Fecha</th><th scope="col">Archivo</th></tr></thead>
                        <tbody>
                            @foreach ($publicaciones as $publicacion)
                                <tr>
                                    <td data-label="Libro"><strong>{{ $publicacion->nombre_libro }}</strong><small>{{ strtoupper($publicacion->archivo_extension) }}</small></td>
                                    <td data-label="Publicación">{{ $publicacion->titulo_publicacion }}@if ($publicacion->resumen_publicacion)<small>{{ $publicacion->resumen_publicacion }}</small>@endif</td>
                                    <td data-label="Fecha">{{ $publicacion->fecha_publicacion?->format('d/m/Y') ?? '—' }}</td>
                                    <td data-label="Archivo"><a class="boton boton--pequeno boton--linea" href="{{ route('publicaciones.ver', $publicacion->id) }}" target="_blank" rel="noopener">Abrir documento</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav class="publicaciones__paginacion" aria-label="Páginas de publicaciones">{{ $publicaciones->links() }}</nav>
            @endif
        </div>
    </section>
@endsection