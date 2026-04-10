<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Agrega el campo 'perdido' a la tabla libros.
     */
    public function up(): void
    {
        Schema::table('libros', function (Blueprint $table) {
            // Indica si el libro está dado de baja por pérdida
            $table->boolean('perdido')->default(false)->after('cantidad_ejemplares');
            // Opcional: motivo de baja
            $table->string('motivo_baja')->nullable()->after('perdido');
        });
    }

    /**
     * Elimina el campo 'perdido' y 'motivo_baja'.
     */
    public function down(): void
    {
        Schema::table('libros', function (Blueprint $table) {
            $table->dropColumn(['perdido', 'motivo_baja']);
        });
    }
};
