<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence(20),
            'descripcion' => $this->faker->paragraph(),
            'fecha_hora' => $this->faker->dateTimeBetween('now', '+1 year'),
            'ubicacion' => $this->faker->address(),
            'usuario_id' => 4,
        ];
    }
}
