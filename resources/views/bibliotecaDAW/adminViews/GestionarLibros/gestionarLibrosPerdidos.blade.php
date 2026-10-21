@extends('layouts.admin')

@section('title', 'Libros perdidos')

@section('content')
<div class="a-vista-admin">
    <header class="a-titulo"><div><h1>Libros perdidos</h1><p class="a-subtitulo">Registra y consulta las bajas por extravío o daños.</p></div></header>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Dar de baja un libro</h2></div></header>
<form class="a-form" action="{{ route('admin.librosPerdidos.marcar') }}" method="POST">
                    @csrf
                    <div class="a-form__fila a-form__fila--3">
<div class="a-campo">
                        <label for="libro_identificador">Escribe el Titulo o ISBN</label>
                        <input type="text" name="libro_identificador" id="libro_identificador" list="listaLibros"
                            placeholder="Filtrando..." required>
                        <datalist id="listaLibros">
                            @foreach ($libros as $libro)
                                <option value="{{ $libro->isbn }}">{{ $libro->titulo }}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="a-campo">
                        <label for="motivo_baja">Motivo de baja</label>
                        <input type="text" name="motivo_baja" id="motivo_baja" required
                            placeholder="Ej: Perdido por el usuario">
                    </div>

</div>
<div class="a-form__acciones"><button type="submit" class="a-boton a-boton--primario">Marcar como perdido</button>

</div>
</form>
</section>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Historial de bajas ({{ count($librosPerdidos) }})</h2></div></header>
<div class="a-tabla-envoltura" tabindex="0" role="region" aria-label="Tabla: Libro"><table class="a-tabla a-tabla--gestion"><thead>
<tr><th scope="col">Libro</th>
    <th scope="col">Autor</th>
    <th scope="col">ISBN</th>
    <th scope="col">Motivo de baja</th>
    <th scope="col">Fecha de baja</th></tr></thead><tbody>
@forelse ($librosPerdidos as $libro)<tr><td><div class="a-tabla__identidad"><strong>{{ $libro->titulo }}</strong></div></td>
    <td>{{ $libro->autor }}</td>
    <td>{{ $libro->isbn ?: '—' }}</td>
    <td class="a-texto-tabla"><div>{{ $libro->motivo_baja }}</div></td>
    <td class="a-fecha">{{ $libro->updated_at->format('d/m/Y H:i') }}</td></tr>
@empty<tr><td colspan="5"><p class="a-vacio">No hay libros registrados como perdidos.</p></td></tr>
@endforelse
</tbody></table></div>
</section>
</div>
@endsection
