<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla de configuración del footer.
     * Es una tabla de fila única: solo existirá 1 registro con toda la config.
     */
    public function up(): void
    {
        Schema::create('footer_config', function (Blueprint $table) {
            $table->id();

            // Columna 1: Info general
            $table->string('titulo')->default('Biblioteca DAW Proyecto');
            $table->string('telefono')->default('123-456-789');
            $table->string('direccion')->default('Avd. de la Universidad, 123');
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('youtube_url')->nullable();

            // Columna 2: Horarios
            $table->string('horario_semana')->default('9:00 - 20:00');
            $table->string('horario_sabado')->default('10:00 - 18:00');
            $table->string('horario_domingo')->default('Cerrado');

            // Columna 3: Contacto y legal
            $table->string('email_contacto')->default('info@biblioteca.local');
            $table->string('aviso_legal_url')->nullable();
            $table->string('politica_cookies_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_config');
    }
};
