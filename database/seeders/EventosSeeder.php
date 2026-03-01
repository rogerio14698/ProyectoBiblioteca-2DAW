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

        Evento::factory()
            ->count(3)
            ->state(new Sequence(
                [
                    'titulo' => 'Club de Lectura',
                    'descripcion' => 'Sesión mensual del club de lectura.',
                    'fecha_hora' => now()->addDays(7),
                    'ubicacion' => 'Sala Principal',
                    'usuario_id' => 4,
                    'prioridad' => 2,
                ],
                [
                    'titulo' => 'Taller de Escritura',
                    'descripcion' => 'Taller práctico de escritura creativa.',
                    'fecha_hora' => now()->addDays(14),
                    'ubicacion' => 'Aula 2',
                    'usuario_id' => 4,
                    'prioridad' => 3,
                ],
                [
                    'titulo' => 'Presentación de Libro',
                    'descripcion' => 'Presentación y firma con autor invitado.',
                    'fecha_hora' => now()->addDays(21),
                    'ubicacion' => 'Auditorio',
                    'usuario_id' => 4,
                    'prioridad' => 1,
                ],
            ))
            ->create();
    }
}