<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Libro;
use App\Models\MetodosPago;
use App\Models\Pago;
use App\Models\Prestamos;
use App\Models\Usuario;
use App\Services\StripeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

/**
 * Pagos con Stripe Checkout: compra de libros, entradas, multas y cuota de socio.
 * Los importes se calculan siempre en servidor a partir de la base de datos.
 */
class PagoController extends Controller
{
    public function __construct(private readonly StripeService $stripe)
    {
    }

    /**
     * Centro de pagos del usuario: cuota, multas pendientes, tarjetas e historial.
     */
    public function index(): View
    {
        $usuario = $this->usuario();

        return view('bibliotecaDAW.userViews.pagos', [
            'usuario' => $usuario,
            'pagos' => $usuario->pagos()->latest()->paginate(10),
            'metodos' => $usuario->metodosPago()->orderByDesc('predeterminado')->latest()->get(),
            'multas' => $usuario->prestamos()->with('libro')->where('multa', '>', 0)->where('multa_pagada', false)->get(),
            'cuotaSocio' => (float) config('services.stripe.cuota_socio'),
        ]);
    }

    public function comprarLibro(int $id): RedirectResponse
    {
        $libro = Libro::findOrFail($id);

        if (! $libro->seVende() || $libro->perdido || $libro->cantidad_ejemplares < 1) {
            return back()->with('error', 'Este libro no está disponible para la venta.');
        }

        return $this->irACheckout('compra_libro', $libro, 'Libro: ' . $libro->titulo, (float) $libro->precio);
    }

    public function entradaEvento(int $id): RedirectResponse
    {
        $evento = Evento::findOrFail($id);
        $usuario = $this->usuario();

        if (! $evento->esDePago()) {
            return back()->with('error', 'Este evento es gratuito; inscríbete desde su página.');
        }
        if ($evento->fecha_hora < now()) {
            return back()->with('error', 'Este evento ya se ha celebrado.');
        }
        if ($evento->plazas_libres !== null && $evento->plazas_libres <= 0) {
            return back()->with('error', 'No quedan plazas disponibles para este evento.');
        }
        if ($evento->usuariosInscritos()->where('usuario_id', $usuario->id)->exists()) {
            return back()->with('error', 'Ya tienes entrada para este evento.');
        }

        return $this->irACheckout('entrada_evento', $evento, 'Entrada: ' . $evento->titulo, (float) $evento->precio);
    }

    public function pagarMulta(int $id): RedirectResponse
    {
        $prestamo = Prestamos::with('libro')
            ->where('usuario_id', $this->usuario()->id)
            ->findOrFail($id);

        if (! $prestamo->tieneMultaPendiente()) {
            return back()->with('error', 'Este préstamo no tiene multas pendientes.');
        }

        return $this->irACheckout('multa', $prestamo, 'Multa por retraso: ' . ($prestamo->libro->titulo ?? 'préstamo #' . $prestamo->id), (float) $prestamo->multa);
    }

    public function cuotaSocio(): RedirectResponse
    {
        return $this->irACheckout('cuota_socio', null, 'Cuota anual de socio', (float) config('services.stripe.cuota_socio'));
    }

    /**
     * Vuelta desde Stripe. Confirmamos aquí también para no depender del webhook en local.
     */
    public function exito(Request $request): View|RedirectResponse
    {
        $sessionId = (string) $request->query('session_id', '');
        $pago = Pago::where('stripe_checkout_session_id', $sessionId)
            ->where('usuario_id', $this->usuario()->id)
            ->first();

        if (! $pago) {
            return redirect()->route('usuario.pagos')->with('error', 'No hemos encontrado ese pago.');
        }

        try {
            $pago = $this->stripe->confirmarSesion($this->stripe->recuperarSesion($sessionId)) ?? $pago;
        } catch (\Throwable $e) {
            Log::error('Error confirmando pago Stripe: ' . $e->getMessage());
        }

        return view('bibliotecaDAW.userViews.pagoResultado', ['pago' => $pago, 'ok' => $pago->estado === 'pagado']);
    }

