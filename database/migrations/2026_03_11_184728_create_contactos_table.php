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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email');
            $table->string('asunto');
            $table->text('mensaje');
            $table->text('respuesta')->nullable();
            $table->enum('estado', ['pendiente','en_proceso','leido'])->default('pendiente');
            // Doble confirmación: el mensaje solo llega al admin cuando el remitente confirma su email.
            $table->string('token_verificacion', 64)->nullable()->unique();
            $table->timestamp('email_verificado_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
