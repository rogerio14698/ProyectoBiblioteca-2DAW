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
            $table->boolean('is_demo')->default(false); // Para marcar si el usuario es de demostración
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
