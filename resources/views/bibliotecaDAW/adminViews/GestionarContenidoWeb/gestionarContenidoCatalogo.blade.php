@extends('layouts.admin')

@section('title', 'Gestionar catálogo')

@section('content')
<div class="a-vista-admin">
    <header class="a-titulo"><div><h1>Gestionar catálogo</h1><p class="a-subtitulo">Administra los libros, su disponibilidad y sus precios.</p></div></header>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>{{ isset($libroEditar) ? 'Editar libro' : 'Añadir libro' }}</h2></div></header>
@if (isset($libroEditar))
                    <form action="{{ route('admin.gestionCatalogo.update', $libroEditar->id) }}" method="POST" enctype="multipart/form-data" class="a-form">
                        @csrf
                        @method('PUT')
                @else
                    <form action="{{ route('admin.gestionCatalogo.store') }}" method="POST" enctype="multipart/form-data" class="a-form">
                        @csrf
                @endif

                    <div class="a-form__fila a-form__fila--3">
<div class="a-campo">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $libroEditar->titulo ?? '') }}" required>
                        @error('titulo') <span class="a-campo__error">{{ $message }}</span> @enderror
                    </div>
                    <div class="a-campo">
                        <label for="autor">Autor:</label>
                        <input type="text" id="autor" name="autor" value="{{ old('autor', $libroEditar->autor ?? '') }}" required>
                        @error('autor') <span class="a-campo__error">{{ $message }}</span> @enderror
                    </div>
                    <div class="a-campo">
                        <label for="genero">Género:</label>
                        <input type="text" id="genero" name="genero" value="{{ old('genero', $libroEditar->genero ?? '') }}" required>
                        @error('genero') <span class="a-campo__error">{{ $message }}</span> @enderror
                    </div>
                    <div class="a-campo">
                        <label for="anio">Año:</label>
                        <input type="number" id="anio" name="anio" value="{{ old('anio', $libroEditar->anio ?? '') }}" min="1000" max="{{ date('Y') }}" required>
                        @error('anio') <span class="a-campo__error">{{ $message }}</span> @enderror
                    </div>
                    <div class="a-campo">
                        <label for="editorial">Editorial:</label>
                        <input type="text" id="editorial" name="editorial" value="{{ old('editorial', $libroEditar->editorial ?? '') }}" required>
                        @error('editorial') <span class="a-campo__error">{{ $message }}</span> @enderror
                    </div>
                    <div class="a-campo">
                        <label for="isbn">ISBN:</label>
                        <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $libroEditar->isbn ?? '') }}" required>
                        @error('isbn') <span class="a-campo__error">{{ $message }}</span> @enderror
                    </div>
                    <div class="a-campo">
                        <label for="disponibilidad">Disponibilidad:</label>
                        @php $dispVal = old('disponibilidad', $libroEditar->disponibilidad ?? 'disponible'); @endphp
                        <select id="disponibilidad" name="disponibilidad" required>
                            <option value="disponible" {{ $dispVal === 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="prestado" {{ $dispVal === 'prestado' ? 'selected' : '' }}>Prestado</option>
                        </select>
                    </div>
                    <div class="a-campo">
                        <label for="formato">Formato:</label>
                        @php $fmtVal = old('formato', $libroEditar->formato ?? 'ambos'); @endphp
                        <select id="formato" name="formato" required>
                            <option value="fisico" {{ $fmtVal === 'fisico' ? 'selected' : '' }}>Físico</option>
                            <option value="digital" {{ $fmtVal === 'digital' ? 'selected' : '' }}>Digital</option>
                            <option value="ambos" {{ $fmtVal === 'ambos' ? 'selected' : '' }}>Ambos</option>
                        </select>
                    </div>
                    <div class="a-campo">
                        <label for="opcion_compra">Opción:</label>
                        @php $opcVal = old('opcion_compra', $libroEditar->opcion_compra ?? 'prestamo'); @endphp
                        <select id="opcion_compra" name="opcion_compra" required>
                            <option value="prestamo" {{ $opcVal === 'prestamo' ? 'selected' : '' }}>Préstamo</option>
                            <option value="compra" {{ $opcVal === 'compra' ? 'selected' : '' }}>Compra</option>
                        </select>
</div>
                    <div class="a-campo">
                            <label for="precio">Precio de venta (€):</label>
                            <input type="number" id="precio" name="precio" min="0" step="0.01" value="{{ old('precio', $libroEditar->precio ?? '') }}" @if ($opcVal === 'compra') required @endif>
                    </div>
                    <div class="a-campo">
                        <label for="cantidad_ejemplares">Ejemplares:</label>
                        <input type="number" id="cantidad_ejemplares" name="cantidad_ejemplares" value="{{ old('cantidad_ejemplares', $libroEditar->cantidad_ejemplares ?? 1) }}" min="0" required>
                    </div>
                    <div class="a-campo">
                        <label for="portada_img">Portada (imagen):</label>
                        <input type="file" id="portada_img" name="portada_img" accept="image/jpeg,image/png,image/jpg,image/webp">
                        @error('portada_img') <span class="a-campo__error">{{ $message }}</span> @enderror
                        @if (isset($libroEditar) && $libroEditar->portada_img)
                            <img src="{{ $libroEditar->portada_url }}" alt="Portada actual" class="a-miniatura"
                                loading="lazy" width="200" height="300">
                        @endif
                    </div>


</div>
<div class="a-form__acciones">
                        @if (isset($libroEditar))
                            <button type="submit" class="a-boton a-boton--primario">Guardar cambios</button>
                            <a href="{{ route('admin.gestionCatalogo') }}" class="a-boton a-boton--fantasma">Cancelar</a>
                        @else
                            <button type="submit" class="a-boton a-boton--primario">Añadir libro</button>
                        @endif
                    </div>
</form>
</section>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Buscar libros</h2></div></header>
<form action="{{ route('admin.gestionCatalogo') }}" method="GET" class="a-form">
                    <div class="a-form__fila a-form__fila--3">
<div class="a-campo"><label for="filtroTitulo">Título</label><input id="filtroTitulo" type="text" name="filtroTitulo" value="{{ $filtroTitulo }}" placeholder="Título..."></div>
                    <div class="a-campo"><label for="filtroAutor">Autor</label><input id="filtroAutor" type="text" name="filtroAutor" value="{{ $filtroAutor }}" placeholder="Autor..."></div>
                    <div class="a-campo"><label for="filtroGenero">Género</label><input id="filtroGenero" type="text" name="filtroGenero" value="{{ $filtroGenero }}" placeholder="Género..."></div>
                    <div class="a-campo"><label for="filtroAnio">Año</label><input id="filtroAnio" type="text" name="filtroAnio" value="{{ $filtroAnio }}" placeholder="Año..."></div>
                    <div class="a-campo"><label for="filtroEditorial">Editorial</label><input id="filtroEditorial" type="text" name="filtroEditorial" value="{{ $filtroEditorial }}" placeholder="Editorial..."></div>
                    <div class="a-campo"><label for="filtroDisponibilidad">Disponibilidad</label><select id="filtroDisponibilidad" name="filtroDisponibilidad">
                        <option value="">Todos</option>
                        <option value="disponible" {{ $filtroDisponibilidad === 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="prestado" {{ $filtroDisponibilidad === 'prestado' ? 'selected' : '' }}>Prestado</option>
                    </select></div>
</div>
<div class="a-form__acciones"><button class="a-boton a-boton--primario" type="submit" >Filtrar</button>
                    <a href="{{ route('admin.gestionCatalogo') }}" class="a-boton a-boton--fantasma">Limpiar</a>
</div>
</form>
</section>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Catálogo ({{ $libros->total() }} libros)</h2></div></header>
<div class="a-tabla-envoltura" tabindex="0" role="region" aria-label="Tabla: Libro"><table class="a-tabla a-tabla--gestion"><thead>
<tr><th scope="col">Libro</th>
    <th scope="col">Género</th>
    <th scope="col">Editorial</th>
    <th scope="col">ISBN</th>
    <th scope="col">Año</th>
    <th scope="col">Formato</th>
    <th scope="col">Disponibilidad</th>
    <th scope="col" class="a-num">Ejemplares</th>
    <th scope="col" class="a-num">Precio</th>
    <th scope="col">Acciones</th></tr></thead><tbody>
@forelse ($libros as $libro)<tr><td><div class="a-tabla__identidad"><img class="a-miniatura" src="{{ $libro->portada_url }}" alt="" loading="lazy"><div><strong>{{ $libro->titulo }}</strong><span>{{ $libro->autor }}</span></div></div></td>
    <td>{{ $libro->genero }}</td>
    <td>{{ $libro->editorial }}</td>
    <td>{{ $libro->isbn }}</td>
    <td class="a-num">{{ $libro->anio }}</td>
    <td>{{ ucfirst($libro->formato) }}</td>
    <td><span class="a-pill {{ $libro->disponibilidad === 'disponible' ? 'a-pill--positivo' : 'a-pill--aviso' }}">{{ ucfirst($libro->disponibilidad) }}</span></td>
    <td class="a-num">{{ $libro->cantidad_ejemplares }}</td>
    <td class="a-num">{{ $libro->precio !== null ? number_format($libro->precio, 2, ',', '.') . ' €' : '—' }}</td>
    <td><div class="a-acciones-fila">
                                <form class="a-form" action="{{ route('admin.gestionCatalogo.destroy', $libro->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este libro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="a-boton a-boton--peligro">Eliminar</button>
                                </form>
                                <form class="a-form" action="{{ route('admin.gestionCatalogo.edit', $libro->id) }}" method="GET">
                                    <button type="submit" class="a-boton">Editar</button>
                                </form>
                            </div></td></tr>
@empty<tr><td colspan="10"><p class="a-vacio">No se encontraron libros con esos filtros.</p></td></tr>
@endforelse
</tbody></table></div><div class="a-paginacion">{{ $libros->links() }}</div>
</section>
</div>
@endsection
