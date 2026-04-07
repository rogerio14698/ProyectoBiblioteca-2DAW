<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Noticias;
use Illuminate\Database\Seeder;

/**
 * Seeder para poblar la tabla 'noticias' con datos de ejemplo.
 * Utiliza 'img-landingPage.png' como imagen genérica de muestra
 * para todas las noticias, al ser una imagen grande adecuada para este uso.
 */
class NoticiasSeeder extends Seeder
{
    /**
     * Ejecutar el seeder de noticias.
     * Crea 5 noticias de ejemplo con distintas categorías y estados.
     *
     * @return void
     *
     * @efectos Inserta registros en la tabla 'noticias'.
     */
    public function run(): void
    {
        // Imágenes temáticas de noticias/biblioteca desde images.unsplash.com (una por noticia).
        $imagenMuestra = [
            'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=1600&h=900&fit=crop', // Periódicos/prensa
            'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=1600&h=900&fit=crop', // Biblioteca/sala lectura
            'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=1600&h=900&fit=crop', // Libros abiertos
            'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=1600&h=900&fit=crop', // Taller/manualidades
            'https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=1600&h=900&fit=crop', // Estantería de libros
        ];

        // Array con los datos de cada noticia de ejemplo.
        $noticias = [
            [
                'titulo'            => 'Inauguración de la nueva sala de lectura infantil',
                'contenido'         => 'La biblioteca DAW se complace en anunciar la apertura de una nueva sala de lectura dedicada exclusivamente al público infantil. El espacio cuenta con más de 500 títulos seleccionados para niños de 3 a 12 años, zona de cuentacuentos y actividades interactivas. La inauguración tendrá lugar el próximo sábado a las 11:00h con un evento especial de animación a la lectura.',
                'autor'             => 'Administrador Principal',
                'fecha_publicacion' => '2026-03-15',
                'imagen_url'        => $imagenMuestra[0],
                'destacado'         => true,
                'categoria'         => 'Instalaciones',
                'enlace_externo'    => null,
                'admin_id'          => 1,
            ],
            [
                'titulo'            => 'Club de lectura de marzo: "Cien años de soledad"',
                'contenido'         => 'Este mes el club de lectura de la Biblioteca DAW se sumerge en el universo mágico de Macondo. Leeremos juntos "Cien años de soledad" de Gabriel García Márquez. Las sesiones de debate se celebrarán todos los jueves a las 18:00h en la Sala Principal. ¡No es necesario haber leído el libro completo para participar! Cada sesión cubrirá capítulos específicos.',
                'autor'             => 'Editor de Contenido',
                'fecha_publicacion' => '2026-03-10',
                'imagen_url'        => $imagenMuestra[1],
                'destacado'         => false,
                'categoria'         => 'Actividades',
                'enlace_externo'    => null,
                'admin_id'          => 2,
            ],
            [
                'titulo'            => 'Nuevo horario de primavera',
                'contenido'         => 'A partir del 1 de abril, la biblioteca amplía su horario de apertura. De lunes a viernes abriremos de 9:00 a 21:00h (antes cerrábamos a las 20:00h). Los sábados mantenemos el horario habitual de 10:00 a 14:00h. Este cambio responde a la demanda de nuestros socios que necesitan más horas de estudio durante la época de exámenes.',
                'autor'             => 'Administrador Principal',
                'fecha_publicacion' => '2026-03-18',
                'imagen_url'        => $imagenMuestra[2],
                'destacado'         => true,
                'categoria'         => 'Avisos',
                'enlace_externo'    => null,
                'admin_id'          => 1,
            ],
            [
                'titulo'            => 'Taller gratuito de encuadernación artesanal',
                'contenido'         => 'La Biblioteca DAW organiza un taller práctico de encuadernación artesanal impartido por la artista local María Dolores Gutiérrez. Los participantes aprenderán técnicas básicas de encuadernación japonesa y belga. El taller es totalmente gratuito para socios de la biblioteca. Plazas limitadas a 15 personas. Inscripciones abiertas en el mostrador de atención al público.',
                'autor'             => 'Moderador General',
                'fecha_publicacion' => '2026-03-05',
                'imagen_url'        => $imagenMuestra[3],
                'destacado'         => false,
                'categoria'         => 'Talleres',
                'enlace_externo'    => null,
                'admin_id'          => 3,
            ],
            [
                'titulo'            => 'Donación de 200 nuevos títulos al catálogo digital',
                'contenido'         => 'Gracias a un acuerdo con la editorial Planeta, hemos incorporado 200 nuevos títulos a nuestro catálogo digital. Los socios ya pueden acceder a estas obras desde la plataforma de préstamo electrónico. Entre las novedades se incluyen best-sellers recientes, clásicos de la literatura hispanoamericana y una selección de ensayos contemporáneos.',
                'autor'             => 'Editor de Contenido',
                'fecha_publicacion' => '2026-03-01',
                'imagen_url'        => $imagenMuestra[4],
                'destacado'         => false,
                'categoria'         => 'Catálogo',
                'enlace_externo'    => null,
                'admin_id'          => 2,
            ],
        ];

        // Recorremos cada noticia e insertamos o actualizamos por título (evita duplicados).
        foreach ($noticias as $noticia) {
            Noticias::updateOrCreate(
                // Condición: usamos el título como identificador único de muestra.
                ['titulo' => $noticia['titulo']],
                // Datos completos a insertar o actualizar.
                $noticia
            );
        }
    }
}
