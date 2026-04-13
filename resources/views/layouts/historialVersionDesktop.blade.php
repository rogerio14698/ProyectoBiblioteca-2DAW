{{-- ============================================================
HISTORIAL DE ACTIVIDAD DEL USUARIO (versión desktop: divs tipo tabla)
Esta vista se muestra en pantallas >= 1200px.
Usa divs con CSS Grid para simular tablas, lo que permite
que en pantallas más pequeñas se reorganice como cards.
============================================================ --}}

<section class="contenedor contenidoHistorial">

    {{-- ===================== HISTORIAL DE PRÉSTAMOS ===================== --}}
    <div class="historialPrestamos">
        <h3>Historial de préstamos</h3>

        @if($prestamos->isEmpty())
            <p class="sinRegistros">No tienes préstamos registrados.</p>
        @else
            {{-- Cabecera de la "tabla" (solo visible en desktop) --}}
            <div class="tablaResponsive">
                <div class="filaHeader">
                    <span class="celdaHeader celdaTitulo">Libro</span>
                    <span class="celdaHeader celdaIsbn">ISBN</span>
                    <span class="celdaHeader celdaFecha">Fecha de préstamo</span>
                    <span class="celdaHeader celdaFecha">Fecha de devolución</span>
                    <span class="celdaHeader celdaEstado">Estado</span>
                    <span class="celdaHeader celdaAcciones">Acciones</span>
                </div>

                {{-- Cada préstamo es una fila --}}
                @foreach($prestamos as $prestamo)
                    <div class="filaBody">
                        <span class="celdaBody celdaTitulo" data-label="Libro">{{ $prestamo->libro->titulo }}</span>
                        <span class="celdaBody celdaIsbn" data-label="ISBN">{{ $prestamo->libro->isbn ?? 'N/A' }}</span>
                        <span class="celdaBody celdaFecha"
                            data-label="Fecha préstamo">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</span>
                        <span class="celdaBody celdaFecha" data-label="Fecha devolución">
                            {{ $prestamo->fecha_devolucion_real ? $prestamo->fecha_devolucion_real->format('d/m/Y') : 'Pendiente' }}
                        </span>
                        <span class="celdaBody celdaEstado" data-label="Estado">
                            {{ $prestamo->fecha_devolucion_real ? 'Devuelto' : 'En préstamo' }}
                        </span>
                        <span class="celdaBody celdaAcciones" data-label="Acciones">
                            <div class="tablaAccionesBotones">
                                <a href="{{ route('libro.paginaInterna', $prestamo->libro->id) }}"
                                    class="btn-base btn-verde">Ver</a>
                            </div>
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ===================== HISTORIAL DE RESERVAS EVENTOS ===================== --}}
    <div class="historialReservas">
        <h3>Historial de reservas Eventos</h3>

        @if($eventosInscritos->isEmpty())
            <p class="sinRegistros">No tienes inscripciones a eventos.</p>
        @else
            <div class="tablaResponsive">
                <div class="filaHeader">
                    <span class="celdaHeader celdaTitulo">Nombre Evento</span>
                    <span class="celdaHeader celdaUbicacion">Ubicación</span>
                    <span class="celdaHeader celdaFecha">Fecha</span>
                    <span class="celdaHeader celdaHora">Hora</span>
                    <span class="celdaHeader celdaEstado">Estado</span>
                    <span class="celdaHeader celdaAcciones">Acciones</span>
                </div>

                @foreach($eventosInscritos as $evento)
                    <div class="filaBody">
                        <span class="celdaBody celdaTitulo" data-label="Evento">{{ $evento->titulo }}</span>
                        <span class="celdaBody celdaUbicacion"
                            data-label="Ubicación">{{ $evento->ubicacion ?? 'Sin ubicación' }}</span>
                        <span class="celdaBody celdaFecha"
                            data-label="Fecha">{{ date('d/m/Y', strtotime($evento->fecha_hora)) }}</span>
                        <span class="celdaBody celdaHora"
                            data-label="Hora">{{ date('H:i', strtotime($evento->fecha_hora)) }}</span>
                        <span class="celdaBody celdaEstado"
                            data-label="Estado">{{ ucfirst(str_replace('_', ' ', $evento->pivot->estado)) }}</span>
                        <span class="celdaBody celdaAcciones" data-label="Acciones">
                            <div class="tablaAccionesBotones">
                                <a href="{{ route('evento.paginaInterna', $evento->id) }}" class="btn-base btn-verde">Ver</a>
                            </div>
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ===================== HISTORIAL DE COMPRAS ===================== --}}
    <div class="historialCompras">
        <h3>Historial de compras</h3>

        @if($compras->isEmpty())
            <p class="sinRegistros">No tienes compras registradas.</p>
        @else
            <div class="tablaResponsive">
                <div class="filaHeader">
                    <span class="celdaHeader celdaTitulo">Libro</span>
                    <span class="celdaHeader celdaIsbn">ISBN</span>
                    <span class="celdaHeader celdaFecha">Fecha de compra</span>
                    <span class="celdaHeader celdaPrecio">Precio</span>
                    <span class="celdaHeader celdaEstado">Estado</span>
                    <span class="celdaHeader celdaAcciones">Acciones</span>
                </div>

                @foreach($compras as $compra)
                    <div class="filaBody">
                        <span class="celdaBody celdaTitulo" data-label="Libro">{{ $compra->libro->titulo }}</span>
                        <span class="celdaBody celdaIsbn" data-label="ISBN">{{ $compra->libro->isbn ?? 'N/A' }}</span>
                        <span class="celdaBody celdaFecha"
                            data-label="Fecha compra">{{ $compra->fecha_compra->format('d/m/Y') }}</span>
                        <span class="celdaBody celdaPrecio"
                            data-label="Precio">{{ number_format((float) $compra->precio, 2, ',', '.') }} €</span>
                        <span class="celdaBody celdaEstado" data-label="Estado">{{ ucfirst($compra->estado) }}</span>
                        <span class="celdaBody celdaAcciones" data-label="Acciones">
                            <div class="tablaAccionesBotones">
                                <a href="{{ route('libro.paginaInterna', $compra->libro->id) }}"
                                    class="btn-base btn-verde">Ver</a>
                            </div>
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ===================== HISTORIAL DE PUBLICACIONES ===================== --}}
    <div class="historialPublicaciones">
        <h3>Historial de publicaciones</h3>

        @if($publicaciones->isEmpty())
            <p class="sinRegistros">No tienes publicaciones registradas.</p>
        @else
            <div class="tablaResponsive">
                <div class="filaHeader">
                    <span class="celdaHeader celdaTituloPublicacion">Título</span>
                    <span class="celdaHeader celdaResumen">Resumen</span>
                    <span class="celdaHeader celdaLibro">Libro</span>
                    <span class="celdaHeader celdaFormato">Formato</span>
                    <span class="celdaHeader celdaFecha">Fecha de publicación</span>
                    <span class="celdaHeader celdaAcciones">Acciones</span>
                </div>

                @foreach($publicaciones as $publicacion)
                    <div class="filaBody">
                        <span class="celdaBody celdaTituloPublicacion"
                            data-label="Título">{{ $publicacion->titulo_publicacion }}</span>
                        <span class="celdaBody celdaResumen"
                            data-label="Resumen">{{ Str::limit($publicacion->resumen_publicacion, 60) }}</span>
                        <span class="celdaBody celdaLibro" data-label="Libro">{{ $publicacion->nombre_libro }}</span>
                        <span class="celdaBody celdaFormato"
                            data-label="Formato">{{ strtoupper($publicacion->archivo_extension) }}</span>
                        <span class="celdaBody celdaFecha"
                            data-label="Fecha">{{ $publicacion->fecha_publicacion->format('d/m/Y') }}</span>
                        <span class="celdaBody celdaAcciones" data-label="Acciones">
                            <div class="tablaAccionesBotones">
                                <button class="btn-base btn-verde">Ver</button>
                            </div>
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</section>