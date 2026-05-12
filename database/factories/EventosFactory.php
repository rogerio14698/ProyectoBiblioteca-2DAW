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
            'titulo' => $this->faker->sentence(4),
            'descripcion' => $this->faker->paragraph(),
            'fecha_hora' => $this->faker->dateTimeBetween('now', '+1 year'),
            'ubicacion' => $this->faker->address(),
            'usuario_id' => $usuarioId,
            'prioridad' => $this->faker->numberBetween(1, 3),
            'url_paginaInterna' => $this->faker->url(),
        ];
    }
}
