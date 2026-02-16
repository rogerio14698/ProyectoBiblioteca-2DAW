@extends('layouts.app')

@section('title', 'Login Administrador')

@section('content')
    <h1>Login Administrador</h1>
    <p>Acceso al panel de administración de la Biblioteca DAW.</p>

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
        <form action="{{ route('admin.login.procesar') }}" method="POST">
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

            <button type="submit">Iniciar Sesión como Admin</button>
        </form>
        <hr>
        <p><a href="{{ route('usuario.login.mostrar') }}">¿Eres un usuario normal? Inicia sesión aquí</a></p>
    </div>
@endsection