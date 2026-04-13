<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo inscrito en tu evento</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1a1a1a; padding: 20px; background-color: #f5f5f5;">

    {{-- Contenedor principal del email --}}
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; border: 1px solid #e0e0e0;">

        {{-- Cabecera --}}
        <h1 style="color: #2e7d32; font-size: 20px; margin-bottom: 10px;">Biblioteca DAW</h1>
        <hr style="border: none; border-top: 2px solid #2e7d32; margin-bottom: 20px;">

        {{-- Mensaje principal --}}
        <p style="font-size: 15px; line-height: 1.6;">
            Hola,<br><br>
            <strong>{{ $nombreAsistente }}</strong> se ha inscrito en tu evento
            <strong>«{{ $evento->titulo }}»</strong>.
        </p>

        {{-- Datos del evento --}}
        <div style="background-color: #f9f9f9; padding: 15px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #2e7d32;">
            <p style="margin: 4px 0;"><strong>Fecha:</strong> {{ date('d/m/Y', strtotime($evento->fecha_hora)) }}</p>
            <p style="margin: 4px 0;"><strong>Hora:</strong> {{ date('H:i', strtotime($evento->fecha_hora)) }}h</p>
            <p style="margin: 4px 0;"><strong>Ubicación:</strong> {{ $evento->ubicacion }}</p>
        </div>

        <p style="font-size: 14px; line-height: 1.6;">
            Encontrarás adjunto el ticket PDF del asistente con todos sus datos de inscripción.
        </p>

        {{-- Pie del email --}}
        <hr style="border: none; border-top: 1px solid #ddd; margin-top: 25px;">
        <p style="font-size: 12px; color: #888; text-align: center;">
            Este email ha sido enviado automáticamente desde Biblioteca DAW.
        </p>
    </div>

</body>
</html>
