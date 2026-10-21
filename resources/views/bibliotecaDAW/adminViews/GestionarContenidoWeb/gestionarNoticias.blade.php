@extends('layouts.admin')

@section('title', 'Gestionar noticias')

@section('content')
<div class="a-vista-admin">
    <header class="a-titulo"><div><h1>Gestionar noticias</h1><p class="a-subtitulo">Publica novedades, avisos y noticias de la biblioteca.</p></div></header>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>{{ isset($noticiaEditar) && $noticiaEditar ? 'Editar noticia #' . $noticiaEditar->id : 'Nueva noticia' }}</h2></div></header>
@if (isset($noticiaEditar) && $noticiaEditar)
                    <form action="{{ route('admin.gestionNoticias.update', $noticiaEditar->id) }}" method="POST" class="a-form">
                        @csrf
                        @method('PUT')
                @else
                    <form action="{{ route('admin.gestionNoticias.store') }}" method="POST" class="a-form">
                        @csrf
                @endif

                    <div class="a-form__fila a-form__fila--3">
<div class="a-campo">
                        <label for="titulo">Título de la noticia</label>
                        <input type="text" id="titulo" name="titulo"
                            value="{{ old('titulo', $noticiaEditar->titulo ?? '') }}"
                            placeholder="Ej: Nueva sala de estudio" required>
                        @error('titulo')
                            <span class="a-campo__error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="a-campo">
                        <label for="contenido">Contenido</label>
                        <textarea id="contenido" name="contenido" rows="5"
                            placeholder="Escribe el contenido de la noticia..." required>{{ old('contenido', $noticiaEditar->contenido ?? '') }}</textarea>
                        @error('contenido')
                            <span class="a-campo__error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="a-campo">
                        <label for="autor">Autor</label>
                        <input type="text" id="autor" name="autor"
                            value="{{ old('autor', $noticiaEditar->autor ?? '') }}"
                            placeholder="Ej: Biblioteca DAW">
                    </div>

                    <div class="a-campo">
                        <label for="categoria">Categoría</label>
                        <select id="categoria" name="categoria">
                            <option value="">Seleccionar categoría</option>
                            <option value="general" {{ old('categoria', $noticiaEditar->categoria ?? '') === 'general' ? 'selected' : '' }}>General</option>
                            <option value="eventos" {{ old('categoria', $noticiaEditar->categoria ?? '') === 'eventos' ? 'selected' : '' }}>Eventos</option>
                            <option value="novedades" {{ old('categoria', $noticiaEditar->categoria ?? '') === 'novedades' ? 'selected' : '' }}>Novedades</option>
                            <option value="avisos" {{ old('categoria', $noticiaEditar->categoria ?? '') === 'avisos' ? 'selected' : '' }}>Avisos</option>
                        </select>
                    </div>

                    <div class="a-campo">
                        <label for="fecha_publicacion">Fecha de publicación</label>
                        <input type="date" id="fecha_publicacion" name="fecha_publicacion"
                            value="{{ old('fecha_publicacion', isset($noticiaEditar) && $noticiaEditar->fecha_publicacion ? $noticiaEditar->fecha_publicacion->format('Y-m-d') : '') }}"
                            required>
                    </div>

                    <div class="a-campo">
                        <label for="imagen_url">URL de imagen (opcional)</label>
                        <input type="url" id="imagen_url" name="imagen_url"
                            value="{{ old('imagen_url', $noticiaEditar->imagen_url ?? '') }}"
                            placeholder="https://ejemplo.com/imagen.jpg">
                    </div>

                    <div class="a-campo">
                        <label for="enlace_externo">Enlace externo (opcional)</label>
                        <input type="url" id="enlace_externo" name="enlace_externo"
                            value="{{ old('enlace_externo', $noticiaEditar->enlace_externo ?? '') }}"
                            placeholder="https://ejemplo.com">
                    </div>

                    <div class="a-casilla">
                        <input type="checkbox" id="destacado" name="destacado" value="1"
                            {{ old('destacado', isset($noticiaEditar) && $noticiaEditar->destacado ? '1' : '') ? 'checked' : '' }}>
                        <label for="destacado">Marcar como destacada</label>
                    </div>


</div>
<div class="a-form__acciones"><button class="a-boton a-boton--primario" type="submit">
                        {{ isset($noticiaEditar) && $noticiaEditar ? 'Actualizar noticia' : 'Guardar noticia' }}
                    </button>

                    @if (isset($noticiaEditar) && $noticiaEditar)
                        <a href="{{ route('admin.gestionNoticias') }}" class="a-boton a-boton--fantasma noticiasBtnCancelar">Cancelar edición</a>
                    @endif

</div>
</form>
</section>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Noticias ({{ $noticias->count() }})</h2></div></header>
<div class="a-tabla-envoltura" tabindex="0" role="region" aria-label="Tabla: Noticia"><table class="a-tabla a-tabla--gestion"><thead>
<tr><th scope="col">Noticia</th>
    <th scope="col">Contenido</th>
    <th scope="col">Categoría</th>
    <th scope="col">Destacada</th>
    <th scope="col">Autor</th>
    <th scope="col">Publicada</th>
    <th scope="col">Acciones</th></tr></thead><tbody>
@forelse ($noticias as $noticia)<tr><td><div class="a-tabla__identidad"><strong>{{ $noticia->titulo }}</strong></div></td>
    <td class="a-texto-tabla"><div>{{ $noticia->contenido }}</div></td>
    <td>{{ $noticia->categoria ? ucfirst($noticia->categoria) : '—' }}</td>
    <td>@if ($noticia->destacado)<span class="a-pill a-pill--aviso">Destacada</span>@else<span class="a-muted">No</span>@endif</td>
    <td>{{ $noticia->autor ?: '—' }}</td>
    <td class="a-fecha">{{ $noticia->fecha_publicacion?->format('d/m/Y') ?? '—' }}</td>
    <td><div class="a-acciones-fila">
                                <a href="{{ route('admin.gestionNoticias', ['edit' => $noticia->id]) }}"
                                    class="a-boton btnEditarNoticia">Editar</a>

                                <form class="a-form" action="{{ route('admin.gestionNoticias.destroy', $noticia->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="a-boton a-boton--peligro btnEliminarNoticia" type="submit"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta noticia?')">
                                        Eliminar
                                    </button>
                                </form>
                            </div></td></tr>
@empty<tr><td colspan="7"><p class="a-vacio">No hay noticias registradas. Crea la primera desde el formulario.</p></td></tr>
@endforelse
</tbody></table></div>
</section>
</div>
@endsection
