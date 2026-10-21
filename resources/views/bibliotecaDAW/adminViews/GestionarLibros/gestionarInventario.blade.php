@extends('layouts.admin')

@section('title', 'Inventario de libros')

@section('content')
<div class="a-vista-admin">
    <header class="a-titulo"><div><h1>Inventario de libros</h1><p class="a-subtitulo">Consulta el estado de los fondos y genera informes personalizados.</p></div></header>
<dl class="a-kpis a-kpis--seis"><div><dt>Total libros</dt><dd>{{ $resumen['total'] }}</dd></div><div><dt>Disponibles</dt><dd>{{ $resumen['disponibles'] }}</dd></div><div><dt>Prestados</dt><dd>{{ $resumen['prestados'] }}</dd></div><div><dt>Formato físico</dt><dd>{{ $resumen['fisicos'] }}</dd></div><div><dt>Formato digital</dt><dd>{{ $resumen['digitales'] }}</dd></div><div><dt>Ejemplares totales</dt><dd>{{ $resumen['ejemplares_total'] }}</dd></div></dl><section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Generar informe PDF</h2><p>Sin filtros se incluirán todos los libros. El informe se abre en otra pestaña.</p></div></header>
<form action="{{ route('admin.inventario.pdf') }}" method="GET" target="_blank" class="a-form">

                <div class="a-form__fila a-form__fila--3">
                    <div class="a-campo">
                        <label for="filtro_disponibilidad">Disponibilidad</label>
                        <select id="filtro_disponibilidad" name="disponibilidad">
                            <option value="">Todos</option>
                            <option value="disponible">Solo disponibles</option>
                            <option value="prestado">Solo prestados</option>
                        </select>
                    </div>

                    <div class="a-campo">
                        <label for="filtro_formato">Formato</label>
                        <select id="filtro_formato" name="formato">
                            <option value="">Todos</option>
                            <option value="fisico">Físico</option>
                            <option value="digital">Digital</option>
                            <option value="ambos">Ambos</option>
                        </select>
                    </div>

                    <div class="a-campo">
                        <label for="filtro_opcion">Opción</label>
                        <select id="filtro_opcion" name="opcion_compra">
                            <option value="">Todos</option>
                            <option value="compra">Venta</option>
                            <option value="prestamo">Préstamo</option>
                        </select>
                    </div>

                    <div class="a-campo">
                        <label for="filtro_autor">Autor</label>
                        <input type="text" id="filtro_autor" name="autor" placeholder="Ej: García Márquez">
                    </div>

                    <div class="a-campo">
                        <label for="filtro_genero">Género</label>
                        <input type="text" id="filtro_genero" name="genero" placeholder="Ej: Novela, Ciencia ficción...">
                    </div>

                    <div class="a-campo">
                        <label for="filtro_editorial">Editorial</label>
                        <input type="text" id="filtro_editorial" name="editorial" placeholder="Ej: Planeta, Alfaguara...">
                    </div>

                    <div class="a-campo">
                        <label for="filtro_anio_desde">Año desde</label>
                        <input type="number" id="filtro_anio_desde" name="anio_desde" placeholder="Ej: 1990" min="1000" max="2100">
                    </div>

                    <div class="a-campo">
                        <label for="filtro_anio_hasta">Año hasta</label>
                        <input type="number" id="filtro_anio_hasta" name="anio_hasta" placeholder="Ej: 2026" min="1000" max="2100">
                    </div>

                    <div class="a-campo">
                        <label for="filtro_titulo">Título</label>
                        <input type="text" id="filtro_titulo" name="titulo" placeholder="Buscar por título...">
                    </div>

                    <div class="a-campo">
                        <label for="filtro_limite">Máximo de libros</label>
                        <input type="number" id="filtro_limite" name="limite" placeholder="Sin límite" min="1" max="10000">
                    </div>
                </div>

                <div class="a-form__acciones">
                    <button type="submit" class="a-boton a-boton--primario">Generar informe PDF</button>
                    <button type="reset" class="a-boton">Limpiar filtros</button>
                </div>
            </form>
</section>
</div>
@endsection
