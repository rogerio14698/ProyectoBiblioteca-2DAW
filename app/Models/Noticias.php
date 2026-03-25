<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para la tabla 'noticias'.
 * Representa las noticias publicadas por los administradores de la biblioteca.
 */
class Noticias extends Model
{
    // Nombre explícito de la tabla en la base de datos.
    protected $table = 'noticias';

    // Campos que se pueden asignar masivamente (mass assignment).
    protected $fillable = [
        'titulo',
        'contenido',
        'autor',
        'fecha_publicacion',
        'imagen_url',
        'destacado',
        'categoria',
        'enlace_externo',
        'admin_id',
        'url_paginaInterna'
    ];

    // Casting automático de tipos para ciertos campos.
    protected $casts = [
        'destacado'         => 'boolean',
        'fecha_publicacion' => 'date',
    ];
}
