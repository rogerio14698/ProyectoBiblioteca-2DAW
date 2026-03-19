<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Contacto;
use Illuminate\Database\Seeder;

/**
 * Seeder para poblar la tabla 'contactos' con mensajes de ejemplo.
 * Simula mensajes de contacto de usuarios con distintos estados
 * para poder probar el flujo de gestión de contactos en el panel admin.
 */
class ContactoSeeder extends Seeder
{
    /**
     * Ejecutar el seeder de contactos.
     * Crea 5 mensajes de contacto de ejemplo con distintos estados.
     *
     * @return void
     *
     * @efectos Inserta registros en la tabla 'contactos'.
     */
    public function run(): void
    {
        // Array con los datos de cada contacto de ejemplo.
        $contactos = [
            [
                'nombre' => 'Pedro Martínez',
                'email'  => 'pedro.martinez@email.com',
                'asunto' => 'Consulta sobre horarios de apertura',
                'mensaje' => 'Buenos días, me gustaría saber si la biblioteca abre los sábados por la tarde durante el mes de marzo. Necesito acceder a la sala de estudio para preparar mis exámenes. Muchas gracias.',
                'estado' => 'leido',
            ],
            [
                'nombre' => 'Laura Sánchez',
                'email'  => 'laura.sanchez@email.com',
                'asunto' => 'Problema con el préstamo digital',
                'mensaje' => 'Hola, llevo varios días intentando acceder al préstamo digital de "Cien años de soledad" pero me sale un error al descargar el archivo. Mi número de socio es 45621TR. ¿Podrían revisarlo? Gracias.',
                'estado' => 'en_proceso',
            ],
            [
                'nombre' => 'Carlos López',
                'email'  => 'carlos.lopez@email.com',
                'asunto' => 'Sugerencia de nuevo título',
                'mensaje' => 'Me gustaría sugerir la incorporación al catálogo del libro "Sapiens: De animales a dioses" de Yuval Noah Harari. Creo que sería una gran adición a la sección de ensayo y divulgación. Un saludo.',
                'estado' => 'pendiente',
            ],
            [
                'nombre' => 'Ana Ruiz',
                'email'  => 'ana.ruiz@email.com',
                'asunto' => 'Reserva de sala para grupo de estudio',
                'mensaje' => 'Somos un grupo de 6 estudiantes del ciclo de DAW y nos gustaría reservar la sala de reuniones para los martes y jueves de 16:00 a 19:00 durante las próximas tres semanas. ¿Es posible? Gracias de antemano.',
                'estado' => 'pendiente',
            ],
            [
                'nombre' => 'Miguel Torres',
                'email'  => 'miguel.torres@email.com',
                'asunto' => 'Agradecimiento por el taller de escritura',
                'mensaje' => 'Quería agradecer al equipo de la biblioteca por el fantástico taller de escritura creativa del pasado viernes. La ponente fue increíble y aprendí mucho. Espero que organicéis más talleres similares en el futuro. ¡Enhorabuena!',
                'estado' => 'leido',
            ],
        ];

        // Recorremos cada contacto e insertamos o actualizamos por email + asunto.
        foreach ($contactos as $contacto) {
            Contacto::updateOrCreate(
                // Condición: combinación de email y asunto para evitar duplicados.
                [
                    'email'  => $contacto['email'],
                    'asunto' => $contacto['asunto'],
                ],
                // Datos completos a insertar o actualizar.
                $contacto
            );
        }
    }
}
