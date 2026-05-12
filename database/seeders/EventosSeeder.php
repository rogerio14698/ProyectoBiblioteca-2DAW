<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class EventosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::query()->updateOrCreate(
            ['email' => 'usuario4@test.com'],
            [
                'name' => 'Roger Developer',
                'dni' => '40000004A',
                'movil' => '600000004',
                'password' => Hash::make('password123'),
                'nSocio' => '40004US',
            ]
        );

        $usuarioId = Usuario::query()->where('email', 'usuario4@test.com')->value('id');

        // URLs directas de Unsplash con imágenes temáticas (800x600, recortadas)
        $evento1 = 'https://images.unsplash.com/photo-1531243269054-5ebf6f34081e?w=800&h=600&fit=crop'; // Arte/exposición
        $evento2 = 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=800&h=600&fit=crop'; // Libros/biblioteca
        $evento3 = 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=800&h=600&fit=crop'; // Conferencia/presentación
        Evento::factory()
            ->count(3)
            ->state(new Sequence(
                [
                    'titulo' => 'Exposición de Arte Local',
                    'descripcion' => 'Exposición de obras de artistas locales en la biblioteca.',
                    'fecha_hora' => now()->addDays(7),
                    'ubicacion' => 'Sala Principal',
                    'aforo' => 50,
                    'asistentes' => 10,
                    // plazas_libres se calcula automáticamente (columna generada: aforo - asistentes).
                    'imagen_url' => $evento1,
                    'usuario_id' => $usuarioId,
                    'prioridad' => 2,
                ],
                [
                    'titulo' => 'Club de lectura: Escritura Creativa',
                    'descripcion' => 'Taller práctico de escritura creativa.',
                    'fecha_hora' => now()->addDays(14),
                    'ubicacion' => 'Aula 2',
                    'aforo' => 30,
                    'asistentes' => 5,
                    'imagen_url' => $evento2,
                    'usuario_id' => $usuarioId,
                    'prioridad' => 3,
                ],
                [
                    'titulo' => 'Presentación de Libro',
                    'descripcion' => 'Presentación y firma con autor invitado.',
                    'fecha_hora' => now()->addDays(21),
                    'ubicacion' => 'Auditorio',
                    'aforo' => 100,
                    'asistentes' => 0,
                    'imagen_url' => $evento3,
                    'usuario_id' => $usuarioId,
                    'prioridad' => 1,
                ],
            ))
            ->create();
    }
}