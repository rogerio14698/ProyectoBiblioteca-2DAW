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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->dateTime('fecha_hora');
            $table->string('ubicacion')->nullable();
            $table->integer('aforo')->nullable();
            $table->integer('asistentes')->default(0);
            //Calcula las plazas libres restando el número de asistentes al aforo total del evento.
            $table->integer('plazas_libres')->storedAs('aforo - asistentes');
            $table->string('imagen_url')->nullable();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->integer('prioridad')->default(0); //cuanto mayor sea el numero mayor prioridad
            $table->string('url_paginaInterna')->nullable(); // Nueva columna para la URL de la página interna del evento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};