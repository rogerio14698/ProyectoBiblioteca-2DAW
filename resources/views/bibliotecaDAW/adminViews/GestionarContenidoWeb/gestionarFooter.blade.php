@extends('layouts.app')

@section('title', 'Gestionar Footer')

@section('content')

    {{-- Pegar el codigo aqui --}}
    <main class="contenedor">
        <section class="gestionarFooter">
            <h1>1º columna</h1>
            <ul>
                <li>titulo de enlace: Biblioteca DAW</li>
                <li>Contacto:
                    <ul>
                        <li>telefono: 12334567890</li>
                        <li>Calle: Calle 123</li>
                    </ul>
                </li>
                <li>Enlaces:
                    <ul>
                        <li>Instagram:</li>
                        <li>Linkeding:</li>
                        <li>X/twitter:</li>
                        <li>Youtube:</li>
                    </ul>
                </li>
            </ul>

            <h1>2º columna</h1>
            <ul>
                Horarios
                <li>Lunes a viernes: 9:00 - 18:00</li>
                <li>Sábado: 10:00 - 14:00</li>
                <li>Domingo: Cerrado</li>
            </ul>
            <h1>3º columna</h1>
            <ul>
                Contacto
                <li>Contacto Info: info@bibliotecadaw.com</li>
                <li>Aviso legal: </li>
            </ul>
        </section>
    </main>


@endsection
