@extends('layouts.app')

@section('title', 'Gestionar Home')

@section('content')


    <main class="contenedor gestionarHome">
        <section class="slidesSeccion">
            <h1>Slides bienvenida</h1>
            <p>Rellena el formulario para editar los slides de bienvenida de la página principal</p>

            <!--Layout 2 columnas: formulario a la izquierda, listado a la derecha -->
            <div class="slidesLayout">

                <!--Columna izquierda: formulario de creación/edición -->
                <div class="slidesFormulario">
                    <h2>{{ $slideEditar ? 'Editar Slide' : 'Crear Slide' }}</h2>
                    <form action="{{ $slideEditar ? route('admin.slide.update', $slideEditar->id) : route('admin.slide.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @if ($slideEditar)
                            @method('PUT')
                        @endif
                        <div class="gestionGrupoFormulario">
                            <label for="titulo">Título del Slide:</label>
                            <input type="text" placeholder="Titulo Slide" id="titulo" name="titulo"
                                value="{{ old('titulo', $slideEditar->titulo ?? '') }}" required>
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label for="descripcion">Descripción del Slide:</label>
                            <textarea id="descripcion" name="descripcion" required>{{ old('descripcion', $slideEditar->descripcion ?? '') }}</textarea>
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label for="imagen">Imagen del Slide:</label>
                            <input type="file" id="imagen" name="imagen" accept="image/*" {{ $slideEditar ? '' : 'required' }}>
                            <small class="gestionAyudaCampo">
                                Dimensión recomendada: <strong>680 × 420 px</strong> (horizontal).
                                La imagen se recortará automáticamente al centro si excede ese tamaño.
                            </small>
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label for="posicion">Posición del slide:</label>
                            <input type="number" id="posicion" name="posicion" min="1"
                                value="{{ old('posicion', $slideEditar->posicion ?? '') }}">
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label for="url">URL del botón del slide:</label>
                            <input type="url" id="url" name="url" placeholder="https://ejemplo.com"
                                value="{{ old('url', $slideEditar->url ?? '') }}">
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label>Orden actual de los slides</label>
                            <ul>
                                @forelse ($slidesBienvenida as $slideOrden)
                                    <li>Posición {{ $slideOrden->posicion ?? 'Sin asignar' }}: {{ $slideOrden->titulo }}</li>
                                @empty
                                    <li>No hay slides creados todavía.</li>
                                @endforelse
                            </ul>
                            <p>El sistema mostrará los slides ordenados de menor a mayor posición.</p>
                        </div>
                        <button type="submit" class="gestionBotonEnvio">{{ $slideEditar ? 'Actualizar Slide' : 'Guardar Slide' }}</button>
                    </form>
                </div>

                <!--Columna derecha: listado de slides en formato tarjeta -->
                <div class="slidesListado">
                    <h2>Listado de slides</h2>
                    <div class="slidesListadoCards">
                        @forelse ($slidesBienvenida as $slide)
                            <div class="slideCard">
                                <!--Imagen del slide -->
                                <div class="slideCardImagen">
                                    @if ($slide->imagen)
                                        <img src="{{ \Illuminate\Support\Str::startsWith($slide->imagen, ['http://', 'https://']) ? $slide->imagen : asset($slide->imagen) }}"
                                            alt="Imagen del slide {{ $slide->titulo }}" loading="lazy" width="680" height="420">
                                    @else
                                        <span class="slideCardSinImagen">Sin imagen</span>
                                    @endif
                                </div>
                                <!--Datos del slide -->
                                <div class="slideCardInfo">
                                    <span class="slideCardPosicion">Pos: {{ $slide->posicion ?? '-' }}</span>
                                    <h3 class="slideCardTitulo">{{ $slide->titulo }}</h3>
                                    <p class="slideCardDescripcion">{{ $slide->descripcion }}</p>
                                    @if ($slide->url)
                                        <a href="{{ $slide->url }}" target="_blank" rel="noopener noreferrer" class="slideCardEnlace">Ver enlace</a>
                                    @endif
                                    <span class="slideCardFecha">{{ $slide->created_at?->format('d/m/Y H:i') }}</span>
                                </div>
                                <!--Acciones del slide -->
                                <div class="slideCardAcciones">
                                    <a href="{{ route('admin.gestionHome', ['edit' => $slide->id]) }}" class="btn-base btnEditarSlide">Editar</a>
                                    <form action="{{ route('admin.slide.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este slide?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-base btnEliminarSlide">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="slideCardVacio">No hay slides de bienvenida registrados todavía.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </section>
    </main>

@endsection
