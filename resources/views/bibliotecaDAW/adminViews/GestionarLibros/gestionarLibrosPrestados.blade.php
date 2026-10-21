@extends('layouts.admin')

@section('title', 'Libros prestados')

@section('content')
<div class="a-vista-admin">
    <header class="a-titulo"><div><h1>Libros prestados</h1><p class="a-subtitulo">Registra devoluciones o marca un préstamo como perdido.</p></div><div class="a-titulo__acciones"><a href="{{ route('admin.librosPerdidos') }}" class="a-boton">Ver libros perdidos</a></div></header>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Pendientes de devolución ({{ $prestamosActivos->count() }})</h2></div></header>
<div class="a-tabla-envoltura" tabindex="0" role="region" aria-label="Reservas"><table class="a-tabla a-tabla--gestion"><thead>
<tr><th scope="col" class="a-num">ID</th>
    <th scope="col">Libro</th>
    <th scope="col">ISBN</th>
    <th scope="col">Usuario</th>
    <th scope="col">Préstamo</th>
    <th scope="col">Devolución prevista</th>
    <th scope="col">Acciones</th></tr></thead><tbody>
@forelse ($prestamosActivos as $prestamo)<tr><td class="a-num">{{ $prestamo->id }}</td>
    <td><div class="a-tabla__identidad"><strong>{{ $prestamo->libro->titulo }}</strong></div></td>
    <td>{{ $prestamo->libro->isbn }}</td>
    <td>{{ $prestamo->usuario->name ?? 'Usuario eliminado' }}</td>
    <td class="a-fecha">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
    <td class="a-fecha">{{ $prestamo->fecha_devolucion_esperada?->format('d/m/Y') ?? '—' }}</td>
    <td><div class="a-acciones-fila">
                            <form class="a-form" action="{{ route('admin.librosPrestados.devolver', $prestamo->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="a-boton a-boton--primario btnDevolverPréstamo"
                                    onclick="return confirm('¿Registrar la devolución de este libro?')">
                                    Devolver
                                </button>
                            </form>
                            <form class="a-form" action="{{ route('admin.librosPrestados.perdido', $prestamo->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="a-boton a-boton--peligro btnPerdidoPréstamo"
                                    onclick="return confirm('¿Marcar este libro como perdido? Se cerrará el prestamo y aparecera en Libros Perdidos.')">
                                    Marcar Perdido
                                </button>
                            </form>
                        </div></td></tr>
@empty<tr><td colspan="7"><p class="a-vacio">No hay préstamos activos en este momento.</p></td></tr>
@endforelse
</tbody></table></div>
</section>
</div>
@endsection
