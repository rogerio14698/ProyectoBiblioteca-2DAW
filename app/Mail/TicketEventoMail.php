<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Evento;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable que envía el ticket PDF de inscripción a un evento.
 * Se adjunta el PDF generado y se envía al email del creador del evento.
 *
 * @sideEffect Envía un email con adjunto PDF al creador del evento.
 */
class TicketEventoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Constructor: recibe los datos necesarios para componer el email.
     * Usamos Constructor Property Promotion (PHP 8.3).
     *
     * @param Evento $evento        Evento al que se inscribe el asistente.
     * @param string $nombreAsistente Nombre completo del asistente.
     * @param string $pdfContent    Contenido binario del PDF generado.
     */
    public function __construct(
        public readonly Evento $evento,
        public readonly string $nombreAsistente,
        public readonly string $pdfContent,
    ) {}

    /**
     * Definir el sobre del correo: asunto y destinatario de respuesta.
     *
     * @return Envelope Configuración del sobre del email.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Asunto descriptivo con el nombre del evento.
            subject: 'Nuevo inscrito en tu evento: ' . $this->evento->titulo,
        );
    }

    /**
     * Definir el contenido del correo: vista Blade renderizada como HTML.
     * Las propiedades públicas están disponibles automáticamente en la vista.
     *
     * @return Content Vista y datos del email.
     */
    public function content(): Content
    {
        return new Content(
            // Vista Blade que se renderiza como cuerpo del email.
            view: 'emails.ticketEvento',
        );
    }

    /**
     * Adjuntar el PDF del ticket al correo.
     *
     * @return array<int, Attachment> Lista de adjuntos.
     */
    public function attachments(): array
    {
        return [
            // Adjuntamos el PDF generado en memoria (sin guardarlo en disco).
            Attachment::fromData(fn () => $this->pdfContent, 'ticket-' . $this->evento->id . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
