@extends('layouts.app')
@section('title', 'Comprar libros')
@section('content')
@include('bibliotecaDAW.userViews._cabeceraSocio', ['titulo' => 'Compra de', 'enfasis' => 'libros', 'entradilla' => 'Consulta la información disponible sobre la tienda de la biblioteca.'])
<section class="capitulo capitulo--tinta-2 capitulo--compacto"><div class="envoltura envoltura--estrecha"><section class="panel socio-estado" aria-labelledby="comprar-estado"><p><span class="insignia insignia--neutra">En preparación</span></p><h2 class="panel__titulo" id="comprar-estado">La tienda todavía no está disponible</h2><p>La compra de libros se habilitará cuando el catálogo de venta está preparado. Mientras tanto, puedes explorar los ejemplares disponibles para préstamo.</p><div class="acciones"><a class="boton" href="{{ route('usuario.alquilar') }}">Explorar préstamos</a><a class="boton boton--linea" href="{{ route('catalogo') }}">Ver catálogo público</a></div></section></div></section>
@endsection
