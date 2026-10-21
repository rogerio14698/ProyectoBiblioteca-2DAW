<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Registro único de todos los cobros realizados con Stripe Checkout.
 * 'pagable' apunta al objeto que se paga (Libro, Evento, Prestamos o null para la cuota de socio).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->enum('concepto', ['compra_libro', 'entrada_evento', 'multa', 'cuota_socio']);
            $table->nullableMorphs('pagable');
            $table->string('descripcion');
            // Importe en céntimos, como lo maneja Stripe.
            $table->unsignedInteger('importe');
            $table->string('moneda', 3)->default('eur');
            $table->enum('estado', ['pendiente', 'pagado', 'fallido', 'cancelado', 'reembolsado'])->default('pendiente');
            $table->string('stripe_checkout_session_id')->nullable()->unique();
            $table->string('stripe_payment_intent_id')->nullable()->index();
            $table->timestamp('pagado_at')->nullable();
            $table->timestamps();

            $table->index(['usuario_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
