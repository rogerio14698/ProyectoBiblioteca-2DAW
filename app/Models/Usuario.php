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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        'profile_photo_path',
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

    /**
     * Accessor que devuelve la URL correcta de la foto de perfil.
     * Si no hay foto, devuelve la imagen por defecto.
     * Si es una URL externa (http), la devuelve directamente.
     * Si es un archivo local, devuelve la ruta con asset('storage/...').
     *
     * @return string URL completa de la foto de perfil o imagen por defecto.
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        // Si no hay foto de perfil, devolvemos la imagen por defecto.
        if (empty($this->profile_photo_path)) {
            return asset('img/default.png');
        }

        // Si es una URL externa (del seeder u otra fuente).
        if (Str::startsWith($this->profile_photo_path, ['http://', 'https://'])) {
            return $this->profile_photo_path;
        }

        // Si es un archivo local subido por el usuario.
        return asset('storage/' . $this->profile_photo_path);
    }

    /**
     * Relación: un usuario tiene muchos préstamos de libros.
     *
     * @return HasMany Relación con el modelo Prestamos.
     */
    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamos::class, 'usuario_id');
    }

    /**
     * Relación: un usuario tiene muchas reservas de libros.
     *
     * @return HasMany Relación con el modelo Reserva.
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'usuario_id');
    }

    /**
     * Relación: un usuario tiene muchas compras de libros.
     *
     * @return HasMany Relación con el modelo Compra.
     */
    public function compras(): HasMany
    {
        return $this->hasMany(Compra::class, 'usuario_id');
    }

    /**
     * Relación: un usuario tiene muchas publicaciones.
     *
     * @return HasMany Relación con el modelo Publicacion.
     */
    public function publicaciones(): HasMany
    {
        return $this->hasMany(Publicacion::class, 'usuario_id');
    }

    /**
     * Relación: un usuario puede inscribirse a muchos eventos (tabla pivote evento_usuario).
     *
     * @return BelongsToMany Relación con el modelo Evento.
     */
    public function eventosInscritos(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class, 'evento_usuario', 'usuario_id', 'evento_id')
            ->withPivot('fecha_inscripcion', 'estado')
            ->withTimestamps();
    }

    /**
     * Relación: un usuario tiene muchos métodos de pago.
     *
     * @return HasMany Relación con el modelo MetodosPago.
     */
    public function metodosPago(): HasMany
    {
        return $this->hasMany(MetodosPago::class, 'usuario_id');
    }
}
