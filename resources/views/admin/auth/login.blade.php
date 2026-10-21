@extends('layouts.app')

@section('title', 'Acceso de administración | Biblioteca DAW')

@section('content')
    <section class="capitulo capitulo--tinta">
        <div class="envoltura envoltura--estrecha">
            <header class="portadilla">
                <ol class="migas"><li><a href="{{ url('/biblioteca') }}">Biblioteca</a></li><li aria-current="page">Administración</li></ol>
                <h1>Área de <em>gestión</em></h1>
                <p class="entradilla">Acceso reservado al equipo administrador de la Biblioteca DAW.</p>
            </header>
            @if ($errors->any())<div class="aviso aviso--error formulario__errores" role="alert"><div><strong>No se pudo iniciar sesión.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>@endif
            <div class="acceso">
                <form class="formulario acceso__formulario" action="{{ route('admin.login.procesar') }}" method="POST">
                    @csrf
                    <div class="campo"><label for="email">Correo electrónico</label><input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="username" required aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">@error('email')<p class="campo__error">{{ $message }}</p>@enderror</div>
                    <div class="campo"><label for="password">Contraseña</label><input type="password" name="password" id="password" autocomplete="current-password" required aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">@error('password')<p class="campo__error">{{ $message }}</p>@enderror</div>
                    <label class="casilla" for="recordar"><input type="checkbox" name="recordar" id="recordar" value="1" @checked(old('recordar'))> Mantener la sesión iniciada</label>
                    <button type="submit" class="boton">Iniciar sesión como administrador</button>
                </form>
                <aside class="panel acceso__demo"><h2 class="panel__titulo">Entorno de demostración</h2><p>Consulta la experiencia del panel con una cuenta de solo lectura.</p><form action="{{ route('admin.login.demo') }}" method="POST">@csrf<button type="submit" class="boton boton--linea">Iniciar demo de administración</button></form></aside>
            </div>
        </div>
    </section>
@endsection