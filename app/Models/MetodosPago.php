<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodosPago extends Model
{
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
