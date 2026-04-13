<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\TicketEventoMail;
use App\Models\Evento;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Controlador para la generación y envío del ticket PDF de inscripción a eventos.
 * Gestiona dos acciones: generar PDF (nueva pestaña) y enviar PDF por email al creador.
 */
class TicketEventoController extends Controller
{
    /**
     * Generar el ticket PDF y mostrarlo en el navegador (pestaña nueva).
     * Recibe los datos del formulario de inscripción por POST.
     *
     * @param Request $request Datos del formulario (nombre, apellido, email, nsocio, telefono).
     * @param int     $id      ID del evento.
     * @return Response PDF renderizado para visualización inline en el navegador.
     */
    public function generarPdf(Request $request, int $id): Response
    {
        // Validamos los datos del formulario de inscripción.
        $datos = $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'nsocio'   => 'required|string|max:50',
            'telefono' => 'required|string|max:20',
        ]);

        // Obtenemos el evento con su relación de usuario (creador).
        $evento = Evento::with('usuario')->findOrFail($id);

        // Generamos un código de confirmación único para este ticket.
        $codigoConfirmacion = strtoupper(Str::random(8));

        // Renderizamos la vista PDF con los datos del formulario y del evento.
        $pdf = Pdf::loadView('pdf.ticketEvento', [
            'evento'             => $evento,
            'nombre'             => $datos['nombre'],
            'apellido'           => $datos['apellido'],
            'email'              => $datos['email'],
            'nsocio'             => $datos['nsocio'],
            'telefono'           => $datos['telefono'],
            'codigoConfirmacion' => $codigoConfirmacion,
        ]);

        // Devolvemos el PDF para visualización inline (se abre en el navegador).
        return $pdf->stream('ticket-evento-' . $evento->id . '.pdf');
    }

    /**
     * Generar el ticket PDF y enviarlo por email al creador del evento.
     *
     * @param Request $request Datos del formulario (nombre, apellido, email, nsocio, telefono).
     * @param int     $id      ID del evento.
     * @return JsonResponse Respuesta JSON con mensaje de éxito o error.
     * @sideEffect Envía un email con PDF adjunto al creador del evento.
     */
    public function enviarPorEmail(Request $request, int $id): JsonResponse
    {
        // Validamos los datos del formulario de inscripción.
        $datos = $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'nsocio'   => 'required|string|max:50',
            'telefono' => 'required|string|max:20',
        ]);

        // Obtenemos el evento con la relación del usuario creador.
        $evento = Evento::with('usuario')->findOrFail($id);

        // Generamos código de confirmación único.
        $codigoConfirmacion = strtoupper(Str::random(8));

        // Generamos el contenido binario del PDF (sin guardarlo en disco).
        $pdfContent = Pdf::loadView('pdf.ticketEvento', [
            'evento'             => $evento,
            'nombre'             => $datos['nombre'],
            'apellido'           => $datos['apellido'],
            'email'              => $datos['email'],
            'nsocio'             => $datos['nsocio'],
            'telefono'           => $datos['telefono'],
            'codigoConfirmacion' => $codigoConfirmacion,
        ])->output();

        // Nombre completo del asistente para el cuerpo del email.
        $nombreAsistente = $datos['nombre'] . ' ' . $datos['apellido'];

        // Obtenemos el email del creador del evento.
        $emailCreador = $evento->usuario->email;

        try {
            // Enviamos el email con el PDF adjunto al creador del evento.
            Mail::to($emailCreador)->send(
                new TicketEventoMail($evento, $nombreAsistente, $pdfContent)
            );

            return response()->json([
                'success' => true,
                'message' => 'Ticket enviado correctamente al organizador del evento.',
            ]);
        } catch (\Exception $e) {
            // Si falla el envío, devolvemos un error con mensaje amigable.
            return response()->json([
                'success' => false,
                'message' => 'No se pudo enviar el email. Inténtalo de nuevo más tarde.',
            ], 500);
        }
    }
}