    public function cancelado(Request $request): View
    {
        $pago = Pago::where('usuario_id', $this->usuario()->id)->find((int) $request->query('pago'));

        if ($pago && $pago->estado === 'pendiente') {
            $pago->update(['estado' => 'cancelado']);
        }

        return view('bibliotecaDAW.userViews.pagoResultado', ['pago' => $pago, 'ok' => false]);
    }

    public function agregarTarjeta(): RedirectResponse
    {
        try {
            return redirect()->away($this->stripe->crearCheckoutGuardarTarjeta($this->usuario()), 303);
        } catch (\Throwable $e) {
            Log::error('Error creando sesión de tarjeta: ' . $e->getMessage());
            return back()->with('error', 'No se ha podido conectar con Stripe. Inténtalo más tarde.');
        }
    }

    public function tarjetaGuardada(Request $request): RedirectResponse
    {
        try {
            $session = $this->stripe->recuperarSesion((string) $request->query('session_id', ''));
            if ($session->customer === $this->usuario()->stripe_customer_id) {
                $this->stripe->confirmarSesion($session);
                return redirect()->route('usuario.pagos')->with('success', 'Tarjeta guardada correctamente.');
            }
        } catch (\Throwable $e) {
            Log::error('Error guardando tarjeta: ' . $e->getMessage());
        }

        return redirect()->route('usuario.pagos')->with('error', 'No se ha podido guardar la tarjeta.');
    }

    public function predeterminarTarjeta(int $id): RedirectResponse
    {
        $usuario = $this->usuario();
        $metodo = $usuario->metodosPago()->findOrFail($id);

        $usuario->metodosPago()->update(['predeterminado' => false]);
        $metodo->update(['predeterminado' => true]);

        return back()->with('success', 'Tarjeta predeterminada actualizada.');
    }

    public function eliminarTarjeta(int $id): RedirectResponse
    {
        /** @var MetodosPago $metodo */
        $metodo = $this->usuario()->metodosPago()->findOrFail($id);
        $this->stripe->eliminarTarjeta($metodo);

        return back()->with('success', 'Tarjeta eliminada.');
    }

    /**
     * Webhook de Stripe. Configura STRIPE_WEBHOOK_SECRET (stripe listen --forward-to .../stripe/webhook).
     */
    public function webhook(Request $request): Response
    {
        $secret = config('services.stripe.webhook_secret');
        if (empty($secret)) {
            Log::warning('Webhook de Stripe recibido sin STRIPE_WEBHOOK_SECRET configurado.');
            return response('Webhook no configurado', 400);
        }

        try {
            $event = Webhook::constructEvent($request->getContent(), (string) $request->header('Stripe-Signature'), $secret);
        } catch (SignatureVerificationException|\UnexpectedValueException $e) {
            return response('Firma no válida', 400);
        }

        try {
            switch ($event->type) {
                case 'checkout.session.completed':
                case 'checkout.session.async_payment_succeeded':
                    $this->stripe->confirmarSesion($this->stripe->recuperarSesion($event->data->object->id));
                    break;
                case 'checkout.session.expired':
                case 'checkout.session.async_payment_failed':
                    $this->stripe->marcarCancelado($event->data->object->id);
                    break;
            }
        } catch (\Throwable $e) {
            Log::error('Error procesando webhook Stripe: ' . $e->getMessage());
            return response('Error', 500);
        }

        return response('ok', 200);
    }

    private function irACheckout(string $concepto, mixed $pagable, string $descripcion, float $euros): RedirectResponse
    {
        try {
            $url = $this->stripe->crearCheckout($this->usuario(), $concepto, $pagable, $descripcion, (int) round($euros * 100));
        } catch (\Throwable $e) {
            Log::error('Error creando Checkout de Stripe: ' . $e->getMessage());
            return back()->with('error', 'No se ha podido iniciar el pago. Inténtalo de nuevo en unos minutos.');
        }

        return redirect()->away($url, 303);
    }

    private function usuario(): Usuario
    {
        /** @var Usuario */
        return auth('web')->user();
    }
}
