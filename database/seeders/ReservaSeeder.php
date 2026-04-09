<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Libro;
use App\Models\Reserva;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Seeder para crear reservas de ejemplo.
 * Asigna libros existentes a usuarios registrados con distintos estados
 * para demostrar la funcionalidad del historial de reservas.
 *
 * @sideEffect Crea registros en la tabla 'reservas'.
 */
class ReservaSeeder extends Seeder
{
    /**
     * Ejecutar el seeder de reservas.
     * Toma usuarios y libros existentes y crea reservas variadas.
     *
     * @return void
     */
    public function run(): void
    {
        // Obtenemos los usuarios y libros existentes en la base de datos.
        $usuarios = Usuario::all();
        $libros = Libro::all();

        // Si no hay usuarios o libros, no podemos crear reservas.
        if ($usuarios->isEmpty() || $libros->isEmpty()) {
            $this->command->warn('No hay usuarios o libros para crear reservas de ejemplo.');
            return;
        }

        // Fecha de hoy como referencia.
        $hoy = Carbon::today();

        // --- Reservas ACTIVAS (libros prestados que aún no se han devuelto) ---
        foreach ($usuarios->take(3) as $index => $usuario) {
            // A cada usuario le asignamos 2 libros activos.
            $librosActivos = $libros->slice($index * 2, 2);

            foreach ($librosActivos as $libro) {
                Reserva::create([
                    'usuario_id'                => $usuario->id,
                    'libro_id'                  => $libro->id,
                    'fecha_reserva'             => $hoy->copy()->subDays(rand(1, 10)),
                    'fecha_devolucion_prevista' => $hoy->copy()->addDays(rand(5, 20)),
                    'fecha_devolucion_real'     => null,
                    'estado'                    => 'activa',
                    'observaciones'             => null,
                ]);
            }
        }

        // --- Reservas DEVUELTAS (historial de préstamos completados) ---
        foreach ($usuarios->take(3) as $index => $usuario) {
            $librosDevueltos = $libros->slice(6 + ($index * 2), 2);

            foreach ($librosDevueltos as $libro) {
                $fechaReserva = $hoy->copy()->subDays(rand(30, 60));
                $fechaDevPrevista = $fechaReserva->copy()->addDays(14);

                Reserva::create([
                    'usuario_id'                => $usuario->id,
                    'libro_id'                  => $libro->id,
                    'fecha_reserva'             => $fechaReserva,
                    'fecha_devolucion_prevista' => $fechaDevPrevista,
                    'fecha_devolucion_real'     => $fechaDevPrevista->copy()->subDays(rand(1, 5)),
                    'estado'                    => 'devuelta',
                    'observaciones'             => 'Devuelto en buen estado.',
                ]);
            }
        }

        // --- Reservas VENCIDAS (usuario no devolvió a tiempo) ---
        if ($usuarios->count() >= 2) {
            $librosVencidos = $libros->slice(12, 2);

            foreach ($librosVencidos as $libro) {
                Reserva::create([
                    'usuario_id'                => $usuarios[1]->id,
                    'libro_id'                  => $libro->id,
                    'fecha_reserva'             => $hoy->copy()->subDays(25),
                    'fecha_devolucion_prevista' => $hoy->copy()->subDays(11),
                    'fecha_devolucion_real'     => null,
                    'estado'                    => 'vencida',
                    'observaciones'             => 'El usuario no ha devuelto el libro a tiempo.',
                ]);
            }
        }

        // --- Reserva CANCELADA (ejemplo de cancelación) ---
        if ($usuarios->count() >= 3 && $libros->count() >= 16) {
            Reserva::create([
                'usuario_id'                => $usuarios[2]->id,
                'libro_id'                  => $libros[15]->id,
                'fecha_reserva'             => $hoy->copy()->subDays(5),
                'fecha_devolucion_prevista' => $hoy->copy()->addDays(9),
                'fecha_devolucion_real'     => null,
                'estado'                    => 'cancelada',
                'observaciones'             => 'Cancelada por el usuario.',
            ]);
        }

        $this->command->info('Reservas de ejemplo creadas correctamente.');
    }
}
