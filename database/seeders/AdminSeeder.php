<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin de prueba para desarrollo local
        // Email: admin@test.com
        // Contraseña: admin123
        Admin::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Administrador Principal',
                'password' => 'admin123', // Se hasheará automáticamente en el modelo
                'rol' => 'superadmin',
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'editor@test.com'],
            [
                'name' => 'Editor de Contenido',
                'password' => 'editor123',
                'rol' => 'editor',
            ]
        );
    }
}
