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
            $table->enum('formato', ['fisico', 'digital', 'ambos'])->default('ambos');
            $table->enum('opcion_compra', ['compra', 'prestamo']);
            $table->integer('cantidad_ejemplares');

            // Mueve estas líneas aquí para que queden después de cantidad_ejemplares
            $table->boolean('perdido')->default(false);
            $table->string('motivo_baja')->nullable();

            $table->string('isbn');
            $table->string('portada_img')->nullable();
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
