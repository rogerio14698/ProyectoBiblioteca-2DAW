@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    <main class="contenedor perfilEditarUsuario">
        <section class="perfilEditarHeader">
            <h1>Editar Perfil</h1>
            <p>Aquí puedes actualizar la información principal de tu cuenta y mantener tus datos personales al día.</p>
        </section>

        <section class="perfilEditarBloque">
            <div class="perfilEditarIntro">
                <h2>Datos de usuario</h2>
                <p>Revisa cuidadosamente tus datos antes de guardar los cambios para evitar errores en préstamos, compras o comunicaciones.</p>
            </div>

            <form action="{{ route('usuario.perfilActualizar') }}" method="POST" class="perfilEditarForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="campoPerfilEditar">
                    <label for="name">Nombre de usuario</label>
                    <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>
                </div>

                <div class="campoPerfilEditar">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required>
                </div>

                <div class="campoPerfilEditar">
                    <label for="dni">DNI</label>
                    <input type="text" id="dni" name="dni" value="{{ Auth::user()->dni }}" required>
                </div>

                <div class="campoPerfilEditar">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" value="{{ Auth::user()->telefono ?? '0000' }}" required>
                </div>

                <div class="campoPerfilEditar campoCompletoPerfilEditar">
                    <label for="profile_photo">Foto de perfil</label>
                    <input type="file" id="profile_photo" name="profile_photo">
                </div>

                <div class="accionesPerfilEditar campoCompletoPerfilEditar">
                    <button type="submit" class="btn-base btn-verde">Guardar Cambios</button>
                    <button type="button" class="btn-base btn-azul">Cambiar Contraseña</button>
                    <button type="button" class="btn-base btn-rojo">Cerrar Sesión</button>
                </div>
            </form>
        </section>
    </main>


@endsection
