<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirma tu mensaje</title>
</head>
<body style="margin:0;padding:0;background:#0f0b0a;font-family:Georgia,'Times New Roman',serif;color:#f3e9d8;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#0f0b0a;padding:40px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="560" cellpadding="0" cellspacing="0" style="max-width:560px;background:#1b1412;">
                    <tr>
                        <td style="background:#6e1423;padding:28px 32px;">
                            <p style="margin:0;font-size:24px;color:#f3e9d8;">Biblioteca DAW</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;font-size:17px;line-height:1.6;color:#f3e9d8;">
                            <p style="margin:0 0 16px;">Hola {{ $nombre }}:</p>
                            <p style="margin:0 0 16px;">Hemos recibido tu mensaje «{{ $asunto }}». Para que llegue a nuestro equipo, confirma que este correo es tuyo.</p>
                            <p style="margin:28px 0;">
                                <a href="{{ $urlConfirmacion }}" style="background:#c9a227;color:#0f0b0a;padding:14px 28px;text-decoration:none;font-family:Arial,Helvetica,sans-serif;font-weight:700;display:inline-block;">Confirmar mi mensaje</a>
                            </p>
                            <p style="margin:0;font-size:14px;color:#c8b9a3;">El enlace caduca en 48 horas. Si no has escrito a la biblioteca, ignora este correo y el mensaje se descartará.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>