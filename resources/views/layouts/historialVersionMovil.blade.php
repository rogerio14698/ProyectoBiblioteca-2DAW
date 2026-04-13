{{-- ============================================================
HISTORIAL DE ACTIVIDAD DEL USUARIO (versión móvil: cards)
Esta vista se muestra en pantallas < 1200px. Usa cards (article) para cada registro, ideal para pantallas
    pequeñas.============================================================--}} <section class="historialVersionMovil">

    {{-- ===================== HISTORIAL DE PRÉSTAMOS ===================== --}}
    <div class="historialPrestamos">
        <h3>Historial de préstamos</h3>
        <div class="contenedorCardsHistorial">
            @forelse($prestamos as $prestamo)
                <article class="cardHistorialMovil">
                    <p><strong>Libro:</strong> {{ $prestamo->libro->titulo }}</p>
                    <p><strong>ISBN:</strong> {{ $prestamo->libro->isbn ?? 'N/A' }}</p>
                    <p><strong>Fecha de préstamo:</strong> {{ $prestamo->fecha_prestamo->format('d/m/Y') }}</p>
                    <p><strong>Fecha de devolución:</strong>
                        {{ $prestamo->fecha_devolucion_real ? $prestamo->fecha_devolucion_real->format('d/m/Y') : 'Pendiente' }}
                    </p>
                    <p><strong>Estado:</strong>
                        {{ $prestamo->fecha_devolucion_real ? 'Devuelto' : 'En préstamo' }}
                    </p>
                    <div class="tablaAccionesBotones">
                        <a href="{{ route('libro.paginaInterna', $prestamo->libro->id) }}"
                            class="btn-base btn-verde">Ver</a>
                    </div>
                </article>
            @empty
                <p class="sinRegistros">No tienes préstamos registrados.</p>
            @endforelse
        </div>
    </div>
    <hr>

    {{-- ===================== HISTORIAL DE RESERVAS EVENTOS ===================== --}}
    <div class="historialReservas">
        <h3>Historial de reservas eventos</h3>
        <div class="contenedorCardsHistorial">
            @forelse($eventosInscritos as $evento)
                <article class="cardHistorialMovil">
                    <p><strong>Nombre evento:</strong> {{ $evento->titulo }}</p>
                    <p><strong>Ubicación:</strong> {{ $evento->ubicacion ?? 'Sin ubicación' }}</p>
                    <p><strong>Fecha:</strong> {{ date('d/m/Y', strtotime($evento->fecha_hora)) }}</p>
                    <p><strong>Hora:</strong> {{ date('H:i', strtotime($evento->fecha_hora)) }}</p>
                    <p><strong>Estado:</strong> {{ ucfirst(str_replace('_', ' ', $evento->pivot->estado)) }}</p>
                    <div class="tablaAccionesBotones">
                        <a href="{{ route('evento.paginaInterna', $evento->id) }}" class="btn-base btn-verde">Ver</a>
                    </div>
                </article>
            @empty
                <p class="sinRegistros">No tienes inscripciones a eventos.</p>
            @endforelse
        </div>
    </div>
    <hr>

    {{-- ===================== HISTORIAL DE COMPRAS ===================== --}}
    <div class="historialCompras">
        <h3>Historial de compras</h3>
        <div class="contenedorCardsHistorial">
            @forelse($compras as $compra)
                <article class="cardHistorialMovil">
                    <p><strong>Libro:</strong> {{ $compra->libro->titulo }}</p>
                    <p><strong>ISBN:</strong> {{ $compra->libro->isbn ?? 'N/A' }}</p>
                    <p><strong>Fecha de compra:</strong> {{ $compra->fecha_compra->format('d/m/Y') }}</p>
                    <p><strong>Precio:</strong> {{ number_format((float) $compra->precio, 2, ',', '.') }} €</p>
                    <p><strong>Estado:</strong> {{ ucfirst($compra->estado) }}</p>
                    <div class="tablaAccionesBotones">
                        <a href="{{ route('libro.paginaInterna', $compra->libro->id) }}" class="btn-base btn-verde">Ver</a>
                    </div>
                </article>
            @empty
                <p class="sinRegistros">No tienes compras registradas.</p>
            @endforelse
        </div>
    </div>
    <hr>

    {{-- ===================== HISTORIAL DE PUBLICACIONES ===================== --}}
    <div class="historialPublicaciones">
        <h3>Historial de publicaciones</h3>
        <div class="contenedorCardsHistorial">
            @forelse($publicaciones as $publicacion)
                <article class="cardHistorialMovil">
                    <p><strong>Título:</strong> {{ $publicacion->titulo_publicacion }}</p>
                    <p><strong>Resumen:</strong> {{ Str::limit($publicacion->resumen_publicacion, 80) }}</p>
                    <p><strong>Libro:</strong> {{ $publicacion->nombre_libro }}</p>
                    <p><strong>Formato:</strong> {{ strtoupper($publicacion->archivo_extension) }}</p>
                    <p><strong>Fecha de publicación:</strong> {{ $publicacion->fecha_publicacion->format('d/m/Y') }}</p>
                    <div class="tablaAccionesBotones">
                        <button class="btn-base btn-verde">Ver</button>
                    </div>
                </article>
            @empty
                <p class="sinRegistros">No tienes publicaciones registradas.</p>
            @endforelse
        </div>
    </div>
    <hr>

    </section>