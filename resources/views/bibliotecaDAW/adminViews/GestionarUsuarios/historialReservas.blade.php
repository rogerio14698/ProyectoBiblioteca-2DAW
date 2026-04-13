@extends('layouts.app')

@section('title', 'Historial de Reservas')

@section('content')
    <!-- Contenedor principal de la página de historial de reservas -->
    <main class="contenedor gestionReservas">

        <!-- Encabezado con título y navegación entre vistas -->
        <div class="reservasEncabezado">
            <div>
                <h1>Historial de Reservas</h1>
                <p>Gestiona todos los préstamos de libros de la Biblioteca DAW.</p>
            </div>
            <div class="reservasNav">
                <a href="{{ route('admin.reservasActivas') }}" class="btn-base btn-primario">Ver Reservas Activas</a>
            </div>
        </div>

        <!-- Mensajes flash de éxito o error -->
        @if (session('success'))
            <div class="alertaExito">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alertaError">{{ session('error') }}</div>
        @endif

        <!-- ========== BUSCADOR / FILTROS ========== -->
        <form action="{{ route('admin.historialReservas') }}" method="GET" class="reservasBuscador">
            <h2>Filtrar Reservas</h2>
            <div class="reservasFiltros">
                <!-- Filtro por estado -->
                <div class="reservasGrupoFiltro">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado">
                        <option value="">Todos</option>
                        <option value="activa" {{ request('estado') === 'activa' ? 'selected' : '' }}>Activa</option>
                        <option value="devuelta" {{ request('estado') === 'devuelta' ? 'selected' : '' }}>Devuelta</option>
                        <option value="vencida" {{ request('estado') === 'vencida' ? 'selected' : '' }}>Vencida</option>
                        <option value="cancelada" {{ request('estado') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
                <!-- Filtro por usuario -->
                <div class="reservasGrupoFiltro">
                    <label for="filtroUsuario">Usuario</label>
                    <input type="text" id="filtroUsuario" name="usuario" value="{{ request('usuario') }}" placeholder="Nombre del usuario">
                </div>
                <!-- Filtro por libro -->
                <div class="reservasGrupoFiltro">
                    <label for="filtroLibro">Libro</label>
                    <input type="text" id="filtroLibro" name="libro" value="{{ request('libro') }}" placeholder="Título del libro">
                </div>
            </div>
            <div class="reservasBotonesFiltro">
                <button class="btn-base btn-primario" type="submit">Filtrar</button>
                <a href="{{ route('admin.historialReservas') }}" class="btn-base btn-amarillo">Limpiar</a>
            </div>
        </form>

        <!-- ========== LAYOUT: FORMULARIO + LISTADO ========== -->
        <div class="reservasLayout">

            <!-- ========== COLUMNA IZQUIERDA: FORMULARIO ========== -->
            <div class="reservasFormulario">
                @if (isset($reservaEditar) && $reservaEditar)
                    <!-- Formulario de EDICIÓN -->
                    <form action="{{ route('admin.reservas.update', $reservaEditar->id) }}" method="POST" class="reservasFormInner">
                        @csrf
                        @method('PUT')
                        <h2>Editar Reserva #{{ $reservaEditar->id }}</h2>
                @else
                    <!-- Formulario de CREACIÓN -->
                    <form action="{{ route('admin.reservas.store') }}" method="POST" class="reservasFormInner">
                        @csrf
                        <h2>Nueva Reserva</h2>
                @endif

                    <!-- Campo: Usuario -->
                    <div class="reservasGrupoForm">
                        <label for="usuario_id">Usuario (Nombre o N. de socio)</label>
                        <input type="text" id="usuario_id" name="usuario_id" value="{{ old('usuario_id', $reservaEditar->usuario->name ?? '') }}" placeholder="Ej: Ana Pérez o 12345AB" required>
                        @error('usuario_id')
                            <span class="errorCampo">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo: Libro -->
                    <div class="reservasGrupoForm">
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

                    <!-- Campo: Fecha de reserva -->
                    <div class="reservasGrupoForm">
                        <label for="fecha_reserva">Fecha de Reserva</label>
                        <input type="date" id="fecha_reserva" name="fecha_reserva"
                            value="{{ old('fecha_reserva', isset($reservaEditar) && $reservaEditar->fecha_reserva ? $reservaEditar->fecha_reserva->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
                    </div>

                    <!-- Campo: Fecha devolución prevista -->
                    <div class="reservasGrupoForm">
                        <label for="fecha_devolucion_prevista">Devolución Prevista</label>
                        <input type="date" id="fecha_devolucion_prevista" name="fecha_devolucion_prevista"
                            value="{{ old('fecha_devolucion_prevista', isset($reservaEditar) && $reservaEditar->fecha_devolucion_prevista ? $reservaEditar->fecha_devolucion_prevista->format('Y-m-d') : '') }}" required>
                    </div>

                    <!-- Campos adicionales solo en modo edición -->
                    @if (isset($reservaEditar) && $reservaEditar)
                        <!-- Campo: Fecha devolución real -->
                        <div class="reservasGrupoForm">
                            <label for="fecha_devolucion_real">Devolución Real</label>
                            <input type="date" id="fecha_devolucion_real" name="fecha_devolucion_real"
                                value="{{ old('fecha_devolucion_real', $reservaEditar->fecha_devolucion_real ? $reservaEditar->fecha_devolucion_real->format('Y-m-d') : '') }}">
                        </div>

                        <!-- Campo: Estado -->
                        <div class="reservasGrupoForm">
                            <label for="estadoEdit">Estado</label>
                            <select id="estadoEdit" name="estado" required>
                                <option value="activa" {{ old('estado', $reservaEditar->estado) === 'activa' ? 'selected' : '' }}>Activa</option>
                                <option value="devuelta" {{ old('estado', $reservaEditar->estado) === 'devuelta' ? 'selected' : '' }}>Devuelta</option>
                                <option value="vencida" {{ old('estado', $reservaEditar->estado) === 'vencida' ? 'selected' : '' }}>Vencida</option>
                                <option value="cancelada" {{ old('estado', $reservaEditar->estado) === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </div>
                    @endif

                    <!-- Campo: Observaciones -->
                    <div class="reservasGrupoForm">
                        <label for="observaciones">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" rows="3"
                            placeholder="Notas opcionales...">{{ old('observaciones', $reservaEditar->observaciones ?? '') }}</textarea>
                    </div>

                    <!-- Botón de envío -->
                    <button class="reservasBotonEnvio" type="submit">
                        {{ isset($reservaEditar) && $reservaEditar ? 'Actualizar Reserva' : 'Crear Reserva' }}
                    </button>

                    @if (isset($reservaEditar) && $reservaEditar)
                        <a href="{{ route('admin.historialReservas') }}" class="btn-base btn-amarillo reservasBtnCancelar">Cancelar Edición</a>
                    @endif
                </form>
            </div>

            <!-- ========== COLUMNA DERECHA: LISTADO DE RESERVAS ========== -->
            <div class="reservasListado">
                <h2>Todas las Reservas ({{ $reservas->count() }})</h2>

                <div class="reservasListadoCards">
                    @forelse ($reservas as $reserva)
                        <!-- Tarjeta individual de reserva -->
                        <article class="reservaCard reservaCard--{{ $reserva->estado }}">
                            <div class="reservaCardInfo">
                                <!-- Cabecera: ID + estado -->
                                <div class="reservaCardCabecera">
                                    <span class="reservaCardId">#{{ $reserva->id }}</span>
                                    <span class="reservaCardEstado reservaCardEstado--{{ $reserva->estado }}">
                                        {{ ucfirst($reserva->estado) }}
                                    </span>
                                </div>

                                <!-- Libro y usuario -->
                                <h3 class="reservaCardTitulo">{{ $reserva->libro->titulo ?? 'Libro eliminado' }}</h3>
                                <p class="reservaCardUsuario">{{ $reserva->usuario->name ?? 'Usuario eliminado' }}
                                    @if ($reserva->usuario && $reserva->usuario->nSocio)
                                        <span class="reservaCardSocio">({{ $reserva->usuario->nSocio }})</span>
                                    @endif
                                </p>

                                <!-- Fechas -->
                                <div class="reservaCardMeta">
                                    <span class="reservaCardMetaItem">Reserva: {{ $reserva->fecha_reserva->format('d/m/Y') }}</span>
                                    <span class="reservaCardMetaItem">Límite: {{ $reserva->fecha_devolucion_prevista->format('d/m/Y') }}</span>
                                    @if ($reserva->fecha_devolucion_real)
                                        <span class="reservaCardMetaItem">Devuelto: {{ $reserva->fecha_devolucion_real->format('d/m/Y') }}</span>
                                    @endif
                                </div>

                                <!-- Observaciones si existen -->
                                @if ($reserva->observaciones)
                                    <p class="reservaCardObs">{{ $reserva->observaciones }}</p>
                                @endif
                            </div>

                            <!-- Acciones -->
                            <div class="reservaCardAcciones">
                                <!-- Editar -->
                                <a href="{{ route('admin.historialReservas', ['edit' => $reserva->id]) }}"
                                    class="btn-base btn-azul btnEditarReserva">Editar</a>

                                <!-- Marcar como devuelto (solo si está activa o vencida) -->
                                @if (in_array($reserva->estado, ['activa', 'vencida']))
                                    <form action="{{ route('admin.reservas.devolver', $reserva->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn-base btn-verde btnDevolverReserva" type="submit"
                                            onclick="return confirm('¿Marcar este libro como devuelto?')">
                                            Devolver
                                        </button>
                                    </form>
                                @endif

                                <!-- Eliminar -->
                                <form action="{{ route('admin.reservas.destroy', $reserva->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-base btn-rojo btnEliminarReserva" type="submit"
                                        onclick="return confirm('¿Eliminar esta reserva del historial?')">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <p class="reservaCardVacio">No se encontraron reservas con los filtros aplicados.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </main>
@endsection
