@extends('layouts.app')

@section('title', 'Registro')

@section('content')
    <h1>Registro</h1>
    <p>Bienvenido a la sección de registro de la Biblioteca DAW.</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="registro">
        <form action="{{ route('usuario.store') }}" method="POST">
            @csrf

            <label for="name">Nombre completo:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name') <span class="error">{{ $message }}</span> @enderror

            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" value="{{ old('dni') }}" required>
            @error('dni') <span class="error">{{ $message }}</span> @enderror

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email') <span class="error">{{ $message }}</span> @enderror

            <label for="movil">Número móvil</label>
            <input type="number" id="movil" name="movil" placeholder="Número de móvil" value="{{ old('movil') }}">
            @error('movil') <span class="error">{{ $message }}</span> @enderror

            <hr>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            @error('password') <span class="error">{{ $message }}</span> @enderror

            <label for="password_confirmation">Confirmar Contraseña:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <hr>
            <button type="submit">Registrarse</button>
        </form>
    </div>
@endsection