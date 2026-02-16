@extends('layouts.app')

@section('title', 'Aquilar')

@section('content')
    <h1>Aquilar</h1>
    <p>Bienvenido <span>{{ Auth::user()->name }}</span> a la sección de aquilar de la Biblioteca DAW.</p>
    <p>En esta sección podrás alquilar los libros disponibles en la Biblioteca DAW. Para alquilar un libro, simplemente haz
        clic en el botón "Alquilar" junto al libro que deseas alquilar. Asegúrate de tener una cuenta activa y haber
        iniciado sesión para poder alquilar libros.</p>
    <p>Recuerda que el alquiler de libros está sujeto a disponibilidad y a las políticas de la biblioteca. Asegúrate de
        revisar los términos y condiciones antes de realizar un alquiler.</p>
    <p>¡Disfruta de tu lectura!</p>

    <h2>Formulario para alquilar libros</h2>
    <form action="">
        <label for="libro">Selecciona el libro que deseas alquilar:</label> <select name="libro" id="libro">
            <option value="libro1">Libro 1</option>
            <option value="libro2">Libro 2</option>
            <option value="libro3">Libro 3</option>
        </select>
        <label for="fecha_devolucion">Fecha de devolución:</label>
        <input type="date" id="fecha_devolucion" name="fecha_devolucion">

        <label for="">Formato</label>
        <select name="formato" id="formato">
            <option value="fisico">Físico</option>
            <option value="digital">Digital</option>
        </select>
        <button type="submit">Alquilar</button>
    </form>

    <div class="calcular-precio">
        <h2>Calcula el precio de tu alquiler</h2>
        <form action=""> <label for="dias">Número de días:</label> <input type="number" id="dias" name="dias" min="1">
            <button type="submit">Calcular Precio</button>
        </form>
    </div>
    <div class="historial-alquileres">
        <h2>Historial de alquileres</h2>
        <p>Aquí podrás ver el historial de tus alquileres anteriores, incluyendo los libros alquilados, las fechas de
            alquiler y devolución, y el estado de cada alquiler.</p>
    </div>
    <div class="recomendaciones">
        <h2>Recomendaciones de libros</h2>
        <p>Basado en tus alquileres anteriores, aquí te recomendamos algunos libros que podrían interesarte.</p>
        <form action="">
            <input type="text" placeholder="Libro">
            <input type="text" placeholder="Autor">
            <textarea name="" id="" aria-placeholder="Comentario a cerca del libro"></textarea>

        </form>
    </div>
    <div class="soporte">
        <h2>Soporte</h2>
        <p>Si tienes alguna pregunta o necesitas ayuda con el proceso de alquiler, no dudes en contactarnos a través de
            nuestro soporte via mail.</p>
    </div>
    </div>



@endsection