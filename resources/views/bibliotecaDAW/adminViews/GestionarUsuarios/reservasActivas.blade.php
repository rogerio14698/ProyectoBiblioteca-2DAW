@extends('layouts.admin')

@section('title', 'Reservas activas')

@section('content')
<div class="a-vista-admin">
    <header class="a-titulo"><div><h1>Reservas activas</h1><p class="a-subtitulo">Reservas activas y vencidas, pendientes de devolución.</p></div><div class="a-titulo__acciones"><a href="{{ route('admin.historialReservas') }}" class="a-boton">Ver historial completo</a></div></header>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Pendientes de devolución ({{ $reservas->count() }})</h2></div></header>
<div class="a-tabla-envoltura" tabindex="0" role="region" aria-label="Reservas"><table class="a-tabla a-tabla--gestion"><thead>
<tr><th scope="col" class="a-num">ID</th>
    <th scope="col">Libro</th>
    <th scope="col">Usuario</th>
    <th scope="col">Reserva</th>
    <th scope="col">Devolución prevista</th>
    <th scope="col">Estado</th>
    <th scope="col">Observaciones</th>
    <th scope="col">Acciones</th></tr></thead><tbody>
@forelse ($reservas as $reserva)<tr><td class="a-num">{{ $reserva->id }}</td>
    <td><div class="a-tabla__identidad"><strong>{{ $reserva->libro->titulo ?? 'Libro eliminado' }}</strong></div></td>
    <td><div class="a-tabla__identidad"><div><strong>{{ $reserva->usuario->name ?? 'Usuario eliminado' }}</strong>@if ($reserva->usuario && $reserva->usuario->nSocio)<span>Socio {{ $reserva->usuario->nSocio }}</span>@endif</div></div></td>
    <td class="a-fecha">{{ $reserva->fecha_reserva->format('d/m/Y') }}</td>
    <td class="a-fecha">{{ $reserva->fecha_devolucion_prevista->format('d/m/Y') }}</td>
    <td><span class="a-pill {{ $reserva->estado === 'vencida' ? 'a-pill--negativo' : ($reserva->estado === 'devuelta' ? 'a-pill--positivo' : 'a-pill--aviso') }}">{{ ucfirst($reserva->estado) }}</span></td>
    <td class="a-texto-tabla"><div>{{ $reserva->observaciones ?: '—' }}</div></td>
    <td><div class="a-acciones-fila">
                            <form class="a-form" action="{{ route('admin.reservas.devolver', $reserva->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="a-boton a-boton--primario btnDevolverReserva" type="submit"
                                    onclick="return confirm('¿Marcar este libro como devuelto?')">
                                    Devolver
                                </button>
                            </form>
                            <a href="{{ route('admin.historialReservas', ['edit' => $reserva->id]) }}"
                                class="a-boton btnEditarReserva">Editar</a>
                        </div></td></tr>
@empty<tr><td colspan="8"><p class="a-vacio">No hay préstamos pendientes de devolución.</p></td></tr>
@endforelse
</tbody></table></div>
</section>
</div>
@endsection
