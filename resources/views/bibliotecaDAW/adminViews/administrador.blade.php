@extends('layouts.admin')

@section('title', 'Resumen')

@section('content')
    <main class="a-vista-admin a-dashboard">
        <header class="a-titulo">
            <div>
                <h1>Resumen</h1>
                <p class="a-subtitulo">Actividad de la biblioteca · {{ now()->format('d/m/Y') }}</p>
            </div>
        </header>

        <dl class="a-kpis">
            <div><dt>Libros disponibles</dt><dd>{{ number_format($librosDisponibles, 0, ',', '.') }}</dd></div>
            <div><dt>Eventos próximos</dt><dd>{{ number_format($eventosProximos, 0, ',', '.') }}</dd></div>
            <div><dt>Usuarios registrados</dt><dd>{{ number_format($usuariosRegistrados, 0, ',', '.') }}</dd></div>
            <div><dt>Noticias publicadas</dt><dd>{{ number_format($totalNoticias, 0, ',', '.') }}</dd></div>
        </dl>

        <div class="a-rejilla a-dashboard__rejilla">
            <div class="a-pila">
                <section class="a-tarjeta" aria-labelledby="mensajes-titulo">
                    <header class="a-tarjeta__cabecera">
                        <div><h2 id="mensajes-titulo">Mensajes de contacto</h2><p>Mensajes con correo verificado y acciones pendientes.</p></div>
                        <a class="a-boton a-boton--pequeno" href="{{ route('admin.mensajes.index') }}">Ver bandeja</a>
                    </header>
                    @forelse ($mensajes as $mail)
                        <article class="a-mensaje">
                            <div class="a-mensaje__cabecera">
                                <div><h3>{{ $mail->asunto }}</h3><p>{{ $mail->nombre }} · <a href="mailto:{{ $mail->email }}">{{ $mail->email }}</a></p></div>
                                <span class="a-pill {{ $mail->estado === 'pendiente' ? 'a-pill--aviso' : ($mail->estado === 'leido' ? 'a-pill--positivo' : 'a-pill--neutro') }}">{{ $mail->estado === 'pendiente' ? 'Pendiente' : ($mail->estado === 'en_proceso' ? 'En proceso' : 'Leído') }}</span>
                            </div>
                            <p class="a-mensaje__texto">{{ $mail->mensaje }}</p>
                            <p class="a-mensaje__fecha">{{ $mail->created_at?->format('d/m/Y · H:i') }}</p>
                            <div class="a-mensaje__acciones">
                                <form action="{{ route('admin.mensajes.update', $mail->id) }}" method="POST" class="a-form a-form--inline">
                                    @csrf
                                    @method('PATCH')
                                    <label class="visually-hidden" for="estado_{{ $mail->id }}">Estado de {{ $mail->asunto }}</label>
                                    <select id="estado_{{ $mail->id }}" name="estado">
                                        <option value="pendiente" @selected($mail->estado === 'pendiente')>Pendiente</option>
                                        <option value="en_proceso" @selected($mail->estado === 'en_proceso')>En proceso</option>
                                        <option value="leido" @selected($mail->estado === 'leido')>Leído</option>
                                    </select>
                                    <button class="a-boton a-boton--pequeno" type="submit">Actualizar estado</button>
                                </form>
                                <details class="a-responder">
                                    <summary class="a-boton a-boton--pequeno">Responder</summary>
                                    <form action="{{ route('admin.mensajes.responder', $mail->id) }}" method="POST" class="a-form">
                                        @csrf
                                        <label for="respuesta_{{ $mail->id }}">Respuesta para {{ $mail->nombre }}</label>
                                        <textarea id="respuesta_{{ $mail->id }}" name="respuesta" rows="4" required>{{ old('respuesta') }}</textarea>
                                        @error('respuesta')<p class="a-campo__error">{{ $message }}</p>@enderror
                                        <button class="a-boton a-boton--primario" type="submit">Enviar respuesta</button>
                                    </form>
                                </details>
                                <form action="{{ route('admin.mensajes.delete', $mail->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este mensaje?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="a-boton a-boton--peligro a-boton--pequeno" type="submit">Eliminar</button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <p class="a-vacio">No hay mensajes verificados.</p>
                    @endforelse
                    @if ($mensajes->hasPages())<div class="a-paginacion">{{ $mensajes->links() }}</div>@endif
                </section>

                <section class="a-tarjeta" aria-labelledby="pagos-recientes-titulo">
                    <header class="a-tarjeta__cabecera"><div><h2 id="pagos-recientes-titulo">Últimos pagos</h2><p>Movimientos registrados en Stripe.</p></div></header>
                    <div class="a-tabla-envoltura">
                        <table class="a-tabla">
                            <thead><tr><th>Usuario</th><th>Concepto</th><th>Fecha</th><th>Estado</th><th class="a-num">Importe</th></tr></thead>
                            <tbody>
                                @forelse ($ultimosPagos as $pago)
                                    <tr>
                                        <td>{{ $pago->usuario?->name ?? 'Usuario eliminado' }}</td>
                                        <td>{{ $pago->concepto_texto }}</td>
                                        <td>{{ $pago->pagado_at?->format('d/m/Y') ?? $pago->created_at?->format('d/m/Y') ?? '—' }}</td>
                                        <td><span class="a-pill {{ $pago->estado === 'pagado' ? 'a-pill--positivo' : ($pago->estado === 'fallido' ? 'a-pill--negativo' : 'a-pill--neutro') }}">{{ ucfirst($pago->estado) }}</span></td>
                                        <td class="a-num">{{ $pago->importe_euros }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="a-muted">Todavía no hay pagos.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <aside class="a-pila">
                <section class="a-tarjeta a-ingresos" aria-labelledby="ingresos-titulo">
                    <header class="a-tarjeta__cabecera"><div><h2 id="ingresos-titulo">Ingresos del mes</h2><p>{{ \Illuminate\Support\Str::ucfirst(now()->locale('es')->translatedFormat('F Y')) }}</p></div></header>
                    <p class="a-ingresos__total">{{ number_format($ingresosMes / 100, 2, ',', '.') }} <span>€</span></p>
                    <p class="a-ingresos__nota">Suma de pagos completados este mes.</p>
                    <ul class="a-barras" aria-label="Ingresos por concepto">
                        @foreach ($ingresosPorConcepto as $concepto)
                            <li><span>{{ $concepto['etiqueta'] }}</span><span class="a-barras__pista"><span style="--valor: {{ $concepto['porcentaje'] }}"></span></span><span class="a-num">{{ $concepto['euros'] }}</span></li>
                        @endforeach
                    </ul>
                </section>
                <section class="a-tarjeta" aria-labelledby="operativa-titulo">
                    <header class="a-tarjeta__cabecera"><div><h2 id="operativa-titulo">Operativa</h2><p>Elementos que requieren seguimiento.</p></div></header>
                    <dl class="a-resumen-operativo">
                        <div><dt>Préstamos activos</dt><dd>{{ number_format($prestamosActivos, 0, ',', '.') }}</dd></div>
                        <div><dt>Multas pendientes</dt><dd>{{ number_format($multasPendientes, 0, ',', '.') }}</dd></div>
                    </dl>
                </section>
            </aside>
        </div>
    </main>
@endsection
