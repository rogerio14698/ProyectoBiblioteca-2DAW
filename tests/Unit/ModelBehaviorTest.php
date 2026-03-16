<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Admin;
use App\Models\Evento;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ModelBehaviorTest extends TestCase
{
    use RefreshDatabase;

    public function test_ut01_user_password_is_hashed_automatically(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => 'Secret123!',
        ]);

        $this->assertNotSame('Secret123!', $user->password);
        $this->assertTrue(Hash::check('Secret123!', $user->password));
    }

    public function test_ut04_admin_password_is_hashed_automatically(): void
    {
        $admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'AdminSecret123!',
            'rol' => 'editor',
        ]);

        $this->assertNotSame('AdminSecret123!', $admin->password);
        $this->assertTrue(Hash::check('AdminSecret123!', $admin->password));
    }

    public function test_ut02_usuario_generates_n_socio_automatically(): void
    {
        $usuario = Usuario::create([
            'name' => 'Maria',
            'email' => 'maria@example.com',
            'dni' => '12345678A',
            'movil' => '600111222',
            'password' => 'Password123!',
        ]);

        $this->assertNotNull($usuario->nSocio);
        $this->assertMatchesRegularExpression('/^[0-9]{5}[A-Z]{2}$/', $usuario->nSocio);
    }

    public function test_ut03_usuario_generates_unique_n_socio_for_multiple_records(): void
    {
        $first = Usuario::create([
            'name' => 'User One',
            'email' => 'one@example.com',
            'dni' => '11111111A',
            'movil' => '600000001',
            'password' => 'Password123!',
        ]);

        $second = Usuario::create([
            'name' => 'User Two',
            'email' => 'two@example.com',
            'dni' => '22222222B',
            'movil' => '600000002',
            'password' => 'Password123!',
        ]);

        $this->assertNotSame($first->nSocio, $second->nSocio);
    }

    public function test_ut05_evento_prioridad_texto_accessor_returns_expected_values(): void
    {
        $usuario = Usuario::create([
            'name' => 'Evento Owner',
            'email' => 'owner@example.com',
            'dni' => '33333333C',
            'movil' => '600000003',
            'password' => 'Password123!',
        ]);

        $eventoBajo = Evento::create([
            'titulo' => 'Evento Bajo',
            'descripcion' => 'Descripcion',
            'fecha_hora' => now()->addDay(),
            'ubicacion' => 'Biblioteca',
            'usuario_id' => $usuario->id,
            'prioridad' => 1,
        ]);

        $eventoMedio = Evento::create([
            'titulo' => 'Evento Medio',
            'descripcion' => 'Descripcion',
            'fecha_hora' => now()->addDays(2),
            'ubicacion' => 'Biblioteca',
            'usuario_id' => $usuario->id,
            'prioridad' => 2,
        ]);

        $eventoAlto = Evento::create([
            'titulo' => 'Evento Alto',
            'descripcion' => 'Descripcion',
            'fecha_hora' => now()->addDays(3),
            'ubicacion' => 'Biblioteca',
            'usuario_id' => $usuario->id,
            'prioridad' => 3,
        ]);

        $this->assertSame('Baja', $eventoBajo->prioridad_texto);
        $this->assertSame('Media', $eventoMedio->prioridad_texto);
        $this->assertSame('Alta', $eventoAlto->prioridad_texto);
    }
}
