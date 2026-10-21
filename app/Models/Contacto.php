<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contacto extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'nombre',
        'email',
        'asunto',
        'mensaje',
        'respuesta',
        'estado',
        'token_verificacion',
        'email_verificado_at',
    ];

    protected $casts = [
        'email_verificado_at' => 'datetime',
    ];

    /**
     * Solo los mensajes con el email confirmado son visibles para el admin.
     */
    public function scopeVerificados($query)
    {
        return $query->whereNotNull('email_verificado_at');
    }
}
