<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Evento;
use App\Models\Pago;
use App\Models\Prestamos;
use App\Models\Libro;
use App\Models\Usuario;
use App\Services\StripeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Stripe\Checkout\Session as CheckoutSession;
use Tests\TestCase;

class PagosStripeTest extends TestCase
{
    use RefreshDatabase;

    private function usuario(): Usuario
    {
        return Usuario::create([
            'name' => 'Pagador',
            'email' => 'pagador@gmail.com',
            'dni' => '44444444D',
            'password' => 'Password123!',
            'stripe_customer_id' => 'cus_test',
        ]);
    }

    private function sesionPagada(Pago $pago): CheckoutSession
    {
        return CheckoutSession::constructFrom([
            'id' => $pago->stripe_checkout_session_id,
            'mode' => 'payment',
            'payment_status' => 'paid',
            'payment_intent' => 'pi_test_' . $pago->id,
            'customer' => 'cus_test',
        ]);
    }

    private function pago(Usuario $usuario, string $concepto, $pagable, int $importe): Pago
    {
        return Pago::create([
            'usuario_id' => $usuario->id,
            'concepto' => $concepto,
            'pagable_type' => $pagable?->getMorphClass(),
            'pagable_id' => $pagable?->getKey(),
            'descripcion' => 'Test',
            'importe' => $importe,
            'stripe_checkout_session_id' => 'cs_test_' . uniqid(),
        ]);
    }

    public function test_cuota_socio_extiende_un_anio_y_es_idempotente(): void
    {
        $usuario = $this->usuario();
        $pago = $this->pago($usuario, 'cuota_socio', null, 2000);
        $servicio = app(StripeService::class);

        $servicio->confirmarSesion($this->sesionPagada($pago));
        $servicio->confirmarSesion($this->sesionPagada($pago));

        $this->assertSame('pagado', $pago->fresh()->estado);
        $this->assertTrue($usuario->fresh()->cuotaSocioAlDia());
        $this->assertSame(now()->addYear()->toDateString(), $usuario->fresh()->socio_hasta->toDateString());
    }

    public function test_entrada_evento_inscribe_al_usuario_una_vez(): void
    {
        $usuario = $this->usuario();
        $evento = Evento::create([
            'titulo' => 'Concierto', 'descripcion' => 'x', 'fecha_hora' => now()->addWeek(),
            'ubicacion' => 'Auditorio', 'aforo' => 10, 'usuario_id' => $usuario->id, 'precio' => 8,
        ]);
        $pago = $this->pago($usuario, 'entrada_evento', $evento, 800);
        $servicio = app(StripeService::class);

        $servicio->confirmarSesion($this->sesionPagada($pago));
        $servicio->confirmarSesion($this->sesionPagada($pago));

        $this->assertSame(1, $evento->fresh()->asistentes);
        $this->assertTrue($evento->usuariosInscritos()->where('usuario_id', $usuario->id)->exists());
    }

    public function test_multa_queda_pagada_y_compra_de_libro_se_registra(): void
    {
        $usuario = $this->usuario();
        $libro = Libro::create([
            'titulo' => 'Don Quijote', 'autor' => 'Cervantes', 'genero' => 'Ficción', 'anio' => 1605,
            'editorial' => 'Juan de la Cuesta', 'disponibilidad' => 'disponible', 'opcion_compra' => 'compra',
            'cantidad_ejemplares' => 3, 'isbn' => '9780000000001', 'precio' => 15,
        ]);
        $prestamo = Prestamos::create([
            'libro_id' => $libro->id, 'usuario_id' => $usuario->id,
            'fecha_prestamo' => now()->subDays(20), 'fecha_devolucion_esperada' => now()->subDays(6),
        ]);
        $prestamo->update(['fecha_devolucion_real' => now()]);

        $this->assertSame('3.00', $prestamo->fresh()->multa);

        $servicio = app(StripeService::class);
        $servicio->confirmarSesion($this->sesionPagada($this->pago($usuario, 'multa', $prestamo, 300)));
        $servicio->confirmarSesion($this->sesionPagada($this->pago($usuario, 'compra_libro', $libro, 1500)));

        $this->assertTrue($prestamo->fresh()->multa_pagada);
        $this->assertDatabaseHas('compras', ['usuario_id' => $usuario->id, 'libro_id' => $libro->id, 'estado' => 'completado']);
        $this->assertSame(2, $libro->fresh()->cantidad_ejemplares);
    }

    public function test_sesion_no_pagada_no_aplica_efecto(): void
    {
        $usuario = $this->usuario();
        $pago = $this->pago($usuario, 'cuota_socio', null, 2000);

        app(StripeService::class)->confirmarSesion(CheckoutSession::constructFrom([
            'id' => $pago->stripe_checkout_session_id, 'mode' => 'payment', 'payment_status' => 'unpaid',
        ]));

        $this->assertSame('pendiente', $pago->fresh()->estado);
        $this->assertNull($usuario->fresh()->socio_hasta);
    }

    public function test_webhook_rechaza_firma_invalida(): void
    {
        config(['services.stripe.webhook_secret' => 'whsec_test']);

        $this->postJson('/stripe/webhook', ['type' => 'checkout.session.completed'], ['Stripe-Signature' => 'falsa'])
            ->assertStatus(400);
    }

    public function test_pagos_requiere_sesion(): void
    {
        $this->get('/pagos')->assertRedirect(route('usuario.login.mostrar'));
    }
}
