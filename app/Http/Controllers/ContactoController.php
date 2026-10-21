<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Mail\ConfirmarContacto;
use App\Mail\ContactoRecibido;
use App\Mail\RespuestaDeAdminAContacto;
use App\Rules\EmailNoDesechable;
use App\Rules\Turnstile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Vista para el admin para ver todos los mensajes de contacto recibidos.
        $mensajes = Contacto::latest()->paginate(10);
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
     * Validar el formulario y guardar el mensaje pendiente de confirmación.
     * Capas: honeypot + Cloudflare Turnstile + RFC/DNS (MX) + dominios desechables + throttle (ruta).
     * El admin solo recibe el mensaje cuando el remitente pulsa el enlace enviado a su correo.
     * @param Request $request Datos del formulario de contacto.
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito o error.
     */
    public function store(Request $request)
    {
        // Campo trampa invisible: los bots lo rellenan, las personas no.
        if (filled($request->input('web'))) {
            return redirect()->back()->with('success', 'Revisa tu correo para confirmar el mensaje.');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|min:2|max:255',
            'email' => ['required', 'string', 'max:255', 'email:rfc,dns', new EmailNoDesechable()],
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string|min:10|max:5000',
            'cf-turnstile-response' => [new Turnstile()],
        ], [
            'email.email' => 'Ese correo no existe o su dominio no puede recibir emails. Revísalo.',
            'mensaje.min' => 'Cuéntanos un poco más (mínimo 10 caracteres).',
        ]);

        $token = Str::random(64);

        $contacto = Contacto::create([
            'nombre' => strip_tags($validated['nombre']),
            'email' => Str::lower($validated['email']),
            'asunto' => strip_tags($validated['asunto']),
            'mensaje' => strip_tags($validated['mensaje']),
            'token_verificacion' => $token,
        ]);

        $url = URL::temporarySignedRoute('contacto.confirmar', now()->addHours(48), ['token' => $token]);

        try {
            Mail::to($contacto->email)->send(new ConfirmarContacto($contacto->nombre, $contacto->asunto, $url));
        } catch (\Exception $e) {
            Log::error('Error al enviar confirmación de contacto: ' . $e->getMessage());
            $contacto->delete();

            return redirect()->back()->withInput()->with('error', 'No hemos podido enviar el correo de confirmación a esa dirección. Comprueba que es correcta.');
        }

        return redirect()->back()->with('success', 'Te hemos enviado un correo a ' . $contacto->email . '. Pulsa el enlace para que tu mensaje nos llegue.');
    }

    /**
     * Enlace de la doble confirmación: marca el email como verificado y avisa al admin.
     */
    public function confirmar(Request $request, string $token)
    {
        $contacto = Contacto::where('token_verificacion', $token)->first();

        if (! $contacto) {
            return redirect()->route('contacto.create')->with('error', 'Este enlace ya se ha usado o no es válido.');
        }

        $contacto->update([
            'email_verificado_at' => now(),
            'token_verificacion' => null,
        ]);

        try {
            Mail::to(config('mail.admin_address', 'rogeriolucas14698@gmail.com'))->send(
                new ContactoRecibido(
                    nombre: $contacto->nombre,
                    email: $contacto->email,
                    asunto: $contacto->asunto,
                    mensaje: $contacto->mensaje,
                )
            );
        } catch (\Exception $e) {
            // El mensaje queda visible en el panel aunque falle el aviso por correo.
            Log::error('Error al enviar correo de contacto al admin: ' . $e->getMessage());
        }

        return redirect()->route('contacto.create')->with('success', '¡Correo confirmado! Tu mensaje ya está en manos de la biblioteca.');
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
