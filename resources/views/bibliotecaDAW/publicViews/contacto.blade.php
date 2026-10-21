@extends('layouts.app')

@section('title', 'Contacto | Biblioteca DAW')
@section('meta_description', 'Escribe a la Biblioteca DAW para consultas, propuestas y sugerencias.')

@push('head')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endpush

@section('content')
    @php($footerConfig = \App\Models\FooterConfig::first())
    <section class="capitulo capitulo--tinta">
        <div class="envoltura">
            <header class="portadilla">
                <ol class="migas"><li><a href="{{ url('/biblioteca') }}">Biblioteca</a></li><li aria-current="page">Contacto</li></ol>
                <h1>Hablemos <em>de libros</em></h1>
                <p class="entradilla">Dudas, sugerencias o una propuesta para la agenda: estamos al otro lado.</p>
            </header>
            <div class="dos-columnas">
                <aside aria-label="Datos de contacto">
                    <h2>La biblioteca</h2>
                    <dl class="contacto__datos">
                        <div class="contacto__dato"><dt>Dirección</dt><dd>{{ $footerConfig?->direccion ?: 'Consulta la dirección en el pie de página.' }}</dd></div>
                        <div class="contacto__dato"><dt>Teléfono</dt><dd>@if ($footerConfig?->telefono)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $footerConfig->telefono) }}">{{ $footerConfig->telefono }}</a>@else No disponible @endif</dd></div>
                        <div class="contacto__dato"><dt>Correo</dt><dd>@if ($footerConfig?->email_contacto)<a href="mailto:{{ $footerConfig->email_contacto }}">{{ $footerConfig->email_contacto }}</a>@else No disponible @endif</dd></div>
                        @if ($footerConfig?->horario_semana)<div class="contacto__dato"><dt>Horario entre semana</dt><dd>{{ $footerConfig->horario_semana }}</dd></div>@endif
                    </dl>
                </aside>
                <div class="contacto__formulario">
                    <h2>Escríbenos</h2>
                    <p class="formulario__nota">Te enviaremos un enlace de confirmación al correo para verificar la dirección antes de remitir tu mensaje.</p>
                    @if ($errors->any())
                        <div class="aviso aviso--error formulario__errores" role="alert"><div><strong>Revisa estos campos:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
                    @endif
                    <form class="formulario" action="{{ route('contacto.store') }}" method="POST">
                        @csrf
                        <div class="campo">
                            <label for="nombre">Nombre</label>
                            <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" autocomplete="name" required aria-invalid="{{ $errors->has('nombre') ? 'true' : 'false' }}" @if ($errors->has('nombre')) aria-describedby="error-nombre" @endif>
                            @error('nombre')<p class="campo__error" id="error-nombre">{{ $message }}</p>@enderror
                        </div>
                        <div class="campo">
                            <label for="email">Correo electrónico</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" @if ($errors->has('email')) aria-describedby="error-email" @endif>
                            @error('email')<p class="campo__error" id="error-email">{{ $message }}</p>@enderror
                        </div>
                        <div class="campo">
                            <label for="asunto">Asunto</label>
                            <select id="asunto" name="asunto" required aria-invalid="{{ $errors->has('asunto') ? 'true' : 'false' }}" @if ($errors->has('asunto')) aria-describedby="error-asunto" @endif>
                                <option value="">Selecciona una opción</option>
                                @foreach (['informacion' => 'Solicitud de información', 'evento' => 'Crear o consultar un evento', 'consulta' => 'Consulta general', 'sugerencia' => 'Sugerencia', 'reclamo' => 'Reclamación'] as $valor => $etiqueta)
                                    <option value="{{ $valor }}" @selected(old('asunto') === $valor)>{{ $etiqueta }}</option>
                                @endforeach
                            </select>
                            @error('asunto')<p class="campo__error" id="error-asunto">{{ $message }}</p>@enderror
                        </div>
                        <div class="campo">
                            <label for="mensaje">Mensaje</label>
                            <textarea id="mensaje" name="mensaje" rows="6" required aria-invalid="{{ $errors->has('mensaje') ? 'true' : 'false' }}" @if ($errors->has('mensaje')) aria-describedby="error-mensaje" @endif>{{ old('mensaje') }}</textarea>
                            @error('mensaje')<p class="campo__error" id="error-mensaje">{{ $message }}</p>@enderror
                        </div>
                        <div class="campo-trampa" aria-hidden="true"><label for="web">No rellenar</label><input id="web" name="web" tabindex="-1" autocomplete="off"></div>
                        <div class="campo">
                            <span class="campo__etiqueta">Verificación</span>
                            <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="dark" data-language="es"></div>
                            @error('cf-turnstile-response')<p class="campo__error" id="error-turnstile">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="boton">Enviar mensaje</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection