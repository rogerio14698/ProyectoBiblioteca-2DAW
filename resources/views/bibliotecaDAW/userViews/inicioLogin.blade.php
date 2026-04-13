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
            <article class="inicioLoginCard ">
                <p class="inicioLoginEtiqueta">Tu espacio personal</p>
                <h2>Panel de usuario</h2>
                <p>
                    Consulta tus préstamos, revisa próximos eventos, gestiona tus compras y mantén organizada tu
                    actividad dentro de la biblioteca desde un único lugar.
                </p>
                <a href="{{ route('usuario.prestamos') }}" class="btn-base btn-azul">Ver mis préstamos</a>
                <a href="{{ route('usuario.organizarEvento') }}" class="btn-base btn-verde">Ver eventos</a>
            </article>

            <article class="inicioLoginCard">
                <h2>Qué puedes hacer aquí</h2>
                <div class="inicioLoginLista">
                    <a class="btn-base btn-verde" href="{{ route('usuario.alquilar') }}">Alquilar libros físicos o digitales.</a>
                    <a class="btn-base btn-azul" href="{{ route('usuario.comprar') }}">Consultar tus compras y futuras reservas.</a>
                    <a class="btn-base btn-amarillo" href="{{ route('usuario.organizarEvento') }}">Organizar y seguir eventos de la comunidad.</a>
                </div>
            </article>
        </section>
    </main>
@endsection