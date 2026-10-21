<?php

namespace App\Models;

use App\Support\PublicStoragePath;
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

    public function getImagenPublicUrlAttribute(): ?string
    {
        return PublicStoragePath::url($this->imagen);
    }
}
