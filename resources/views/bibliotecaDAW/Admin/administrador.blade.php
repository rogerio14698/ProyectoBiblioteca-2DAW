@extends('layouts.app')

@section('title', 'Administrador')

@section('content')
    <h2>Bienvenido al Panel de Administrador</h2>
    <p>Desde aquí puedes gestionar los recursos de la Biblioteca DAW.</p>
    <ul>
        <li><a href="{{ route('admin.libros') }}">Gestionar Libros</a></li>
        <li><a href="{{ route('admin.usuarios') }}">Gestionar Usuarios</a></li>
        <li><a href="{{ route('admin.prestamos') }}">Gestionar Préstamos</a></li>
        <li><a href="{{ route('admin.librosPerdidos') }}">Gestionar Libros Perdidos</a></li>
        <li><a href="{{ route('admin.inventario') }}">Gestionar Inventario</a></li>
        
        <!-- Agrega más enlaces según las funcionalidades que quieras ofrecer -->
    </ul>
    
@endsection