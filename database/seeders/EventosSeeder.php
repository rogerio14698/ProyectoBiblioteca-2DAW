<?php

namespace Database\Seeders;

use App\Models\Evento;
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
                'name' => 'Usuario ID 4',
                'email' => 'usuario4@test.com',
                'dni' => '40000004A',
                'movil' => '600000004',
                'password' => Hash::make('password123'),
                'nSocio' => '40004US',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $eventos = [
            [
                'titulo' => 'Club de Lectura',
                'descripcion' => 'Sesión mensual del club de lectura.',
                'fecha_hora' => now()->addDays(7),
                'ubicacion' => 'Sala Principal',
            ],
            [
                'titulo' => 'Taller de Escritura',
                'descripcion' => 'Taller práctico de escritura creativa.',
                'fecha_hora' => now()->addDays(14),
                'ubicacion' => 'Aula 2',
            ],
            [
                'titulo' => 'Presentación de Libro',
                'descripcion' => 'Presentación y firma con autor invitado.',
                'fecha_hora' => now()->addDays(21),
                'ubicacion' => 'Auditorio',
            ],
        ];

        foreach ($eventos as $evento) {
            Evento::updateOrCreate(
                [
                    'titulo' => $evento['titulo'],
                    'fecha_hora' => $evento['fecha_hora'],
                ],
                [
                    'descripcion' => $evento['descripcion'],
                    'ubicacion' => $evento['ubicacion'],
                    'usuario_id' => 4,
                ]
            );
        }
    }
}
