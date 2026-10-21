<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Doble confirmación: enlace firmado que demuestra que el buzón existe y es del remitente.
 */
class ConfirmarContacto extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $nombre,
        public readonly string $asunto,
        public readonly string $urlConfirmacion,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Confirma tu mensaje a la Biblioteca DAW');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.confirmarContacto');
    }
}