<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\MetodosPago;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeder para crear métodos de pago de ejemplo.
 * Asocia métodos de pago ficticios a los usuarios existentes
 * para demostrar la sección de métodos de pago en el perfil.
 *
 * @sideEffect Crea registros en la tabla 'metodos_pago'.
 */
class MetodosPagoSeeder extends Seeder
{
    /**
     * Ejecutar el seeder de métodos de pago.
     * Crea tarjetas de crédito y cuentas PayPal de ejemplo.
     *
     * @return void
     */
    public function run(): void
    {
        // Obtenemos los usuarios existentes en la base de datos.
        $usuarios = Usuario::all();

        // Si no hay usuarios, no podemos crear métodos de pago.
        if ($usuarios->isEmpty()) {
            $this->command->warn('No hay usuarios para crear métodos de pago de ejemplo.');
            return;
        }

        // Para cada usuario creamos una tarjeta de crédito y un PayPal.
        foreach ($usuarios->take(3) as $usuario) {
            // Tarjeta de crédito ficticia.
            MetodosPago::create([
                'usuario_id'   => $usuario->id,
                'type'         => 'tarjeta_credito',
                'provider'     => 'Stripe',
                'token'        => Str::random(32), // Token seguro simulado.
                'last_four'    => (string) rand(1000, 9999), // Últimos 4 dígitos aleatorios.
                'paypal_email' => null,
            ]);

            // Cuenta PayPal ficticia.
            MetodosPago::create([
                'usuario_id'   => $usuario->id,
                'type'         => 'paypal',
                'provider'     => 'PayPal',
                'token'        => Str::random(32), // Token seguro simulado.
                'last_four'    => null,
                'paypal_email' => $usuario->email, // Usamos el email del usuario como PayPal.
            ]);
        }

        // Mensaje informativo en la consola al finalizar.
        $this->command->info('Métodos de pago de ejemplo creados correctamente.');
    }
}
