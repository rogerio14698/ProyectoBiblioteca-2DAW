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
        $usuarioId = Usuario::query()->inRandomOrder()->value('id');

        if (!$usuarioId) {
            $usuarioId = Usuario::query()->firstOrCreate(
                ['email' => 'seed-eventos@local.test'],
                [
                    'name' => 'Seeder Eventos',
                    'dni' => '11111111Z',
                    'movil' => '600000111',
                    'password' => 'password123',
                    'nSocio' => '11111SE',
                ]
            )->id;
        }

        $prioridad = random_int(1, 3);
        $tituloBase = ['Actividad', 'Taller', 'Encuentro', 'Presentacion'];
        $ubicaciones = ['Sala Principal', 'Aula 1', 'Aula 2', 'Auditorio'];

        return [
            'titulo' => $tituloBase[array_rand($tituloBase)] . ' ' . now()->format('YmdHis'),
            'descripcion' => 'Evento generado por factory para pruebas de seeding.',
            'fecha_hora' => now()->addDays(random_int(1, 365)),
            'ubicacion' => $ubicaciones[array_rand($ubicaciones)],
            'usuario_id' => $usuarioId,
            'prioridad' => $prioridad,
            'url_paginaInterna' => '/eventos/' . now()->format('YmdHis') . '-' . random_int(100, 999),
        ];
    }
}
