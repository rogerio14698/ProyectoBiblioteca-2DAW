<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Eloquent para la tabla 'compras'.
 * Representa la compra de un libro realizada por un usuario registrado.
 * Cada compra vincula un usuario con un libro, incluyendo precio y estado.
 */
class Compra extends Model
{
    // Nombre explícito de la tabla en la base de datos.
    protected $table = 'compras';

    // Campos que se pueden asignar masivamente (mass assignment).
    protected $fillable = [
        'usuario_id',
        'libro_id',
        'fecha_compra',
        'precio',
        'estado',
    ];

    // Casting automático de tipos para ciertos campos.
    protected $casts = [
        'fecha_compra' => 'datetime',
        'precio'       => 'decimal:2',
    ];

    /**
     * Relación: la compra pertenece a un usuario.
     *
     * @return BelongsTo Relación con el modelo Usuario.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Relación: la compra pertenece a un libro.
     *
     * @return BelongsTo Relación con el modelo Libro.
     */
    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }
}
