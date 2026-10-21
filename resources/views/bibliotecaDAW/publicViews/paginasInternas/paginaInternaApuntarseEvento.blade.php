@extends('layouts.app')

@section('title', 'Inscripción: ' . $evento->titulo . ' | Biblioteca DAW')

@section('content')
    @php $fechaEvento = \Illuminate\Support\Carbon::parse($evento->fecha_hora)->locale('es'); @endphp
    <section class="capitulo capitulo--tinta">
        <div class="envoltura">
            <header class="portadilla">
                <ol class="migas"><li><a href="{{ url('/biblioteca') }}">Biblioteca</a></li><li><a href="{{ url('/actividades') }}">Agenda</a></li><li><a href="{{ route('evento.paginaInterna', $evento->id) }}">{{ $evento->titulo }}</a></li><li aria-current="page">Inscripción</li></ol>
                <h1>Reserva tu <em>plaza</em></h1>
                <p class="entradilla">{{ $evento->titulo }} · {{ $fechaEvento->translatedFormat('d/m/Y, H:i') }} · {{ $evento->ubicacion }}</p>
            </header>
            @if ($evento->esDePago())
                <div class="aviso aviso--info formulario__errores">
                    <div><p>Este evento requiere entrada. Para completar la reserva, compra la entrada primero.</p>
                        @auth('web')
                            @if ($evento->plazas_libres > 0)
                                <form action="{{ route('pagos.evento', $evento->id) }}" method="POST">@csrf<button type="submit" class="boton">Comprar entrada · {{ number_format($evento->precio, 2, ',', '.') }} €</button></form>
                            @else
                                <p>El evento está completo.</p>
                            @endif
                        @else
                            <a href="{{ route('usuario.login.mostrar') }}" class="boton">Inicia sesión para comprar</a>
                        @endauth
                    </div>
                </div>
            @endif

            @auth('web')
                <p>Bienvenido, {{ Auth::guard('web')->user()->name }}. Completa los datos para la vista previa del ticket.</p>
                @if ($errors->any())
                    <div class="aviso aviso--error formulario__errores" role="alert"><div><strong>Revisa los datos.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
                @endif
                @if (session('mensaje'))<div class="aviso aviso--info formulario__errores" role="status">{{ session('mensaje') }}</div>@endif
                @if (session('status'))<div class="aviso aviso--info formulario__errores" role="status">{{ session('status') }}</div>@endif
                <div class="dos-columnas inscripcion-evento">
                    <div class="inscripcion-evento__formulario">
                        <h2>Datos de inscripción</h2>
                        <form class="formulario" id="formApuntarse" action="{{ route('evento.procesarApuntarse', ['id' => $evento->id]) }}" method="POST">
                            @csrf
                            <div class="campo campo--doble">
                                <div class="campo"><label for="nombre">Nombre</label><input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" autocomplete="given-name" required aria-invalid="{{ $errors->has('nombre') ? 'true' : 'false' }}">@error('nombre')<p class="campo__error">{{ $message }}</p>@enderror</div>
                                <div class="campo"><label for="apellido">Apellido</label><input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" autocomplete="family-name" required aria-invalid="{{ $errors->has('apellido') ? 'true' : 'false' }}">@error('apellido')<p class="campo__error">{{ $message }}</p>@enderror</div>
                            </div>
                            <div class="campo"><label for="email">Correo electrónico</label><input type="email" id="email" name="email" value="{{ old('email', Auth::guard('web')->user()->email) }}" autocomplete="email" required aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">@error('email')<p class="campo__error">{{ $message }}</p>@enderror</div>
                            <div class="campo campo--doble">
                                <div class="campo"><label for="nsocio">N.º de socio</label><input type="text" id="nsocio" name="nsocio" value="{{ old('nsocio', Auth::guard('web')->user()->nsocio) }}" required aria-invalid="{{ $errors->has('nsocio') ? 'true' : 'false' }}">@error('nsocio')<p class="campo__error">{{ $message }}</p>@enderror</div>
                                <div class="campo"><label for="telefono">Teléfono</label><input type="tel" id="telefono" name="telefono" value="{{ old('telefono', Auth::guard('web')->user()->movil) }}" autocomplete="tel" required aria-invalid="{{ $errors->has('telefono') ? 'true' : 'false' }}">@error('telefono')<p class="campo__error">{{ $message }}</p>@enderror</div>
                            </div>
                            <div class="inscripcion-evento__botones">
                                <button type="button" id="btnGenerarPdf" class="boton boton--linea">Generar ticket PDF</button>
                                <button type="button" id="btnEnviarEmail" class="boton boton--linea">Enviar ticket por email</button>
                                @unless ($evento->esDePago())<button type="submit" class="boton">Apuntarme al evento</button>@endunless
                            </div>
                        </form>
                        <form id="formPdfOculto" class="ticket__formulario-oculto" action="{{ route('evento.ticketPdf', ['id' => $evento->id]) }}" method="POST" target="_blank">
                            @csrf<input type="hidden" name="nombre"><input type="hidden" name="apellido"><input type="hidden" name="email"><input type="hidden" name="nsocio"><input type="hidden" name="telefono">
                        </form>
                        <div id="feedbackEmail" class="feedbackEmail" role="status" aria-live="polite"></div>
                    </div>
                    <aside class="inscripcion-evento__preview" aria-label="Vista previa del ticket">
                        <h2>Vista previa del ticket</h2>
                        <p><strong>Evento:</strong> {{ $evento->titulo }}</p>
                        <p><strong>Fecha:</strong> {{ $fechaEvento->format('d/m/Y') }}</p>
                        <p><strong>Hora:</strong> {{ $fechaEvento->format('H:i') }}</p>
                        <p><strong>Ubicación:</strong> {{ $evento->ubicacion }}</p>
                        <hr>
                        <p id="previewNombre"><strong>Nombre:</strong> —</p>
                        <p id="previewApellido"><strong>Apellido:</strong> —</p>
                        <p id="previewEmail"><strong>Email:</strong> —</p>
                        <p id="previewNsocio"><strong>Nº Socio:</strong> —</p>
                        <p id="previewTelefono"><strong>Teléfono:</strong> —</p>
                    </aside>
                </div>
            @else
                <div class="panel"><h2 class="panel__titulo">Acceso requerido</h2><p>Inicia sesión para inscribirte y gestionar tu ticket.</p><a class="boton" href="{{ route('usuario.login.mostrar') }}">Iniciar sesión</a></div>
            @endauth
        </div>
    </section>
    <div id="ticketEventoData" class="ticket__datos" data-url-email="{{ route('evento.ticketEmail', ['id' => $evento->id]) }}" data-csrf="{{ csrf_token() }}"></div>
@endsection