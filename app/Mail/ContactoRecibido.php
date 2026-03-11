<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable que se envía cuando un usuario rellena el formulario de contacto.
 * Contiene los datos del formulario: nombre, email, asunto y mensaje.
 * Se envía al correo del administrador de la biblioteca.
 */
class ContactoRecibido extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Constructor: recibe los datos validados del formulario de contacto.
     * Usamos Constructor Property Promotion de PHP 8.3.
     *
     * @param string $nombre  Nombre del remitente.
     * @param string $email   Email del remitente.
     * @param string $asunto  Asunto seleccionado en el formulario.
     * @param string $mensaje Cuerpo del mensaje enviado.
     */
    public function __construct(
        public readonly string $nombre,
        public readonly string $email,
        public readonly string $asunto,
        public readonly string $mensaje,
    ) {}

    /**
     * Definir el sobre del correo: asunto y remitente de respuesta.
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Asunto visible en la bandeja de entrada del admin.
            subject: 'Nuevo mensaje de contacto: ' . $this->asunto,
            // replyTo apunta al email del usuario para poder responder directamente.
            replyTo: [$this->email],
        );
    }

    /**
     * Definir el contenido del correo: vista Blade que se renderiza como HTML.
     * Las propiedades públicas ($nombre, $email, $asunto, $mensaje)
     * están disponibles automáticamente en la vista.
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contacto',
        );
    }

    /**
     * Archivos adjuntos (ninguno en este caso).
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
