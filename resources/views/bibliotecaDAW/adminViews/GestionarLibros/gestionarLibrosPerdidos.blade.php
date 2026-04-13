@extends('layouts.app')

@section('title', 'Libros Perdidos')

@section('content')

    <main class="contenedor gestionLibrosPerdidos">

        <!-- Encabezado con titulo y descripcion -->
        <div class="librosPerdidosEncabezado">
            <h1>Gestionar Libros Perdidos</h1>
            <p>Registra las bajas de libros extraviados o dañados.</p>
        </div>

        <!-- Mensajes flash de feedback -->
        @if (session('success'))
            <div class="alertaExito">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alertaError">{{ session('error') }}</div>
        @endif

        <!-- Formulario para marcar libro como perdido -->
        <section class="librosPerdidosFormulario">
            <div class="librosPerdidosFormInner">
                <h2>Dar de baja un libro</h2>
                <form action="{{ route('admin.librosPerdidos.marcar') }}" method="POST">
                    @csrf
                    <div class="librosPerdidosGrupoForm">
                        <label for="libro_identificador">Escribe el Titulo o ISBN</label>
                        <input type="text" name="libro_identificador" id="libro_identificador" list="listaLibros"
                            placeholder="Filtrando..." required>
                        <datalist id="listaLibros">
                            @foreach ($libros as $libro)
                                <option value="{{ $libro->isbn }}">{{ $libro->titulo }}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="librosPerdidosGrupoForm">
                        <label for="motivo_baja">Motivo de baja</label>
                        <input type="text" name="motivo_baja" id="motivo_baja" required
                            placeholder="Ej: Perdido por el usuario">
                    </div>
                    <button type="submit" class="librosPerdidosBotonEnvio">Marcar como perdido</button>
                </form>
            </div>
        </section>

        <!-- Listado de libros dados de baja -->
        <section class="librosPerdidosListado">
            <h2>Historial de bajas ({{ count($librosPerdidos) }})</h2>

            <div class="librosPerdidosCards">
                @forelse ($librosPerdidos as $libro)
                    <article class="libroPerdidoCard">
                        <div class="libroPerdidoCardInfo">
                            <h3 class="libroPerdidoCardTitulo">{{ $libro->titulo }}</h3>
                            <span class="libroPerdidoCardAutor">{{ $libro->autor }}</span>
                            <p class="libroPerdidoCardMotivo">{{ $libro->motivo_baja }}</p>
                            <div class="libroPerdidoCardMeta">
                                <span class="libroPerdidoCardMetaItem">Baja: {{ $libro->updated_at->format('d/m/Y H:i') }}</span>
                                @if ($libro->isbn)
                                    <span class="libroPerdidoCardMetaItem">ISBN: {{ $libro->isbn }}</span>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="libroPerdidoCardVacio">No hay libros registrados como perdidos.</p>
                @endforelse
            </div>
        </section>
    </main>

@endsection
