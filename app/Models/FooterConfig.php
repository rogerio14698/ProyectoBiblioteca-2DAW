<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la configuración del footer.
 * Esta tabla solo tiene 1 fila con toda la configuración del pie de página.
 */
class FooterConfig extends Model
{
    // Nombre de la tabla en la base de datos.
    protected $table = 'footer_config';

    // Campos que se pueden rellenar masivamente desde formularios.
    protected $fillable = [
        'titulo',
        'telefono',
        'direccion',
        'instagram_url',
        'linkedin_url',
        'twitter_url',
        'youtube_url',
        'horario_semana',
        'horario_sabado',
        'horario_domingo',
        'email_contacto',
        'aviso_legal_url',
        'politica_cookies_url',
    ];
}
