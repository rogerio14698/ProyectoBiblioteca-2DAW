@extends('layouts.app')

@section('title', 'Inicio Login')

@section('content')
    <h1>Bienvenido <span>{{ Auth::user()->name }}</span> a la Biblioteca DAW</h1>
    <p>En esta sección podrás acceder a los servicios exclusivos para usuarios registrados. Explora nuestras opciones de
        alquiler, reservas, compras y eventos organizados por la comunidad.</p>
    <p>Recuerda que para disfrutar de todos los beneficios de la Biblioteca DAW, es necesario tener una cuenta activa e
        iniciar sesión. Si aún no tienes una cuenta, puedes registrarte fácilmente desde la página de inicio.</p>
    <p>¡Disfruta de tu experiencia en la Biblioteca DAW!</p>


    <p>Aqui se podría poner un carrusel de eventos de la bibliteca</p>
    <p>Aqui se podria poner los libros que el usuario ha cogido prestado y cuanto falta para devolver</p>
    <p>Aqui un <button>Publicar libros propios</button></p>

@endsection