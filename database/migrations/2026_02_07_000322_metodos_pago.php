<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metodos_pago', function(Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');

            $table->enum('type', [
                'tarjeta_credito',
                'tarjeta_debito',
                'paypal',
                'otro'
            ]);
            $table->string('provider')->nullable(); //Strip, paypal, etc
            $table->string('token'); //Esto va a ser token seguro del proveedor
            $table->string('last_four', 4)->nullable(); //Últimos 4 dígitos para tarjetas
            $table->string('paypal_email')->nullable(); //Email para PayPal

            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metodos_pago');
    }
};
