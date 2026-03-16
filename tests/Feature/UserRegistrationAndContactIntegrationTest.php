<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\ContactoRecibido;
use App\Models\Contacto;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserRegistrationAndContactIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it01_register_user_with_valid_data(): void
    {
        $response = $this->post('/registro', [
            'name' => 'Juan Test',
            'email' => 'juan@example.com',
            'dni' => '44444444D',
            'movil' => '600000004',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect('/biblioteca');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('usuarios', [
            'email' => 'juan@example.com',
            'dni' => '44444444D',
        ]);
    }

    public function test_it02_register_rejects_duplicate_email(): void
    {
        Usuario::create([
            'name' => 'Existing User',
            'email' => 'duplicado@example.com',
            'dni' => '55555555E',
            'movil' => '600000005',
            'password' => 'Password123!',
        ]);

        $response = $this->from('/registro')->post('/registro', [
            'name' => 'New User',
            'email' => 'duplicado@example.com',
            'dni' => '66666666F',
            'movil' => '600000006',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect('/registro');
        $response->assertSessionHasErrors('email');

        $this->assertDatabaseCount('usuarios', 1);
    }

    public function test_it03_register_rejects_duplicate_dni(): void
    {
        Usuario::create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'dni' => '77777777G',
            'movil' => '600000007',
            'password' => 'Password123!',
        ]);

        $response = $this->from('/registro')->post('/registro', [
            'name' => 'New User',
            'email' => 'new@example.com',
            'dni' => '77777777G',
            'movil' => '600000008',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect('/registro');
        $response->assertSessionHasErrors('dni');

        $this->assertDatabaseCount('usuarios', 1);
    }

    public function test_it04_register_rejects_when_password_confirmation_fails(): void
    {
        $response = $this->from('/registro')->post('/registro', [
            'name' => 'Ana Test',
            'email' => 'ana@example.com',
            'dni' => '88888888H',
            'movil' => '600000009',
            'password' => 'Password123!',
            'password_confirmation' => 'DifferentPassword123!',
        ]);

        $response->assertRedirect('/registro');
        $response->assertSessionHasErrors('password');

        $this->assertDatabaseMissing('usuarios', [
            'email' => 'ana@example.com',
        ]);
    }

    public function test_it09_contact_form_stores_data_and_sends_mail(): void
    {
        Mail::fake();

        $response = $this->from('/contacto')->post('/contacto', [
            'nombre' => 'Carlos',
            'email' => 'carlos@example.com',
            'asunto' => 'Consulta',
            'mensaje' => 'Necesito informacion sobre horarios.',
        ]);

        $response->assertRedirect('/contacto');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contactos', [
            'nombre' => 'Carlos',
            'email' => 'carlos@example.com',
            'asunto' => 'Consulta',
            'mensaje' => 'Necesito informacion sobre horarios.',
        ]);

        Mail::assertSent(ContactoRecibido::class);
    }

    public function test_it10_contact_form_sanitizes_html_tags_in_message(): void
    {
        Mail::fake();

        $rawMessage = '<script>alert("x")</script><b>Hola</b> <i>Mundo</i>';
        $expectedCleanMessage = 'alert("x")Hola Mundo';

        $this->from('/contacto')->post('/contacto', [
            'nombre' => 'Lucia',
            'email' => 'lucia@example.com',
            'asunto' => 'Prueba de seguridad',
            'mensaje' => $rawMessage,
        ])->assertRedirect('/contacto');

        $contacto = Contacto::query()->where('email', 'lucia@example.com')->first();

        $this->assertNotNull($contacto);
        $this->assertSame($expectedCleanMessage, $contacto->mensaje);
    }
}
