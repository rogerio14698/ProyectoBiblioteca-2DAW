<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodosPago extends Model
{
    // Nombre explícito de la tabla (la migración crea 'metodos_pago', no 'metodos_pagos').
    protected $table = 'metodos_pago';

    protected $fillable = [
        'usuario_id',
        'type',
        'provider',
        'token',
        'last_four',
        'paypal_email'
    ];
    protected $casts = [
        'token' => 'encrypted',
    ];

    public  function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}