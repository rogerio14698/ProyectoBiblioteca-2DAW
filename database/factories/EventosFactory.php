<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\Usuario;
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
        $usuarioId = Usuario::query()->inRandomOrder()->value('id')
            ?? Usuario::factory()->create()->id;

        return [
            'titulo' => fake()->sentence(4),
            'descripcion' => fake()->paragraph(),
            'fecha_hora' => fake()->dateTimeBetween('now', '+1 year'),
            'ubicacion' => fake()->address(),
            'usuario_id' => $usuarioId,
            'prioridad' => fake()->numberBetween(1, 3),
            'url_paginaInterna' => fake()->url(),
        ];
    }
}
