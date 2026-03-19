@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <main class="contenedor login">
        <div class="loginHeader">
            <h1>Login - Usuario</h1>
        </div>
        @if ($errors->any())
            <!--Tengo que definir estilos para las alertas -->
            <div class="alertLogin alert-dangerLogin">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="contenidoLogin">
            <form class="formLogin" action="{{ route('usuario.login.procesar') }}" method="POST">
                @csrf
                <div class="labelLogin">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="labelLogin">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" required>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="labelLogin">
                    <label for="recordar" class="recuerdame">
                    <input type="checkbox" name="recordar" id="recordar">
                    Recuérdame
                </label>
                </div>

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
