<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RespuestaDeAdminAContacto extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * 
     * usamos el constructor para recibir los datos necesario para la respuesta.
     */ //estas variable estarán dispobibles automaticamente en la vista Blade; Constructor Property Promotion (PHP 8+).
        
    public function __construct(
        
        public string $nombreUsuario,
        public string $emailUsuario,
        public string $asuntoOriginal,
        public string $mensajeRespuesta,
        )
    {
       
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: ' . $this->asuntoOriginal . ' - Respuesta de Biblioteca DAW',
        );
    }

    /**
     *Definimos la ruta de la vista que crearemos a continuación
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.respuestaAdmin',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
