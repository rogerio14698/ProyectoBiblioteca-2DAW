@extends('layouts.app')

@section('title', 'Acceso prohibido')

@section('content')
    <!-- Página de error 403 personalizada. Cumple estándar AGENTS.md -->
    <main id="main-content" class="contenedorError" style="min-height: 60vh; display: flex; flex-direction: column; align-items: center; justify-content: center; background: var(--color-fondo-global);">
        <h1 style="color: var(--color-primario); font-size: 4rem; margin-bottom: var(--unidad-espaciado);">403</h1>
        <h2 style="color: var(--color-secundario); margin-bottom: var(--unidad-espaciado);">Acceso prohibido</h2>
        <p style="color: var(--color-primario); margin-bottom: calc(var(--unidad-espaciado) * 2);">No tienes permisos para acceder a esta sección.</p>
        <a href="/" class="botonVolver" style="background: var(--color-primario); color: #fff; padding: var(--unidad-espaciado) calc(var(--unidad-espaciado)*2); border-radius: var(--unidad-espaciado); text-decoration: none; box-shadow: var(--sombra-suave); font-size: 1.2rem;">Volver al inicio</a>
    </main>
@endsection
