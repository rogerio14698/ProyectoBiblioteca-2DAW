@extends('layouts.app')

@section('title', 'Login Administrador')

@section('content')
    <section class="login">
        <div class="headerContenido">
            <h1 class="tituloPagina">Login Administrador</h1>
            <p class="parrafoContenido">Acceso al panel de administración de la Biblioteca DAW.</p>
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
                    <label class="tituloLabel" for="email">Email:</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="labelLogin">
                    <label class="tituloLabel" for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" required>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="labelLogin">
                    <label class="tituloLabel recuerdame" for="recordar">
                        <input type="checkbox" name="recordar" id="recordar">
                        Recuérdame
                    </label>
        </div>
        <div class="btnsInicioSesion">
            <button type="submit" class="btn-base btn-verde">Iniciar Sesión como Admin</button>
            <!--Aún por implementar -->
            <button class="btn-base btn-amarillo">Iniciar Demo Admin</button>
        </div>
        </form>
        <hr>
        </div>
    </section>
@endsection
