@extends('layouts.app')

@section('title', 'Aviso Legal')

@section('content')
	<div class="headerContenido separador">
		<h1 class="tituloPagina">Políticas de Cookies</h1>
		<p class="parrafoTitulo">Información sobre el uso de cookies en este proyecto académico de Biblioteca DAW.</p>
	</div>

    <section class="contacto separador" aria-labelledby="politicas-cookies">
        <div class="contenedor-columnas">
            <article class="columna-izquierda">
                <h2 id="politicas-cookies" class="tituloFormulario">1. ¿Qué son las cookies?</h2>
                <p class="textoFormulario">
                    Las cookies son pequeños archivos de texto que se almacenan en su dispositivo cuando visita un sitio web. Se utilizan para mejorar la experiencia del usuario, recordar preferencias y recopilar información sobre el uso del sitio.
                </p>

                <h2 class="tituloFormulario">2. Cookies utilizadas en este proyecto</h2>
                <p class="textoFormulario">
                    Dado que este proyecto es un entorno de práctica académica, se utilizan cookies de terceros como pueden ser las de Google Analytics para analizar el tráfico del sitio.
                     Sin embargo, se pueden emplear cookies técnicas para mantener la sesión del usuario y recordar sus preferencias durante la navegación.
                </p>

                <h2 class="tituloFormulario">3. Gestión de cookies</h2>
                <p class="textoFormulario">
                    Usted puede configurar su navegador para aceptar, rechazar o eliminar las cookies según sus preferencias. Tenga en cuenta que deshabilitar las cookies puede afectar la funcionalidad del sitio y su experiencia de usuario.
                </p>
            </article>

            <article class="columna-derecha">
                <div>
                    <h2 class="tituloFormulario">4. Cambios en las políticas de cookies</h2>
                    <p class="textoFormulario">
                        Dado el carácter formativo de este proyecto, las políticas de cookies pueden ser actualizadas o modificadas sin previo aviso para adaptarse a los objetivos académicos y técnicos del entorno de práctica.
                    </p>
                </div>
            </article>
        </div>

	
@endsection
