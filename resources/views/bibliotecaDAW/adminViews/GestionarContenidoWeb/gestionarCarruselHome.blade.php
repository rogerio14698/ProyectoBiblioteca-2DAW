@extends('layouts.app')

@section('title', 'Carrusel Home')

@section('content')



    <div class="contenedor gestionCarruselHome">
        <h2>Gestión de Eventos</h2>
        <p>Rellena el formulario del carrusel de la ventana principal</p>

        <!--Layout 2 columnas: formulario izquierda, listado derecha -->
        <div class="eventosLayout">

            <!--Columna izquierda: formulario de creación/edición -->
            <div class="eventosFormulario">
                <h3>{{ $eventoEditar ? 'Editar Evento' : 'Crear Evento' }}</h3>
                <form
                    action="{{ $eventoEditar ? route('admin.updateCarrusel', $eventoEditar->id) : route('admin.agregarCarrusel') }}"
                    method="POST" enctype="multipart/form-data" class="gestionFormularioCarrusel">
                    @csrf
                    @if ($eventoEditar)
                        @method('PUT')
                    @endif

                    <div class="gestionGrupoFormulario">
                        <label for="titulo">Título del Evento:</label>
                        <input type="text" placeholder="Titulo Evento" id="titulo" name="titulo"
                            value="{{ old('titulo', $eventoEditar->titulo ?? '') }}" required>
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="descripcion">Descripción del Evento:</label>
                        <textarea id="descripcion" name="descripcion" required>{{ old('descripcion', $eventoEditar->descripcion ?? '') }}</textarea>
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="imagen">Imagen del Evento:</label>
                        <input type="file" id="imagen" name="imagen">
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="fecha_hora">Fecha y Hora del Evento:</label>
                        <input type="datetime-local" id="fecha_hora" name="fecha_hora"
                            value="{{ old('fecha_hora', isset($eventoEditar->fecha_hora) ? \Illuminate\Support\Carbon::parse($eventoEditar->fecha_hora)->format('Y-m-d\TH:i') : '') }}"
                            required>
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="ubicacion">Ubicación del Evento:</label>
                        <input type="text" id="ubicacion" name="ubicacion"
                            value="{{ old('ubicacion', $eventoEditar->ubicacion ?? '') }}" required>
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="prioridad">Prioridad del Evento:</label>
                        <select id="prioridad" name="prioridad">
                            @php $prioridadSeleccionada = old('prioridad', $eventoEditar->prioridad ?? 1); @endphp
                            <option value="1" {{ (int) $prioridadSeleccionada === 1 ? 'selected' : '' }}>Baja</option>
                            <option value="2" {{ (int) $prioridadSeleccionada === 2 ? 'selected' : '' }}>Media</option>
                            <option value="3" {{ (int) $prioridadSeleccionada === 3 ? 'selected' : '' }}>Alta</option>
                        </select>
                    </div>
                    <button type="submit" class="gestionBotonEnvio">{{ $eventoEditar ? 'Actualizar evento' : 'Guardar Evento' }}</button>
                </form>
            </div>

            <!--Columna derecha: listado de eventos en formato tarjeta -->
            <div class="eventosListado">
                <h3>Listado de eventos</h3>
                <div class="eventosListadoCards">
                    @forelse ($eventos as $evento)
                        <div class="eventoCard">
                            <!--Imagen del evento -->
                            <div class="eventoCardImagen">
                                @if ($evento->imagen_url)
                                    <img src="{{ asset('storage/' . $evento->imagen_url) }}" alt="Imagen de {{ $evento->titulo }}">
                                @else
                                    <span class="eventoCardSinImagen">Sin imagen</span>
                                @endif
                            </div>
                            <!--Datos del evento -->
                            <div class="eventoCardInfo">
                                <div class="eventoCardCabecera">
                                    <h4 class="eventoCardTitulo">{{ $evento->titulo }}</h4>
                                    <span class="eventoCardPrioridad eventoCardPrioridad--{{ $evento->prioridad }}">
                                        {{ $evento->prioridad == 3 ? 'Alta' : ($evento->prioridad == 2 ? 'Media' : 'Baja') }}
                                    </span>
                                </div>
                                <p class="eventoCardDescripcion">{{ $evento->descripcion }}</p>
                                <div class="eventoCardMeta">
                                    <span>📅 {{ \Illuminate\Support\Carbon::parse($evento->fecha_hora)->format('d/m/Y H:i') }}</span>
                                    <span>📍 {{ $evento->ubicacion }}</span>
                                    <span>👤 {{ $evento->usuario->name ?? 'Sin autor' }}</span>
                                </div>
                            </div>
                            <!--Acciones del evento -->
                            <div class="eventoCardAcciones">
                                <a href="{{ route('admin.gestionCarrusel', ['edit' => $evento->id]) }}" class="btn-base btnEditarEvento">Editar</a>
                                <form action="{{ route('admin.deleteCarrusel', $evento->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-base btnEliminarEvento">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="eventoCardVacio">No hay eventos disponibles todavía.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>


@endsection
