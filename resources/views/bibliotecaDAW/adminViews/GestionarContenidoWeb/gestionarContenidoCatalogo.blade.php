@extends('layouts.app')

@section('title', 'Gestión del Catálogo')

@section('content')

    <main class="contenedor gestionCatalogoPageAdmin">
        <h1>Gestión del Contenido del Catálogo</h1>
        <p>Administra los libros y productos del catálogo de la biblioteca</p>

        <!--Mensajes de éxito o error tras crear/eliminar -->
        @if (session('success'))
            <div class="alertaExitoAdmin">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alertaErrorAdmin">{{ session('error') }}</div>
        @endif

        <!--Layout 2 columnas: formulario izquierda, listado derecha -->
        <div class="catalogoLayoutAdmin">

            <!--Columna izquierda: formulario de creación / edición -->
            <div class="catalogoFormularioColAdmin">
                <!--Si $libroEditar existe, estamos en modo edición; si no, modo creación -->
                @if (isset($libroEditar))
                    <h2>Editar libro</h2>
                    <form action="{{ route('admin.gestionCatalogo.update', $libroEditar->id) }}" method="POST" enctype="multipart/form-data" class="gestionFormularioCarrusel">
                        @csrf
                        @method('PUT')
                @else
                    <h2>Añadir nuevo libro</h2>
                    <form action="{{ route('admin.gestionCatalogo.store') }}" method="POST" enctype="multipart/form-data" class="gestionFormularioCarrusel">
                        @csrf
                @endif

                    <div class="gestionGrupoFormulario">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $libroEditar->titulo ?? '') }}" required>
                        @error('titulo') <span class="errorCampoAdmin">{{ $message }}</span> @enderror
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="autor">Autor:</label>
                        <input type="text" id="autor" name="autor" value="{{ old('autor', $libroEditar->autor ?? '') }}" required>
                        @error('autor') <span class="errorCampoAdmin">{{ $message }}</span> @enderror
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="genero">Género:</label>
                        <input type="text" id="genero" name="genero" value="{{ old('genero', $libroEditar->genero ?? '') }}" required>
                        @error('genero') <span class="errorCampoAdmin">{{ $message }}</span> @enderror
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="anio">Año:</label>
                        <input type="number" id="anio" name="anio" value="{{ old('anio', $libroEditar->anio ?? '') }}" min="1000" max="{{ date('Y') }}" required>
                        @error('anio') <span class="errorCampoAdmin">{{ $message }}</span> @enderror
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="editorial">Editorial:</label>
                        <input type="text" id="editorial" name="editorial" value="{{ old('editorial', $libroEditar->editorial ?? '') }}" required>
                        @error('editorial') <span class="errorCampoAdmin">{{ $message }}</span> @enderror
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="isbn">ISBN:</label>
                        <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $libroEditar->isbn ?? '') }}" required>
                        @error('isbn') <span class="errorCampoAdmin">{{ $message }}</span> @enderror
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="disponibilidad">Disponibilidad:</label>
                        @php $dispVal = old('disponibilidad', $libroEditar->disponibilidad ?? 'disponible'); @endphp
                        <select id="disponibilidad" name="disponibilidad" required>
                            <option value="disponible" {{ $dispVal === 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="prestado" {{ $dispVal === 'prestado' ? 'selected' : '' }}>Prestado</option>
                        </select>
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="formato">Formato:</label>
                        @php $fmtVal = old('formato', $libroEditar->formato ?? 'ambos'); @endphp
                        <select id="formato" name="formato" required>
                            <option value="fisico" {{ $fmtVal === 'fisico' ? 'selected' : '' }}>Físico</option>
                            <option value="digital" {{ $fmtVal === 'digital' ? 'selected' : '' }}>Digital</option>
                            <option value="ambos" {{ $fmtVal === 'ambos' ? 'selected' : '' }}>Ambos</option>
                        </select>
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="opcion_compra">Opción:</label>
                        @php $opcVal = old('opcion_compra', $libroEditar->opcion_compra ?? 'prestamo'); @endphp
                        <select id="opcion_compra" name="opcion_compra" required>
                            <option value="prestamo" {{ $opcVal === 'prestamo' ? 'selected' : '' }}>Préstamo</option>
                            <option value="compra" {{ $opcVal === 'compra' ? 'selected' : '' }}>Compra</option>
                        </select>
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="cantidad_ejemplares">Ejemplares:</label>
                        <input type="number" id="cantidad_ejemplares" name="cantidad_ejemplares" value="{{ old('cantidad_ejemplares', $libroEditar->cantidad_ejemplares ?? 1) }}" min="0" required>
                    </div>
                    <div class="gestionGrupoFormulario">
                        <label for="portada_img">Portada (imagen):</label>
                        <input type="file" id="portada_img" name="portada_img" accept="image/jpeg,image/png,image/jpg,image/webp">
                        @error('portada_img') <span class="errorCampoAdmin">{{ $message }}</span> @enderror
                        <!--Si estamos editando y ya tiene portada, mostramos la miniatura actual -->
                        @if (isset($libroEditar) && $libroEditar->portada_img)
                            <img src="{{ $libroEditar->portada_url }}" alt="Portada actual" class="catalogoPortadaPreviewAdmin">
                        @endif
                    </div>

                    <div class="catalogoFormBotonesAdmin">
                        @if (isset($libroEditar))
                            <button type="submit" class="gestionBotonEnvio">Guardar cambios</button>
                            <a href="{{ route('admin.gestionCatalogo') }}" class="btnCancelarEdicionAdmin">Cancelar</a>
                        @else
                            <button type="submit" class="gestionBotonEnvio">Añadir libro</button>
                        @endif
                    </div>
                </form>
            </div>

            <!--Columna derecha: listado de libros con filtros y scroll -->
            <div class="catalogoListadoColAdmin">
                <h2>Listado del catálogo ({{ $libros->total() }} libros)</h2>

                <!--Filtros de búsqueda -->
                <form action="{{ route('admin.gestionCatalogo') }}" method="GET" class="catalogoFiltrosAdmin">
                    <input type="text" name="filtroTitulo" value="{{ $filtroTitulo }}" placeholder="Título...">
                    <input type="text" name="filtroAutor" value="{{ $filtroAutor }}" placeholder="Autor...">
                    <input type="text" name="filtroGenero" value="{{ $filtroGenero }}" placeholder="Género...">
                    <input type="text" name="filtroAnio" value="{{ $filtroAnio }}" placeholder="Año...">
                    <input type="text" name="filtroEditorial" value="{{ $filtroEditorial }}" placeholder="Editorial...">
                    <select name="filtroDisponibilidad">
                        <option value="">Todos</option>
                        <option value="disponible" {{ $filtroDisponibilidad === 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="prestado" {{ $filtroDisponibilidad === 'prestado' ? 'selected' : '' }}>Prestado</option>
                    </select>
                    <button type="submit" class="btnFiltrarAdmin">Filtrar</button>
                    <a href="{{ route('admin.gestionCatalogo') }}" class="btnLimpiarFiltrosAdmin">Limpiar</a>
                </form>

                <!--Contenedor con scroll de 80vh para el listado de cards -->
                <div class="catalogoListadoScrollAdmin">
                    @forelse ($libros as $libro)
                        <div class="catalogoCardAdmin">
                            <!--Imagen de portada del libro -->
                            <div class="catalogoCardImgAdmin">
                                <img src="{{ $libro->portada_url }}" alt="Portada de {{ $libro->titulo }}">
                            </div>
                            <!--Información del libro -->
                            <div class="catalogoCardInfoAdmin">
                                <h3>{{ $libro->titulo }}</h3>
                                <p><strong>Autor:</strong> {{ $libro->autor }}</p>
                                <p><strong>Género:</strong> {{ $libro->genero }}</p>
                                <p><strong>Editorial:</strong> {{ $libro->editorial }}</p>
                                <p><strong>ISBN:</strong> {{ $libro->isbn }}</p>
                                <div class="catalogoCardMetaAdmin">
                                    <span class="catalogoCardAnioAdmin">{{ $libro->anio }}</span>
                                    <span class="catalogoCardFormatoAdmin catalogoCardFormatoAdmin--{{ $libro->formato }}">{{ $libro->formato }}</span>
                                    <span class="catalogoCardDisponibilidadAdmin catalogoCardDisponibilidadAdmin--{{ $libro->disponibilidad }}">{{ $libro->disponibilidad }}</span>
                                    <span class="catalogoCardEjemplaresAdmin">{{ $libro->cantidad_ejemplares }} ej.</span>
                                </div>
                            </div>
                            <!--Botón eliminar -->
                            <div class="catalogoCardAccionesAdmin">
                                <form action="{{ route('admin.gestionCatalogo.destroy', $libro->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este libro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-base btn-rojo">Eliminar</button>
                                </form>
                                <form action="{{ route('admin.gestionCatalogo.edit', $libro->id) }}" method="GET">
                                    <button type="submit" class="btn-base btn-azul">Editar</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="catalogoVacioAdmin">No se encontraron libros con esos filtros.</p>
                    @endforelse
                </div>

                <!--Paginación fuera del scroll -->
                <div class="catalogoPaginacionAdmin">
                    {{ $libros->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>

        </div>
    </main>

@endsection
