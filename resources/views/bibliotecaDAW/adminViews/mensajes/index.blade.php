@extends('layouts.admin')

@section('title', 'Mensajes de contacto')

@section('content')
    <main class="a-vista-admin">
        <header class="a-titulo"><div><h1>Mensajes de contacto</h1><p class="a-subtitulo">Bandeja de mensajes con correo confirmado.</p></div></header>
        <section class="a-tarjeta">
            <div class="a-tabla-envoltura">
                <table class="a-tabla">
                    <thead><tr><th>Contacto</th><th>Asunto y mensaje</th><th>Verificación</th><th>Estado</th><th>Fecha</th><th>Acciones</th></tr></thead>
                    <tbody>
                        @forelse ($mensajes as $mensaje)
                            <tr>
                                <td><div class="a-tabla__identidad"><div><strong>{{ $mensaje->nombre }}</strong><span><a href="mailto:{{ $mensaje->email }}">{{ $mensaje->email }}</a></span></div></div></td>
                                <td class="a-mensajes__contenido"><strong>{{ $mensaje->asunto }}</strong><p>{{ $mensaje->mensaje }}</p></td>
                                <td><span class="a-pill {{ $mensaje->email_verificado_at ? 'a-pill--positivo' : 'a-pill--aviso' }}">{{ $mensaje->email_verificado_at ? 'Verificado' : 'Sin verificar' }}</span></td>
                                <td><span class="a-pill {{ $mensaje->estado === 'pendiente' ? 'a-pill--aviso' : ($mensaje->estado === 'leido' ? 'a-pill--positivo' : 'a-pill--neutro') }}">{{ $mensaje->estado === 'pendiente' ? 'Pendiente' : ($mensaje->estado === 'en_proceso' ? 'En proceso' : 'Leído') }}</span></td>
                                <td>{{ $mensaje->created_at?->format('d/m/Y H:i') ?? '—' }}</td>
                                <td>
                                    <div class="a-acciones-fila">
                                        <form action="{{ route('admin.mensajes.update', $mensaje->id) }}" method="POST" class="a-form a-form--inline">
                                            @csrf @method('PATCH')
                                            <label class="visually-hidden" for="mensaje_estado_{{ $mensaje->id }}">Estado del mensaje</label>
                                            <select id="mensaje_estado_{{ $mensaje->id }}" name="estado">
                                                <option value="pendiente" @selected($mensaje->estado === 'pendiente')>Pendiente</option>
                                                <option value="en_proceso" @selected($mensaje->estado === 'en_proceso')>En proceso</option>
                                                <option value="leido" @selected($mensaje->estado === 'leido')>Leído</option>
                                            </select>
                                            <button class="a-boton a-boton--pequeno" type="submit">Guardar</button>
                                        </form>
                                        <details class="a-responder"><summary class="a-boton a-boton--pequeno">Responder</summary>
                                            <form action="{{ route('admin.mensajes.responder', $mensaje->id) }}" method="POST" class="a-form">
                                                @csrf
                                                <label for="mensaje_respuesta_{{ $mensaje->id }}">Respuesta para {{ $mensaje->nombre }}</label>
                                                <textarea id="mensaje_respuesta_{{ $mensaje->id }}" name="respuesta" rows="4" required>{{ old('respuesta') }}</textarea>
                                                @error('respuesta')<p class="a-campo__error">{{ $message }}</p>@enderror
                                                <button class="a-boton a-boton--primario" type="submit">Enviar respuesta</button>
                                            </form>
                                        </details>
                                        <form action="{{ route('admin.mensajes.delete', $mensaje->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este mensaje?')">
                                            @csrf @method('DELETE')
                                            <button class="a-boton a-boton--peligro a-boton--pequeno" type="submit">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6"><p class="a-vacio">No hay mensajes de contacto.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if (method_exists($mensajes, 'links'))<div class="a-paginacion">{{ $mensajes->links() }}</div>@endif
        </section>
    </main>
@endsection
