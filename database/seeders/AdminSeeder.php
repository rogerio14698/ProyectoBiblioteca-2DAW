<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'email' => 'admin@test.com',
                'name' => 'Administrador Principal',
                'password' => 'admin123',
                'rol' => 'superadmin',
            ],
            [
                'email' => 'editor@test.com',
                'name' => 'Editor de Contenido',
                'password' => 'editor123',
                'rol' => 'editor',
            ],
            [
                'email' => 'moderador@test.com',
                'name' => 'Moderador General',
                'password' => 'moderador123',
                'rol' => 'moderador',
            ],
        ];

        foreach ($admins as $admin) {
            Admin::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => $admin['password'],
                    'rol' => $admin['rol'],
                ]
            );
        }
    }
}