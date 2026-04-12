@extends('layouts.app')

@section('title', 'Sesión expirada')

@section('content')
    <!-- Página de error 419 personalizada. Cumple estándar AGENTS.md -->
    <main id="main-content" class="contenedorError" style="min-height: 60vh; display: flex; flex-direction: column; align-items: center; justify-content: center; background: var(--color-fondo-global);">
        <h1 style="color: var(--color-primario); font-size: 4rem; margin-bottom: var(--unidad-espaciado);">419</h1>
        <h2 style="color: var(--color-secundario); margin-bottom: var(--unidad-espaciado);">Sesión expirada</h2>
        <p style="color: var(--color-primario); margin-bottom: var(--unidad-espaciado);">Por seguridad, tu sesión ha expirado o el token CSRF no es válido.</p>
        <p style="color: var(--color-secundario); margin-bottom: var(--unidad-espaciado);">URL solicitada: {{ request()->fullUrl() }}</p>
        <ul style="margin-bottom: var(--unidad-espaciado); color: var(--color-primario);">
            <li>Revisa si escribiste bien la dirección</li>
            <li>Vuelve a la página principal</li>
            <li>Usa el buscador</li>
        </ul>
        <form action="/buscar" method="GET" style="margin-bottom: var(--unidad-espaciado); display: flex; gap: var(--unidad-espaciado);">
            <input type="text" name="q" placeholder="Buscar..." style="padding: var(--unidad-espaciado); border-radius: var(--unidad-espaciado); border: 1px solid var(--color-secundario);" />
            <button type="submit" style="background: var(--color-primario); color: #fff; border: none; border-radius: var(--unidad-espaciado); padding: 0 var(--unidad-espaciado);">Buscar</button>
        </form>
        <p style="color: var(--color-secundario); margin-bottom: var(--unidad-espaciado);">Código de error: {{ $errorId ?? uniqid('err_') }}</p>
        <a href="/" class="botonVolver" style="background: var(--color-primario); color: #fff; padding: var(--unidad-espaciado) calc(var(--unidad-espaciado)*2); border-radius: var(--unidad-espaciado); text-decoration: none; box-shadow: var(--sombra-suave); font-size: 1.2rem;">Volver al inicio</a>
    </main>
@endsection
