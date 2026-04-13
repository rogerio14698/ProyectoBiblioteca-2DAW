<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración para crear la tabla 'compras'.
 * Registra las compras de libros realizadas por los usuarios.
 * Cada compra vincula un usuario con un libro, incluyendo precio y estado.
 */
return new class extends Migration
{
    /**
     * Crear la tabla 'compras' con sus columnas y claves foráneas.
     */
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            // Identificador único de la compra.
            $table->id();

            // Clave foránea al usuario que realiza la compra.
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');

            // Clave foránea al libro comprado.
            $table->foreignId('libro_id')->constrained('libros')->onDelete('cascade');

            // Fecha en la que se realizó la compra.
            $table->dateTime('fecha_compra');

            // Precio pagado por el libro (en euros, hasta 8 dígitos con 2 decimales).
            $table->decimal('precio', 8, 2);

            // Estado actual de la compra.
            $table->enum('estado', ['pendiente', 'completado', 'cancelado', 'enviado', 'recibido'])->default('pendiente');

            // Timestamps de creación y actualización del registro.
            $table->timestamps();
        });
    }

    /**
     * Eliminar la tabla 'compras'.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
