@extends('layouts.app')

@section('title', $evento->titulo . ' | Biblioteca DAW')

@section('content')
    @php $fechaEvento = \Illuminate\Support\Carbon::parse($evento->fecha_hora)->locale('es'); @endphp
    <section class="capitulo capitulo--tinta">
        <div class="envoltura">
            <header class="portadilla">
                <ol class="migas"><li><a href="{{ url('/biblioteca') }}">Biblioteca</a></li><li><a href="{{ url('/actividades') }}">Agenda</a></li><li aria-current="page">{{ $evento->titulo }}</li></ol>
                <h1>{{ $evento->titulo }}</h1>
                <p class="entradilla">{{ $evento->ubicacion }} · {{ \Illuminate\Support\Str::ucfirst($fechaEvento->translatedFormat('l j \d\e F, Y')) }}</p>
            </header>
            <div class="dos-columnas ficha-evento">
                <article>
                    @if ($evento->imagen_url)
                        <figure class="lamina ficha-evento__imagen"><img src="{{ $evento->imagen_public_url }}" alt="Imagen de {{ $evento->titulo }}" width="1200" height="700"><figcaption>{{ $evento->ubicacion }}</figcaption></figure>
                    @endif
                    <h2>Sobre el encuentro</h2>
                    <p class="articulo__cuerpo">{{ $evento->descripcion }}</p>
                    <dl class="ficha-evento__datos">
                        <div class="ficha-evento__dato"><dt>Fecha</dt><dd>{{ \Illuminate\Support\Str::ucfirst($fechaEvento->translatedFormat('l j \d\e F, Y')) }}</dd></div>
                        <div class="ficha-evento__dato"><dt>Hora</dt><dd>{{ $fechaEvento->format('H:i') }} h</dd></div>
                        <div class="ficha-evento__dato"><dt>Lugar</dt><dd>{{ $evento->ubicacion }}</dd></div>
                        <div class="ficha-evento__dato"><dt>Organiza</dt><dd>{{ $evento->usuario?->name ?? 'Biblioteca DAW' }}</dd></div>
                    </dl>
                </article>
                <aside class="panel">
                    <h2 class="panel__titulo">Participación</h2>
                    @if ($evento->aforo)
                        @php $porcentaje = min(100, (int) round(($evento->asistentes / max(1, $evento->aforo)) * 100)); @endphp
                        <div class="evento__aforo">
                            <div class="evento__aforo-label"><span>{{ $evento->asistentes }} de {{ $evento->aforo }} asistentes</span><span>{{ $evento->plazas_libres }} libres</span></div>
                            <progress class="evento__aforo-barra" aria-label="Ocupación del evento" max="{{ $evento->aforo }}" value="{{ $evento->asistentes }}">{{ $porcentaje }}%</progress>
                        </div>
                    @endif
                    <p><span class="insignia insignia--neutra">Prioridad: {{ $evento->prioridad_texto }}</span></p>
                    <div class="evento__acciones">
                        @if ($evento->esDePago())
                            <div class="evento__compra">
                                <p class="precio">{{ number_format($evento->precio, 2, ',', '.') }} €</p>
                                @auth('web')
                                    @if ($evento->plazas_libres > 0)
                                        <form action="{{ route('pagos.evento', $evento->id) }}" method="POST">@csrf<button type="submit" class="boton">Comprar entrada</button></form>
                                    @else
                                        <p class="aviso aviso--info">El evento está completo.</p>
                                    @endif
                                @else
                                    <a href="{{ route('usuario.login.mostrar') }}" class="boton">Inicia sesión para comprar</a>
                                @endauth
                            </div>
                        @elseif ($evento->plazas_libres > 0)
                            @auth('web')
                                <a href="{{ route('evento.apuntarse', ['id' => $evento->id]) }}" class="boton">Inscribirme gratis</a>
                            @else
                                <p>Para inscribirte, <a href="{{ route('usuario.login.mostrar') }}">inicia sesión</a>.</p>
                            @endauth
                        @else
                            <p class="aviso aviso--info">El evento está completo.</p>
                        @endif
                        <a href="{{ url('/actividades') }}" class="boton boton--linea">Volver a la agenda</a>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection