@extends('layouts.app')

@section('title', 'Reservas Activas')

@section('content')
    <!-- Contenedor principal de la página de reservas activas -->
    <main class="contenedor gestionReservas">

        <!-- Encabezado con título y navegación -->
        <div class="reservasEncabezado">
            <div>
                <h1>Reservas Activas</h1>
                <p>Préstamos pendientes de devolución (activos y vencidos).</p>
            </div>
            <div class="reservasNav">
                <a href="{{ route('admin.historialReservas') }}" class="btn-base btn-primario">Ver Historial Completo</a>
            </div>
        </div>

        <!-- Mensajes flash -->
        @if (session('success'))
            <div class="alertaExito">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alertaError">{{ session('error') }}</div>
        @endif

        <!-- Listado de reservas activas -->
        <div class="reservasListado">
            <h2>Préstamos Pendientes ({{ $reservas->count() }})</h2>

            <div class="reservasListadoCards">
                @forelse ($reservas as $reserva)
                    <article class="reservaCard reservaCard--{{ $reserva->estado }}">
                        <div class="reservaCardInfo">
                            <div class="reservaCardCabecera">
                                <span class="reservaCardId">#{{ $reserva->id }}</span>
                                <span class="reservaCardEstado reservaCardEstado--{{ $reserva->estado }}">
                                    {{ ucfirst($reserva->estado) }}
                                </span>
                            </div>

                            <h3 class="reservaCardTitulo">{{ $reserva->libro->titulo ?? 'Libro eliminado' }}</h3>
                            <p class="reservaCardUsuario">{{ $reserva->usuario->name ?? 'Usuario eliminado' }}
                                @if ($reserva->usuario && $reserva->usuario->nSocio)
                                    <span class="reservaCardSocio">({{ $reserva->usuario->nSocio }})</span>
                                @endif
                            </p>

                            <div class="reservaCardMeta">
                                <span class="reservaCardMetaItem">Reserva: {{ $reserva->fecha_reserva->format('d/m/Y') }}</span>
                                <span class="reservaCardMetaItem">Límite: {{ $reserva->fecha_devolucion_prevista->format('d/m/Y') }}</span>
                            </div>

                            @if ($reserva->observaciones)
                                <p class="reservaCardObs">{{ $reserva->observaciones }}</p>
                            @endif
                        </div>

                        <!-- Acción rápida: marcar como devuelto -->
                        <div class="reservaCardAcciones">
                            <form action="{{ route('admin.reservas.devolver', $reserva->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn-base btn-verde btnDevolverReserva" type="submit"
                                    onclick="return confirm('¿Marcar este libro como devuelto?')">
                                    Devolver
                                </button>
                            </form>
                            <a href="{{ route('admin.historialReservas', ['edit' => $reserva->id]) }}"
                                class="btn-base btn-azul btnEditarReserva">Editar</a>
                        </div>
                    </article>
                @empty
                    <p class="reservaCardVacio">No hay préstamos pendientes de devolución.</p>
                @endforelse
            </div>
        </div>

    </main>
@endsection