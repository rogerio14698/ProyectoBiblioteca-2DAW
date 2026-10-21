<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Métodos de pago guardados del usuario.
 * Nunca se almacenan datos de tarjeta: solo la referencia de Stripe (pm_...)
 * y los datos visibles que Stripe devuelve (marca, últimos 4, caducidad).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metodos_pago', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->cascadeOnDelete();

            $table->string('stripe_payment_method_id')->unique(); // pm_...
            $table->string('tipo')->default('card');              // card, sepa_debit, link...
            $table->string('marca')->nullable();                  // visa, mastercard...
            $table->string('last_four', 4)->nullable();
            $table->unsignedTinyInteger('exp_mes')->nullable();
            $table->unsignedSmallInteger('exp_anio')->nullable();
            $table->boolean('predeterminado')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metodos_pago');
    }
};