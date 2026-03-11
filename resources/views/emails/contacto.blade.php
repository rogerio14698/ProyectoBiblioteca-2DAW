{{-- Vista del correo electrónico que recibe el admin cuando un usuario envía el formulario de contacto --}}
{{-- Las variables $nombre, $email, $asunto y $mensaje vienen del Mailable ContactoRecibido --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo mensaje de contacto</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, Helvetica, sans-serif;">

    {{-- Contenedor principal centrado --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 30px 0;">
        <tr>
            <td align="center">

                {{-- Tarjeta principal del email --}}
                <table role="presentation" width="600" cellpadding="0" cellspacing="0"
                       style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

                    {{-- Cabecera verde con el título --}}
                    <tr>
                        <td style="background-color: #2e7d32; padding: 25px 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 700;">
                                📬 Nuevo Mensaje de Contacto
                            </h1>
                            <p style="color: #c8e6c9; margin: 8px 0 0; font-size: 14px;">
                                Biblioteca DAW — Sistema de Contacto
                            </p>
                        </td>
                    </tr>

                    {{-- Cuerpo del email con los datos --}}
                    <tr>
                        <td style="padding: 30px;">

                            {{-- Fila: Nombre --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                                <tr>
                                    <td style="font-size: 12px; font-weight: 600; color: #2e7d32; text-transform: uppercase; letter-spacing: 0.5px; padding-bottom: 4px;">
                                        Nombre
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 16px; color: #333333; padding: 10px 15px; background-color: #f9f9f9; border-left: 3px solid #2e7d32; border-radius: 4px;">
                                        {{ $nombre }}
                                    </td>
                                </tr>
                            </table>

                            {{-- Fila: Email --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                                <tr>
                                    <td style="font-size: 12px; font-weight: 600; color: #2e7d32; text-transform: uppercase; letter-spacing: 0.5px; padding-bottom: 4px;">
                                        Email
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 16px; color: #333333; padding: 10px 15px; background-color: #f9f9f9; border-left: 3px solid #2e7d32; border-radius: 4px;">
                                        <a href="mailto:{{ $email }}" style="color: #2e7d32; text-decoration: none;">{{ $email }}</a>
                                    </td>
                                </tr>
                            </table>

                            {{-- Fila: Asunto --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                                <tr>
                                    <td style="font-size: 12px; font-weight: 600; color: #2e7d32; text-transform: uppercase; letter-spacing: 0.5px; padding-bottom: 4px;">
                                        Asunto
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 16px; color: #333333; padding: 10px 15px; background-color: #f9f9f9; border-left: 3px solid #2e7d32; border-radius: 4px;">
                                        {{ $asunto }}
                                    </td>
                                </tr>
                            </table>

                            {{-- Fila: Mensaje --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 10px;">
                                <tr>
                                    <td style="font-size: 12px; font-weight: 600; color: #2e7d32; text-transform: uppercase; letter-spacing: 0.5px; padding-bottom: 4px;">
                                        Mensaje
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 15px; color: #333333; padding: 15px; background-color: #f9f9f9; border-left: 3px solid #2e7d32; border-radius: 4px; line-height: 1.6;">
                                        {{-- nl2br convierte saltos de línea en <br> para respetar el formato del mensaje --}}
                                        {!! nl2br(e($mensaje)) !!}
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    {{-- Pie del email --}}
                    <tr>
                        <td style="background-color: #e8f5e9; padding: 15px 30px; text-align: center; border-top: 1px solid #c8e6c9;">
                            <p style="margin: 0; font-size: 12px; color: #666666;">
                                Este correo fue generado automáticamente desde el formulario de contacto de
                                <strong style="color: #2e7d32;">Biblioteca DAW</strong>.
                            </p>
                        </td>
                    </tr>

                </table>
                {{-- Fin de la tarjeta --}}

            </td>
        </tr>
    </table>
    {{-- Fin del contenedor principal --}}

</body>
</html>
