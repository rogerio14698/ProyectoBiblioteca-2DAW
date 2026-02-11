@extends('layouts.app')

@section('title', 'Login')

@section('content')
  <h1>Login</h1>
  <p>Bienvenido a la sección de login de la Biblioteca DAW.</p>
  <p>Aqui quiero poner un logo de la bilioteca pequeño</p>
  <div class="login">
    <input type="text" id="username">
    <label for="username">Nombre de usuario:</label>

    <input type="password" id="password">
    <label for="password">Contraseña:</label>

    <button type="submit">Iniciar Sesión</button>
    <hr>
  </div>
@endsection