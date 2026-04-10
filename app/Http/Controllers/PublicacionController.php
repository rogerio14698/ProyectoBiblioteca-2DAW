<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador de gestión de publicaciones de usuarios y administradores.
 *
 * Reglas principales:
 * - Solo se aceptan archivos (PDF/DOC/DOCX/ODT/RTF).
 * - Los usuarios deben estar verificados como escritores.
 * - Los administradores siempre pueden publicar.
 */
class PublicacionController extends Controller
{
    /**
     * Mostrar el panel de gestión con formulario, resumen y listado.
     *
     * @return View
     */
    public function index(): View
    {
        // Cargamos publicaciones con sus relaciones para evitar N+1.
        $publicaciones = Publicacion::with(['usuario', 'admin'])
            ->orderBy('fecha_publicacion', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Usuarios habilitados para publicar: escritores verificados.
        $usuariosEscritores = Usuario::query()
            ->where('es_escritor_verificado', true)
            ->whereNotNull('tipo_escritor')
            ->orderBy('name')
            ->get();

        // Resumen de actividad para el panel.
        $resumen = [
            'total' => $publicaciones->count(),
            'usuarios' => $publicaciones->where('publicado_por', 'usuario')->count(),
            'admin' => $publicaciones->where('publicado_por', 'admin')->count(),
            'profesional' => $publicaciones
                ->filter(fn(Publicacion $p) => $p->usuario?->tipo_escritor === 'profesional')
                ->count(),
            'aficion' => $publicaciones
                ->filter(fn(Publicacion $p) => $p->usuario?->tipo_escritor === 'aficion')
                ->count(),
        ];

        return view('bibliotecaDAW.adminViews.GestionarUsuarios.publicacionesUser', [
            'publicaciones' => $publicaciones,
            'usuariosEscritores' => $usuariosEscritores,
            'resumen' => $resumen,
        ]);
    }

    /**
     * Guardar una publicación nueva asociada a usuario escritor o admin.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'publicado_por' => 'required|in:usuario,admin',
            'usuario_id' => 'nullable|exists:usuarios,id',
            'nombre_libro' => 'required|string|max:255',
            'titulo_publicacion' => 'required|string|max:255',
            'resumen_publicacion' => 'required|string|max:500',
            'archivo_publicacion' => 'required|file|mimes:pdf,doc,docx,odt,rtf|max:10240',
        ]);

        try {
            // Determinamos quién publica según el selector del formulario.
            $usuarioId = null;
            $adminId = null;

            if ($validatedData['publicado_por'] === 'usuario') {
                // Validamos que venga usuario y que sea escritor verificado.
                if (empty($validatedData['usuario_id'])) {
                    return redirect()->back()
                        ->withErrors(['usuario_id' => 'Debes seleccionar un usuario escritor verificado.'])
                        ->withInput();
                }

                $usuario = Usuario::find($validatedData['usuario_id']);
                if (!$usuario || !$usuario->es_escritor_verificado || empty($usuario->tipo_escritor)) {
                    return redirect()->back()
                        ->withErrors(['usuario_id' => 'El usuario no está habilitado para publicar.'])
                        ->withInput();
                }

                $usuarioId = $usuario->id;
            }

            if ($validatedData['publicado_por'] === 'admin') {
                $adminId = auth('admin')->id();
            }

            // Guardamos el archivo en disco público para poder descargarlo desde el panel.
            $archivo = $request->file('archivo_publicacion');
            $archivoRuta = $archivo->store('publicaciones', 'public');

            Publicacion::create([
                'titulo_publicacion' => $validatedData['titulo_publicacion'],
                'resumen_publicacion' => $validatedData['resumen_publicacion'],
                'nombre_libro' => $validatedData['nombre_libro'],
                'usuario_id' => $usuarioId,
                'admin_id' => $adminId,
                'publicado_por' => $validatedData['publicado_por'],
                'archivo_original' => $archivo->getClientOriginalName(),
                'archivo_ruta' => $archivoRuta,
                'archivo_extension' => strtolower((string) $archivo->getClientOriginalExtension()),
                'archivo_size_bytes' => (int) $archivo->getSize(),
                'fecha_publicacion' => now(),
            ]);

            return redirect()->route('admin.publicacionesUser')->with('success', 'Publicación creada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.publicacionesUser')->with('error', 'Error al crear la publicación: ' . $e->getMessage());
        }
    }
}
