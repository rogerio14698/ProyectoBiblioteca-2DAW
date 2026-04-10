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
    Schema::create('prestamos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('libro_id')->constrained('libros')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        $table->timestamp('fecha_prestamo')->useCurrent();
        $table->timestamp('fecha_devolucion_esperada')->nullable();
        
        // ESTA ES LA COLUMNA QUE TE FALTA:
        $table->timestamp('fecha_devolucion_real')->nullable(); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
