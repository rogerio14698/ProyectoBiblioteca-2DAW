@extends('layouts.app')

@section('title', 'Gestionar Publicaciones')

@section('content')
    <main class="contenedor gestionPublicacionesPage">
        <header class="publicacionesEncabezado">
            <h1>Gestionar Publicaciones</h1>
            <p>Gestiona publicaciones de usuarios escritores y del administrador. Solo se admiten archivos en formato PDF.</p>
        </header>

        @if (session('success'))
            <div class="alertaExito">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alertaError">{{ session('error') }}</div>
        @endif

        <section class="publicacionesResumen" aria-label="Resumen de publicaciones">
            <article class="publicacionResumenCard">
                <h3>Total publicaciones</h3>
                <p>{{ $resumen['total'] }}</p>
            </article>
            <article class="publicacionResumenCard">
                <h3>Publicadas por usuarios</h3>
                <p>{{ $resumen['usuarios'] }}</p>
            </article>
            <article class="publicacionResumenCard">
                <h3>Publicadas por admin</h3>
                <p>{{ $resumen['admin'] }}</p>
            </article>
            <article class="publicacionResumenCard">
                <h3>Autores profesionales</h3>
                <p>{{ $resumen['profesional'] }}</p>
            </article>
            <article class="publicacionResumenCard">
                <h3>Autores por afición</h3>
                <p>{{ $resumen['aficion'] }}</p>
            </article>
        </section>

        <section class="publicacionesLayout">
            <aside class="publicacionesFormPanel">
                <form action="{{ route('admin.publicacionesUser.store') }}" method="POST" enctype="multipart/form-data" class="publicacionesForm">
                    @csrf
                    <h2>Nueva Publicación</h2>

                    <div class="publicacionesCampo">
                        <label for="publicado_por">Tipo de publicación</label>
                        <select id="publicado_por" name="publicado_por" required>
                            <option value="usuario" {{ old('publicado_por', 'usuario') === 'usuario' ? 'selected' : '' }}>Publicar como Usuario Escritor</option>
                            <option value="admin" {{ old('publicado_por') === 'admin' ? 'selected' : '' }}>Publicar como Administrador</option>
                        </select>
                    </div>

                    <div class="publicacionesCampo">
                        <label for="usuario_id">Usuario escritor verificado</label>
                        <select id="usuario_id" name="usuario_id">
                            <option value="">Seleccionar usuario...</option>
                            @foreach ($usuariosEscritores as $usuario)
                                <option value="{{ $usuario->id }}" {{ (string) old('usuario_id') === (string) $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }} ({{ $usuario->nSocio }}) - {{ ucfirst($usuario->tipo_escritor) }}
                                </option>
                            @endforeach
                        </select>
                        <p class="publicacionesHint">Este campo es obligatorio cuando se publica como usuario.</p>
                        @error('usuario_id')
                            <span class="errorCampo">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="publicacionesCampo">
                        <label for="nombre_libro">Libro o ensayo asociado</label>
                        <input type="text" id="nombre_libro" name="nombre_libro" value="{{ old('nombre_libro') }}" placeholder="Ej: Don Quijote, Ensayo sobre la ceguera..." required>
                        <p class="publicacionesHint">Escribe el nombre del libro o ensayo. Puede ser externo a la biblioteca.</p>
                        @error('nombre_libro')
                            <span class="errorCampo">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="publicacionesCampo">
                        <label for="titulo_publicacion">Título de la publicación</label>
                        <input type="text" id="titulo_publicacion" name="titulo_publicacion" value="{{ old('titulo_publicacion') }}" required>
                        @error('titulo_publicacion')
                            <span class="errorCampo">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="publicacionesCampo">
                        <label for="resumen_publicacion">Resumen de lo publicado</label>
                        <textarea id="resumen_publicacion" name="resumen_publicacion" required>{{ old('resumen_publicacion') }}</textarea>
                        @error('resumen_publicacion')
                            <span class="errorCampo">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="publicacionesCampo">
                        <label for="archivo_publicacion">Archivo de publicación</label>
                        <input type="file" id="archivo_publicacion" name="archivo_publicacion" accept=".pdf" required>
                        <p class="publicacionesHint">No se permite publicar texto plano en web. Máximo 10MB.</p>
                        @error('archivo_publicacion')
                            <span class="errorCampo">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-base btn-verde">Guardar publicación</button>
                </form>
            </aside>

            <article class="publicacionesListadoPanel">
                <h2>Listado de Publicaciones por Usuario y Admin</h2>

                @php
                    $agrupadas = $publicaciones->groupBy(function ($publicacion) {
                        if ($publicacion->publicado_por === 'admin') {
                            return 'admin_' . ($publicacion->admin_id ?? 'sin_admin');
                        }

                        return 'usuario_' . ($publicacion->usuario_id ?? 'sin_usuario');
                    });
                @endphp

                @forelse ($agrupadas as $claveGrupo => $itemsGrupo)
                    @php
                        $primera = $itemsGrupo->first();
                    @endphp

                    <section class="publicacionesGrupoUsuario">
                        <header class="publicacionesGrupoHead">
                            @if ($primera->publicado_por === 'admin')
                                <h3>Administrador: {{ $primera->admin->name ?? 'Administrador no disponible' }}</h3>
                                <p>Publicaciones institucionales</p>
                            @else
                                <h3>Usuario: {{ $primera->usuario->name ?? 'Usuario no disponible' }}</h3>
                                <p>
                                    Nº socio: {{ $primera->usuario->nSocio ?? 'Sin dato' }} |
                                    Tipo escritor: {{ ucfirst($primera->usuario->tipo_escritor ?? 'No definido') }}
                                </p>
                            @endif
                        </header>

                        <div class="publicacionesCards">
                            @foreach ($itemsGrupo as $publicacion)
                                <article class="publicacionCard">
                                    <header class="publicacionCardHead">
                                        <h4>{{ $publicacion->titulo_publicacion }}</h4>
                                        @if ($publicacion->publicado_por === 'admin')
                                            <span class="publicacionesBadge publicacionesBadge--admin">Admin</span>
                                        @elseif (($publicacion->usuario->tipo_escritor ?? null) === 'profesional')
                                            <span class="publicacionesBadge publicacionesBadge--profesional">Profesional</span>
                                        @else
                                            <span class="publicacionesBadge publicacionesBadge--aficion">Afición</span>
                                        @endif
                                    </header>


                                    <div class="publicacionCardBody">
                                        <p class="publicacionCardLibro">
                                            <strong>Libro/Ensayo:</strong> {{ $publicacion->nombre_libro }}
                                        </p>
                                        <p class="publicacionCardResumen">{{ $publicacion->resumen_publicacion }}</p>
                                    </div>

                                    <footer class="publicacionCardFooter">
                                        <span class="publicacionCardFecha">
                                            {{ optional($publicacion->fecha_publicacion)->format('d/m/Y H:i') }}
                                        </span>
                                        <a href="{{ asset('storage/' . $publicacion->archivo_ruta) }}" target="_blank" rel="noopener" class="publicacionCardArchivo">
                                            {{ $publicacion->archivo_original }}
                                        </a>
                                    </footer>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @empty
                    <p class="publicacionesVacio">Todavía no hay publicaciones registradas.</p>
                @endforelse
            </article>
        </section>
    </main>
@endsection
