@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
    <div class="headerContenido">
        <h1 class="tituloPagina">Contacto</h1>
        <p class="parrafoTitulo">Información de contacto con del desarrollador de la web</p>
    </div>
    <section class="contacto separador">


        <section class="contenedor-columnas">
            <div class="columna-izquierda">
                <div class="contactoDirecion">
                    <h2 class="tituloFormulario">Calle: </h2>
                    <p class="textoFormulario">Pintor Orlando Pelayo, 7, 33023</p>
                </div>

                <div class="contactoTelefono">
                    <h2 class="tituloFormulario">Teléfono: </h2>
                    <p class="textoFormulario">+34 629 94 81 07</p>
                </div>

                <div class="contactoEmail">
                    <h2 class="tituloFormulario">Email: </h2>
                    <p class="textoFormulario">rogeriolucas14698@gmail.com</p>
                </div>

                <div class="pdf">
                    <h2 class="tituloFormulario">Descarga mi CV</h2>
                    <h3 class="tituloLabel">Resumen mi perfil:</h3>
                    <p class="textoFormulario">Desarrollador Full Stack finalizando el Grado Superior (DAW), con un enfoque
                        pragmático y orientado a la resolución de problemas. Aporto experiencia práctica en el mantenimiento
                        de aplicaciones en producción, despliegue de entornos con Docker y desarrollo backend con Laravel
                        12. Destaco por mi capacidad para analizar proyectos complejos, refactorizar código heredado y
                        solucionar bugs, aportando valor y estabilidad al software desde el primer día.</p>
                    <div class="cvs-botones">
                        <a class="btn-base btn-verde" href="{{ asset('docs/CV-RogerioLucas-DAW-Spanish.pdf') }}"
                            target="_blank" rel="noopener noreferrer">Spanish CV</a>
                        <a class="btn-base btn-verde" href="{{ asset('docs/CV-RogerioLucas-DAW-English.pdf') }}"
                            target="_blank" rel="noopener noreferrer">English CV</a>
                    </div>
                </div>



            </div>


            <div class="columna-derecha">
                <form action="{{ route('contacto.store') }}" method="post">
                    @csrf
                    <h2 class="tituloFormulario">Ponte en contacto con nosotros</h2>
                    <div class="labelContacto">
                        <label class="tituloLabel" for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>

                    <div class="labelContacto">
                        <label class="tituloLabel" for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="labelContacto">
                        <label class="tituloLabel" for="asunto">Asunto</label>
                        <select id="asunto" name="asunto" required>
                            <option value="">Selecciona un asunto</option>
                            <option value="informacion">Solicitud de información</option>
                            <option value="evento">Crear o información de evento</option>
                            <option value="consulta">Consulta general</option>
                            <option value="sugerencia">Sugerencia</option>
                            <option value="reclamo">Reclamo</option>
                        </select>

                    </div>
                    <div class="labelContacto">
                        <label class="tituloLabel" for="mensaje">Mensaje:</label>
                        <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
                    </div>


                    <button type="submit" class="btn-base btn-verde">Enviar</button>
                </form>
            </div>
        </section>
    </section>
@endsection
