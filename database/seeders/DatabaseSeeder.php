<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar los seeders personalizados en orden lógico.
        // Primero usuarios y admins (dependencias), luego el resto de tablas.
        $this->call([
            UsuarioSeeder::class,
            AdminSeeder::class,
            EventosSeeder::class,
            LibroSeeder::class,
            NoticiasSeeder::class,
            ContactoSeeder::class,
            SlideBienvenidaSeeder::class,
            FooterConfigSeeder::class,
        ]);
    }
}
