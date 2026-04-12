<?php
/**
 * App\Models\Usuario
 *
 * @method static \Illuminate\Database\Eloquent\Builder|static where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static create(array $attributes = [])
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $dni
 * @property string|null $movil
 * @property string $password
 * @property string $nSocio
 * @property bool $es_escritor_verificado
 * @property string|null $tipo_escritor
 */

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
        'nSocio',
        'es_escritor_verificado',
        'tipo_escritor',
    ];

    /**
     * Casts: 'hashed' hashea automáticamente el password con bcrypt
     * cada vez que se asigna (tanto en create como en update).
     * Esto reemplaza el Hash::make manual del evento booted().
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'es_escritor_verificado' => 'boolean',
        ];
    }

    protected static function booted()
    {
        // Genera nSocio automáticamente al crear un nuevo usuario
        static::creating(function ($usuario) {
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
