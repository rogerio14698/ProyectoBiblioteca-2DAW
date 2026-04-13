@extends('layouts.app')

@section('title', 'Publicar')

@section('content')
    <main class="contenedor publicarUsuario">
        <section class="publicarHeader">
            <h1>Publicar contenido digital</h1>
            <p>Sube documentos y libros digitales para que otros usuarios de la biblioteca puedan acceder a ellos.</p>
        </section>

        @if (session('success'))
            <section class="publicarMensaje publicarMensajeExito">
                <p>{{ session('success') }}</p>
            </section>
        @endif

        @if (session('error'))
            <section class="publicarMensaje publicarMensajeError">
                <p>{{ session('error') }}</p>
            </section>
        @endif

        @if ($errors->any())
            <section class="publicarMensaje publicarMensajeError">
                <p>Se encontraron errores en el formulario:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </section>
        @endif

        <section class="publicarBloque">
            <div class="publicarIntro">
                <h2>Nueva publicación</h2>
                <p>Formato permitido: PDF (máx. 20MB).</p>
            </div>

            <form action="{{ route('usuario.publicar.store') }}" method="POST" enctype="multipart/form-data" class="publicarForm">
                @csrf

                <div class="campoPublicar">
                    <label for="nombre_libro">Nombre del libro</label>
                    <input type="text" id="nombre_libro" name="nombre_libro" value="{{ old('nombre_libro') }}" required>
                </div>

                <div class="campoPublicar">
                    <label for="titulo_publicacion">Título de la publicación</label>
                    <input type="text" id="titulo_publicacion" name="titulo_publicacion"
                        value="{{ old('titulo_publicacion') }}" required>
                </div>

                <div class="campoPublicar campoCompletoPublicar">
                    <label for="resumen_publicacion">Resumen</label>
                    <textarea id="resumen_publicacion" name="resumen_publicacion" required>{{ old('resumen_publicacion') }}</textarea>
                </div>

                <div class="accionesPublicar campoCompletoPublicar">
                    <div class="campoArchivoPublicar">
                        <label for="archivo_publicacion" class="labelArchivoPublicar">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <span class="labelArchivoTexto">Añade tu archivo digital</span>
                            <span class="labelArchivoFormatos">PDF</span>
                        </label>
                        <input type="file" id="archivo_publicacion" name="archivo_publicacion" class="inputArchivoPublicar"
                            accept=".pdf" required>
                    </div>
                    <button type="submit" class="btn-base btn-verde">Publicar contenido</button>
                </div>
            </form>
        </section>

        <section class="publicarGrid">
            <article class="publicarCard">
                <h2>Mis publicaciones</h2>
                <form action="{{ route('usuario.publicar') }}" method="GET" class="publicarMiniForm">
                    <label for="buscar">Buscar en mis publicaciones</label>
                    <input type="text" id="buscar" name="buscar" value="{{ $buscarPublicacion }}"
                        placeholder="Título, libro o resumen">
                    <button type="submit" class="btn-base btn-azul">Buscar</button>
                </form>

                <div class="publicacionesListado">
                    @forelse($misPublicaciones as $publicacion)
                        <article class="publicacionItem">
                            <h3>{{ $publicacion->titulo_publicacion }}</h3>
                            <p><strong>Libro:</strong> {{ $publicacion->nombre_libro }}</p>
                            <p><strong>Formato:</strong> {{ strtoupper($publicacion->archivo_extension) }}</p>
                            <p><strong>Fecha:</strong> {{ $publicacion->fecha_publicacion?->format('d/m/Y') ?? 'N/A' }}</p>
                            <a href="{{ route('usuario.publicar.archivo', $publicacion->id) }}" class="btn-base btn-verde">Ver archivo</a>
                        </article>
                    @empty
                        <p>No tienes publicaciones registradas.</p>
                    @endforelse
                </div>

                <div class="publicacionesPaginacion">
                    {{ $misPublicaciones->links('vendor.pagination.bootstrap-5') }}
                </div>
            </article>

            <article class="publicarCard">
                <h2>Contenido reciente de la comunidad</h2>
                <p>Estos archivos ya están visibles para otros usuarios autenticados de la plataforma.</p>

                <div class="publicacionesListado">
                    @forelse($publicacionesRecientes as $publicacion)
                        <article class="publicacionItem">
                            <h3>{{ $publicacion->titulo_publicacion }}</h3>
                            <p><strong>Libro:</strong> {{ $publicacion->nombre_libro }}</p>
                            <p><strong>Autor:</strong> {{ $publicacion->usuario?->name ?? 'Usuario biblioteca' }}</p>
                            <a href="{{ route('usuario.publicar.archivo', $publicacion->id) }}" class="btn-base btn-verde">Ver archivo</a>
                        </article>
                    @empty
                        <p>Todavía no hay contenido publicado por usuarios.</p>
                    @endforelse
                </div>
            </article>

            <article class="publicarCard publicarCardMantenimiento">
                <h2>Compra de contenido digital</h2>
                <p>Esta funcionalidad está en mantenimiento. Próximamente habilitaremos opciones de compra en la biblioteca.</p>
                <div class="estadoMantenimientoPublicar">Mantenimiento</div>
            </article>
        </section>
    </main>

@endsection