@extends('layouts.app')

@section('title', 'Publicar')

@section('content')
   <main class="contenedor publicarUsuario">
     <section class="publicarHeader">
        <h1>Publicar Libros</h1>
        <p>En esta sección puedes proponer nuevas publicaciones, gestionar tus libros y consultar información relacionada con su actividad.</p>
     </section>

     <section class="publicarBloque">
        <div class="publicarIntro">
            <h2>Nueva publicación</h2>
            <p>Completa la información principal del libro para enviar una nueva propuesta de publicación dentro de la biblioteca.</p>
        </div>

        <form action="" class="publicarForm">
            <div class="campoPublicar">
                <label for="titulo">Título del libro</label>
                <input type="text" id="titulo" name="titulo">
            </div>

            <div class="campoPublicar">
                <label for="autor">Autor del libro</label>
                <input type="text" id="autor" name="autor">
            </div>

            <div class="campoPublicar campoCompletoPublicar">
                <label for="descripcion">Descripción del libro</label>
                <textarea id="descripcion" name="descripcion"></textarea>
            </div>

            <div class="accionesPublicar campoCompletoPublicar">
                <div class="campoArchivoPublicar">
                    <label for="archivoLibro" class="labelArchivoPublicar">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span class="labelArchivoTexto">Añade el libro en formato digital</span>
                        <span class="labelArchivoFormatos">PDF, EPUB, MOBI (máx. 50MB)</span>
                    </label>
                    <input type="file" id="archivoLibro" name="archivoLibro" class="inputArchivoPublicar" accept=".pdf,.epub,.mobi">
                </div>
                <button type="submit" class="btn-base btn-verde">Publicar Libro</button>
            </div>
        </form>
     </section>

     <section class="publicarGrid">
        <article class="publicarCard">
            <h2>Libros publicados por el usuario</h2>
            <p>Aquí se mostrarán los libros que has publicado en la biblioteca, junto con opciones para editar o eliminar cada publicación.</p>
            <form action="" class="publicarMiniForm">
                <label for="buscar">Buscar libros publicados</label>
                <input type="text" id="buscar" name="buscar">
                <button type="submit" class="btn-base btn-azul">Buscar</button>
            </form>
        </article>

        <article class="publicarCard">
            <h2>Estadísticas de publicaciones</h2>
            <p>Aquí podrás ver estadísticas relacionadas con tus publicaciones, como el número de veces que tus libros han sido alquilados o reservados por otros usuarios.</p>
            <form action="" class="publicarMiniForm">
                <label for="estadisticas">Selecciona una estadística para visualizar</label>
                <select id="estadisticas" name="estadisticas">
                    <option value="alquileres">Número de alquileres</option>
                    <option value="reservas">Número de reservas</option>
                    <option value="comentarios">Número de comentarios</option>
                </select>
                <button type="submit" class="btn-base btn-azul">Ver Estadística</button>
            </form>
        </article>

        <article class="publicarCard">
            <h2>Comentarios y valoraciones</h2>
            <p>Aquí podrás ver los comentarios y valoraciones que otros usuarios han dejado sobre tus publicaciones, así como la opción de responder a esos comentarios.</p>
            <form action="" class="publicarMiniForm">
                <label for="comentarios">Selecciona un libro para ver comentarios</label>
                <select id="comentarios" name="comentarios">
                    <option value="libro1">Libro 1</option>
                    <option value="libro2">Libro 2</option>
                    <option value="libro3">Libro 3</option>
                </select>
                <button type="submit" class="btn-base btn-azul">Ver Comentarios</button>
            </form>
        </article>

        <article class="publicarCard">
            <h2>Soporte para publicaciones</h2>
            <p>Si tienes alguna pregunta o necesitas ayuda con el proceso de publicación, no dudes en contactarnos a través de nuestro soporte vía mail.</p>
            <form action="" class="publicarMiniForm">
                <label for="soporte">Enviar una consulta al soporte</label>
                <textarea id="soporte" name="soporte"></textarea>
                <button type="submit" class="btn-base btn-azul">Enviar Consulta</button>
            </form>
        </article>

        <article class="publicarCard">
            <h2>Políticas de publicación</h2>
            <p>Asegúrate de revisar nuestras políticas de publicación antes de publicar un libro en la biblioteca. Esto incluye contenido permitido, derechos de autor y responsabilidades del usuario.</p>
            <div class="accionesPublicarCard">
                <button type="button" class="btn-base btn-verde">Revisar Políticas</button>
            </div>
        </article>
     </section>
   </main>

@endsection