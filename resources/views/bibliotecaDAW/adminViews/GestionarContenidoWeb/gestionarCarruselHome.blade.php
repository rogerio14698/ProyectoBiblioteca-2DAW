@extends('layouts.admin')

@section('title', 'Gestionar eventos')

@section('content')
<div class="a-vista-admin">
    <header class="a-titulo"><div><h1>Gestionar eventos</h1><p class="a-subtitulo">Actualiza las actividades publicadas en el carrusel de la biblioteca.</p></div></header>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>{{ $eventoEditar ? 'Editar evento' : 'Crear evento' }}</h2></div></header>
<form class="a-form"
                    action="{{ $eventoEditar ? route('admin.updateCarrusel', $eventoEditar->id) : route('admin.agregarCarrusel') }}"
                    method="POST" enctype="multipart/form-data" class="a-form">
                    @csrf
                    @if ($eventoEditar)
                        @method('PUT')
                    @endif

                    <div class="a-form__fila a-form__fila--3">
<div class="a-campo">
                        <label for="titulo">Título del evento:</label>
                        <input type="text" placeholder="Título de evento" id="titulo" name="titulo"
                            value="{{ old('titulo', $eventoEditar->titulo ?? '') }}" required>
                    </div>
                    <div class="a-campo">
                        <label for="descripcion">Descripción del evento:</label>
                        <textarea id="descripcion" name="descripcion" required>{{ old('descripcion', $eventoEditar->descripcion ?? '') }}</textarea>
                    </div>
                    <div class="a-campo">
                        <label for="imagen">Imagen del evento:</label>
                        <input type="file" id="imagen" name="imagen">
                    </div>
                    <div class="a-campo">
                        <label for="fecha_hora">Fecha y hora del evento:</label>
                        <input type="datetime-local" id="fecha_hora" name="fecha_hora"
                            value="{{ old('fecha_hora', isset($eventoEditar->fecha_hora) ? \Illuminate\Support\Carbon::parse($eventoEditar->fecha_hora)->format('Y-m-d\TH:i') : '') }}"
                            required>
                    </div>
                    <div class="a-campo">
                        <label for="ubicacion">Ubicación del evento:</label>
                        <input type="text" id="ubicacion" name="ubicacion"
                            value="{{ old('ubicacion', $eventoEditar->ubicacion ?? '') }}" required>
                    </div>
                    <div class="a-campo"><label for="precio">Precio de entrada (€):</label><input type="number" id="precio" name="precio" min="0" step="0.01" value="{{ old('precio', $eventoEditar->precio ?? 0) }}"></div>
                    <div class="a-campo">
                        <label for="prioridad">Prioridad del evento:</label>
                        <select id="prioridad" name="prioridad">
                            @php $prioridadSeleccionada = old('prioridad', $eventoEditar->prioridad ?? 1); @endphp
                            <option value="1" {{ (int) $prioridadSeleccionada === 1 ? 'selected' : '' }}>Baja</option>
                            <option value="2" {{ (int) $prioridadSeleccionada === 2 ? 'selected' : '' }}>Media</option>
                            <option value="3" {{ (int) $prioridadSeleccionada === 3 ? 'selected' : '' }}>Alta</option>
                        </select>
                    </div>

</div>
<div class="a-form__acciones"><button type="submit" class="a-boton a-boton--primario">{{ $eventoEditar ? 'Actualizar evento' : 'Guardar evento' }}</button>

</div>
</form>
</section>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Eventos publicados</h2></div></header>
<div class="a-tabla-envoltura" tabindex="0" role="region" aria-label="Tabla: Evento"><table class="a-tabla a-tabla--gestion"><thead>
<tr><th scope="col">Evento</th>
    <th scope="col">Descripción</th>
    <th scope="col">Fecha y hora</th>
    <th scope="col">Ubicación</th>
    <th scope="col">Autor</th>
    <th scope="col">Prioridad</th>
    <th scope="col" class="a-num">Precio</th>
    <th scope="col">Acciones</th></tr></thead><tbody>
@forelse ($eventos as $evento)<tr><td><div class="a-tabla__identidad">@if ($evento->imagen_url)@php $urlImagen = \Illuminate\Support\Str::startsWith($evento->imagen_url, ['http://', 'https://']) ? $evento->imagen_url : asset('storage/' . $evento->imagen_url); @endphp<img class="a-miniatura a-miniatura--ancha" src="{{ $urlImagen }}" alt="" loading="lazy">@endif<strong>{{ $evento->titulo }}</strong></div></td>
    <td class="a-texto-tabla"><div>{{ $evento->descripcion }}</div></td>
    <td class="a-fecha">{{ \Illuminate\Support\Carbon::parse($evento->fecha_hora)->format('d/m/Y H:i') }}</td>
    <td>{{ $evento->ubicacion }}</td>
    <td>{{ $evento->usuario->name ?? 'Sin autor' }}</td>
    <td><span class="a-pill {{ $evento->prioridad == 3 ? 'a-pill--aviso' : 'a-pill--neutro' }}">{{ $evento->prioridad == 3 ? 'Alta' : ($evento->prioridad == 2 ? 'Media' : 'Baja') }}</span></td>
    <td class="a-num">{{ number_format($evento->precio ?? 0, 2, ',', '.') }} €</td>
    <td><div class="a-acciones-fila">
                                <a href="{{ route('admin.gestionCarrusel', ['edit' => $evento->id]) }}" class="a-boton btnEditarEvento">Editar</a>
                                <form class="a-form" action="{{ route('admin.deleteCarrusel', $evento->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="a-boton btnEliminarEvento a-boton--peligro">Eliminar</button>
                                </form>
                            </div></td></tr>
@empty<tr><td colspan="8"><p class="a-vacio">No hay eventos disponibles todavía.</p></td></tr>
@endforelse
</tbody></table></div>
</section>
</div>
@endsection
