<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\FooterConfig;
use Illuminate\Database\Seeder;

/**
 * Seeder para crear la fila única de configuración del footer.
 * Se ejecuta solo si no existe ya un registro para evitar duplicados.
 */
class FooterConfigSeeder extends Seeder
{
    /**
     * Insertar la configuración por defecto del footer.
     * @effect Crea 1 registro en footer_config si la tabla está vacía.
     */
    public function run(): void
    {
        // Solo creamos la fila si la tabla está vacía.
        FooterConfig::firstOrCreate([], [
            'titulo' => 'Biblioteca DAW Proyecto',
            'telefono' => '+34 629948107',
            'direccion' => 'Avd. de la Universidad, 123',
            'instagram_url' => 'https://www.instagram.com/',
            'linkedin_url' => 'https://www.linkedin.com/',
            'twitter_url' => 'https://twitter.com/',
            'youtube_url' => 'https://www.youtube.com/',
            'horario_semana' => '9:00 - 20:00',
            'horario_sabado' => '10:00 - 18:00',
            'horario_domingo' => 'Cerrado',
            'email_contacto' => 'rogeriolucas14698@gmail.com',
            'aviso_legal_url' => '/avisoLegal',
            'politica_cookies_url' => '/politicasCookies',
        ]);
    }
}
