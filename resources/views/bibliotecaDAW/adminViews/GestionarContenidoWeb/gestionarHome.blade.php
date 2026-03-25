@extends('layouts.app')

@section('title', 'Gestionar Home')

@section('content')


    <main class="contenedor gestionarHome">
        <section>
            <h1>Slides bienvenida</h1>
            <p>Rellena el formulario para editar los slides de bienvenida de la página principal</p>

            <form action="">
                <div class="gestionGrupoFormulario">
                    <label for="titulo">Título del Slide:</label>
                    <input type="text" placeholder="Titulo Slide" id="titulo" name="titulo">
                </div>
                <div class="gestionGrupoFormulario">
                    <label for="descripcion">Descripción del Slide:</label>
                    <textarea id="descripcion" name="descripcion"></textarea>
                </div>
                <div class="gestionGrupoFormulario">
                    <label for="imagen">Imagen del Slide:</label>
                    <input type="file" id="imagen" name="imagen">
                </div>
                <div class="gestionGrupoFormulario">
                    <label for="posicion">Posición del slide:</label>
                    <input type="number" id="posicion" name="posicion" min="1">
                </div>
                <div class="gestionGrupoFormulario">
                    <label for="">Orden de los slides</label>
                    <!--Listado de orden de los slides -->
                    <ul>
                        <li>Slide 1: nombre1</li>
                        <li>Slide 2: nombre2</li>
                        <li>Slide 3: nombre3</li>
                    </ul>
                    <a href="#">Cambiar orden</a>
                    <a href="#">Añadir slide</a>
                </div>
                <button type="submit" class="gestionBotonEnvio">Guardar Slide</button>
            </form>

        </section>

        <section>
            <h1>Novedades del catalogo</h1>

        </section>


        <section>
            <h1> Agenda de Eventos </h1>

        </section>


        <section>
            <h1>Noticias</h1>
            
        </section>

    </main>

@endsection
