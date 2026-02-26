@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
    <div class="titulo">
        <h1>Contacto</h1>
        <p>Información de contacto de la Biblioteca DAW.</p>
    </div>
    <section class="contenedor-columnas">

        <div class="columna-izquierda">
            <h2>Dirección</h2>
            <p>Calle Principal, 123, Ciudad, País</p>

            <h2>Teléfono</h2>
            <p>+1 234 567 890</p>

            <h2>Email</h2>
            <p>contacto@bibliotecadaw.com</p>


            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.086123456789!2d-122.41941548468123!3d37.77492977975956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809c12345678%3A0xabcdef1234567890!2sBiblioteca%20DAW!5e0!3m2!1ses-419!2sus!4v1712345678901"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>


        <div class="columna-derecha">
            <form action="#" method="post">
                <h2>Ponte en contacdo con nosotros</h2>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="mensaje">Mensaje:</label><br>
                <textarea id="mensaje" name="mensaje" rows="5" cols="40"></textarea><br><br>

                <input type="submit" value="Enviar">
            </form>
        </div>
        </div>
    </section>
@endsection