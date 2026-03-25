<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlideBienvenida extends Model
{
    protected $table = 'slide_bienvenidas';
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'url',
        'posicion',
    ];

}
