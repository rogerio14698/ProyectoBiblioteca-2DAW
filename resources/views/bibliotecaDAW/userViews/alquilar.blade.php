@extends('layouts.app')

@section('title', 'Aquilar')

@section('content')
    <div class="contenedor alquilar">
       <div class="contenidoHeader">
        <h1>Alquilar</h1>
        <p>Bienvenido <span>{{ Auth::user()->name }}</span> a la sección de alquilar de la Biblioteca DAW.</p>
       </div>
        <section class="bloqueAlquilar formularioAlquilerBloque">
        <h2>Formulario para alquilar libros</h2>
        <form action="" class="formularioAlquilar">
            <label for="libroBusqueda">Selecciona el libro que deseas alquilar:</label>
            <div class="buscadorAlquilar">
                <input type="text" id="libroBusqueda" name="libroBusqueda" placeholder="Buscar libro por titulo, autor o ISBN">
            </div>
            <div class="resultadoBusquedaAlquilar">
                <h2>Resultados de búsqueda:</h2>
                <a href="#">
                    <p>Libro 1 - Autor 1 - ISBN: 1234567890</p>
                </a>
                <a href="#">
                    <p>Libro 2 - Autor 2 - ISBN: 0987654321</p>
                </a>


            </div>
            <label for="fecha_devolucion">Fecha de devolución:</label>
            <input type="date" id="fecha_devolucion" name="fecha_devolucion">

            <label for="formato">Formato</label>
            <select name="formato" id="formato">
                <option value="fisico">Físico</option>
                <option value="digital">Digital</option>
            </select>
            <button type="submit" class="btn-base btn-alquilar">Alquilar</button>
        </form>
        </section>

        <section class="bloqueAlquilar calcularPrecio">
            <h2>Calcula el precio de tu alquiler</h2>
            <form action="" class="calcularPrecioForm">
                <label for="dias">Número de días:</label>
                <input type="number" id="dias" name="dias" min="1">
                <button type="submit" class="btn-base btn-azul">Calcular Precio</button>
            </form>
        </section>
        <section class="bloqueAlquilar historialAlquileres">
            <h2>Historial de alquileres</h2>
            <p>Aquí podrás ver el historial de tus alquileres anteriores, incluyendo los libros alquilados, las fechas de
                alquiler y devolución, y el estado de cada alquiler.</p>
        </section>
        <section class="bloqueAlquilar recomendacionesAlquiler">
            <h2>Recomendaciones de libros</h2>
            <p>Basado en tus alquileres anteriores, aquí te recomendamos algunos libros que podrían interesarte.</p>
            <form action="" class="recomendacionesForm">
                <label for="libroRecomendado">Libro recomendado</label>
                <input type="text" id="libroRecomendado" name="libroRecomendado" placeholder="Libro">
                <label for="autorRecomendado">Autor recomendado</label>
                <input type="text" id="autorRecomendado" name="autorRecomendado" placeholder="Autor">
                <label for="comentarioLibro">Comentario sobre el libro</label>
                <textarea name="comentarioLibro" id="comentarioLibro" placeholder="Comentario acerca del libro"></textarea>

            </form>
        </section>
        <section class="bloqueAlquilar soporteAlquiler">
            <h2>Soporte</h2>
            <p>Si tienes alguna pregunta o necesitas ayuda con el proceso de alquiler, no dudes en contactarnos a través de
                nuestro soporte via mail.</p>
        </section>
    </div>



@endsection
