<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración para crear la tabla 'reservas'.
 * Registra los préstamos/reservas de libros realizados por los usuarios.
 * Cada reserva vincula un usuario con un libro, con fechas y estado.
 */
return new class extends Migration
{
    /**
     * Crear la tabla 'reservas' con sus columnas y claves foráneas.
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            // Identificador único de la reserva.
            $table->id();

            // Clave foránea al usuario que realiza la reserva.
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');

            // Clave foránea al libro reservado.
            $table->foreignId('libro_id')->constrained('libros')->onDelete('cascade');

            // Fecha en la que se realizó la reserva/préstamo.
            $table->date('fecha_reserva');

            // Fecha límite para devolver el libro.
            $table->date('fecha_devolucion_prevista');

            // Fecha real en la que el usuario devolvió el libro (null si aún no devuelto).
            $table->date('fecha_devolucion_real')->nullable();

            // Estado actual de la reserva.
            $table->enum('estado', ['activa', 'devuelta', 'vencida', 'cancelada'])->default('activa');

            // Observaciones opcionales del administrador.
            $table->text('observaciones')->nullable();

            // Timestamps de creación y actualización del registro.
            $table->timestamps();
        });
    }

    /**
     * Eliminar la tabla 'reservas'.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
