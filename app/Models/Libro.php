<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\PublicStoragePath;

/**
 * Modelo Eloquent para la tabla 'libros'.
 * Representa un libro del catálogo de la biblioteca.
 */
class Libro extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos.
    protected $table = 'libros';

    // Campos que se pueden rellenar masivamente desde formularios.
    protected $fillable = [
        'titulo',
        'autor',
        'genero',
        'anio',
        'editorial',
        'disponibilidad',
        'formato',
        'opcion_compra',
        'cantidad_ejemplares',
        'precio',
        'isbn',
        'portada_img',
        'perdido',
        'motivo_baja',
    ];

    protected $casts = [
        'perdido' => 'boolean',
        'precio' => 'decimal:2',
    ];

    public function seVende(): bool
    {
        return $this->opcion_compra === 'compra' && (float) $this->precio > 0;
    }

    /**
     * Accessor que devuelve la URL correcta de la portada,
     * sin importar si es una URL externa (seeder) o un archivo local (upload).
     *
     * @return string URL completa de la portada o imagen por defecto.
     */
    public function getPortadaUrlAttribute(): string
    {
        // Si no hay portada, devolvemos una imagen por defecto.
        if (empty($this->portada_img)) {
            return asset('img/elPrincipito.jpg');
        }

        return PublicStoragePath::url($this->portada_img) ?? asset('img/elPrincipito.jpg');
    }
}
