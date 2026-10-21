@extends('layouts.app')

@section('title', 'Política de cookies | Biblioteca DAW')

@section('content')
    <section class="capitulo capitulo--tinta">
        <div class="envoltura envoltura--estrecha">
            <header class="portadilla">
                <ol class="migas"><li><a href="{{ url('/biblioteca') }}">Biblioteca</a></li><li aria-current="page">Cookies</li></ol>
                <h1>Política de <em>cookies</em></h1>
                <p class="entradilla">Información sobre el uso de cookies en este proyecto académico de Biblioteca DAW.</p>
            </header>
            <article class="lectura">
                <h2>¿Qué son las cookies?</h2>
                <p>Las cookies son pequeños archivos de texto que se almacenan en su dispositivo cuando visita un sitio web. Se utilizan para mejorar la experiencia del usuario, recordar preferencias y recopilar información sobre el uso del sitio.</p>

                <h2>Cookies utilizadas en este proyecto</h2>
                <p>Dado que este proyecto es un entorno de práctica académica, se pueden utilizar cookies de terceros, como las de Google Analytics, para analizar el tráfico del sitio. También se emplean cookies técnicas para mantener la sesión del usuario y recordar sus preferencias durante la navegación.</p>

                <h2>Gestión de cookies</h2>
                <p>Usted puede configurar su navegador para aceptar, rechazar o eliminar las cookies según sus preferencias. Tenga en cuenta que deshabilitar las cookies puede afectar la funcionalidad del sitio y su experiencia de usuario.</p>

                <h2>Cambios en la política de cookies</h2>
                <p>Dado el carácter formativo de este proyecto, la política de cookies puede actualizarse o modificarse para adaptarse a los objetivos académicos y técnicos del entorno de práctica.</p>
                <p>Para cualquier consulta, puedes escribirnos desde el <a href="{{ route('contacto.create') }}">formulario de contacto</a>.</p>
            </article>
        </div>
    </section>
@endsection