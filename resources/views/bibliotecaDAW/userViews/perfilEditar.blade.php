@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    <main class="contenedor perfilEditarUsuario">
        {{-- Cabecera de la sección --}}
        <section class="perfilEditarHeader">
            <h1>Editar Perfil</h1>
            <p>Aquí puedes actualizar la información principal de tu cuenta y mantener tus datos personales al día.</p>
        </section>

        {{-- Mensaje de éxito al actualizar datos --}}
        @if (session('success'))
            <div class="alertaExito" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Mensaje de éxito al cambiar contraseña --}}
        @if (session('password_success'))
            <div class="alertaExito" role="alert">
                {{ session('password_success') }}
            </div>
        @endif

        {{-- ========================================= --}}
        {{-- BLOQUE 1: Datos personales y foto --}}
        {{-- ========================================= --}}
        <section class="perfilEditarBloque">
            <div class="perfilEditarIntro">
                <h2>Datos de usuario</h2>
                <p>Revisa cuidadosamente tus datos antes de guardar los cambios para evitar errores en préstamos, compras o
                    comunicaciones.</p>
            </div>

            <form action="{{ route('usuario.perfilActualizar') }}" method="POST" class="perfilEditarForm"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Campo: Nombre --}}
                <div class="campoPerfilEditar">
                    <label for="name">Nombre de usuario</label>
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                    @error('name')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Email (solo lectura, se usa para login) --}}
                <div class="campoPerfilEditar">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" value="{{ Auth::user()->email }}" disabled>
                    <span class="infoEstatico">El correo no se puede modificar porque se usa para iniciar sesión.</span>
                </div>

                {{-- Campo: DNI --}}
                <div class="campoPerfilEditar">
                    <label for="dni">DNI</label>
                    <input type="text" id="dni" name="dni" value="{{ old('dni', Auth::user()->dni) }}" required>
                    @error('dni')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Teléfono --}}
                <div class="campoPerfilEditar">
                    <label for="movil">Teléfono</label>
                    <input type="text" id="movil" name="movil" value="{{ old('movil', Auth::user()->movil) }}">
                    @error('movil')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Foto de perfil con previsualización --}}
                <div class="campoPerfilEditar campoCompletoPerfilEditar campoFotoPerfil">
                    <label for="profile_photo">Foto de perfil</label>
                    <div class="fotoPerfilPreview">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto de perfil actual" class="fotoPerfilImg"
                            id="previewFoto">
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/jpeg,image/png,image/webp">
                    </div>
                    @error('profile_photo')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Botones de acción --}}
                <div class="accionesPerfilEditar campoCompletoPerfilEditar">
                    <button type="submit" class="btn-base btn-verde">Guardar Cambios</button>
                    <button type="button" class="btn-base btn-azul" id="btnMostrarPassword">Cambiar Contraseña</button>
                </div>
            </form>

            {{-- Formulario de logout separado (HTML no permite formularios anidados) --}}
            <form action="{{ route('logout') }}" method="POST" class="formLogoutEditar">
                @csrf
                <button type="submit" class="btn-base btn-rojo">Cerrar Sesión</button>
            </form>
        </section>

        {{-- ========================================= --}}
        {{-- BLOQUE 2: Cambio de contraseña --}}
        {{-- ========================================= --}}
        <section class="perfilEditarBloque seccionPassword" id="seccionPassword"
            data-password-errors="{{ $errors->has('current_password') || $errors->has('new_password') ? 'true' : 'false' }}">
            <div class="perfilEditarIntro">
                <h2>Cambiar Contraseña</h2>
                <p>Introduce tu contraseña actual para verificar tu identidad y luego escribe la nueva contraseña dos veces.
                </p>
            </div>

            <form action="{{ route('usuario.cambiarPassword') }}" method="POST" class="perfilEditarForm formPassword">
                @csrf
                @method('PUT')

                {{-- Campo: Contraseña actual --}}
                <div class="campoPerfilEditar campoCompletoPerfilEditar">
                    <label for="current_password">Contraseña actual</label>
                    <input type="password" id="current_password" name="current_password" required
                        autocomplete="current-password">
                    @error('current_password')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Nueva contraseña --}}
                <div class="campoPerfilEditar">
                    <label for="new_password">Nueva contraseña</label>
                    <input type="password" id="new_password" name="new_password" required minlength="8"
                        autocomplete="new-password">
                    @error('new_password')
                        <span class="errorCampo">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Confirmar nueva contraseña --}}
                <div class="campoPerfilEditar">
                    <label for="new_password_confirmation">Confirmar nueva contraseña</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                        minlength="8" autocomplete="new-password">
                </div>

                {{-- Botón de guardar contraseña --}}
                <div class="accionesPerfilEditar campoCompletoPerfilEditar">
                    <button type="submit" class="btn-base btn-verde">Actualizar Contraseña</button>
                    <button type="button" class="btn-base btn-rojo" id="btnOcultarPassword">Cancelar</button>
                </div>
            </form>
        </section>
    </main>

@endsection