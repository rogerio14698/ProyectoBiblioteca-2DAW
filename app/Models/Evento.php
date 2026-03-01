<?php

namespace App\Models;

use Database\Factories\EventosFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_hora',
        'ubicacion',
        'usuario_id',
        'prioridad',
    ];
    //Validamos el formulario.

    /*Este codigo le dice que el dueño está en el modelo de Usuario*/
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    protected function prioridadTexto(): Attribute
    {
        // Devuelve una representación legible de la prioridad
        return Attribute::get(fn() => match ($this->prioridad) {

            3 => 'Alta',
            2 => 'Media',
            1 => 'Baja',
            default => 'Sin Prioridad',
        });
    }

    protected static function newFactory(): EventosFactory
    {
        return EventosFactory::new();
    }
}