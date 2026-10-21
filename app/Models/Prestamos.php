<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Eloquent para la tabla 'prestamos'.
 * Representa un préstamo de un libro realizado por un usuario registrado.
 */
class Prestamos extends Model
{
    use HasFactory;

    // Nombre explícito de la tabla en la base de datos.
    protected $table = 'prestamos';

    // Campos que permitimos llenar masivamente.
    protected $fillable = [
        'libro_id',
        'usuario_id',
        'fecha_prestamo',
        'fecha_devolucion_esperada',
        'fecha_devolucion_real',
        'multa',
        'multa_pagada',
    ];

    // Indicamos a Laravel que trate estos campos como fechas (Carbon).
    protected $casts = [
        'fecha_prestamo' => 'datetime',
        'fecha_devolucion_esperada' => 'datetime',
        'fecha_devolucion_real' => 'datetime',
        'multa' => 'decimal:2',
        'multa_pagada' => 'boolean',
    ];

    /**
     * Multa pendiente de pago (si la hay).
     */
    public function tieneMultaPendiente(): bool
    {
        return (float) $this->multa > 0 && ! $this->multa_pagada;
    }

    /**
     * Al registrar la devolución calcula la multa por días de retraso.
     */
    protected static function booted(): void
    {
        static::saving(function (Prestamos $prestamo) {
            if (! $prestamo->isDirty('fecha_devolucion_real') || ! $prestamo->fecha_devolucion_real
                || ! $prestamo->fecha_devolucion_esperada || (float) $prestamo->multa > 0) {
                return;
            }

            $diasRetraso = (int) $prestamo->fecha_devolucion_esperada->copy()->startOfDay()
                ->diffInDays($prestamo->fecha_devolucion_real->copy()->startOfDay(), false);

            if ($diasRetraso > 0) {
                $prestamo->multa = round($diasRetraso * (float) config('services.stripe.multa_dia', 0.5), 2);
            }
        });
    }

    /**
     * RELACIÓN: Un préstamo pertenece a un Libro.
     * Esto te permite hacer: $prestamo->libro->titulo
     *
     * @return BelongsTo Relación con el modelo Libro.
     */
    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }

    /**
     * RELACIÓN: Un préstamo pertenece a un Usuario registrado.
     * Esto te permite hacer: $prestamo->usuario->name
     *
     * @return BelongsTo Relación con el modelo Usuario.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
