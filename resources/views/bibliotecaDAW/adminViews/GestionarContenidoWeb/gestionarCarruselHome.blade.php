@extends('layouts.app')

@section('title', 'Carrusel Home')

@section('content')



    <div class="contenedor gestionCarruselHome">
        <h2>Editar Carrusel de Eventos y añadir eventos en general</h2>
        <p>Rellena el formulario del carrusel de la ventana principal</p>

        {{-- Cambio aplicado: enviar el formulario a la ruta POST que guarda el evento --}}
        {{-- La Gracia de estos forms que son reutilizables para crear y editar --}}
        <form
            action="{{ $eventoEditar ? route('admin.updateCarrusel', $eventoEditar->id) : route('admin.agregarCarrusel') }}"
            method="POST" enctype="multipart/form-data" class="gestionFormularioCarrusel">
            @csrf
            {{-- Ver que hace esto method put --}}
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
                {{-- Importante: los input file no deben llevar value en HTML por seguridad del navegador --}}
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
                    {{-- Guardamos la prioridad seleccionada para no repetir lógica en cada opción --}}
                    @php $prioridadSeleccionada = old('prioridad', $eventoEditar->prioridad ?? 1); @endphp
                    <option value="1" {{ (int) $prioridadSeleccionada === 1 ? 'selected' : '' }}>Baja</option>
                    <option value="2" {{ (int) $prioridadSeleccionada === 2 ? 'selected' : '' }}>Media</option>
                    <option value="3" {{ (int) $prioridadSeleccionada === 3 ? 'selected' : '' }}>Alta</option>
                </select>
            </div>
            <button type="submit" class="gestionBotonEnvio">{{ $eventoEditar ? 'Actualizar evento' : 'Guardar Evento' }}</button>
        </form>

        <h2>Listado de las pestañas del carrusel</h2>
        <p>Aqui se mostraria un listado de las pestañas del carrusel con la opcion de editarlas o eliminarlas</p>
        <div class="gestionTablaBloqueador">
            <table class="gestionTablaEventos">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Nombre autor</th>
                        <th>Fecha y hora</th>
                        <th>Ubicación</th>
                        <th>Fecha Creacion</th>
                        <th>Prioridad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($eventos as $evento)
                        <tr>
                            <td>{{ $evento->titulo }}</td>
                            <td>{{ $evento->descripcion }}</td>
                            <td><img src="{{ asset('storage/' . $evento->imagen) }}" alt="Imagen del Evento" width="100">
                            </td>
                            <td>{{ $evento->usuario->name ?? 'Sin autor' }}</td>
                            <td>{{ $evento->fecha_hora }}</td>
                            <td>{{ $evento->ubicacion }}</td>
                            <td>{{ $evento->created_at }}</td>
                            <td>{{ $evento->prioridad }}</td>
                            <!-- Aquí puedes agregar botones para editar o eliminar el evento -->
                            <td>
                                <a href="{{ route('admin.gestionCarrusel', ['edit' => $evento->id]) }}"
                                    class="gestionBotonEditar">Editar</a>
                                <form action="{{ route('admin.deleteCarrusel', $evento->id) }}" method="POST"
                                    style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="gestionBotonEliminar">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="gestionFilaVacia">
                            <td colspan="9">No hay eventos disponibles todavía.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


@endsection
