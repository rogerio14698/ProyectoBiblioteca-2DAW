<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Mail\ContactoRecibido;
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
