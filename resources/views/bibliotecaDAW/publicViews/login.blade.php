@extends('layouts.app')

@section('title', 'Acceso de socios | Biblioteca DAW')

@section('content')
    <section class="capitulo capitulo--tinta">
        <div class="envoltura envoltura--estrecha">
            <header class="portadilla">
                <ol class="migas"><li><a href="{{ url('/biblioteca') }}">Biblioteca</a></li><li aria-current="page">Acceso</li></ol>
                <h1>Qué bueno <em>verte</em></h1>
                <p class="entradilla">Accede a tu espacio de socio para gestionar préstamos, actividades y publicaciones.</p>
            </header>
            @if ($errors->any())
                <div class="aviso aviso--error formulario__errores" role="alert"><div><strong>No se pudo iniciar sesión.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
            @endif
            <div class="acceso">
                <form class="formulario acceso__formulario" action="{{ route('usuario.login.procesar') }}" method="POST">
                    @csrf
                    <div class="campo"><label for="email">Correo electrónico</label><input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">@error('email')<p class="campo__error">{{ $message }}</p>@enderror</div>
                    <div class="campo"><label for="password">Contraseña</label><input type="password" id="password" name="password" autocomplete="current-password" required aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">@error('password')<p class="campo__error">{{ $message }}</p>@enderror</div>
                    <label class="casilla" for="recordar"><input type="checkbox" name="recordar" id="recordar" value="1" @checked(old('recordar'))> Mantener la sesión iniciada</label>
                    <button type="submit" class="boton">Iniciar sesión</button>
                    <nav class="acceso__enlaces" aria-label="Otras opciones"><a href="{{ route('usuario.show') }}">¿Todavía no tienes cuenta? Regístrate</a><a href="{{ route('admin.login.mostrar') }}">Acceso para administradores</a></nav>
                </form>
                <aside class="panel acceso__demo">
                    <h2 class="panel__titulo">Explora la biblioteca</h2>
                    <p>Entra con el perfil de demostración para recorrer la experiencia de socio.</p>
                    <form action="{{ route('usuario.login.demo') }}" method="POST">@csrf<button type="submit" class="boton boton--linea">Iniciar demo de socio</button></form>
                </aside>
            </div>
        </div>
    </section>
@endsection