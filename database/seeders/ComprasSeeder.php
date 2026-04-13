<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Compra;
use App\Models\Libro;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Seeder para crear compras de ejemplo.
 * Vincula usuarios existentes con libros existentes
 * para demostrar el historial de compras en el perfil del usuario.
 *
 * @sideEffect Crea registros en la tabla 'compras'.
 */
class ComprasSeeder extends Seeder
{
    /**
     * Ejecutar el seeder de compras.
     * Crea compras variadas con distintos estados para los usuarios existentes.
     *
     * @return void
     */
    public function run(): void
    {
        // Obtenemos los usuarios y libros existentes en la base de datos.
        $usuarios = Usuario::all();
        $libros = Libro::all();

        // Si no hay usuarios o libros, no podemos crear compras.
        if ($usuarios->isEmpty() || $libros->isEmpty()) {
            $this->command->warn('No hay usuarios o libros para crear compras de ejemplo.');
            return;
        }

        // Posibles estados de compra para dar variedad a los datos.
        $estados = ['completado', 'recibido', 'pendiente', 'enviado'];

        // Precios de ejemplo para las compras.
        $precios = [9.99, 12.50, 15.00, 18.75, 22.90, 25.00, 7.50, 30.00];

        // Asignamos a cada usuario entre 2 y 4 compras.
        foreach ($usuarios->take(3) as $usuario) {
            // Seleccionamos libros aleatorios para simular compras.
            $librosComprados = $libros->random(min($libros->count(), rand(2, 4)));

            foreach ($librosComprados as $libro) {
                Compra::create([
                    'usuario_id'   => $usuario->id,
                    'libro_id'     => $libro->id,
                    'fecha_compra' => Carbon::now()->subDays(rand(1, 120)),
                    'precio'       => $precios[array_rand($precios)],
                    'estado'       => $estados[array_rand($estados)],
                ]);
            }
        }

        // Mensaje informativo en la consola al finalizar.
        $this->command->info('Compras de ejemplo creadas correctamente.');
    }
}
