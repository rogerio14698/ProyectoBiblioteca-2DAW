<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Libro;
use App\Models\Prestamos;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Seeder para crear préstamos de ejemplo.
 * Asigna libros existentes a usuarios registrados con distintos estados
 * para demostrar la funcionalidad del historial de préstamos en el perfil.
 *
 * @sideEffect Crea registros en la tabla 'prestamos'.
 */
class PrestamosSeeder extends Seeder
{
    /**
     * Ejecutar el seeder de préstamos.
     * Toma usuarios y libros existentes y crea préstamos variados.
     *
     * @return void
     */
    public function run(): void
    {
        // Obtenemos los usuarios y libros existentes en la base de datos.
        $usuarios = Usuario::all();
        $libros = Libro::all();

        // Si no hay usuarios o libros, no podemos crear préstamos.
        if ($usuarios->isEmpty() || $libros->isEmpty()) {
            $this->command->warn('No hay usuarios o libros para crear préstamos de ejemplo.');
            return;
        }

        // Fecha de hoy como referencia para calcular fechas pasadas y futuras.
        $hoy = Carbon::today();

        // --- Préstamos ACTIVOS (libros que aún no se han devuelto) ---
        foreach ($usuarios->take(2) as $index => $usuario) {
            // A cada usuario le asignamos 2 libros en préstamo activo.
            $librosActivos = $libros->slice($index * 2, 2);

            foreach ($librosActivos as $libro) {
                Prestamos::create([
                    'libro_id'                  => $libro->id,
                    'usuario_id'                => $usuario->id,
                    'fecha_prestamo'            => $hoy->copy()->subDays(rand(1, 10)),
                    'fecha_devolucion_esperada' => $hoy->copy()->addDays(rand(5, 20)),
                    'fecha_devolucion_real'     => null, // Aún no devuelto.
                ]);
            }
        }

        // --- Préstamos DEVUELTOS (historial de préstamos completados) ---
        foreach ($usuarios->take(2) as $index => $usuario) {
            // A cada usuario le asignamos 3 libros ya devueltos.
            $librosDevueltos = $libros->slice(4 + ($index * 3), 3);

            foreach ($librosDevueltos as $libro) {
                // Calculamos una fecha de préstamo pasada y una devolución previa.
                $fechaPrestamo = $hoy->copy()->subDays(rand(30, 90));
                $fechaDevEsperada = $fechaPrestamo->copy()->addDays(14);

                Prestamos::create([
                    'libro_id'                  => $libro->id,
                    'usuario_id'                => $usuario->id,
                    'fecha_prestamo'            => $fechaPrestamo,
                    'fecha_devolucion_esperada' => $fechaDevEsperada,
                    'fecha_devolucion_real'     => $fechaDevEsperada->copy()->subDays(rand(1, 5)),
                ]);
            }
        }

        // Mensaje informativo en la consola al finalizar.
        $this->command->info('Préstamos de ejemplo creados correctamente.');
    }
}
