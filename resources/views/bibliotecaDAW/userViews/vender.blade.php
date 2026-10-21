@extends('layouts.app')
@section('title', 'Vender libros')
@section('content')
@include('bibliotecaDAW.userViews._cabeceraSocio', ['titulo' => 'Vender libros en la', 'enfasis' => 'biblioteca', 'entradilla' => 'Estamos preparando un espacio para poner en contacto a lectores y autores de la comunidad.'])
<section class="capitulo capitulo--tinta-2 capitulo--compacto"><div class="envoltura envoltura--estrecha"><section class="panel socio-estado" aria-labelledby="vender-estado"><p><span class="insignia insignia--neutra">En preparación</span></p><h2 class="panel__titulo" id="vender-estado">La venta entre socios aún no está activa</h2><p>En esta sección podrás encontrar información cuando la biblioteca habilite el proceso de venta. No se aceptan solicitudes de venta desde un formulario porque todavía no hay un flujo de gestión disponible.</p><div class="acciones"><a class="boton" href="{{ route('usuario.publicar') }}">Compartir una publicación digital</a><a class="boton boton--linea" href="{{ route('usuario.consultas') }}">Consultar a la biblioteca</a></div></section></div></section>
@endsection
