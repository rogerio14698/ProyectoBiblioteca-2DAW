<?php

namespace Database\Seeders;

use App\Models\Evento;
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
        if (!DB::table('usuarios')->where('id', 4)->exists()) {
            DB::table('usuarios')->insert([
                'id' => 4,
                'name' => 'Roger Developer',
                'email' => 'usuario4@test.com',
                'dni' => '40000004A',
                'movil' => '600000004',
                'password' => Hash::make('password123'),
                'nSocio' => '40004US',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $evento1= ('img/evento1.jpg');
        $evento2= ('img/evento2.jpg');
        $evento3= ('img/evento3.jpg');
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
                    'usuario_id' => 4,
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
                    'usuario_id' => 4,
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
                    'usuario_id' => 4,
                    'prioridad' => 1,
                ],
            ))
            ->create();
    }
}