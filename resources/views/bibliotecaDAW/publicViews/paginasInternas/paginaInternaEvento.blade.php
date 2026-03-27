@extends('layouts.app')

@section('title', 'Página Interna del Libro {{ $libro->titulo }}')

@section('content')

<section class="paginaInternaLibro separador">
    <h1>Hola desde la página interna del Libro {{ $libro->titulo }}</h1>

</section>



@endsection