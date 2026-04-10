<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamos extends Model
{
    use HasFactory;

    // Si tu tabla se llama 'prestamos' y tu modelo 'Prestamo', no hace falta esto,
    // pero si tu modelo se llama 'Prestamos', mejor especifica el nombre de la tabla:
    protected $table = 'prestamos';

    // Campos que permitimos llenar masivamente
    protected $fillable = [
        'libro_id',
        'user_id',
        'fecha_prestamo',
        'fecha_devolucion_esperada',
        'fecha_devolucion_real'
    ];

    // Indicamos a Laravel que trate estos campos como fechas (Carbon)
    protected $casts = [
        'fecha_prestamo' => 'datetime',
        'fecha_devolucion_esperada' => 'datetime',
        'fecha_devolucion_real' => 'datetime',
    ];

    /**
     * RELACIÓN: Un préstamo pertenece a un Libro.
     * Esto te permite hacer: $prestamo->libro->titulo
     */
    public function libro()
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }

    /**
     * RELACIÓN: Un préstamo pertenece a un Usuario.
     * Esto te permite hacer: $prestamo->usuario->name
     */
    public function usuario()
    {
        // Nota: Asegúrate de que el modelo se llame 'User' (el de Laravel por defecto)
        return $this->belongsTo(User::class, 'user_id');
    }
}