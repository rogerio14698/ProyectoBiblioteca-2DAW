<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Compra;
use App\Models\Evento;
use App\Models\Libro;
use App\Models\MetodosPago;
use App\Models\Pago;
use App\Models\Prestamos;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\PaymentMethod;
use Stripe\StripeClient;

/**
 * Integración con Stripe Checkout.
 *
 * Flujo: se crea un Pago 'pendiente' y una sesión de Checkout; Stripe redirige a
 * /pagos/exito y además avisa por webhook. Ambos caminos llaman a confirmarSesion(),
 * que es idempotente: el efecto (compra, inscripción, multa, cuota) se aplica una sola vez.
 */
class StripeService
{
    private ?StripeClient $client = null;

    public function client(): StripeClient
    {
        if ($this->client === null) {
            $secret = config('services.stripe.secret');
            if (empty($secret)) {
                throw new RuntimeException('Stripe no está configurado (STRIPE_SECRET).');
            }
            $this->client = new StripeClient($secret);
        }

        return $this->client;
    }

    public function obtenerCliente(Usuario $usuario): string
    {
        if ($usuario->stripe_customer_id) {
            return $usuario->stripe_customer_id;
        }

        $customer = $this->client()->customers->create([
            'email' => $usuario->email,
            'name' => $usuario->name,
            'metadata' => ['usuario_id' => (string) $usuario->id, 'n_socio' => (string) $usuario->nSocio],
        ]);

        $usuario->forceFill(['stripe_customer_id' => $customer->id])->save();

        return $customer->id;
    }

