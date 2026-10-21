<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

/**
 * Rechaza direcciones de servicios de correo temporal (config/correo.php).
 * También comprueba subdominios: x.mailinator.com cuenta como mailinator.com.
 */
class EmailNoDesechable implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dominio = Str::lower(Str::after((string) $value, '@'));
        $desechables = config('correo.dominios_desechables', []);

        foreach ($desechables as $desechable) {
            if ($dominio === $desechable || Str::endsWith($dominio, '.' . $desechable)) {
                $fail('No se admiten direcciones de correo temporales. Usa tu email habitual.');
                return;
            }
        }
    }
}