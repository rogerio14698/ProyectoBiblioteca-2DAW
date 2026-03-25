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
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('contenido');
            $table->string('autor')->nullable();
            $table->date('fecha_publicacion')->nullable();
            $table->string('imagen_url')->nullable();
            $table->boolean('destacado')->default(false);
            $table->string('categoria')->nullable();
            $table->string('enlace_externo')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('admin')->onDelete('set null');
            $table->string('url_paginaInterna')->nullable(); // Nueva columna para la URL de la página interna de la noticia
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
