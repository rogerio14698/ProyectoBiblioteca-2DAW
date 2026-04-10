@extends('layouts.app')

@section('title', 'Libros Perdidos')

@section('content')
    <!-- Enlace al CSS específico de la página (importar en main.css) -->
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/gestionarLibrosPerdidos.css') }}">
    @endpush

    <main class=" contenedor gestionarLibrosPerdidosContenedor">
        <div class="tituloSeccion">
            <h1>Gestionar Libros Perdidos</h1>
        <p>Registra las bajas de libros extraviados o dañados.</p>
        </div>

        {{-- Formulario para marcar libro como perdido --}}
        <section>
            <h2>Dar de baja un libro</h2>
            <form action="{{ route('admin.librosPerdidos.marcar') }}" method="POST" class="formularioBajaLibro">
                @csrf
                <div class="campoLibro">
                    <label for="libro_identificador">Escribe el Título o ISBN</label>
                    <input type="text" name="libro_identificador" id="libro_identificador" list="listaLibros" placeholder="Filtrando..." required>
                    <datalist id="listaLibros">
                        @foreach ($libros as $libro)
                            <option value="{{ $libro->isbn }}">{{ $libro->titulo }}</option>
                        @endforeach
                    </datalist>
                </div>
                <div class="campoMotivo">
                    <label for="motivo_baja">Motivo de baja</label>
                    <input type="text" name="motivo_baja" id="motivo_baja" required placeholder="Ej: Perdido por el usuario">
                </div>
                <button type="submit" class="botonAccion">Marcar como perdido</button>
            </form>
        </section>

        {{-- Listado de libros perdidos --}}
        <section>
            <h2>Historial de bajas</h2>
            @if (count($librosPerdidos) > 0)
                <div class="historialBajas">
                    @foreach ($librosPerdidos as $libro)
                        <article class="tarjetaLibroPerdido">
                            <h3>{{ $libro->titulo }}</h3>
                            <p><strong>Autor:</strong> {{ $libro->autor }}</p>
                            <p><strong>Motivo:</strong> {{ $libro->motivo_baja }}</p>
                            <p class="fechaBaja"><strong>Fecha:</strong> {{ $libro->updated_at->format('d/m/Y H:i') }}</p>
                        </article>
                    @endforeach
                </div>
            @else
                <p>No hay libros registrados como perdidos.</p>
            @endif
        </section>
    </main>
@endsection
