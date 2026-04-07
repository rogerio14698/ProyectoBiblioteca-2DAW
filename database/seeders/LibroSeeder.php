<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Libro;
use Illuminate\Database\Seeder;

/**
 * Seeder para poblar la tabla 'libros' con datos de ejemplo.
 * Utiliza la Factory LibroFactory para generar los datos aleatorios.
 * Cada libro recibe una portada distinta usando images.unsplash.com.
 */
class LibroSeeder extends Seeder
{
    /**
     * Ejecutar el seeder de libros.
     * Crea 500 libros de ejemplo usando la Factory, cada uno con portada diferente.
     *
     * @return void
     *
     * @efectos Inserta 500 registros en la tabla 'libros'.
     */
    public function run(): void
    {
        // Creamos 500 libros usando la Factory.
        // Cada portada se genera automáticamente con un ID único en LibroFactory.
        Libro::factory()->count(500)->create();
    }
}