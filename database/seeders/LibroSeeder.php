<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Libro;
use Illuminate\Database\Seeder;

/**
 * Seeder para poblar la tabla 'libros' con datos de ejemplo.
 * Utiliza la imagen 'elPrincipito.jpg' como portada genérica de muestra
 * para todos los libros, ya que aún no se dispone de las portadas reales.
 */
class LibroSeeder extends Seeder
{
    /**
     * Ejecutar el seeder de libros.
     * Crea 10 libros de ejemplo con diferentes géneros, formatos y disponibilidad.
     *
     * @return void
     *
     * @efectos Inserta registros en la tabla 'libros'.
     */

        // Array con los datos de cada libro de ejemplo.
        public function run(): void{
            \App\Models\Libro::factory()->count(500)->create();
        }

    
    
}