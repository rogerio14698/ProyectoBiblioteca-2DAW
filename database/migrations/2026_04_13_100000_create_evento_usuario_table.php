<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración para crear la tabla pivote 'evento_usuario'.
 * Registra la inscripción de un usuario a un evento (asistencia).
 * Cada registro vincula un usuario con un evento, incluyendo estado y fecha de inscripción.
 */
return new class extends Migration
{
    /**
     * Crear la tabla 'evento_usuario' con sus columnas y claves foráneas.
     */
    public function up(): void
    {
        Schema::create('evento_usuario', function (Blueprint $table) {
            // Identificador único de la inscripción.
            $table->id();

            // Clave foránea al usuario que se inscribe al evento.
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');

            // Clave foránea al evento al que se inscribe el usuario.
            $table->foreignId('evento_id')->constrained('eventos')->onDelete('cascade');

            // Fecha y hora en la que el usuario se inscribió al evento.
            $table->dateTime('fecha_inscripcion');

            // Estado de la asistencia del usuario al evento.
            $table->enum('estado', ['inscrito', 'asistido', 'cancelado', 'no_asistio'])->default('inscrito');

            // Timestamps de creación y actualización del registro.
            $table->timestamps();

            // Índice único para evitar inscripciones duplicadas del mismo usuario al mismo evento.
            $table->unique(['usuario_id', 'evento_id']);
        });
    }

    /**
     * Eliminar la tabla 'evento_usuario'.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_usuario');
    }
};