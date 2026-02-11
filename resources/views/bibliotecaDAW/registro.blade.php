@extends('layouts.app')

@section('title', 'Registro')

@section('content')
    <h1>Registro</h1>
    <p>Bienvenido a la sección de registro de la Biblioteca DAW.</p>
    <div class="registro">
        <input type="text" id="username">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="dni">
        <label for="dni">DNI:</label>
        <input type="email" id="email">
        <label for="email">Correo electrónico:</label>
        <input id="telefono" type="number" placeholder="Número de teléfono">
        <label for="telefono" value="+34">Número de teléfono:</label>
        <hr>
        <!-- Aqui preguntar si es autor autonomo o no -->
        <input type="select">
        <input type="password" id="password">
        <label for="password">Contraseña:</label>
        <hr>
        <input type="password" id="confirm_password">
        <label for="confirm_password">Confirmar Contraseña:</label>
        <hr>
        <button type="submit">Registrarse</button>
    </div>
@endsection