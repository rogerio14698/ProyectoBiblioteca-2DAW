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
        Admin::create([
            'name' => 'Administrador Principal',
            'email' => 'admin@test.com',
            'password' => 'admin123', // Se hasheará automáticamente en el modelo
            'rol' => 'superadmin',
        ]);

        Admin::create([
            'name' => 'Editor de Contenido',
            'email' => 'editor@test.com',
            'password' => 'editor123',
            'rol' => 'editor',
        ]);
    }
}
