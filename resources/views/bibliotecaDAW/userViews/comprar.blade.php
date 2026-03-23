@extends('layouts.app')

@section('title', 'Comprar')

@section('content')
    <main class="contenedor comprarLibros">
        <section class="comprarHeader">
            <h1>Comprar</h1>
            <p>Bienvenido <span>{{ Auth::user()->name }}</span> a la sección de tienda de la Biblioteca DAW.</p>
        </section>

        <section class="comprarEstado" aria-labelledby="comprarEstadoTitulo">
            <article class="comprarEstadoCard">
                <p class="comprarEstadoEtiqueta">Proximamente</p>
                <h2 id="comprarEstadoTitulo">Estamos trabajando en esta sección</h2>
                <p>
                    En breve podras consultar el listado completo de libros disponibles para compra, revisar precios
                    y gestionar tus pedidos desde esta area.
                </p>
                <div class="comprarEstadoLista">
                    <p>Catalogo de libros en venta.</p>
                    <p>Filtros por autor, genero y formato.</p>
                    <p>Resumen claro del proceso de compra.</p>
                </div>
            </article>
        </section>
    </main>
@endsection