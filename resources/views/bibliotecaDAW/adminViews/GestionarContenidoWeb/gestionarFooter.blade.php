@extends('layouts.app')

@section('title', 'Gestionar Footer')

@section('content')

    <main class="contenedor gestionarFooterPage">
        <h1>Gestión del Footer</h1>
        <p>Edita el contenido del pie de página de la web</p>

        <!--Layout 2 columnas: formulario izquierda, vista previa derecha -->
        <div class="footerLayout">

            <!--Columna izquierda: formulario de edición -->
            <div class="footerFormularioCol">
                <h2>Editar contenido</h2>
                <form action="{{ route('admin.gestionFooter.update') }}" method="POST" class="gestionFormularioCarrusel">
                    @csrf
                    @method('PUT')

                    <!--Sección 1: Información general -->
                    <fieldset class="footerFieldset">
                        <legend>Información general</legend>
                        <div class="gestionGrupoFormulario">
                            <label for="titulo">Título:</label>
                            <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $footerConfig->titulo) }}" required>
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $footerConfig->telefono) }}" required>
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label for="direccion">Dirección:</label>
                            <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $footerConfig->direccion) }}" required>
                        </div>
                    </fieldset>

                    <!--Sección 2: Redes sociales -->
                    <fieldset class="footerFieldset">
                        <legend>Redes sociales</legend>
                        <div class="gestionGrupoFormulario">
                            <label for="instagram_url">Instagram URL:</label>
                            <input type="url" id="instagram_url" name="instagram_url" placeholder="https://instagram.com/..." value="{{ old('instagram_url', $footerConfig->instagram_url) }}">
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label for="linkedin_url">LinkedIn URL:</label>
                            <input type="url" id="linkedin_url" name="linkedin_url" placeholder="https://linkedin.com/..." value="{{ old('linkedin_url', $footerConfig->linkedin_url) }}">
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label for="twitter_url">X / Twitter URL:</label>
                            <input type="url" id="twitter_url" name="twitter_url" placeholder="https://x.com/..." value="{{ old('twitter_url', $footerConfig->twitter_url) }}">
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label for="youtube_url">YouTube URL:</label>
                            <input type="url" id="youtube_url" name="youtube_url" placeholder="https://youtube.com/..." value="{{ old('youtube_url', $footerConfig->youtube_url) }}">
                        </div>
                    </fieldset>

                    <!--Sección 3: Horarios -->
                    <fieldset class="footerFieldset">
                        <legend>Horarios</legend>
                        <div class="gestionGrupoFormulario">
                            <label for="horario_semana">Lunes a Viernes:</label>
                            <input type="text" id="horario_semana" name="horario_semana" value="{{ old('horario_semana', $footerConfig->horario_semana) }}" required>
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label for="horario_sabado">Sábado:</label>
                            <input type="text" id="horario_sabado" name="horario_sabado" value="{{ old('horario_sabado', $footerConfig->horario_sabado) }}" required>
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label for="horario_domingo">Domingo:</label>
                            <input type="text" id="horario_domingo" name="horario_domingo" value="{{ old('horario_domingo', $footerConfig->horario_domingo) }}" required>
                        </div>
                    </fieldset>

                    <!--Sección 4: Contacto y legal -->
                    <fieldset class="footerFieldset">
                        <legend>Contacto y legal</legend>
                        <div class="gestionGrupoFormulario">
                            <label for="email_contacto">Email de contacto:</label>
                            <input type="email" id="email_contacto" name="email_contacto" value="{{ old('email_contacto', $footerConfig->email_contacto) }}" required>
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label for="aviso_legal_url">URL Aviso legal:</label>
                            <input type="text" id="aviso_legal_url" name="aviso_legal_url" placeholder="/avisoLegal" value="{{ old('aviso_legal_url', $footerConfig->aviso_legal_url) }}">
                        </div>
                        <div class="gestionGrupoFormulario">
                            <label for="politica_cookies_url">URL Política de cookies:</label>
                            <input type="text" id="politica_cookies_url" name="politica_cookies_url" placeholder="/politicasCookies" value="{{ old('politica_cookies_url', $footerConfig->politica_cookies_url) }}">
                        </div>
                    </fieldset>

                    <button type="submit" class="gestionBotonEnvio">Guardar cambios</button>
                </form>
            </div>

            <!--Columna derecha: vista previa del footer -->
            <div class="footerPreviewCol">
                <h2>Vista previa</h2>
                <div class="footerPreview">
                    <!--Columna 1: Info -->
                    <div class="footerPreviewBloque">
                        <h3>{{ $footerConfig->titulo }} &copy; {{ date('Y') }}</h3>
                        <p>Tel: {{ $footerConfig->telefono }}</p>
                        <p>{{ $footerConfig->direccion }}</p>
                        <div class="footerPreviewRedes">
                            @if ($footerConfig->instagram_url)
                                <a href="{{ $footerConfig->instagram_url }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram"></i></a>
                            @endif
                            @if ($footerConfig->linkedin_url)
                                <a href="{{ $footerConfig->linkedin_url }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-linkedin"></i></a>
                            @endif
                            @if ($footerConfig->twitter_url)
                                <a href="{{ $footerConfig->twitter_url }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-twitter-x"></i></a>
                            @endif
                            @if ($footerConfig->youtube_url)
                                <a href="{{ $footerConfig->youtube_url }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-youtube"></i></a>
                            @endif
                        </div>
                    </div>
                    <!--Columna 2: Horarios -->
                    <div class="footerPreviewBloque">
                        <h3>Horarios</h3>
                        <p>Lunes a Viernes: {{ $footerConfig->horario_semana }}</p>
                        <p>Sábado: {{ $footerConfig->horario_sabado }}</p>
                        <p>Domingo: {{ $footerConfig->horario_domingo }}</p>
                    </div>
                    <!--Columna 3: Contacto -->
                    <div class="footerPreviewBloque">
                        <h3>Contacto</h3>
                        <p>{{ $footerConfig->email_contacto }}</p>
                        @if ($footerConfig->aviso_legal_url)
                            <p>Aviso legal: <a href="{{ url($footerConfig->aviso_legal_url) }}">Ver</a></p>
                        @endif
                        @if ($footerConfig->politica_cookies_url)
                            <p>Cookies: <a href="{{ url($footerConfig->politica_cookies_url) }}">Ver</a></p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </main>

@endsection
