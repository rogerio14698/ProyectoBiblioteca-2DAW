@extends('layouts.admin')

@section('title', 'Portada')

@section('content')
<div class="a-vista-admin">
    <header class="a-titulo"><div><h1>Portada</h1><p class="a-subtitulo">Organiza las diapositivas de bienvenida de la página principal.</p></div></header>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>{{ $slideEditar ? 'Editar diapositiva' : 'Crear diapositiva' }}</h2></div></header>
<form class="a-form" action="{{ $slideEditar ? route('admin.slide.update', $slideEditar->id) : route('admin.slide.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @if ($slideEditar)
                            @method('PUT')
                        @endif
                        <div class="a-form__fila a-form__fila--3">
<div class="a-campo">
                            <label for="titulo">Título de la diapositiva:</label>
                            <input type="text" placeholder="Titulo Slide" id="titulo" name="titulo"
                                value="{{ old('titulo', $slideEditar->titulo ?? '') }}" required>
                        </div>
                        <div class="a-campo">
                            <label for="descripcion">Descripción de la diapositiva:</label>
                            <textarea id="descripcion" name="descripcion" required>{{ old('descripcion', $slideEditar->descripcion ?? '') }}</textarea>
                        </div>
                        <div class="a-campo">
                            <label for="imagen">Imagen de la diapositiva:</label>
                            <input type="file" id="imagen" name="imagen" accept="image/*" {{ $slideEditar ? '' : 'required' }}>
                            <small class="a-campo__ayuda">
                                Dimensión recomendada: <strong>680 × 420 px</strong> (horizontal).
                                La imagen se recortará automáticamente al centro si excede ese tamaño.
                            </small>
                        </div>
                        <div class="a-campo">
                            <label for="posicion">Posición del slide:</label>
                            <input type="number" id="posicion" name="posicion" min="1"
                                value="{{ old('posicion', $slideEditar->posicion ?? '') }}">
                        </div>
                        <div class="a-campo">
                            <label for="url">URL del botón del slide:</label>
                            <input type="url" id="url" name="url" placeholder="https://ejemplo.com"
                                value="{{ old('url', $slideEditar->url ?? '') }}">
                        </div>
                        <div class="a-campo">
                            <label>Orden actual de los slides</label>
                            <ul>
                                @forelse ($slidesBienvenida as $slideOrden)
                                    <li>Posición {{ $slideOrden->posicion ?? 'Sin asignar' }}: {{ $slideOrden->titulo }}</li>
                                @empty
                                    <li>No hay slides creados todavía.</li>
                                @endforelse
                            </ul>
                            <p>El sistema mostrará los slides ordenados de menor a mayor posición.</p>
                        </div>

</div>
<div class="a-form__acciones"><button type="submit" class="a-boton a-boton--primario">{{ $slideEditar ? 'Actualizar diapositiva' : 'Guardar diapositiva' }}</button>

</div>
</form>
</section>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Diapositivas de bienvenida</h2></div></header>
<div class="a-tabla-envoltura" tabindex="0" role="region" aria-label="Tabla: Posición"><table class="a-tabla a-tabla--gestion"><thead>
<tr><th scope="col" class="a-num">Posición</th>
    <th scope="col">Diapositiva</th>
    <th scope="col">Descripción</th>
    <th scope="col">Enlace</th>
    <th scope="col">Creada</th>
    <th scope="col">Acciones</th></tr></thead><tbody>
@forelse ($slidesBienvenida as $slide)<tr><td class="a-num">{{ $slide->posicion ?? '—' }}</td>
    <td><div class="a-tabla__identidad">@if ($slide->imagen)<img class="a-miniatura a-miniatura--ancha" src="{{ \Illuminate\Support\Str::startsWith($slide->imagen, ['http://', 'https://']) ? $slide->imagen : asset($slide->imagen) }}" alt="" loading="lazy">@endif<strong>{{ $slide->titulo }}</strong></div></td>
    <td class="a-texto-tabla"><div>{{ $slide->descripcion }}</div></td>
    <td>@if ($slide->url)<a class="a-boton a-boton--pequeno" href="{{ $slide->url }}" target="_blank" rel="noopener noreferrer">Ver enlace</a>@else<span class="a-muted">Sin enlace</span>@endif</td>
    <td class="a-fecha">{{ $slide->created_at?->format('d/m/Y H:i') }}</td>
    <td><div class="a-acciones-fila">
                                    <a href="{{ route('admin.gestionHome', ['edit' => $slide->id]) }}" class="a-boton btnEditarSlide">Editar</a>
                                    <form class="a-form" action="{{ route('admin.slide.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este slide?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="a-boton btnEliminarSlide a-boton--peligro">Eliminar</button>
                                    </form>
                                </div></td></tr>
@empty<tr><td colspan="6"><p class="a-vacio">No hay diapositivas de bienvenida registradas.</p></td></tr>
@endforelse
</tbody></table></div>
</section>
</div>
@endsection
