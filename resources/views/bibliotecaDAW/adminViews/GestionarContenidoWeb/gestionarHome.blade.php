@extends('layouts.app')

@section('title', 'Gestionar Home')

@section('content')


<main class="contenedor">
    <section>
        <h1>Editar pagina principal</h1>

        <p>Cambiar el slide de Bienvenida</p>

        <form action="#">
            @csrf
            @method('PUT')
            

        </form>
        


    </section>
</main>

@endsection