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
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();

            // Datos de la publicación para el listado y resumen administrativo.
            $table->string('titulo_publicacion');
            $table->string('resumen_publicacion', 500);

            // Nombre del libro o ensayo asociado (texto libre, puede ser externo).
            $table->string('nombre_libro');

            // Referencias de autoría: usuario escritor o administrador.
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admin')->nullOnDelete();

            // Indica si la publicación es de usuario o de administrador.
            $table->enum('publicado_por', ['usuario', 'admin']);

            // Metadatos del archivo subido (nunca texto plano directo en web).
            $table->string('archivo_original');
            $table->string('archivo_ruta');
            $table->string('archivo_extension', 10);
            $table->unsignedBigInteger('archivo_size_bytes');

            $table->dateTime('fecha_publicacion');
            $table->timestamps();

            // Índices para acelerar listados y filtros por autor y fecha.
            $table->index(['publicado_por', 'fecha_publicacion']);
            $table->index('usuario_id');
            $table->index('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};
