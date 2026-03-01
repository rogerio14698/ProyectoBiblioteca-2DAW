<?php

namespace Database\Factories;

use App\Models\Evento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventosFactory extends Factory
{
    protected $model = Evento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence(4),
            'descripcion' => $this->faker->paragraph(),
            'fecha_hora' => $this->faker->dateTimeBetween('now', '+1 year'),
            'ubicacion' => $this->faker->address(),
            'usuario_id' => 4,
            'prioridad' => $this->faker->numberBetween(1, 3),
        ];
    }
}
