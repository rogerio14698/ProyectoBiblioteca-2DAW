<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Eloquent para la tabla 'reservas'.
 * Representa un préstamo/reserva de un libro realizada por un usuario.
 * Cada reserva vincula un usuario con un libro e incluye fechas y estado.
 */
class Reserva extends Model
{
    // Nombre explícito de la tabla en la base de datos.
    protected $table = 'reservas';

    // Campos que se pueden asignar masivamente (mass assignment).
    protected $fillable = [
        'usuario_id',
        'libro_id',
        'fecha_reserva',
        'fecha_devolucion_prevista',
        'fecha_devolucion_real',
        'estado',
        'observaciones',
    ];

    // Casting automático de tipos para ciertos campos.
    protected $casts = [
        'fecha_reserva'             => 'date',
        'fecha_devolucion_prevista' => 'date',
        'fecha_devolucion_real'     => 'date',
    ];

    /**
     * Relación: la reserva pertenece a un usuario.
     *
     * @return BelongsTo Relación con el modelo Usuario.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Relación: la reserva pertenece a un libro.
     *
     * @return BelongsTo Relación con el modelo Libro.
     */
    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }
}
