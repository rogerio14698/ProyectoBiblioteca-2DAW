<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Publicacion;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PublicacionSeeder extends Seeder
{
    /**
     * Seed de publicaciones de arranque para pruebas de catálogo y panel admin.
     *
     * Crea publicaciones con archivos PDF reales de ejemplo,
     * distribuidas entre usuarios verificados y administrador.
     */
    public function run(): void
    {
        $usuarios = Usuario::whereIn('email', ['usuario@test.com', 'maria@test.com'])->get();
        $admin = Admin::where('email', 'admin@test.com')->first();

        if ($usuarios->count() < 2 || $admin === null) {
            return;
        }

        // Aseguramos que ambos usuarios de ejemplo estén habilitados para publicar.
        $usuarios->each(function (Usuario $usuario, int $index): void {
            $usuario->update([
                'es_escritor_verificado' => true,
                'tipo_escritor' => $index === 0 ? 'profesional' : 'aficion',
            ]);
        });

        // Creamos PDFs sencillos de ejemplo para que la vista de publicaciones tenga contenido real.
        $archivosSeed = [
            [
                'ruta' => 'publicaciones/seed/metodologia_estudio_daw.pdf',
                'titulo' => 'Metodologia de estudio DAW',
            ],
            [
                'ruta' => 'publicaciones/seed/introduccion_laravel_12.pdf',
                'titulo' => 'Introduccion practica a Laravel 12',
            ],
            [
                'ruta' => 'publicaciones/seed/guia_php_moderna.pdf',
                'titulo' => 'Guia de PHP moderna',
            ],
            [
                'ruta' => 'publicaciones/seed/manual_editorial_admin.pdf',
                'titulo' => 'Manual editorial institucional',
            ],
        ];

        foreach ($archivosSeed as $archivoSeed) {
            Storage::disk('public')->put($archivoSeed['ruta'], $this->buildSimplePdf($archivoSeed['titulo']));
        }

        $publicacionesData = [
            [
                'titulo_publicacion' => 'Metodologia de estudio DAW',
                'resumen_publicacion' => 'Documento academico con pautas de organizacion del estudio y recomendaciones bibliograficas.',
                'usuario_id' => $usuarios[0]->id,
                'admin_id' => null,
                'publicado_por' => 'usuario',
                'nombre_libro' => 'Planificacion de estudio y aprendizaje autonomo',
                'archivo_original' => 'metodologia_estudio_daw.pdf',
                'archivo_ruta' => 'publicaciones/seed/metodologia_estudio_daw.pdf',
                'archivo_extension' => 'pdf',
            ],
            [
                'titulo_publicacion' => 'Introduccion practica a Laravel 12',
                'resumen_publicacion' => 'Apuntes iniciales para comprender rutas, controladores y vistas en proyectos Laravel.',
                'usuario_id' => $usuarios[1]->id,
                'admin_id' => null,
                'publicado_por' => 'usuario',
                'nombre_libro' => 'Laravel aplicado a proyectos reales',
                'archivo_original' => 'introduccion_laravel_12.pdf',
                'archivo_ruta' => 'publicaciones/seed/introduccion_laravel_12.pdf',
                'archivo_extension' => 'pdf',
            ],
            [
                'titulo_publicacion' => 'Guia de PHP moderna',
                'resumen_publicacion' => 'Resumen de buenas practicas de tipado, validacion y estructura en aplicaciones web con PHP.',
                'usuario_id' => $usuarios[0]->id,
                'admin_id' => null,
                'publicado_por' => 'usuario',
                'nombre_libro' => 'PHP moderno y arquitectura web',
                'archivo_original' => 'guia_php_moderna.pdf',
                'archivo_ruta' => 'publicaciones/seed/guia_php_moderna.pdf',
                'archivo_extension' => 'pdf',
            ],
            [
                'titulo_publicacion' => 'Manual editorial institucional',
                'resumen_publicacion' => 'Documento del equipo administrador con criterios de revision y publicacion de contenidos.',
                'usuario_id' => null,
                'admin_id' => $admin->id,
                'publicado_por' => 'admin',
                'nombre_libro' => 'Normativa editorial Biblioteca DAW',
                'archivo_original' => 'manual_editorial_admin.pdf',
                'archivo_ruta' => 'publicaciones/seed/manual_editorial_admin.pdf',
                'archivo_extension' => 'pdf',
            ],
        ];

        foreach ($publicacionesData as $item) {
            $size = Storage::disk('public')->size($item['archivo_ruta']);

            Publicacion::updateOrCreate(
                [
                    'titulo_publicacion' => $item['titulo_publicacion'],
                    'publicado_por' => $item['publicado_por'],
                ],
                [
                    'resumen_publicacion' => $item['resumen_publicacion'],
                    'nombre_libro' => $item['nombre_libro'],
                    'usuario_id' => $item['usuario_id'],
                    'admin_id' => $item['admin_id'],
                    'publicado_por' => $item['publicado_por'],
                    'archivo_original' => $item['archivo_original'],
                    'archivo_ruta' => $item['archivo_ruta'],
                    'archivo_extension' => $item['archivo_extension'],
                    'archivo_size_bytes' => $size,
                    'fecha_publicacion' => now(),
                ]
            );
        }
    }

    /**
     * Genera un PDF minimo en memoria para datos de prueba.
     *
     * @param string $title Titulo visible en el documento.
     * @return string Contenido binario del PDF.
     */
    private function buildSimplePdf(string $title): string
    {
        $safeTitle = str_replace(['(', ')'], '', $title);

        return "%PDF-1.4\n"
            . "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n"
            . "2 0 obj\n<< /Type /Pages /Count 1 /Kids [3 0 R] >>\nendobj\n"
            . "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n"
            . "4 0 obj\n<< /Length 83 >>\nstream\nBT\n/F1 18 Tf\n72 740 Td\n(" . $safeTitle . ") Tj\n0 -28 Td\n/F1 12 Tf\n(Documento de prueba generado por seeder.) Tj\nET\nendstream\nendobj\n"
            . "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n"
            . "xref\n0 6\n0000000000 65535 f \n0000000010 00000 n \n0000000063 00000 n \n0000000122 00000 n \n0000000248 00000 n \n0000000381 00000 n \n"
            . "trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n451\n%%EOF";
    }
}
