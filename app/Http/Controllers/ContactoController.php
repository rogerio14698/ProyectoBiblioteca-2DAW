<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Mail\ContactoRecibido;
use App\Mail\RespuestaDeAdminAContacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Vista para el admin para ver todos los mensajes de contacto recibidos.
        $mensajes = Contacto::orderBy('created_at', 'desc')->paginate(10);
        return view('bibliotecaDAW.adminViews.mensajes.index', compact('mensajes'));
    }
    public function misConsultas()
    {
        //Obtenemos el usuario autenticado del guard 'web' (modelo Usuario).
        $usuario = auth('web')->user();

        //Filtramos los mensajes de contacto por el email del usuario autenticado.
        $mensajes = Contacto::where('email', $usuario->email)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bibliotecaDAW.userViews.misConsultas', compact('mensajes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Mostrar el formulario de contacto público.
        return view('bibliotecaDAW.publicViews.contacto');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Validar los datos del formulario, guardarlos en BD y enviar correo al admin.
     * @param Request $request Datos del formulario de contacto.
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito o error.
     * @effect Crea un registro en la tabla 'contactos' y envía un email SMTP.
     */
    public function store(Request $request)
    {
        //Validamos los datos del formulario antes de procesarlos.
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string',
        ]);

        //Limpiamos el mensaje de etiquetas HTML por seguridad.
        $mensajeLimpio = strip_tags($request->input('mensaje'));

        //Guardamos el mensaje de contacto en la base de datos.
        $contacto = new Contacto();
        $contacto->nombre = $request->input('nombre');
        $contacto->email = $request->input('email');
        $contacto->asunto = $request->input('asunto');
        $contacto->mensaje = $mensajeLimpio;
        $contacto->save();

        //Enviamos el correo electrónico al admin de la biblioteca.
        //Usamos try-catch para que, si el envío falla, el usuario no pierda su mensaje.
        try {
            Mail::to('rogeriolucas14698@gmail.com')->send(
                new ContactoRecibido(
                    nombre: $request->input('nombre'),
                    email: $request->input('email'),
                    asunto: $request->input('asunto'),
                    mensaje: $mensajeLimpio,
                )
            );
        } catch (\Exception $e) {
            //Si el correo falla, lo registramos en el log pero no bloqueamos al usuario.
            Log::error('Error al enviar correo de contacto: ' . $e->getMessage());

            //Le indicamos al usuario que su mensaje se guardó aunque el correo fallara.
            return redirect()->back()->with('success', 'Tu mensaje ha sido guardado. Te responderemos pronto.');
        }

        return redirect()->back()->with('success', 'Tu mensaje ha sido enviado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contacto $contacto)
    {
        //
    }
    //Aqui enviamos el email de vuelta al usuario y lo guardamos en la base de datos:

    /**
     * Responder a un mensaje de contacto enviando un email al usuario.
     * @param Request $request Contiene el campo 'respuesta' con el texto del admin.
     * @param int $id Identificador del mensaje de contacto original.
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito o error.
     * @effect Envía un correo SMTP al email del contacto original.
     */
    public function responder(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        // Validamos que el campo respuesta no esté vacío.
        $request->validate([
            'respuesta' => 'required|string',
        ]);

        // Buscamos el mensaje original en la base de datos.
        $contacto = Contacto::findOrFail($id);

        // Guardamos la respuesta en la base de datos antes de enviar el email.
        $contacto->respuesta = $request->input('respuesta');
        $contacto->estado = 'leido';
        $contacto->save();

        // Intentamos enviar el correo de respuesta al usuario.
        try {
            Mail::to($contacto->email)->send(
                new RespuestaDeAdminAContacto(
                    nombreUsuario: $contacto->nombre,
                    emailUsuario: $contacto->email,
                    asuntoOriginal: $contacto->asunto,
                    mensajeRespuesta: $request->input('respuesta'),
                )
            );
        } catch (\Exception $e) {
            // Si falla el envío, lo registramos y avisamos al admin.
            Log::error('Error al enviar respuesta al contacto: ' . $e->getMessage());
            return redirect()->back()->with('error', 'La respuesta se guardó pero no se pudo enviar el email. Inténtalo de nuevo.');
        }

        return redirect()->back()->with('success', 'Respuesta enviada correctamente a ' . $contacto->email);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contacto $contacto)
    {
        //
    }

    /**
     * Actualizar el estado de un mensaje de contacto (admin).
     * @param Request $request Contiene el nuevo 'estado'.
     * @param int $id Identificador del mensaje.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEstado(Request $request, int $id)
    {
        //Validamos que el estado sea uno de los permitidos.
        $request->validate([
            'estado' => 'required|in:pendiente,en_proceso,leido',
        ]);

        //Buscamos el mensaje y actualizamos su estado.
        $contacto = Contacto::findOrFail($id);
        $contacto->estado = $request->input('estado');
        $contacto->save();

        return redirect()->back()->with('success', 'Estado del mensaje actualizado correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contacto $contacto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contacto $contacto)
    {
        $contacto->delete();
        return redirect()->back()->with('success', 'El mensaje ha sido eliminado exitosamente.');
    }
}
