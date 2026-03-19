<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\SlideBienvenida;
use Illuminate\Database\Seeder;

/**
 * Seeder para poblar la tabla 'slide_bienvenidas' con slides de ejemplo.
 * Utiliza 'img-landingPage.png' como imagen genérica para todos los slides,
 * ya que es una imagen grande adecuada para el carrusel de bienvenida.
 */
class SlideBienvenidaSeeder extends Seeder
{
    /**
     * Ejecutar el seeder de slides de bienvenida.
     * Crea 3 slides para el carrusel de la página principal.
     *
     * @return void
     *
     * @efectos Inserta registros en la tabla 'slide_bienvenidas'.
     */
    public function run(): void
    {
        // Imagen genérica grande para todos los slides del carrusel.
        $imagenMuestra = 'img/img-landingPage.png';

        // Array con los datos de cada slide de bienvenida.
        $slides = [
            [
                'titulo'      => 'Bienvenido a la Biblioteca DAW',
                'descripcion' => 'Tu espacio de lectura, aprendizaje y comunidad. Descubre miles de títulos disponibles en formato físico y digital. Hazte socio y accede a todos nuestros servicios.',
                'imagen'      => $imagenMuestra,
                'url'         => '/catalogo',
            ],
            [
                'titulo'      => 'Eventos y Actividades',
                'descripcion' => 'Participa en nuestros clubes de lectura, talleres de escritura, presentaciones de libros y mucho más. Cada semana organizamos actividades para todos los públicos.',
                'imagen'      => $imagenMuestra,
                'url'         => '/eventos',
            ],
            [
                'titulo'      => 'Catálogo Digital',
                'descripcion' => 'Accede a nuestra colección digital desde cualquier lugar. Préstamos electrónicos disponibles las 24 horas del día, los 7 días de la semana para todos los socios.',
                'imagen'      => $imagenMuestra,
                'url'         => '/catalogo',
            ],
        ];

        // Recorremos cada slide e insertamos o actualizamos por título.
        foreach ($slides as $slide) {
            SlideBienvenida::updateOrCreate(
                // Condición: el título identifica cada slide de forma única.
                ['titulo' => $slide['titulo']],
                // Datos completos a insertar o actualizar.
                $slide
            );
        }
    }
}
