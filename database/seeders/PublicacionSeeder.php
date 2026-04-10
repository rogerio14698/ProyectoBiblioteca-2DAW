<?php

namespace Database\Seeders;

use App\Models\Publicacion;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class PublicacionSeeder extends Seeder
{
    /**
     * Seed de publicaciones de arranque para pruebas del panel admin.
     *
     * Crea 5 publicaciones distribuidas entre 2 usuarios existentes,
     * ambos marcados como escritores verificados.
     */
    public function run(): void
    {
        $usuarios = Usuario::whereIn('email', ['usuario@test.com', 'maria@test.com'])->get();

        if ($usuarios->count() < 2) {
            return;
        }

        // Aseguramos que ambos usuarios de ejemplo estén habilitados para publicar.
        $usuarios->each(function (Usuario $usuario, int $index): void {
            $usuario->update([
                'es_escritor_verificado' => true,
                'tipo_escritor' => $index === 0 ? 'profesional' : 'aficion',
            ]);
        });

        $publicacionesData = [
            [
                'titulo_publicacion' => 'Ensayo sobre narrativa contemporánea',
                'resumen_publicacion' => 'Análisis breve de tendencias narrativas actuales en novela y relato corto.',
                'usuario_id' => $usuarios[0]->id,
                'nombre_libro' => 'Narrativa del siglo XXI: Nuevas voces',
                'archivo_original' => 'ensayo_narrativa_contemporanea.pdf',
                'archivo_ruta' => 'publicaciones/seed/ensayo_narrativa_contemporanea.pdf',
                'archivo_extension' => 'pdf',
                'archivo_size_bytes' => 350000,
            ],
            [
                'titulo_publicacion' => 'Guía de lectura para clubes juveniles',
                'resumen_publicacion' => 'Documento Word con dinámicas y recomendaciones para sesiones de lectura juvenil.',
                'usuario_id' => $usuarios[0]->id,
                'nombre_libro' => 'Dinámicas de lectura en grupo',
                'archivo_original' => 'guia_lectura_juvenil.docx',
                'archivo_ruta' => 'publicaciones/seed/guia_lectura_juvenil.docx',
                'archivo_extension' => 'docx',
                'archivo_size_bytes' => 290000,
            ],
            [
                'titulo_publicacion' => 'Compendio de reseñas literarias',
                'resumen_publicacion' => 'Recopilación de reseñas de obras clásicas y contemporáneas.',
                'usuario_id' => $usuarios[1]->id,
                'nombre_libro' => 'Reseñas literarias: Clásicos y modernos',
                'archivo_original' => 'compendio_resenas.doc',
                'archivo_ruta' => 'publicaciones/seed/compendio_resenas.doc',
                'archivo_extension' => 'doc',
                'archivo_size_bytes' => 270000,
            ],
            [
                'titulo_publicacion' => 'Proyecto de escritura creativa para principiantes',
                'resumen_publicacion' => 'Material de apoyo para personas que empiezan a escribir por afición.',
                'usuario_id' => $usuarios[1]->id,
                'nombre_libro' => 'El arte de empezar a escribir',
                'archivo_original' => 'escritura_creativa_aficion.odt',
                'archivo_ruta' => 'publicaciones/seed/escritura_creativa_aficion.odt',
                'archivo_extension' => 'odt',
                'archivo_size_bytes' => 240000,
            ],
            [
                'titulo_publicacion' => 'Manual breve de estilo editorial',
                'resumen_publicacion' => 'Buenas prácticas de corrección y consistencia editorial para manuscritos.',
                'usuario_id' => $usuarios[0]->id,
                'nombre_libro' => 'Corrección editorial profesional',
                'archivo_original' => 'manual_estilo_editorial.rtf',
                'archivo_ruta' => 'publicaciones/seed/manual_estilo_editorial.rtf',
                'archivo_extension' => 'rtf',
                'archivo_size_bytes' => 210000,
            ],
        ];

        foreach ($publicacionesData as $item) {
            Publicacion::updateOrCreate(
                [
                    'titulo_publicacion' => $item['titulo_publicacion'],
                    'usuario_id' => $item['usuario_id'],
                ],
                [
                    'resumen_publicacion' => $item['resumen_publicacion'],
                    'nombre_libro' => $item['nombre_libro'],
                    'admin_id' => null,
                    'publicado_por' => 'usuario',
                    'archivo_original' => $item['archivo_original'],
                    'archivo_ruta' => $item['archivo_ruta'],
                    'archivo_extension' => $item['archivo_extension'],
                    'archivo_size_bytes' => $item['archivo_size_bytes'],
                    'fecha_publicacion' => now(),
                ]
            );
        }
    }
}
