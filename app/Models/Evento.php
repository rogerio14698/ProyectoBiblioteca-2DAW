<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evento extends Model
{
    protected $table = 'eventos';
    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_hora',
        'ubicacion',
        'usuario_id',
    ];

    /*Este codigo le dice que el dueño está en el modelo de Usuario*/
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
