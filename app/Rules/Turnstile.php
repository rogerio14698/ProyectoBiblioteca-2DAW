<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Verifica el token de Cloudflare Turnstile en el servidor (siteverify).
 * Si no hay clave secreta configurada se omite, para no bloquear entornos locales.
 */
class Turnstile implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('services.turnstile.secret_key');
        if (empty($secret)) {
            return;
        }

        if (! is_string($value) || $value === '') {
            $fail('Confirma que no eres un robot.');
            return;
        }

        try {
            $respuesta = Http::asForm()->timeout(8)->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $secret,
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Turnstile no disponible: ' . $e->getMessage());
            $fail('No hemos podido verificar el formulario. Inténtalo de nuevo.');
            return;
        }

        if (! $respuesta->json('success')) {
            $fail('La verificación anti-bot ha fallado. Recarga la página e inténtalo de nuevo.');
        }
    }
}