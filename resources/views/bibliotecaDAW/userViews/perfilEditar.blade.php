@extends('layouts.app')

@section('title', 'Perfil')

@section('content')

    <section class="contenidoHeader">
        <div class="texto-bienvenidaUsuario">
            <h1>Editar Perfil</h1>
            <p>Aqui puedes editar tu perfil de usuario de la Biblioteca DAW.</p>
        </div>
        <div class="formulario-editarPerfil">
            <form action="{{ route('usuario.perfilActualizar') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="campo-formulario">
                    <label for="name">Nombre de usuario:</label>
                    <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required> 
                </div>
                <div class="campo-formulario">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required>
                </div>
                <div class="campo-formulario">
                    <label for="dni">Editar Dni</label>
                    <input type="text" id="dni" name="dni" value="{{ Auth::user()->dni }}" required>
                </div>
                <div class="campo-formulario">
                    <label for="telefono">Editar telefono</label>
                    <input type="text" id="telefono" name="telefono" value="{{ Auth::user()->telefono ?? '0000' }}" required>
                </div>
                <div class="campo-formulario">
                    <label for="profile_photo">Editar foto perfil</label>
                    <input type="file" id="profile_photo" name="profile_photo">
                </div>
                <button type="submit">Guardar Cambios</button>
            </form>

            <hr>
            <button type="button">Cambiar Contraseña</button>
            <button type="button">Cerrar Sesión</button>
        </div>

    </section>


@endsection
