@extends('layouts.app')

@section('title', 'Gestionar Home')

@section('content')


    <main class="contenedor gestionarHome">
        <section>
            <h1>Slides bienvenida</h1>
            <p>Rellena el formulario para editar los slides de bienvenida de la página principal</p>
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

            <h2>Listado de slides de bienvenida</h2>
            <p>Aqui se muestran todos los slides guardados actualmente en la base de datos</p>
            <div class="gestionTablaBloqueador">
                <table class="gestionTablaEventos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Posición</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Imagen</th>
                            <th>URL</th>
                            <th>Fecha creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($slidesBienvenida as $slide)
                            <tr>
                                <td>{{ $slide->id }}</td>
                                <td>{{ $slide->posicion ?? '-' }}</td>
                                <td>{{ $slide->titulo }}</td>
                                <td>{{ $slide->descripcion }}</td>
                                <td>
                                    @if ($slide->imagen)
                                        <img src="{{ \Illuminate\Support\Str::startsWith($slide->imagen, ['http://', 'https://']) ? $slide->imagen : asset($slide->imagen) }}"
                                            alt="Imagen del slide {{ $slide->titulo }}" width="80">
                                    @else
                                        Sin imagen
                                    @endif
                                </td>
                                <td>
                                    @if ($slide->url)
                                        <a href="{{ $slide->url }}" target="_blank" rel="noopener noreferrer">Abrir enlace</a>
                                    @else
                                        Sin enlace
                                    @endif
                                </td>
                                <td>{{ $slide->created_at?->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.gestionHome', ['edit' => $slide->id]) }}" class="btn-base btn-verde">Editar</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No hay slides de bienvenida registrados todavía.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </section>

        <section>
            <h1>Novedades del catalogo</h1>

        </section>


        <section>
            <h1> Agenda de Eventos </h1>

        </section>


        <section>
            <h1>Noticias</h1>
            
        </section>

    </main>

@endsection
