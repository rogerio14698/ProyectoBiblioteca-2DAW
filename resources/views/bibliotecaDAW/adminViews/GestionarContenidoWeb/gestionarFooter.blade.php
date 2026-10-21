@extends('layouts.admin')

@section('title', 'Pie de página')

@section('content')
<div class="a-vista-admin">
    <header class="a-titulo"><div><h1>Pie de página</h1><p class="a-subtitulo">Edita los datos de contacto, los horarios y los enlaces de la web.</p></div></header>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Editar contenido</h2></div></header>
<form action="{{ route('admin.gestionFooter.update') }}" method="POST" class="a-form">
                    @csrf
                    @method('PUT')


                    <fieldset class="a-grupo-campos">
                        <legend>Información general</legend><div class="a-form__fila a-form__fila--3">
                        <div class="a-campo">
                            <label for="titulo">Título:</label>
                            <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $footerConfig->titulo) }}" required>
                        </div>
                        <div class="a-campo">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $footerConfig->telefono) }}" required>
                        </div>
                        <div class="a-campo">
                            <label for="direccion">Dirección:</label>
                            <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $footerConfig->direccion) }}" required>
                        </div>
                    </div></fieldset>


                    <fieldset class="a-grupo-campos">
                        <legend>Redes sociales</legend><div class="a-form__fila a-form__fila--3">
                        <div class="a-campo">
                            <label for="instagram_url">Instagram URL:</label>
                            <input type="url" id="instagram_url" name="instagram_url" placeholder="https://instagram.com/..." value="{{ old('instagram_url', $footerConfig->instagram_url) }}">
                        </div>
                        <div class="a-campo">
                            <label for="linkedin_url">LinkedIn URL:</label>
                            <input type="url" id="linkedin_url" name="linkedin_url" placeholder="https://linkedin.com/..." value="{{ old('linkedin_url', $footerConfig->linkedin_url) }}">
                        </div>
                        <div class="a-campo">
                            <label for="twitter_url">X / Twitter URL:</label>
                            <input type="url" id="twitter_url" name="twitter_url" placeholder="https://x.com/..." value="{{ old('twitter_url', $footerConfig->twitter_url) }}">
                        </div>
                        <div class="a-campo">
                            <label for="youtube_url">YouTube URL:</label>
                            <input type="url" id="youtube_url" name="youtube_url" placeholder="https://youtube.com/..." value="{{ old('youtube_url', $footerConfig->youtube_url) }}">
                        </div>
                    </div></fieldset>


                    <fieldset class="a-grupo-campos">
                        <legend>Horarios</legend><div class="a-form__fila a-form__fila--3">
                        <div class="a-campo">
                            <label for="horario_semana">Lunes a viernes:</label>
                            <input type="text" id="horario_semana" name="horario_semana" value="{{ old('horario_semana', $footerConfig->horario_semana) }}" required>
                        </div>
                        <div class="a-campo">
                            <label for="horario_sabado">Sábado:</label>
                            <input type="text" id="horario_sabado" name="horario_sabado" value="{{ old('horario_sabado', $footerConfig->horario_sabado) }}" required>
                        </div>
                        <div class="a-campo">
                            <label for="horario_domingo">Domingo:</label>
                            <input type="text" id="horario_domingo" name="horario_domingo" value="{{ old('horario_domingo', $footerConfig->horario_domingo) }}" required>
                        </div>
                    </div></fieldset>


                    <fieldset class="a-grupo-campos">
                        <legend>Contacto y legal</legend><div class="a-form__fila a-form__fila--3">
                        <div class="a-campo">
                            <label for="email_contacto">Email de contacto:</label>
                            <input type="email" id="email_contacto" name="email_contacto" value="{{ old('email_contacto', $footerConfig->email_contacto) }}" required>
                        </div>
                        <div class="a-campo">
                            <label for="aviso_legal_url">URL del aviso legal:</label>
                            <input type="text" id="aviso_legal_url" name="aviso_legal_url" placeholder="/avisoLegal" value="{{ old('aviso_legal_url', $footerConfig->aviso_legal_url) }}">
                        </div>
                        <div class="a-campo">
                            <label for="politica_cookies_url">URL de la política de cookies:</label>
                            <input type="text" id="politica_cookies_url" name="politica_cookies_url" placeholder="/politicasCookies" value="{{ old('politica_cookies_url', $footerConfig->politica_cookies_url) }}">
                        </div>
                    </div></fieldset>

                    <button type="submit" class="a-boton a-boton--primario">Guardar cambios</button>
                </form>
</section>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Contenido publicado</h2></div></header>
<dl class="a-ficha"><div><dt>Título</dt><dd>{{ $footerConfig->titulo }} &copy; {{ date('Y') }}</dd></div><div><dt>Teléfono</dt><dd>{{ $footerConfig->telefono }}</dd></div><div><dt>Dirección</dt><dd>{{ $footerConfig->direccion }}</dd></div><div><dt>Correo electrónico</dt><dd>{{ $footerConfig->email_contacto }}</dd></div><div><dt>Lunes a viernes</dt><dd>{{ $footerConfig->horario_semana }}</dd></div><div><dt>Sábado</dt><dd>{{ $footerConfig->horario_sabado }}</dd></div><div><dt>Domingo</dt><dd>{{ $footerConfig->horario_domingo }}</dd></div></dl><nav class="a-enlaces-pie" aria-label="Enlaces publicados">@if ($footerConfig->instagram_url)<a href="{{ $footerConfig->instagram_url }}" target="_blank" rel="noopener noreferrer">Instagram</a>@endif @if ($footerConfig->linkedin_url)<a href="{{ $footerConfig->linkedin_url }}" target="_blank" rel="noopener noreferrer">LinkedIn</a>@endif @if ($footerConfig->twitter_url)<a href="{{ $footerConfig->twitter_url }}" target="_blank" rel="noopener noreferrer">X / Twitter</a>@endif @if ($footerConfig->youtube_url)<a href="{{ $footerConfig->youtube_url }}" target="_blank" rel="noopener noreferrer">YouTube</a>@endif<a href="{{ $footerConfig->aviso_legal_url }}">Aviso legal</a><a href="{{ $footerConfig->politica_cookies_url }}">Política de cookies</a></nav>
</section>
</div>
@endsection
