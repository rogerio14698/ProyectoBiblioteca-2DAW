<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\MetodosPago;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

/**
 * Tarjetas de ejemplo para la sección "Métodos de pago" del perfil.
 * Usan el prefijo pm_demo_ para que la app sepa que no existen en Stripe
 * y no intente desvincularlas al borrarlas.
 */
class MetodosPagoSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = Usuario::take(3)->get();

        if ($usuarios->isEmpty()) {
            $this->command->warn('No hay usuarios para crear métodos de pago de ejemplo.');
            return;
        }

        $tarjetas = [
            ['marca' => 'visa', 'last_four' => '4242'],
            ['marca' => 'mastercard', 'last_four' => '4444'],
        ];

        foreach ($usuarios as $usuario) {
            foreach ($tarjetas as $i => $tarjeta) {
                MetodosPago::create([
                    'usuario_id' => $usuario->id,
                    'stripe_payment_method_id' => 'pm_demo_' . $usuario->id . '_' . $i,
                    'tipo' => 'card',
                    'marca' => $tarjeta['marca'],
                    'last_four' => $tarjeta['last_four'],
                    'exp_mes' => 12,
                    'exp_anio' => (int) now()->addYears(3)->format('Y'),
                    'predeterminado' => $i === 0,
                ]);
            }
        }
    }
}