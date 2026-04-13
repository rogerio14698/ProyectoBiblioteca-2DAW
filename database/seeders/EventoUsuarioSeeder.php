<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder para crear inscripciones de usuarios a eventos.
 * Vincula usuarios existentes con eventos existentes en la tabla pivote 'evento_usuario'
 * para demostrar el historial de reservas de eventos en el perfil del usuario.
 *
 * @sideEffect Crea registros en la tabla 'evento_usuario'.
 */
class EventoUsuarioSeeder extends Seeder
{
    /**
     * Ejecutar el seeder de inscripciones a eventos.
     * Asigna usuarios a eventos con distintos estados de asistencia.
     *
     * @return void
     */
    public function run(): void
    {
        // Obtenemos los usuarios y eventos existentes en la base de datos.
        $usuarios = Usuario::all();
        $eventos = Evento::all();

        // Si no hay usuarios o eventos, no podemos crear inscripciones.
        if ($usuarios->isEmpty() || $eventos->isEmpty()) {
            $this->command->warn('No hay usuarios o eventos para crear inscripciones de ejemplo.');
            return;
        }

        // Posibles estados de asistencia para dar variedad a los datos.
        $estados = ['inscrito', 'asistido', 'cancelado', 'no_asistio'];

        // Asignamos a cada usuario entre 2 y 4 eventos.
        foreach ($usuarios as $usuario) {
            // Seleccionamos eventos aleatorios para inscribir al usuario.
            $eventosSeleccionados = $eventos->random(min($eventos->count(), rand(2, 4)));

            foreach ($eventosSeleccionados as $evento) {
                // Evitamos duplicados: comprobamos si ya está inscrito.
                $yaInscrito = DB::table('evento_usuario')
                    ->where('usuario_id', $usuario->id)
                    ->where('evento_id', $evento->id)
                    ->exists();

                if ($yaInscrito) {
                    continue;
                }

                // Insertamos la inscripción con un estado aleatorio.
                DB::table('evento_usuario')->insert([
                    'usuario_id'        => $usuario->id,
                    'evento_id'         => $evento->id,
                    'fecha_inscripcion' => Carbon::now()->subDays(rand(1, 60)),
                    'estado'            => $estados[array_rand($estados)],
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }
        }

        // Mensaje informativo en la consola al finalizar.
        $this->command->info('Inscripciones a eventos de ejemplo creadas correctamente.');
    }
}
