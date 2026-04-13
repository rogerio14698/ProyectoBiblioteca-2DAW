@extends('layouts.app')

@section('title', 'Organizar Evento')

@section('content')
    <main class="contenedor organizarEvento">
        {{-- Cabecera con bienvenida al usuario --}}
        <section class="organizarEventoHeader">
            <h1>Organizar Evento</h1>
            <p>Bienvenido <span>{{ Auth::user()->name }}</span> a la sección de organización de eventos de la Biblioteca DAW.</p>
        </section>

        {{-- Mensaje de éxito tras crear un evento --}}
        @if (session('success'))
            <div class="alertaExito" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Bloque del formulario de creación --}}
        <section class="organizarEventoBloque" aria-labelledby="crearEventoTitulo">
            <div class="organizarEventoIntro">
                <h2 id="crearEventoTitulo">Crear Evento</h2>
                <p>
                    Desde aquí podrás proponer un nuevo evento para la biblioteca indicando título, lugar, fecha,
                    hora, descripción, capacidad, prioridad e imagen.
                </p>
            </div>

            {{-- Formulario con enctype para subida de archivos --}}
            <form action="{{ route('usuario.organizarEvento.store') }}" method="POST" enctype="multipart/form-data" class="formOrganizarEvento">
                @csrf

                {{-- Campo: Título del evento --}}
                <div class="campoOrganizarEvento">
                    <label for="titulo">Título del evento</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Título del evento"
                           value="{{ old('titulo') }}" required>
                    @error('titulo')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Ubicación --}}
                <div class="campoOrganizarEvento">
                    <label for="ubicacion">Lugar del evento</label>
                    <input type="text" id="ubicacion" name="ubicacion" placeholder="Lugar del evento"
                           value="{{ old('ubicacion') }}" required>
                    @error('ubicacion')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Fecha --}}
                <div class="campoOrganizarEvento">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}" required>
                    @error('fecha')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Hora --}}
                <div class="campoOrganizarEvento">
                    <label for="hora">Hora</label>
                    <input type="time" id="hora" name="hora" value="{{ old('hora') }}" required>
                    @error('hora')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Aforo (capacidad máxima) --}}
                <div class="campoOrganizarEvento">
                    <label for="aforo">Capacidad máxima de asistentes</label>
                    <input type="number" id="aforo" name="aforo" placeholder="Ej: 50"
                           value="{{ old('aforo') }}" min="1" max="10000" required>
                    @error('aforo')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Prioridad del evento --}}
                <div class="campoOrganizarEvento">
                    <label for="prioridad">Prioridad</label>
                    <select id="prioridad" name="prioridad" required>
                        <option value="" disabled {{ old('prioridad') ? '' : 'selected' }}>Selecciona la prioridad</option>
                        <option value="1" {{ old('prioridad') == '1' ? 'selected' : '' }}>Baja</option>
                        <option value="2" {{ old('prioridad') == '2' ? 'selected' : '' }}>Media</option>
                        <option value="3" {{ old('prioridad') == '3' ? 'selected' : '' }}>Alta</option>
                    </select>
                    @error('prioridad')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Descripción (ocupa fila completa) --}}
                <div class="campoOrganizarEvento campoCompletoOrganizarEvento">
                    <label for="descripcion">Descripción del evento</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Describe el evento, actividades, público objetivo..."
                              required>{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Imagen del evento (ocupa fila completa) --}}
                <div class="campoOrganizarEvento campoCompletoOrganizarEvento">
                    <label for="imagen">Imagen del evento (opcional)</label>
                    <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp">
                    <small class="ayudaCampo">Formatos permitidos: JPEG, PNG, WebP. Tamaño máximo: 3 MB.</small>
                    @error('imagen')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Botón de envío --}}
                <div class="accionesOrganizarEvento campoCompletoOrganizarEvento">
                    <button type="submit" class="btn-base btn-verde">Crear Evento</button>
                </div>
            </form>
        </section>

        {{-- Listado de eventos en los que el usuario está inscrito --}}
        <section class="organizarEventoBloque" aria-labelledby="eventosInscritosTitulo">
            <div class="organizarEventoIntro">
                <h2 id="eventosInscritosTitulo">Mis inscripciones</h2>
                <p>Eventos en los que te has apuntado como asistente.</p>
            </div>

            @if ($eventosInscritos->isEmpty())
                <p class="textoVacio">Aún no te has inscrito en ningún evento.</p>
            @else
                {{-- Cabecera visual que imita una tabla (solo desktop) --}}
                <div class="inscripcionCabecera">
                    <span class="inscripcionCol inscripcionCol--titulo">Evento</span>
                    <span class="inscripcionCol inscripcionCol--fecha">Fecha</span>
                    <span class="inscripcionCol inscripcionCol--hora">Hora</span>
                    <span class="inscripcionCol inscripcionCol--ubicacion">Ubicación</span>
                    <span class="inscripcionCol inscripcionCol--estado">Estado</span>
                    <span class="inscripcionCol inscripcionCol--acciones">Acciones</span>
                </div>

                {{-- Filas/cards de cada inscripción --}}
                @foreach ($eventosInscritos as $evento)
                    <div class="inscripcionFila">
                        <span class="inscripcionCol inscripcionCol--titulo" data-label="Evento">
                            {{ $evento->titulo }}
                        </span>
                        <span class="inscripcionCol inscripcionCol--fecha" data-label="Fecha">
                            {{ date('d/m/Y', strtotime($evento->fecha_hora)) }}
                        </span>
                        <span class="inscripcionCol inscripcionCol--hora" data-label="Hora">
                            {{ date('H:i', strtotime($evento->fecha_hora)) }}h
                        </span>
                        <span class="inscripcionCol inscripcionCol--ubicacion" data-label="Ubicación">
                            {{ $evento->ubicacion }}
                        </span>
                        <span class="inscripcionCol inscripcionCol--estado" data-label="Estado">
                            <span class="estadoInscripcion estadoInscripcion--{{ $evento->pivot->estado }}">
                                {{ ucfirst(str_replace('_', ' ', $evento->pivot->estado)) }}
                            </span>
                        </span>
                        <span class="inscripcionCol inscripcionCol--acciones" data-label="Acciones">
                            <a href="{{ route('evento.paginaInterna', ['id' => $evento->id]) }}" class="btn-base btn-azul">Ver</a>
                            {{-- Solo se puede dar de baja si el estado es 'inscrito' --}}
                                <form action="{{ route('evento.darseDeBaja', ['id' => $evento->id]) }}" method="POST" class="formDarseDeBaja">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-base btn-rojo"onclick="return confirm('¿Seguro que quieres darte de baja de este evento?')">Darse de baja</button>
                                </form>
    
                        </span>
                    </div>
                @endforeach
            @endif
        </section>
    </main>
@endsection