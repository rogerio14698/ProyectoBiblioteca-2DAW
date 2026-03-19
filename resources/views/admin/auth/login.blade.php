@extends('layouts.app')

@section('title', 'Login Administrador')

@section('content')
    <main class="contenedor login">
        <div class="loginHeader">
            <h1>Login Administrador</h1>
            <p>Acceso al panel de administración de la Biblioteca DAW.</p>
        </div>

        @if ($errors->any())
            <div class="alertLogin alert-dangerLogin">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="contenidoLogin">
            <form class="formLogin" action="{{ route('admin.login.procesar') }}" method="POST">
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

                <button type="submit" class="btn-base btn-verde">Iniciar Sesión como Admin</button>
            </form>
            <hr>
        </div>
    </main>
@endsection
