<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px; }
        .header { border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; margin-bottom: 20px; }
        .footer { margin-top: 30px; font-size: 0.8em; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Hola, {{ $nombreUsuario }}</h2>
        </div>
        
        <p>Hemos recibido tu consulta sobre <strong>"{{ $asuntoOriginal }}"</strong>.</p>
        
        <p><strong>Respuesta de la administración:</strong></p>
        <p style="background: #f9f9f9; padding: 15px; border-left: 4px solid #3498db;">
            {{ $mensajeRespuesta }}
        </p>

        <p>Gracias por contactar con nosotros.</p>

        <div class="footer">
            <p>Atentamente,<br>El equipo de la Biblioteca DAW</p>
        </div>
    </div>
</body>
</html>