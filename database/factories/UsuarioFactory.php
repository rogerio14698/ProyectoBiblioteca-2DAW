<?php

namespace Database\Factories;

use Illuminate\Support\Str;
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
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'dni' => strtoupper(Str::random(8)) . $this->faker->randomLetter(),
            'movil' => $this->faker->numerify('6########'),
            'password' => 'password123',
            'nSocio' => null,
            'es_escritor_verificado' => $this->faker->boolean(30),
            'tipo_escritor' => $this->faker->optional()->randomElement(['profesional', 'aficion']),
            'is_demo' => false,
        ];
    }
}