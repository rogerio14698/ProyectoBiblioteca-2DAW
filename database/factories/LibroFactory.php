<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Libro>
 */
class LibroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [ 
            'titulo' => $this->faker->sentence(3),
            'autor' => $this->faker->name(),
            'genero' => $this->faker->randomElement(['Ficción', 'No Ficción', 'Ciencia', 'Historia', 'Biografía']),
            'anio' => $this->faker->year(),
            'editorial' => $this->faker->company(),
            'disponibilidad' => $this->faker->randomElement(['disponible', 'prestado']),
            'formato' => $this->faker->randomElement(['fisico', 'digital', 'ambos']),
            'opcion_compra' => $this->faker->randomElement(['compra', 'prestamo']),
            'cantidad_ejemplares' => $this->faker->numberBetween(1, 10),
            'isbn' => $this->faker->isbn13(),
            'portada_img' => 'img/elPrincipito.jpg', // Imagen de muestra para todos los libros
        ];
    }
}
