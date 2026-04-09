<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\FooterConfig;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Controlador para gestionar la configuración del footer desde el panel admin.
 * La tabla footer_config solo tiene 1 fila, se crea en el seeder.
 */
class FooterConfigController extends Controller
{
    /**
     * Mostrar el formulario de edición del footer con los datos actuales.
     * @return View Vista del formulario con la config del footer.
     */
    public function edit(): View
    {
        // Obtenemos la única fila de configuración del footer.
        // Si no existe, creamos una con valores por defecto.
        $footerConfig = FooterConfig::firstOrCreate([], [
            'titulo' => 'Biblioteca DAW Proyecto',
            'telefono' => '123-456-789',
            'direccion' => 'Avd. de la Universidad, 123',
            'horario_semana' => '9:00 - 20:00',
            'horario_sabado' => '10:00 - 18:00',
            'horario_domingo' => 'Cerrado',
            'email_contacto' => 'info@biblioteca.local',
        ]);

        return view('bibliotecaDAW.adminViews.GestionarContenidoWeb.gestionarFooter', [
            'footerConfig' => $footerConfig,
        ]);
    }

    /**
     * Guardar los cambios en la configuración del footer.
     * @param Request $request Datos del formulario.
     * @return RedirectResponse Redirección con mensaje de éxito.
     * @effect Actualiza la fila única de footer_config en la base de datos.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validamos todos los campos del formulario.
        $request->validate([
            'titulo' => 'required|string|max:255',
            'telefono' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'horario_semana' => 'required|string|max:100',
            'horario_sabado' => 'required|string|max:100',
            'horario_domingo' => 'required|string|max:100',
            'email_contacto' => 'required|email|max:255',
            'aviso_legal_url' => 'nullable|string|max:255',
            'politica_cookies_url' => 'nullable|string|max:255',
        ]);

        // Obtenemos la config existente (o la primera si hay varias por error).
        $footerConfig = FooterConfig::firstOrFail();

        // Actualizamos todos los campos con los datos validados.
        $footerConfig->update($request->only([
            'titulo',
            'telefono',
            'direccion',
            'instagram_url',
            'linkedin_url',
            'twitter_url',
            'youtube_url',
            'horario_semana',
            'horario_sabado',
            'horario_domingo',
            'email_contacto',
            'aviso_legal_url',
            'politica_cookies_url',
        ]));

        return redirect()->back()->with('success', 'Footer actualizado correctamente.');
    }
}
