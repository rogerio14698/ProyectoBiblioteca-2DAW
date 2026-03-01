@extends('layouts.app')

@section('title', 'Gestionar Home')

@section('content')
<h1>Gestionar Home</h1>
<p>Desde aquí puedes gestionar el contenido de la página de inicio de la Biblioteca DAW.</p>
<!-- Aquí puedes agregar un formulario para editar el contenido principal, una sección para gestionar noticias o destacados, avisos importantes, horarios, etc. -->

<table>
    <thead>
        <th>id</th>
        <th>Nombre Contenido</th>
        <th>Descripción</th>
        <th>Acciones</th>
    </thead>
    <tbody>
        <td>Noticias Destacadas</td>
        <td>Últimas noticias y eventos destacados de la biblioteca.</td>
        <form action="#">
            <td><button type="submit">Editar</button></td>
            <td><button type="submit">Eliminar</button></td>
        </form>
    </tbody>
</table>