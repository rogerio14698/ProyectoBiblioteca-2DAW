<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Eloquent para la tabla 'publicaciones'.
 *
 * Una publicación representa un archivo subido (pdf/doc/docx/odt/rtf)
 * asociado a un libro y publicado por un usuario escritor verificado
 * o por un administrador.
 */
class Publicacion extends Model
{
    protected $table = 'publicaciones';

    protected $fillable = [
        'titulo_publicacion',
        'resumen_publicacion',
        'nombre_libro',
        'usuario_id',
        'admin_id',
        'publicado_por',
        'archivo_original',
        'archivo_ruta',
        'archivo_extension',
        'archivo_size_bytes',
        'fecha_publicacion',
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
        'archivo_size_bytes' => 'integer',
    ];

    /**
     * Relación con el usuario publicador (cuando publicado_por = usuario).
     *
     * @return BelongsTo
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Relación con el admin publicador (cuando publicado_por = admin).
     *
     * @return BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
