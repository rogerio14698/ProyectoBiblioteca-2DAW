<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Contacto;
use App\Models\Pago;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_suma_ingresos_pagados_del_mes_y_muestra_mensajes(): void
    {
        $admin = Admin::create([
            'name' => 'Administracion',
            'email' => 'admin.dashboard@example.test',
            'password' => 'Password123!',
            'rol' => 'superadmin',
        ]);
        $usuario = Usuario::create([
            'name' => 'Lector',
            'email' => 'lector.dashboard@example.test',
            'dni' => '11111111A',
            'password' => 'Password123!',
        ]);
        Pago::create([
            'usuario_id' => $usuario->id,
            'concepto' => 'compra_libro',
            'descripcion' => 'Compra de prueba',
            'importe' => 12345,
            'estado' => 'pagado',
            'pagado_at' => now(),
        ]);
        Contacto::create([
            'nombre' => 'Persona sin verificar',
            'email' => 'contacto@example.test',
            'asunto' => 'Consulta de prueba',
            'mensaje' => 'Mensaje de contacto de prueba.',
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewHas('ingresosMes', 12345)
            ->assertViewHas('ingresosPorConcepto', function ($series): bool {
                return $series->firstWhere('etiqueta', 'Libro')['importe'] === 12345;
            });

        $this->actingAs($admin, 'admin')
            ->get(route('admin.mensajes.index'))
            ->assertOk()
            ->assertSee('Persona sin verificar')
            ->assertSee('Sin verificar');
    }
}
