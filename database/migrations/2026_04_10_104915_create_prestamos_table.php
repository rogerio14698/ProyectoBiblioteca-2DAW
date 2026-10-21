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
    Schema::create('prestamos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('libro_id')->constrained('libros')->onDelete('cascade');
        $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
        $table->timestamp('fecha_prestamo')->useCurrent();
        $table->timestamp('fecha_devolucion_esperada')->nullable();
        $table->timestamp('fecha_devolucion_real')->nullable(); 
        // Multa por retraso en euros y si ya se ha pagado vía Stripe.
        $table->decimal('multa', 8, 2)->default(0);
        $table->boolean('multa_pagada')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};