    /**
     * Crea el Pago pendiente y la sesión de Checkout. Devuelve la URL de Stripe.
     *
     * @param int $importe Importe en céntimos (siempre calculado en servidor).
     */
    public function crearCheckout(Usuario $usuario, string $concepto, ?Model $pagable, string $descripcion, int $importe): string
    {
        if ($importe < 50) {
            throw new RuntimeException('El importe mínimo para pagar con tarjeta es 0,50 €.');
        }

        $moneda = config('services.stripe.moneda', 'eur');

        $pago = Pago::create([
            'usuario_id' => $usuario->id,
            'concepto' => $concepto,
            'pagable_type' => $pagable?->getMorphClass(),
            'pagable_id' => $pagable?->getKey(),
            'descripcion' => $descripcion,
            'importe' => $importe,
            'moneda' => $moneda,
            'estado' => 'pendiente',
        ]);

        $session = $this->client()->checkout->sessions->create([
            'mode' => 'payment',
            'customer' => $this->obtenerCliente($usuario),
            'client_reference_id' => (string) $pago->id,
            'locale' => 'es',
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => $moneda,
                    'unit_amount' => $importe,
                    'product_data' => [
                        'name' => $descripcion,
                        'description' => Pago::CONCEPTOS[$concepto] ?? $concepto,
                    ],
                ],
            ]],
            // El usuario decide en Checkout si guarda la tarjeta para próximas compras.
            'saved_payment_method_options' => ['payment_method_save' => 'enabled'],
            'metadata' => ['pago_id' => (string) $pago->id, 'concepto' => $concepto],
            'payment_intent_data' => ['metadata' => ['pago_id' => (string) $pago->id]],
            'success_url' => route('pagos.exito') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('pagos.cancelado') . '?pago=' . $pago->id,
            'expires_at' => now()->addMinutes(30)->timestamp,
        ]);

        $pago->update(['stripe_checkout_session_id' => $session->id]);

        return $session->url;
    }

    /**
     * Checkout en modo 'setup' para añadir una tarjeta sin cobrar nada.
     */
    public function crearCheckoutGuardarTarjeta(Usuario $usuario): string
    {
        $session = $this->client()->checkout->sessions->create([
            'mode' => 'setup',
            'currency' => config('services.stripe.moneda', 'eur'),
            'customer' => $this->obtenerCliente($usuario),
            'payment_method_types' => ['card'],
            'locale' => 'es',
            'metadata' => ['usuario_id' => (string) $usuario->id],
            'success_url' => route('metodosPago.exito') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('usuario.pagos'),
        ]);

        return $session->url;
    }

    public function recuperarSesion(string $sessionId): CheckoutSession
    {
        return $this->client()->checkout->sessions->retrieve($sessionId, [
            'expand' => ['payment_intent.payment_method', 'setup_intent.payment_method'],
        ]);
    }

    /**
     * Marca el pago como pagado y aplica su efecto. Seguro ante llamadas repetidas.
     */
    public function confirmarSesion(CheckoutSession $session): ?Pago
    {
        if ($session->mode === 'setup') {
            $this->guardarTarjetaDesdeSetup($session);
            return null;
        }

        $pago = Pago::where('stripe_checkout_session_id', $session->id)->first();
        if (! $pago || $session->payment_status !== 'paid') {
            return $pago;
        }

        $aplicado = DB::transaction(function () use ($pago, $session) {
            $pago = Pago::whereKey($pago->id)->lockForUpdate()->first();
            if ($pago->estado === 'pagado') {
                return false;
            }

            $paymentIntent = $session->payment_intent;
            $pago->update([
                'estado' => 'pagado',
                'pagado_at' => now(),
                'stripe_payment_intent_id' => is_string($paymentIntent) ? $paymentIntent : $paymentIntent?->id,
            ]);

            $this->aplicarEfecto($pago);

            return true;
        });

        $paymentIntent = $session->payment_intent;
        if ($aplicado && ! is_string($paymentIntent) && $paymentIntent?->payment_method instanceof PaymentMethod) {
            $this->guardarTarjeta($pago->usuario, $paymentIntent->payment_method);
        }

        return $pago->fresh();
    }

    public function marcarCancelado(string $sessionId): void
    {
        Pago::where('stripe_checkout_session_id', $sessionId)
            ->where('estado', 'pendiente')
            ->update(['estado' => 'cancelado']);
    }

    public function eliminarTarjeta(MetodosPago $metodo): void
    {
        // Las tarjetas de ejemplo del seeder no existen en Stripe.
        if (! str_starts_with($metodo->stripe_payment_method_id, 'pm_demo_')) {
            try {
                $this->client()->paymentMethods->detach($metodo->stripe_payment_method_id);
            } catch (\Throwable $e) {
                Log::warning('No se pudo desvincular la tarjeta en Stripe: ' . $e->getMessage());
            }
        }

        $eraPredeterminada = $metodo->predeterminado;
        $usuarioId = $metodo->usuario_id;
        $metodo->delete();

        if ($eraPredeterminada) {
            MetodosPago::where('usuario_id', $usuarioId)->oldest()->first()?->update(['predeterminado' => true]);
        }
    }

    private function aplicarEfecto(Pago $pago): void
    {
        $pagable = $pago->pagable;
        $usuario = $pago->usuario;

        switch ($pago->concepto) {
            case 'compra_libro':
                if ($pagable instanceof Libro) {
                    Compra::create([
                        'usuario_id' => $usuario->id,
                        'libro_id' => $pagable->id,
                        'fecha_compra' => now(),
                        'precio' => $pago->importe / 100,
                        'estado' => 'completado',
                    ]);
                    if ($pagable->cantidad_ejemplares > 0) {
                        $pagable->decrement('cantidad_ejemplares');
                    }
                }
                break;

            case 'entrada_evento':
                if ($pagable instanceof Evento && ! $pagable->usuariosInscritos()->where('usuario_id', $usuario->id)->exists()) {
                    $pagable->usuariosInscritos()->attach($usuario->id, [
                        'fecha_inscripcion' => now(),
                        'estado' => 'inscrito',
                    ]);
                    $pagable->increment('asistentes');
                }
                break;

            case 'multa':
                if ($pagable instanceof Prestamos) {
                    $pagable->update(['multa_pagada' => true]);
                }
                break;

            case 'cuota_socio':
                $desde = $usuario->cuotaSocioAlDia() ? $usuario->socio_hasta : now();
                $usuario->forceFill(['socio_hasta' => $desde->copy()->addYear()])->save();
                break;
        }
    }

    private function guardarTarjetaDesdeSetup(CheckoutSession $session): void
    {
        $usuario = Usuario::where('stripe_customer_id', $session->customer)->first();
        $setupIntent = $session->setup_intent;

        if ($usuario && ! is_string($setupIntent) && $setupIntent?->payment_method instanceof PaymentMethod) {
            $this->guardarTarjeta($usuario, $setupIntent->payment_method);
        }
    }

    /**
     * Solo se guarda si la tarjeta quedó vinculada al cliente (el usuario eligió guardarla).
     */
    private function guardarTarjeta(Usuario $usuario, PaymentMethod $pm): void
    {
        if ($pm->customer !== $usuario->stripe_customer_id || $pm->type !== 'card') {
            return;
        }

        $tieneOtras = $usuario->metodosPago()->exists();

        MetodosPago::updateOrCreate(
            ['stripe_payment_method_id' => $pm->id],
            [
                'usuario_id' => $usuario->id,
                'tipo' => $pm->type,
                'marca' => $pm->card->brand ?? null,
                'last_four' => $pm->card->last4 ?? null,
                'exp_mes' => $pm->card->exp_month ?? null,
                'exp_anio' => $pm->card->exp_year ?? null,
                'predeterminado' => ! $tieneOtras,
            ]
        );
    }
}
