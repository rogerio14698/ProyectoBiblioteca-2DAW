<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UsuarioFactory> */
    use HasFactory, Notifiable;
    protected $table = 'usuarios';
    protected $fillable = [
        'name',
        'email',
        'dni',
        'movil',
        'password',
        'nSocio'
    ];

    protected static function booted()
    {
        static::creating(function ($usuario) {
            $usuario->password = Hash::make($usuario->password);
            $usuario->nSocio = self::generarNSocio();
        });
    }
    private static function generarNSocio(): string
    {
        do {
            $numeros = random_int(10000, 99999);
            $letras  = chr(random_int(65, 90)) . chr(random_int(65, 90));
            $nSocio  = $numeros . $letras;
        } while (self::where('nSocio', $nSocio)->exists());

        return $nSocio;
    }
}
