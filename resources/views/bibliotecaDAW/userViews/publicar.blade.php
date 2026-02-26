@extends('layouts.app')

@section('title', 'Publicar')

@section('content')
    <h1>Publicar Libros</h1>
    <p>En esta sección puedes publicar libros nuevos o existentes en la biblioteca.</p>

    <form action="">
        <label for="titulo">Título del libro:</label> <input type="text" id="titulo" name="titulo"> <label for="autor">Autor
            del libro:</label> <input type="text" id="autor" name="autor"> <label for="descripcion">Descripción del
            libro:</label> <textarea id="descripcion" name="descripcion"></textarea> <button type="submit">Publicar
            Libro</button>
    </form>
    <h2>Libros publicados por el usuario</h2>
    <p>Aquí se mostrarán los libros que has publicado en la biblioteca, junto con opciones para editar o eliminar cada
        publicación.</p>
    <form action=""> <label for="buscar">Buscar libros publicados:</label> <input type="text" id="buscar" name="buscar">
        <button type="submit">Buscar</button>
    </form>
    <h2>Estadísticas de publicaciones</h2>
    <p>Aquí podrás ver estadísticas relacionadas con tus publicaciones, como el número de veces que tus libros han sido
        alquilados o reservados por otros usuarios.</p>
    <form action=""> <label for="estadisticas">Selecciona una estadística para visualizar:</label> <select id="estadisticas"
            name="estadisticas">
            <option value="alquileres">Número de alquileres</option>
            <option value="reservas">Número de reservas</option>
            <option value="comentarios">Número de comentarios</option>
        </select> <button type="submit">Ver Estadística</button> </form>
    <h2>Comentarios y valoraciones</h2>
    <p>Aquí podrás ver los comentarios y valoraciones que otros usuarios han dejado sobre tus publicaciones, así como la
        opción de responder a esos comentarios.</p>
    <form action=""> <label for="comentarios">Selecciona un libro para ver comentarios:</label> <select id="comentarios"
            name="comentarios">
            <option value="libro1">Libro 1</option>
            <option value="libro2">Libro 2</option>
            <option value="libro3">Libro 3</option>
        </select> <button type="submit">Ver Comentarios</button> </form>
    <h2>Soporte para publicaciones</h2>
    <p>Si tienes alguna pregunta o necesitas ayuda con el proceso de publicación, no dudes en contactarnos a través de
        nuestro soporte via mail.</p>
    <form action=""> <label for="soporte">Enviar una consulta al soporte:</label> <textarea id="soporte"
            name="soporte"></textarea> <button type="submit">Enviar Consulta</button> </form>
    <h2>Políticas de publicación</h2>
    <p>Asegúrate de revisar nuestras políticas de publicación antes de publicar un libro en la biblioteca. Esto incluye
        información sobre el contenido permitido, los derechos de autor y las responsabilidades del usuario al publicar
        libros.</p>
    <form action=""> <label for="politicas">Revisar políticas de publicación:</label> <button type="submit">Revisar
            Políticas</button> </form>
    <h2>Recursos para publicar</h2>
    <p>Aquí encontrarás
        </form>

@endsection