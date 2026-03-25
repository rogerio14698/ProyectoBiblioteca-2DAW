@extends('layouts.app')

@section('title', 'BASE de Gestión de Contenido Web')

@section('content')

    {{--Pegar el codigo aqui --}}
    <main class="contenedor">
        <section class="gestionCatalogo">
            <h1>Gestión del Contenido del Catálogo</h1>
            <p>Administra los libros y productos del catálogo de la biblioteca</p>

            <div class="anadirLibrosCatalogo">
                <form action="">
                    <div class="labelFormCatalogo">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo">
                    </div>
                    <div class="labelFormCatalogo">
                        <label for="autor">Autor:</label>
                        <input type="text" id="autor" name="autor">
                    </div>
                    <div class="labelFormCatalogo">
                        <label for="isbn">ISBN:</label>
                        <input type="text" id="isbn" name="isbn">
                    </div>
                    <div class="labelFormCatalogo">
                        <label for="anio">Año:</label>
                        <input type="text" id="anio" name="anio">
                    </div>
                    <div class="labelFormCatalogo">
                        <label for="editorial">Editorial:</label>
                        <input type="text" id="editorial" name="editorial">
                    </div>
                    <div class="labelFormCatalogo">
                        <label for="categoria">Categoría:</label>
                        <input type="text" id="categoria" name="categoria">
                    </div>
                    <div class="labelFormCatalogo">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion"></textarea>
                    </div>
                    <div class="labelFormCatalogo">
                        <label for="portada">Portada:</label>
                        <input type="file" id="portada" name="portada">
                    </div>
                    <div class="labelFormCatalogo">
                        <label for="archivo">Archivo:</label>
                        <input type="file" id="archivo" name="archivo">
                    </div>
                    <div class="labelFormCatalogo">
                        <button type="submit">Añadir libro</button>
                    </div>
                </form>
            </div>
        </section>
        <section class="gestionListado">
            <h2>Listado de los libros del catálogo</h2>
            <p>Aqui se mostraria un listado de los libros del catálogo con la opcion de editarlos o eliminarlos</p>
            <div class="gestionTablaBloqueador">
                <!--filtros para que aparezcan en la tabla -->
                <div class="listadoFiltros">
                    <label for="filtroTitulo">Filtrar por título:</label>
                    <input type="text" id="filtroTitulo" name="filtroTitulo">

                    <label for="filtroAutor">Filtrar por autor:</label>
                    <input type="text" id="filtroAutor" name="filtroAutor">

                    <label for="filtroCategoria">Filtrar por categoría:</label>
                    <input type="text" id="filtroCategoria" name="filtroCategoria">

                    <label for="filtroAnio">Filtrar por año:</label>
                    <input type="text" id="filtroAnio" name="filtroAnio">

                    <label for="filtroEditorial">Filtrar por editorial:</label>
                    <input type="text" id="filtroEditorial" name="filtroEditorial">

                    <label for="filtroDisponibilidad">Filtrar por disponibilidad:</label>
                    <select name="filtroDisponibilidad" id="filtroDisponibilidad">
                        <option value="">Todos</option>
                        <option value="disponible">Disponible</option>
                        <option value="no_disponible">No disponible</option>
                    </select>
                </div>

                <table class="gestionTablaEventos">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>ISBN</th>
                            <th>Año</th>
                            <th>Editorial</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Portada</th>
                            <th>Archivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ejemplo de título</td>
                            <td>Ejemplo de autor</td>
                            <td>1234567890</td>
                            <td>2024</td>
                            <td>Ejemplo de editorial</td>
                            <td>Ejemplo de categoría</td>
                            <td>Ejemplo de descripción del libro</td>
                            <td><img src="ruta/portada.jpg" alt="Portada del libro" width="50"></td>
                            <td><a href="ruta/archivo.pdf" target="_blank">Ver archivo</a></td>
                            <td>
                                <button class="btn-base btn-verde">Editar</button>
                                <button class="btn-base btn-rojo">Eliminar</button>
                            </td>
                        </tr>
                        <!-- Aquí se repetirían las filas por cada libro del catálogo -->
                    </tbody>
                </table>
            </div>

        </section>
    </main>



@endsection
