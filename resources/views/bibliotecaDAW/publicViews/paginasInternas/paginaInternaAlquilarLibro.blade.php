@extends('layouts.app')

@section('title', 'Página Interna Alquilar Libro')

@section('content')

<section class="paginaInternaAlquilarLibro separador">
    <h1>Hola desde la página interna de Alquilar Libro</h1>
    <!-- para esta pagina tengo que poner una condicion; si el usuario no esta logueado, se le muestra un mensaje de que tiene que iniciar sesión para alquilar un libro, y si esta logueado, se le muestra el formulario para alquilar un libro. -->
    @if (Auth::check())
        <p>Bienvenido, {{ Auth::user()->name }}. Aquí puedes alquilar un libro.</p>
        <!-- Aquí iría el formulario para alquilar un libro -->
    @else
        <p>Debes iniciar sesión para alquilar un libro.</p>
    @endif

</section>



@endsection