<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\Usuario;
use Faker\Factory as FakerFactory;
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

        $faker = function_exists('fake')
            ? fake()
            : FakerFactory::create(config('app.faker_locale', 'en_US'));

        return [
            'titulo' => $faker->sentence(4),
            'descripcion' => $faker->paragraph(),
            'fecha_hora' => $faker->dateTimeBetween('now', '+1 year'),
            'ubicacion' => $faker->address(),
            'usuario_id' => $usuarioId,
            'prioridad' => $faker->numberBetween(1, 3),
            'url_paginaInterna' => $faker->url(),
        ];
    }
}
