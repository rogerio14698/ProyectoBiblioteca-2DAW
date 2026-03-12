@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <main class="contenedor login">
        <div class="loginHeader">
            <h1>Login - Usuario</h1>
            <p>Bienvenido a la sección de login de la Biblioteca DAW.</p>
        </div>
        @if ($errors->any())
            <!--Tengo que definir estilos para las alertas -->
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="contenidoLogin">
            <form action="{{ route('usuario.login.procesar') }}" method="POST">
                @csrf
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror

                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror

                <label for="recordar" class="recuerdame">
                    <input type="checkbox" name="recordar" id="recordar">
                    Recuérdame
                </label>

                <button type="submit" class="btn-base btn-verde">Iniciar Sesión</button>
            </form>
            <hr>
            <div class="loginOpciones">
                <p>¿No tienes cuenta? <a href="{{ route('usuario.show') }}">Regístrate aquí</a></p>
                <p><a href="{{ route('admin.login.mostrar') }}">¿Eres administrador? Inicia sesión aquí</a></p>
            </div>
        </div>
    </main>
@endsection
