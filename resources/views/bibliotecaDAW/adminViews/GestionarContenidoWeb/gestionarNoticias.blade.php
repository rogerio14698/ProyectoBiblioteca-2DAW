@extends('layouts.app')

@section('title', 'Gestionar Noticias')

@section('content')

    {{-- Pegar el codigo aqui --}}
    <main class="contenedor">
        <section>
            <h1>Gestionar Noticias</h1>
            <p>Añadir noticias y ver todas las noticias existentes. CRUD</p>
            <form action="">
                <label for="titulo">Titulo de la noticia:</label>
                <input type="text" id="titulo" name="titulo">

                <label for="contenido">Contenido de la noticia:</label>
                <textarea id="contenido" name="contenido"></textarea>

                <button type="submit">Guardar Noticia</button>
            </form>
        </section>
    </main>


@endsection
