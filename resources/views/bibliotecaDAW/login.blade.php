@extends('layouts.app')

@section('title', 'Login')

@section('content')
  <h1>Login - Usuario</h1>
  <p>Bienvenido a la sección de login de la Biblioteca DAW.</p>
  
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="login">
    <form action="{{ route('usuario.login.procesar') }}" method="POST">
      @csrf
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" value="{{ old('email') }}" required>
      @error('email') <span class="error">{{ $message }}</span> @enderror

      <label for="password">Contraseña:</label>
      <input type="password" name="password" id="password" required>
      @error('password') <span class="error">{{ $message }}</span> @enderror

      <label for="recordar">
        <input type="checkbox" name="recordar" id="recordar">
        Recuérdame
      </label>

      <button type="submit">Iniciar Sesión</button>
    </form>
    <hr>
    <p>¿No tienes cuenta? <a href="{{ route('usuario.show') }}">Regístrate aquí</a></p>
    <p><a href="{{ route('admin.login.mostrar') }}">¿Eres administrador? Inicia sesión aquí</a></p>
  </div>
@endsection