@extends('layouts.app')

@section('title', 'Gestionar Noticias')

@section('content')
    <!-- Contenedor principal de la página de gestión de noticias -->
    <main class="contenedor gestionarNoticias">

        <!-- Título principal de la sección -->
        <div class="noticiasEncabezado">
            <h1>Gestionar Noticias</h1>
            <p>Añadir noticias y ver todas las noticias existentes.</p>
        </div>

        <!-- Mensajes flash de éxito o error tras una operación CRUD -->
        @if (session('success'))
            <div class="alertaExito">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alertaError">{{ session('error') }}</div>
        @endif

        <!-- Layout de dos columnas: formulario (izquierda) + listado (derecha) -->
        <div class="noticiasLayout">

            <!-- ========== COLUMNA IZQUIERDA: FORMULARIO ========== -->
            <div class="noticiasFormulario">
                {{-- Si existe $noticiaEditar, el formulario envía PUT para actualizar --}}
                @if (isset($noticiaEditar) && $noticiaEditar)
                    <form action="{{ route('admin.gestionNoticias.update', $noticiaEditar->id) }}" method="POST" class="noticiasFormularioInner">
                        @csrf
                        @method('PUT')
                        <h2>Editar Noticia #{{ $noticiaEditar->id }}</h2>
                @else
                    {{-- Si no hay noticia en edición, el formulario envía POST para crear --}}
                    <form action="{{ route('admin.gestionNoticias.store') }}" method="POST" class="noticiasFormularioInner">
                        @csrf
                        <h2>Agregar Nueva Noticia</h2>
                @endif

                    <!-- Campo: Título de la noticia -->
                    <div class="noticiasGrupoFormulario">
                        <label for="titulo">Título de la Noticia</label>
                        <input type="text" id="titulo" name="titulo"
                            value="{{ old('titulo', $noticiaEditar->titulo ?? '') }}"
                            placeholder="Ej: Nueva sala de estudio" required>
                        @error('titulo')
                            <span class="noticiasError">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo: Contenido de la noticia -->
                    <div class="noticiasGrupoFormulario">
                        <label for="contenido">Contenido</label>
                        <textarea id="contenido" name="contenido" rows="5"
                            placeholder="Escribe el contenido de la noticia..." required>{{ old('contenido', $noticiaEditar->contenido ?? '') }}</textarea>
                        @error('contenido')
                            <span class="noticiasError">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo: Autor de la noticia -->
                    <div class="noticiasGrupoFormulario">
                        <label for="autor">Autor</label>
                        <input type="text" id="autor" name="autor"
                            value="{{ old('autor', $noticiaEditar->autor ?? '') }}"
                            placeholder="Ej: Biblioteca DAW">
                    </div>

                    <!-- Campo: Categoría de la noticia -->
                    <div class="noticiasGrupoFormulario">
                        <label for="categoria">Categoría</label>
                        <select id="categoria" name="categoria">
                            <option value="">Seleccionar categoría</option>
                            <option value="general" {{ old('categoria', $noticiaEditar->categoria ?? '') === 'general' ? 'selected' : '' }}>General</option>
                            <option value="eventos" {{ old('categoria', $noticiaEditar->categoria ?? '') === 'eventos' ? 'selected' : '' }}>Eventos</option>
                            <option value="novedades" {{ old('categoria', $noticiaEditar->categoria ?? '') === 'novedades' ? 'selected' : '' }}>Novedades</option>
                            <option value="avisos" {{ old('categoria', $noticiaEditar->categoria ?? '') === 'avisos' ? 'selected' : '' }}>Avisos</option>
                        </select>
                    </div>

                    <!-- Campo: Fecha de publicación -->
                    <div class="noticiasGrupoFormulario">
                        <label for="fecha_publicacion">Fecha de Publicación</label>
                        <input type="date" id="fecha_publicacion" name="fecha_publicacion"
                            value="{{ old('fecha_publicacion', isset($noticiaEditar) && $noticiaEditar->fecha_publicacion ? $noticiaEditar->fecha_publicacion->format('Y-m-d') : '') }}"
                            required>
                    </div>

                    <!-- Campo: URL de imagen (opcional) -->
                    <div class="noticiasGrupoFormulario">
                        <label for="imagen_url">URL de Imagen (opcional)</label>
                        <input type="url" id="imagen_url" name="imagen_url"
                            value="{{ old('imagen_url', $noticiaEditar->imagen_url ?? '') }}"
                            placeholder="https://ejemplo.com/imagen.jpg">
                    </div>

                    <!-- Campo: Enlace externo (opcional) -->
                    <div class="noticiasGrupoFormulario">
                        <label for="enlace_externo">Enlace Externo (opcional)</label>
                        <input type="url" id="enlace_externo" name="enlace_externo"
                            value="{{ old('enlace_externo', $noticiaEditar->enlace_externo ?? '') }}"
                            placeholder="https://ejemplo.com">
                    </div>

                    <!-- Campo: Destacado (checkbox) -->
                    <div class="noticiasGrupoFormularioCheck">
                        <input type="checkbox" id="destacado" name="destacado" value="1"
                            {{ old('destacado', isset($noticiaEditar) && $noticiaEditar->destacado ? '1' : '') ? 'checked' : '' }}>
                        <label for="destacado">Marcar como destacada</label>
                    </div>

                    <!-- Botón de envío del formulario -->
                    <button class="noticiasBotonEnvio" type="submit">
                        {{ isset($noticiaEditar) && $noticiaEditar ? 'Actualizar Noticia' : 'Guardar Noticia' }}
                    </button>

                    {{-- Si estamos editando, mostramos un enlace para cancelar la edición --}}
                    @if (isset($noticiaEditar) && $noticiaEditar)
                        <a href="{{ route('admin.gestionNoticias') }}" class="btn-base btn-amarillo noticiasBtnCancelar">Cancelar Edición</a>
                    @endif
                </form>
            </div>

            <!-- ========== COLUMNA DERECHA: LISTADO DE NOTICIAS ========== -->
            <div class="noticiasListado">
                <h2>Listado de Noticias ({{ $noticias->count() }})</h2>

                <!-- Contenedor con scroll para las tarjetas de noticias -->
                <div class="noticiasListadoCards">

                    @forelse ($noticias as $noticia)
                        <!-- Tarjeta individual de noticia -->
                        <article class="noticiaCard">
                            <div class="noticiaCardInfo">
                                <!-- Cabecera: categoría + badge destacado -->
                                <div class="noticiaCardCabecera">
                                    @if ($noticia->categoria)
                                        <span class="noticiaCardCategoria noticiaCardCategoria--{{ $noticia->categoria }}">
                                            {{ ucfirst($noticia->categoria) }}
                                        </span>
                                    @endif
                                    @if ($noticia->destacado)
                                        <span class="noticiaCardDestacado">Destacada</span>
                                    @endif
                                </div>

                                <!-- Título de la noticia -->
                                <h3 class="noticiaCardTitulo">{{ $noticia->titulo }}</h3>

                                <!-- Contenido truncado a 2 líneas por CSS -->
                                <p class="noticiaCardContenido">{{ $noticia->contenido }}</p>

                                <!-- Metadatos: autor y fecha -->
                                <div class="noticiaCardMeta">
                                    @if ($noticia->autor)
                                        <span class="noticiaCardMetaItem">{{ $noticia->autor }}</span>
                                    @endif
                                    @if ($noticia->fecha_publicacion)
                                        <span class="noticiaCardMetaItem">{{ $noticia->fecha_publicacion->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Botones de acción: Editar y Eliminar -->
                            <div class="noticiaCardAcciones">
                                <!-- Enlace de edición: redirige a la misma vista con ?edit=ID -->
                                <a href="{{ route('admin.gestionNoticias', ['edit' => $noticia->id]) }}"
                                    class="btn-base btn-azul btnEditarNoticia">Editar</a>

                                <!-- Formulario de eliminación con confirmación JS -->
                                <form action="{{ route('admin.gestionNoticias.destroy', $noticia->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-base btn-rojo btnEliminarNoticia" type="submit"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta noticia?')">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <!-- Mensaje cuando no hay noticias en la base de datos -->
                        <p class="noticiaCardVacio">No hay noticias registradas. ¡Crea la primera desde el formulario!</p>
                    @endforelse

                </div>
            </div>

        </div>
    </main>
@endsection
