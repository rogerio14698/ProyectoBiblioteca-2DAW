@extends('layouts.admin')

@section('title', 'Historial de reservas')

@section('content')
<div class="a-vista-admin">
    <header class="a-titulo"><div><h1>Historial de reservas</h1><p class="a-subtitulo">Gestiona las reservas y sus devoluciones.</p></div><div class="a-titulo__acciones"><a href="{{ route('admin.reservasActivas') }}" class="a-boton">Ver reservas activas</a></div></header>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Filtrar reservas</h2></div></header>
<form action="{{ route('admin.historialReservas') }}" method="GET" class="a-form">
            <div class="a-form__fila a-form__fila--3">
                <div class="a-campo">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado">
                        <option value="">Todos</option>
                        <option value="activa" {{ request('estado') === 'activa' ? 'selected' : '' }}>Activa</option>
                        <option value="devuelta" {{ request('estado') === 'devuelta' ? 'selected' : '' }}>Devuelta</option>
                        <option value="vencida" {{ request('estado') === 'vencida' ? 'selected' : '' }}>Vencida</option>
                        <option value="cancelada" {{ request('estado') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
                <div class="a-campo">
                    <label for="filtroUsuario">Usuario</label>
                    <input type="text" id="filtroUsuario" name="usuario" value="{{ request('usuario') }}" placeholder="Nombre del usuario">
                </div>
                <div class="a-campo">
                    <label for="filtroLibro">Libro</label>
                    <input type="text" id="filtroLibro" name="libro" value="{{ request('libro') }}" placeholder="Título del libro">
                </div>
            </div>
            <div class="a-form__acciones">
                <button class="a-boton a-boton--primario" type="submit">Filtrar</button>
                <a href="{{ route('admin.historialReservas') }}" class="a-boton a-boton--fantasma">Limpiar</a>
            </div>
        </form>
</section>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>{{ isset($reservaEditar) && $reservaEditar ? 'Editar reserva #' . $reservaEditar->id : 'Nueva reserva' }}</h2></div></header>
@if (isset($reservaEditar) && $reservaEditar)
                    <form action="{{ route('admin.reservas.update', $reservaEditar->id) }}" method="POST" class="a-form">
                        @csrf
                        @method('PUT')
                @else
                    <form action="{{ route('admin.reservas.store') }}" method="POST" class="a-form">
                        @csrf
                @endif

                    <div class="a-form__fila a-form__fila--3">
<div class="a-campo">
                        <label for="usuario_id">Usuario (Nombre o N. de socio)</label>
                        <input type="text" id="usuario_id" name="usuario_id" value="{{ old('usuario_id', $reservaEditar->usuario->name ?? '') }}" placeholder="Ej: Ana Pérez o 12345AB" required>
                        @error('usuario_id')
                            <span class="a-campo__error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="a-campo">
                        <label for="libro_id">Libro</label>
                        <select id="libro_id" name="libro_id" required>
                            <option value="">Seleccionar libro</option>
                            @foreach ($libros as $libro)
                                <option value="{{ $libro->id }}"
                                    {{ old('libro_id', $reservaEditar->libro_id ?? '') == $libro->id ? 'selected' : '' }}>
                                    {{ $libro->titulo }} — {{ $libro->autor }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="a-campo">
                        <label for="fecha_reserva">Fecha de reserva</label>
                        <input type="date" id="fecha_reserva" name="fecha_reserva"
                            value="{{ old('fecha_reserva', isset($reservaEditar) && $reservaEditar->fecha_reserva ? $reservaEditar->fecha_reserva->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
                    </div>

                    <div class="a-campo">
                        <label for="fecha_devolucion_prevista">Devolución prevista</label>
                        <input type="date" id="fecha_devolucion_prevista" name="fecha_devolucion_prevista"
                            value="{{ old('fecha_devolucion_prevista', isset($reservaEditar) && $reservaEditar->fecha_devolucion_prevista ? $reservaEditar->fecha_devolucion_prevista->format('Y-m-d') : '') }}" required>
                    </div>

                    @if (isset($reservaEditar) && $reservaEditar)
                        <div class="a-campo">
                            <label for="fecha_devolucion_real">Devolución real</label>
                            <input type="date" id="fecha_devolucion_real" name="fecha_devolucion_real"
                                value="{{ old('fecha_devolucion_real', $reservaEditar->fecha_devolucion_real ? $reservaEditar->fecha_devolucion_real->format('Y-m-d') : '') }}">
                        </div>

                        <div class="a-campo">
                            <label for="estadoEdit">Estado</label>
                            <select id="estadoEdit" name="estado" required>
                                <option value="activa" {{ old('estado', $reservaEditar->estado) === 'activa' ? 'selected' : '' }}>Activa</option>
                                <option value="devuelta" {{ old('estado', $reservaEditar->estado) === 'devuelta' ? 'selected' : '' }}>Devuelta</option>
                                <option value="vencida" {{ old('estado', $reservaEditar->estado) === 'vencida' ? 'selected' : '' }}>Vencida</option>
                                <option value="cancelada" {{ old('estado', $reservaEditar->estado) === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </div>
                    @endif

                    <div class="a-campo">
                        <label for="observaciones">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" rows="3"
                            placeholder="Notas opcionales...">{{ old('observaciones', $reservaEditar->observaciones ?? '') }}</textarea>
                    </div>


</div>
<div class="a-form__acciones"><button class="a-boton a-boton--primario" type="submit">
                        {{ isset($reservaEditar) && $reservaEditar ? 'Actualizar reserva' : 'Crear reserva' }}
                    </button>

                    @if (isset($reservaEditar) && $reservaEditar)
                        <a href="{{ route('admin.historialReservas') }}" class="a-boton a-boton--fantasma reservasBtnCancelar">Cancelar edición</a>
                    @endif

</div>
</form>
</section>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Todas las reservas ({{ $reservas->count() }})</h2></div></header>
<div class="a-tabla-envoltura" tabindex="0" role="region" aria-label="Reservas"><table class="a-tabla a-tabla--gestion"><thead>
<tr><th scope="col" class="a-num">ID</th>
    <th scope="col">Libro</th>
    <th scope="col">Usuario</th>
    <th scope="col">Reserva</th>
    <th scope="col">Devolución prevista</th>
    <th scope="col">Devolución real</th>
    <th scope="col">Estado</th>
    <th scope="col">Observaciones</th>
    <th scope="col">Acciones</th></tr></thead><tbody>
@forelse ($reservas as $reserva)<tr><td class="a-num">{{ $reserva->id }}</td>
    <td><div class="a-tabla__identidad"><strong>{{ $reserva->libro->titulo ?? 'Libro eliminado' }}</strong></div></td>
    <td><div class="a-tabla__identidad"><div><strong>{{ $reserva->usuario->name ?? 'Usuario eliminado' }}</strong>@if ($reserva->usuario && $reserva->usuario->nSocio)<span>Socio {{ $reserva->usuario->nSocio }}</span>@endif</div></div></td>
    <td class="a-fecha">{{ $reserva->fecha_reserva->format('d/m/Y') }}</td>
    <td class="a-fecha">{{ $reserva->fecha_devolucion_prevista->format('d/m/Y') }}</td>
    <td class="a-fecha">{{ $reserva->fecha_devolucion_real?->format('d/m/Y') ?? '—' }}</td>
    <td><span class="a-pill {{ $reserva->estado === 'vencida' ? 'a-pill--negativo' : ($reserva->estado === 'devuelta' ? 'a-pill--positivo' : 'a-pill--aviso') }}">{{ ucfirst($reserva->estado) }}</span></td>
    <td class="a-texto-tabla"><div>{{ $reserva->observaciones ?: '—' }}</div></td>
    <td><div class="a-acciones-fila">
                                <a href="{{ route('admin.historialReservas', ['edit' => $reserva->id]) }}"
                                    class="a-boton btnEditarReserva">Editar</a>

                                @if (in_array($reserva->estado, ['activa', 'vencida']))
                                    <form class="a-form" action="{{ route('admin.reservas.devolver', $reserva->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="a-boton a-boton--primario btnDevolverReserva" type="submit"
                                            onclick="return confirm('¿Marcar este libro como devuelto?')">
                                            Devolver
                                        </button>
                                    </form>
                                @endif

                                <form class="a-form" action="{{ route('admin.reservas.destroy', $reserva->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="a-boton a-boton--peligro btnEliminarReserva" type="submit"
                                        onclick="return confirm('¿Eliminar esta reserva del historial?')">
                                        Eliminar
                                    </button>
                                </form>
                            </div></td></tr>
@empty<tr><td colspan="9"><p class="a-vacio">No se encontraron reservas con los filtros aplicados.</p></td></tr>
@endforelse
</tbody></table></div>
</section>
</div>
@endsection
