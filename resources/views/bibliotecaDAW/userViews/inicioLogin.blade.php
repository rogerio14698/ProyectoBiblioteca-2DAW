@extends('layouts.app')

@section('title', 'Inicio Login')

@section('content')
    <main class="contenedor inicioLoginUsuario">
        <section class="inicioLoginHeader">
            <h1>Bienvenido <span>{{ Auth::user()->name }}</span> a la Biblioteca DAW</h1>
            <p>
                En esta sección podrás acceder a los servicios exclusivos para usuarios registrados. Desde aquí tendrás
                una visión general de tu actividad y accesos directos a las funcionalidades más importantes.
            </p>
        </section>

        <section class="inicioLoginResumen">
            <article class="inicioLoginCard inicioLoginCardDestacada">
                <p class="inicioLoginEtiqueta">Tu espacio personal</p>
                <h2>Panel de usuario</h2>
                <p>
                    Consulta tus préstamos, revisa próximos eventos, gestiona tus compras y mantén organizada tu
                    actividad dentro de la biblioteca desde un único lugar.
                </p>
            </article>

            <article class="inicioLoginCard">
                <h2>Qué puedes hacer aquí</h2>
                <div class="inicioLoginLista">
                    <p>Alquilar libros físicos o digitales.</p>
                    <p>Consultar tus compras y futuras reservas.</p>
                    <p>Organizar y seguir eventos de la comunidad.</p>
                </div>
            </article>
        </section>

        <section class="inicioLoginGrid">
            <article class="inicioLoginCard">
                <h2>Próximos pasos recomendados</h2>
                <p>
                    Si acabas de iniciar sesión, puedes comenzar revisando tu perfil, explorando el catálogo o
                    preparando un nuevo préstamo según tus intereses actuales.
                </p>
                <div class="inicioLoginLista">
                    <p>Revisa los libros que tienes en préstamo.</p>
                    <p>Comprueba fechas de devolución pendientes.</p>
                    <p>Descubre nuevas lecturas según tu actividad.</p>
                </div>
            </article>

            <article class="inicioLoginCard">
                <h2>Actividad sugerida</h2>
                <p>
                    Este panel puede servir como punto de inicio diario para ver novedades de la biblioteca y acceder
                    rápidamente a las tareas más frecuentes de tu cuenta.
                </p>
                <div class="inicioLoginAcciones">
                    <button type="button" class="btn-base btn-azul">Ver mis préstamos</button>
                    <button type="button" class="btn-base btn-verde">Explorar catálogo</button>
                </div>
            </article>

            <article class="inicioLoginCard">
                <h2>Espacio para futuras mejoras</h2>
                <p>
                    Más adelante aquí podrás mostrar recordatorios, recomendaciones personalizadas, un resumen de tus
                    eventos y avisos importantes relacionados con tu cuenta.
                </p>
                <div class="inicioLoginLista">
                    <p>Carrusel de eventos destacados.</p>
                    <p>Estado de préstamos activos.</p>
                    <p>Acceso rápido para publicar libros propios.</p>
                </div>
            </article>
        </section>
    </main>
@endsection