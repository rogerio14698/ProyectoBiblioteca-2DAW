<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementViewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_management_views_render_with_admin_components(): void
    {
        $admin = Admin::create([
            'name' => 'Administracion',
            'email' => 'admin.management@example.test',
            'password' => 'Password123!',
            'rol' => 'superadmin',
        ]);
        $this->actingAs($admin, 'admin');

        foreach ([
            'gestionUsuarios', 'historialReservas', 'reservasActivas',
            'publicacionesUser', 'inventario', 'librosPrestados',
            'librosPerdidos', 'gestionCarrusel', 'gestionCatalogo',
            'gestionFooter', 'gestionHome', 'gestionNoticias',
        ] as $route) {
            $response = $this->get(route('admin.' . $route))
                ->assertOk()
                ->assertSee('class="a-titulo"', false)
                ->assertSee('class="a-tarjeta"', false);

            if (!in_array($route, ['inventario', 'gestionFooter', 'publicacionesUser'], true)) {
                $response->assertSee('class="a-tabla a-tabla--gestion"', false)
                    ->assertSee('scope="col"', false);
            }
        }
    }
}
