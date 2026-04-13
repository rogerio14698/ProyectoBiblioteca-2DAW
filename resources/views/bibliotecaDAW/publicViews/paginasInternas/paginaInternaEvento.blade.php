@extends('layouts.app')

@section('title', $evento->titulo . ' - Evento')

@section('content')

    {{-- Cabecera con imagen del evento a pantalla completa --}}
    <section class="eventoInternoHero">
        @php
            // Comprobamos si la URL ya es un enlace externo o una imagen local.
            $url = Str::startsWith($evento->imagen_url, ['http://', 'https://'])
                ? $evento->imagen_url
                : asset('storage/' . $evento->imagen_url);
        @endphp
        <img src="{{ $url }}" alt="Imagen del evento {{ $evento->titulo }}" class="eventoInternoHeroImg"
            width="1200" height="500">
        {{-- Capa oscura para mejorar la legibilidad del texto sobre la imagen --}}
        <div class="eventoInternoHeroOverlay">
            <h1 class="eventoInternoTitulo">{{ $evento->titulo }}</h1>
            <p class="eventoInternoUbicacion">
                <i class="bi bi-geo-alt-fill"></i> {{ $evento->ubicacion }}
            </p>
        </div>
    </section>

    {{-- Contenido principal del evento en dos columnas --}}
    <section class="eventoInternoContenido separador">
        {{-- Columna izquierda: información del evento --}}
        <article class="eventoInternoInfo">
            <h2 class="eventoInternoSubtitulo">Sobre este evento</h2>
            <p class="eventoInternoDescripcion">{{ $evento->descripcion }}</p>

            {{-- Tarjetas con datos clave del evento --}}
            <div class="eventoInternoDatos">
                {{-- Fecha --}}
                <div class="eventoInternoDato">
                    <i class="bi bi-calendar-event"></i>
                    <div>
                        <span class="eventoInternoDatoLabel">Fecha</span>
                        <span class="eventoInternoDatoValor">{{ \Carbon\Carbon::parse($evento->fecha_hora)->translatedFormat('d \d\e F, Y') }}</span>
                    </div>
                </div>
                {{-- Hora --}}
                <div class="eventoInternoDato">
                    <i class="bi bi-clock"></i>
                    <div>
                        <span class="eventoInternoDatoLabel">Hora</span>
                        <span class="eventoInternoDatoValor">{{ \Carbon\Carbon::parse($evento->fecha_hora)->format('H:i') }}h</span>
                    </div>
                </div>
                {{-- Ubicación --}}
                <div class="eventoInternoDato">
                    <i class="bi bi-building"></i>
                    <div>
                        <span class="eventoInternoDatoLabel">Ubicación</span>
                        <span class="eventoInternoDatoValor">{{ $evento->ubicacion }}</span>
                    </div>
                </div>
                {{-- Organizador --}}
                <div class="eventoInternoDato">
                    <i class="bi bi-person"></i>
                    <div>
                        <span class="eventoInternoDatoLabel">Organiza</span>
                        <span class="eventoInternoDatoValor">{{ $evento->usuario->name }}</span>
                    </div>
                </div>
            </div>
        </article>

        {{-- Columna derecha: panel de inscripción --}}
        <aside class="eventoInternoPanel">
            <div class="eventoInternoPanelCard">
                <h3 class="eventoInternoPanelTitulo">Inscripción</h3>

                {{-- Barra visual de ocupación del aforo --}}
                @if ($evento->aforo)
                    @php
                        // Calculamos el porcentaje de ocupación para la barra de progreso.
                        $porcentaje = round(($evento->asistentes / $evento->aforo) * 100);
                    @endphp
                    <div class="eventoInternoAforo">
                        <div class="eventoInternoAforoTexto">
                            <span>{{ $evento->asistentes }} / {{ $evento->aforo }} asistentes</span>
                            <span>{{ $evento->plazas_libres }} plazas libres</span>
                        </div>
                        {{-- Barra de progreso que refleja la ocupación --}}
                        <div class="eventoInternoBarraFondo">
                            <div class="eventoInternoBarra" style="width: {{ $porcentaje }}%"></div>
                        </div>
                    </div>
                @endif

                {{-- Prioridad del evento --}}
                <div class="eventoInternoPrioridad">
                    <span class="eventoInternoPrioridadBadge eventoInternoPrioridad{{ $evento->prioridad }}">
                        {{ $evento->prioridad_texto }}
                    </span>
                </div>

                {{-- Botón de inscripción: solo visible para usuarios autenticados --}}
                @auth('web')
                    @if ($evento->plazas_libres > 0)
                        <a href="{{ route('evento.apuntarse', ['id' => $evento->id]) }}" class="btn-base btn-verde eventoInternoBtn">
                            <i class="bi bi-check-circle"></i> Apuntarse al evento
                        </a>
                    @else
                        <p class="eventoInternoCompleto">
                            <i class="bi bi-exclamation-circle"></i> Evento completo
                        </p>
                    @endif
                @else
                    <p class="eventoInternoLoginAviso">
                        Debes <a href="{{ route('usuario.login.mostrar') }}">iniciar sesión</a> para apuntarte.
                    </p>
                @endauth

                {{-- Enlace para volver al listado de eventos --}}
                <a href="{{ url('/actividades') }}" class="btn-base btn-azul eventoInternoBtn">
                    <i class="bi bi-arrow-left"></i> Volver a eventos
                </a>
            </div>
        </aside>
    </section>

@endsection