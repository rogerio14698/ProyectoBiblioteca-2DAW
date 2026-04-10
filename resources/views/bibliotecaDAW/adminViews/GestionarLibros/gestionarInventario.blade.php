@extends('layouts.app')

@section('title', 'Inventario de Libros')

@section('content')
    <main class="contenedor inventarioPage">
        {{-- Cabecera --}}
        <header class="inventarioEncabezado">
            <div>
                <h1>Gestión de Inventario</h1>
                <p>Consulta el estado de todos los libros de la Biblioteca DAW y genera informes PDF personalizados.</p>
            </div>
        </header>

        {{-- Resumen con cards informativas tipo dashboard --}}
        <section class="inventarioResumen" aria-label="Resumen del inventario">
            <article class="inventarioResumenCard">
                <h3>Total libros</h3>
                <p>{{ $resumen['total'] }}</p>
            </article>
            <article class="inventarioResumenCard inventarioResumenCard--disponible">
                <h3>Disponibles</h3>
                <p>{{ $resumen['disponibles'] }}</p>
            </article>
            <article class="inventarioResumenCard inventarioResumenCard--prestado">
                <h3>Prestados</h3>
                <p>{{ $resumen['prestados'] }}</p>
            </article>
            <article class="inventarioResumenCard">
                <h3>Formato físico</h3>
                <p>{{ $resumen['fisicos'] }}</p>
            </article>
            <article class="inventarioResumenCard">
                <h3>Formato digital</h3>
                <p>{{ $resumen['digitales'] }}</p>
            </article>
            <article class="inventarioResumenCard">
                <h3>Ejemplares totales <br> Unidad de libros</h3>
                <p>{{ $resumen['ejemplares_total'] }}</p>
            </article>
        </section>

        {{-- Formulario de filtros para generar PDF personalizado --}}
        <section class="inventarioFiltros" aria-label="Filtros para informe PDF">
            <h2>Generar Informe PDF</h2>
            <p class="inventarioFiltrosDesc">Selecciona los filtros que desees para generar un informe PDF personalizado. Si no aplicas ningún filtro, se incluirán todos los libros.</p>

            <form action="{{ route('admin.inventario.pdf') }}" method="GET" target="_blank" class="inventarioFiltrosForm">

                <div class="inventarioFiltrosGrid">
                    {{-- Filtro: Disponibilidad --}}
                    <div class="inventarioFiltroCampo">
                        <label for="filtro_disponibilidad">Disponibilidad</label>
                        <select id="filtro_disponibilidad" name="disponibilidad">
                            <option value="">Todos</option>
                            <option value="disponible">Solo disponibles</option>
                            <option value="prestado">Solo prestados</option>
                        </select>
                    </div>

                    {{-- Filtro: Formato --}}
                    <div class="inventarioFiltroCampo">
                        <label for="filtro_formato">Formato</label>
                        <select id="filtro_formato" name="formato">
                            <option value="">Todos</option>
                            <option value="fisico">Físico</option>
                            <option value="digital">Digital</option>
                            <option value="ambos">Ambos</option>
                        </select>
                    </div>

                    {{-- Filtro: Opción de compra --}}
                    <div class="inventarioFiltroCampo">
                        <label for="filtro_opcion">Opción</label>
                        <select id="filtro_opcion" name="opcion_compra">
                            <option value="">Todos</option>
                            <option value="compra">Venta</option>
                            <option value="prestamo">Préstamo</option>
                        </select>
                    </div>

                    {{-- Filtro: Autor (texto libre) --}}
                    <div class="inventarioFiltroCampo">
                        <label for="filtro_autor">Autor</label>
                        <input type="text" id="filtro_autor" name="autor" placeholder="Ej: García Márquez">
                    </div>

                    {{-- Filtro: Género (texto libre) --}}
                    <div class="inventarioFiltroCampo">
                        <label for="filtro_genero">Género</label>
                        <input type="text" id="filtro_genero" name="genero" placeholder="Ej: Novela, Ciencia ficción...">
                    </div>

                    {{-- Filtro: Editorial (texto libre) --}}
                    <div class="inventarioFiltroCampo">
                        <label for="filtro_editorial">Editorial</label>
                        <input type="text" id="filtro_editorial" name="editorial" placeholder="Ej: Planeta, Alfaguara...">
                    </div>

                    {{-- Filtro: Año desde --}}
                    <div class="inventarioFiltroCampo">
                        <label for="filtro_anio_desde">Año desde</label>
                        <input type="number" id="filtro_anio_desde" name="anio_desde" placeholder="Ej: 1990" min="1000" max="2100">
                    </div>

                    {{-- Filtro: Año hasta --}}
                    <div class="inventarioFiltroCampo">
                        <label for="filtro_anio_hasta">Año hasta</label>
                        <input type="number" id="filtro_anio_hasta" name="anio_hasta" placeholder="Ej: 2026" min="1000" max="2100">
                    </div>

                    {{-- Filtro: Título (texto libre) --}}
                    <div class="inventarioFiltroCampo">
                        <label for="filtro_titulo">Título</label>
                        <input type="text" id="filtro_titulo" name="titulo" placeholder="Buscar por título...">
                    </div>

                    {{-- Filtro: Límite de resultados --}}
                    <div class="inventarioFiltroCampo">
                        <label for="filtro_limite">Máximo de libros</label>
                        <input type="number" id="filtro_limite" name="limite" placeholder="Sin límite" min="1" max="10000">
                    </div>
                </div>

                <div class="inventarioFiltrosBtns">
                    <button type="submit" class="btn-base btn-verde">Generar Informe PDF</button>
                    <button type="reset" class="btn-base">Limpiar filtros</button>
                </div>
            </form>
        </section>
    </main>
@endsection
