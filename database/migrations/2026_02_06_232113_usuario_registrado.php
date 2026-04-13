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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('dni')->unique();
            $table->string('movil')->nullable()->unique();
            $table->string('password'); // contraseña hasheada
            $table->string('nSocio', 7)->nullable()->unique(); // 5 números + 2 letras - nullable de momento
            $table->boolean('es_escritor_verificado')->default(false);
            $table->enum('tipo_escritor', ['profesional', 'aficion'])->nullable();
            $table->boolean('is_demo')->default(false); // Para marcar si el usuario es de demostración
            // Ruta de la foto de perfil (hasheada por Storage, puede superar 255 chars).
            $table->string('profile_photo_path', 500)->nullable();
            //Deberia de poner el last_login, pero esto más adelante 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};