@extends('layouts.app')

@section('title', 'Gestionar Contacto')

@section('content')

    {{-- Pegar el codigo aqui --}}
    <main class="contenedor">
        <section class="gestionarContacto">
            <h1>Gestionar Contacto</h1>
             <ul>
                <li>Direccion: </li>
                <li>Teléfono: 123456789</li>
                <li>Email: contacto@bibliotecadaw.com</li>
                <li>Ubicacion GoogleMaps: asdasd</li>
             </ul>
             <h1>Formulario Contacto</h1>
             <ul>
                <li>Nombre:</li>
                <li>Email:</li>
                <li>Asunto: 
                    <ul>
                        Añadir Asunto nuevo
                        <li> Nuevo asunto: asdasd</li>
                    </ul>
                </li>

             </ul>
        </section>
    </main>


@endsection
