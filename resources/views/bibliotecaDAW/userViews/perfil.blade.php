@extends('layouts.app')
@section('title', 'Mi perfil')
@section('content')
@php($usuario = auth('web')->user())
@include('bibliotecaDAW.userViews._cabeceraSocio', ['titulo' => 'Tu perfil de', 'enfasis' => 'socio', 'entradilla' => 'Consulta tus datos personales y la actividad que compartes con la biblioteca.'])
<section class="capitulo capitulo--tinta-2 capitulo--compacto"><div class="envoltura"><section class="panel socio-identidad" aria-labelledby="datos-personales"><img class="socio-avatar" src="{{ $usuario->profile_photo_url }}" alt="Foto de perfil de {{ $usuario->name }}" width="144" height="144"><div><h2 class="panel__titulo" id="datos-personales">Información personal</h2><dl class="ficha"><dt>Nombre</dt><dd>{{ $usuario->name }}</dd><dt>Correo</dt><dd>{{ $usuario->email }}</dd><dt>Número de socio</dt><dd>{{ $usuario->nSocio }}</dd><dt>Cuota</dt><dd>@if ($usuario->cuotaSocioAlDia())<span class="insignia insignia--verde">Al día hasta {{ $usuario->socio_hasta->format('d/m/Y') }}</span>@else<span class="insignia insignia--neutra">No activa</span>@endif</dd></dl><div class="acciones"><a href="{{ route('usuario.perfilEditar') }}" class="boton">Editar perfil</a><a href="#contenidosHistorial" class="boton boton--linea">Ir a mi actividad</a></div></div></section></div></section>
<section class="capitulo capitulo--tinta capitulo--compacto" id="contenidosHistorial"><div class="envoltura">@include('layouts.historialVersionDesktop')</div></section>
@endsection
