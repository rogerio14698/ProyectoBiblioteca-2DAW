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
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('autor');
            $table->string('genero');
            $table->integer('anio');
            $table->string('editorial');
            $table->enum('disponibilidad', ['disponible', 'prestado']);
            $table->enum('formato', ['fisico', 'digital']);
            $table->enum('opcion_compra', ['compra', 'prestamo']);
            $table->integer('cantidad_ejemplares');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
