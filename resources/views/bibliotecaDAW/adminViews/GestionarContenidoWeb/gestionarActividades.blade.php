@extends('layouts.admin')
@section('title', 'Actividades')
@section('content')
    <main class="a-vista-admin"><header class="a-titulo"><div><h1>Actividades</h1><p class="a-subtitulo">Gestiona los eventos publicados en la biblioteca.</p></div><a class="a-boton a-boton--primario" href="{{ route('admin.gestionCarrusel') }}">Gestionar eventos</a></header><section class="a-tarjeta"><div class="a-tarjeta__cabecera"><div><h2>Gestión de eventos</h2><p>La creación, edición y publicación de eventos se centraliza en el carrusel de eventos.</p></div></div><a class="a-boton" href="{{ route('admin.gestionCarrusel') }}">Abrir eventos</a></section></main>
@endsection
