<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario de prueba para desarrollo local
        // Email: usuario@test.com
        // Contraseña: password123
        Usuario::updateOrCreate(
            ['email' => 'usuario@test.com'],
            [
                'name' => 'Juan Usuario',
                'dni' => '12345678A',
                'movil' => '666123456',
                'password' => 'password123', // Se hasheará automáticamente en el modelo
                'nSocio' => '12345AB', // Se genera automáticamente en booted(), pero lo ponemos aquí como respaldo
            ]
        );

        Usuario::updateOrCreate(
            ['email' => 'maria@test.com'],
            [
                'name' => 'María Lectora',
                'dni' => '87654321B',
                'movil' => '666654321',
                'password' => 'password123',
                'nSocio' => '54321CD', // Se genera automáticamente en booted(), pero lo ponemos aquí como respaldo
            ]
        );
    }
}
