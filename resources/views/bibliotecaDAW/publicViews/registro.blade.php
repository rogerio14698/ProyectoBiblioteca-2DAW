@extends('layouts.app')

@section('title', 'Registro de socios | Biblioteca DAW')

@section('content')
    <section class="capitulo capitulo--tinta">
        <div class="envoltura envoltura--estrecha">
            <header class="portadilla">
                <ol class="migas"><li><a href="{{ url('/biblioteca') }}">Biblioteca</a></li><li aria-current="page">Registro</li></ol>
                <h1>Haz sitio para <em>más historias</em></h1>
                <p class="entradilla">Crea tu cuenta para disfrutar de los préstamos, las actividades y la comunidad.</p>
            </header>
            @if ($errors->any())
                <div class="aviso aviso--error formulario__errores" role="alert"><div><strong>Revisa los datos del formulario.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
            @endif
            <form class="formulario" action="{{ route('usuario.store') }}" method="POST">
                @csrf
                <div class="campo"><label for="name">Nombre completo</label><input type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name" required aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}">@error('name')<p class="campo__error">{{ $message }}</p>@enderror</div>
                <div class="campo campo--doble">
                    <div class="campo"><label for="dni">DNI</label><input type="text" id="dni" name="dni" value="{{ old('dni') }}" autocomplete="off" required aria-invalid="{{ $errors->has('dni') ? 'true' : 'false' }}">@error('dni')<p class="campo__error">{{ $message }}</p>@enderror</div>
                    <div class="campo"><label for="movil">Teléfono móvil <span class="formulario__nota">(opcional)</span></label><input type="tel" id="movil" name="movil" value="{{ old('movil') }}" autocomplete="tel" aria-invalid="{{ $errors->has('movil') ? 'true' : 'false' }}">@error('movil')<p class="campo__error">{{ $message }}</p>@enderror</div>
                </div>
                <div class="campo"><label for="email">Correo electrónico</label><input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">@error('email')<p class="campo__error">{{ $message }}</p>@enderror</div>
                <div class="campo campo--doble">
                    <div class="campo"><label for="password">Contraseña</label><input type="password" id="password" name="password" autocomplete="new-password" required aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">@error('password')<p class="campo__error">{{ $message }}</p>@enderror</div>
                    <div class="campo"><label for="password_confirmation">Confirmar contraseña</label><input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required aria-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}">@error('password_confirmation')<p class="campo__error">{{ $message }}</p>@enderror</div>
                </div>
                <div class="formulario__acciones"><button type="submit" class="boton">Crear cuenta de socio</button><a href="{{ route('usuario.login.mostrar') }}">Ya tengo una cuenta</a></div>
            </form>
        </div>
    </section>
@endsection