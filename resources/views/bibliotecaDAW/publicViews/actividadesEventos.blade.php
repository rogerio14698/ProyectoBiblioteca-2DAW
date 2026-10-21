@extends('layouts.app')

@section('title', 'Actividades y eventos | Biblioteca DAW')
@section('meta_description', 'Consulta la agenda cultural de la Biblioteca DAW.')

@section('content')
    <section class="capitulo capitulo--tinta">
        <div class="envoltura">
            <header class="portadilla">
                <ol class="migas"><li><a href="{{ url('/biblioteca') }}">Biblioteca</a></li><li aria-current="page">Agenda</li></ol>
                <h1>Encuentros y <em>lecturas</em></h1>
                <p class="entradilla">Una agenda para compartir ideas, historias y tiempo en la biblioteca.</p>
            </header>
            @if ($eventos->isEmpty())
                <p class="vacio">No hay actividades programadas por ahora.</p>
            @else
                <ol class="agenda">
                    @foreach ($eventos as $evento)
                        @php $fecha = \Illuminate\Support\Carbon::parse($evento->fecha_hora)->locale('es'); @endphp
                        <li class="agenda__fila">
                            <time class="agenda__fecha" datetime="{{ $fecha->toIso8601String() }}">
                                <span class="agenda__dia">{{ $fecha->format('d') }}</span>
                                <span class="agenda__mes">{{ \Illuminate\Support\Str::ucfirst($fecha->translatedFormat('M Y · H:i')) }}</span>
                            </time>
                            <div class="agenda__cuerpo">
                                <h3><a href="{{ route('evento.paginaInterna', ['id' => $evento->id]) }}">{{ $evento->titulo }}</a></h3>
                                <p>{{ \Illuminate\Support\Str::limit($evento->descripcion, 180) }}</p>
                                <p class="agenda__lugar"><span>{{ $evento->ubicacion }}</span>@if ($evento->aforo)<span>{{ $evento->plazas_libres }} plazas libres</span>@endif</p>
                            </div>
                            <p class="agenda__precio">
                                @if ($evento->esDePago())
                                    <span class="precio">{{ number_format($evento->precio, 2, ',', '.') }} €</span>
                                @else
                                    <span class="insignia insignia--verde">Gratis</span>
                                @endif
                            </p>
                            <span class="agenda__accion" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                        </li>
                    @endforeach
                </ol>
                <nav class="catalogo__paginacion" aria-label="Páginas de la agenda">{{ $eventos->links() }}</nav>
            @endif
        </div>
    </section>
    <section class="capitulo capitulo--tinta-2 capitulo--compacto">
        <div class="envoltura">
            <div class="encabezado">
                <h2>¿Quieres proponer una actividad?</h2>
                <p>Cuéntanos tu idea y el equipo de la biblioteca te ayudará a darle forma.</p>
            </div>
            <a href="{{ route('contacto.create') }}" class="boton">Contactar con la biblioteca</a>
        </div>
    </section>
@endsection