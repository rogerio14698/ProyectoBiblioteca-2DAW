@extends('layouts.app')

@section('title', 'Catálogo')

@section('content')
    <div class="contenedor catalogoContenedor">
    <div class="catalogoHeader">
        <h1>Catálogo de la Biblioteca</h1>
    </div>
    
    <div class="catalogoBody">
        @foreach($libros as $libro)
        <div class="catalogoCard">
            <div class="cardImagen">
                <img src="{{ asset('img/elPrincipito.jpg') }}" alt="Portada del libro">
            </div>
            <div class="cardContenido">
                <h2 class="libroTitulo">{{ $libro->titulo }}</h2>
                
                <div class="infoGrid">
                    <div class="infoItem">
                        <span class="infoLabel">Autor:</span>
                        <span class="infoValue">{{ $libro->autor }}</span>
                    </div>
                    <div class="infoItem">
                        <span class="infoLabel">Género:</span>
                        <span class="infoValue">{{ $libro->genero }}</span>
                    </div>
                    <div class="infoItem">
                        <span class="infoLabel">Editorial:</span>
                        <span class="infoValue">{{ $libro->editorial }}</span>
                    </div>
                    <div class="infoItem">
                        <span class="infoLabel">ISBN:</span>
                        <span class="infoValue">POR AÑADIR AÚN</span>
                    </div>
                    <div class="infoItem">
                        <span class="infoLabel">Año:</span>
                        <span class="infoValue">{{ $libro->anio }}</span>
                    </div>
                    <div class="infoItem">
                        <span class="infoLabel">Formatos:</span>
                        <span class="infoValue">{{ $libro->formatos }}</span>
                    </div>
                    <div class="infoItem">
                        <span class="infoLabel">Estado:</span>
                        <span class="infoValue stock-disponible">{{ $libro->estado }}</span>
                    </div>
                </div>
            </div>

            <div class="accionesCatalogo">
                <a href="#" class="btn-ver">Ver detalles</a>
                <a href="#" class="btn-carrito">Añadir al carrito</a>
                <a href="#" class="btn-alquilar">Alquilar ahora</a>
            </div>
        </div>
        @endforeach
         <div class="paginacionBase paginacionCatalogo">
            {{ $libros->links('vendor.pagination.bootstrap-5') }} <!-- Paginación de 10 libros por página -->
        </div>

    </div>
</div>
@endsection