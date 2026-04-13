<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket - {{ $evento->titulo }}</title>
    <style>
        /* Estilos inline obligatorios para DomPDF (no soporta CSS externo) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'DejaVu Sans', Arial, sans-serif;
        }

        body {
            padding: 30px;
            color: #1a1a1a;
            background-color: #fff;
        }

        /* Cabecera del ticket con branding */
        .ticketCabecera {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px solid #2e7d32;
            margin-bottom: 25px;
        }

        .ticketCabecera h1 {
            font-size: 22px;
            color: #2e7d32;
            margin-bottom: 6px;
        }

        .ticketCabecera p {
            font-size: 12px;
            color: #666;
        }

        /* Sección de datos del evento */
        .ticketSeccion {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background-color: #fafafa;
        }

        .ticketSeccion h2 {
            font-size: 16px;
            color: #2e7d32;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid #ddd;
        }

        /* Tabla de datos sin aspecto de tabla rígida */
        .ticketDatos {
            width: 100%;
            border-collapse: collapse;
        }

        .ticketDatos td {
            padding: 6px 10px;
            font-size: 13px;
            vertical-align: top;
        }

        .ticketDatos td:first-child {
            font-weight: 700;
            color: #333;
            width: 35%;
        }

        .ticketDatos td:last-child {
            color: #555;
        }

        /* Pie del ticket */
        .ticketPie {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #2e7d32;
            font-size: 11px;
            color: #888;
        }

        .ticketPie p {
            margin-bottom: 4px;
        }

        /* Código de confirmación */
        .codigoConfirmacion {
            text-align: center;
            margin: 20px 0;
            padding: 12px;
            background-color: #e8f5e9;
            border: 2px dashed #2e7d32;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 700;
            color: #2e7d32;
            letter-spacing: 3px;
        }
    </style>
</head>
<body>

    {{-- Cabecera con nombre de la biblioteca --}}
    <div class="ticketCabecera">
        <h1>Biblioteca DAW</h1>
        <p>Ticket de inscripción a evento</p>
    </div>

    {{-- Datos del evento --}}
    <div class="ticketSeccion">
        <h2>Datos del evento</h2>
        <table class="ticketDatos">
            <tr>
                <td>Evento:</td>
                <td>{{ $evento->titulo }}</td>
            </tr>
            <tr>
                <td>Fecha:</td>
                <td>{{ date('d/m/Y', strtotime($evento->fecha_hora)) }}</td>
            </tr>
            <tr>
                <td>Hora:</td>
                <td>{{ date('H:i', strtotime($evento->fecha_hora)) }}h</td>
            </tr>
            <tr>
                <td>Ubicación:</td>
                <td>{{ $evento->ubicacion }}</td>
            </tr>
            <tr>
                <td>Aforo máximo:</td>
                <td>{{ $evento->aforo }} personas</td>
            </tr>
            <tr>
                <td>Plazas disponibles:</td>
                <td>{{ $evento->plazas_libres }}</td>
            </tr>
        </table>
    </div>

    {{-- Datos del asistente --}}
    <div class="ticketSeccion">
        <h2>Datos del asistente</h2>
        <table class="ticketDatos">
            <tr>
                <td>Nombre:</td>
                <td>{{ $nombre }}</td>
            </tr>
            <tr>
                <td>Apellido:</td>
                <td>{{ $apellido }}</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{{ $email }}</td>
            </tr>
            <tr>
                <td>Nº Socio:</td>
                <td>{{ $nsocio }}</td>
            </tr>
            <tr>
                <td>Teléfono:</td>
                <td>{{ $telefono }}</td>
            </tr>
        </table>
    </div>

    {{-- Código de confirmación único --}}
    <div class="codigoConfirmacion">
        {{ $codigoConfirmacion }}
    </div>

    {{-- Pie con fecha de generación --}}
    <div class="ticketPie">
        <p>Ticket generado el {{ now()->format('d/m/Y H:i') }}</p>
        <p>Este documento es tu comprobante de inscripción. Preséntalo en el evento.</p>
    </div>

</body>
</html>
