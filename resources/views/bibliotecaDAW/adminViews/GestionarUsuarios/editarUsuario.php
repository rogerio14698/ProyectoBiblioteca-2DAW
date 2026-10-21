@extends('layouts.admin')
@section('title', 'Editar usuario')
@section('content')
    <main class="a-vista-admin"><header class="a-titulo"><div><h1>Editar usuario</h1><p class="a-subtitulo">La edición de perfiles está disponible desde el listado de usuarios.</p></div><a class="a-boton" href="{{ route('admin.gestionUsuarios') }}">Ir a usuarios</a></header><section class="a-tarjeta"><p class="a-vacio">Selecciona un usuario desde la gestión de usuarios para consultar sus datos.</p></section></main>
@endsection
