<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Controlador de la sección /publicar para usuarios autenticados.
 */
class PublicarUsuarioController extends Controller
{
    /**
     * Mostrar listado público de publicaciones en formato académico con filtros.
     *
     * @param Request $request Datos de búsqueda y orden del listado.
     * @return View
     */
    public function communityIndex(Request $request): View
    {
        // Validamos filtros para evitar parámetros inesperados.
        $validatedData = $request->validate([
            'query' => ['nullable', 'string', 'max:120'],
            'extension' => ['nullable', 'string', 'in:todos,pdf'],
            'orden' => ['nullable', 'string', 'in:reciente,antiguo'],
        ]);

        // Normalizamos valores de filtros con defaults sencillos.
        $searchQuery = trim((string) ($validatedData['query'] ?? ''));
        $searchExtension = trim((string) ($validatedData['extension'] ?? 'todos'));
        $searchOrden = trim((string) ($validatedData['orden'] ?? 'reciente'));

        // Construimos consulta con relaciones de usuario y admin para mostrar autoría.
        $publicacionesQuery = Publicacion::query()
            ->with(['usuario', 'admin'])
            ->when($searchQuery !== '', fn($query) => $query->where(function ($subQuery) use ($searchQuery): void {
                $subQuery->where('nombre_libro', 'like', "%{$searchQuery}%")
                    ->orWhere('titulo_publicacion', 'like', "%{$searchQuery}%")
                    ->orWhere('resumen_publicacion', 'like', "%{$searchQuery}%");
            }));

        // Filtro por tipo de archivo para facilitar exploración académica.
        if ($searchExtension !== 'todos') {
            $publicacionesQuery->where('archivo_extension', $searchExtension);
        }

        // Orden por fecha de publicación según preferencia.
        $direccionOrden = $searchOrden === 'antiguo' ? 'asc' : 'desc';
        $publicacionesQuery
            ->orderBy('fecha_publicacion', $direccionOrden)
            ->orderBy('created_at', $direccionOrden);

        $publicaciones = $publicacionesQuery->paginate(12)->withQueryString();

        return view('bibliotecaDAW.publicViews.publicacionesUsuarios', [
            'publicaciones' => $publicaciones,
            'searchQuery' => $searchQuery,
            'searchExtension' => $searchExtension,
            'searchOrden' => $searchOrden,
        ]);
    }

    /**
     * Mostrar formulario de publicación y listados dinámicos.
     *
     * @param Request $request Datos de búsqueda del historial del usuario.
     * @return View
     */
    public function index(Request $request): View
    {
        // Validamos búsqueda opcional para filtrar publicaciones del propio usuario.
        $validatedData = $request->validate([
            'buscar' => ['nullable', 'string', 'max:120'],
        ]);

        // Recuperamos usuario autenticado en el guard web.
        $usuarioId = (int) auth('web')->id();

        // Normalizamos texto de búsqueda para evitar espacios sobrantes.
        $buscar = trim((string) ($validatedData['buscar'] ?? ''));

        // Consulta del historial propio del usuario con búsqueda por campos clave.
        $misPublicaciones = Publicacion::query()
            ->where('usuario_id', $usuarioId)
            ->when($buscar !== '', fn($query) => $query->where(function ($subQuery) use ($buscar): void {
                $subQuery->where('titulo_publicacion', 'like', "%{$buscar}%")
                    ->orWhere('nombre_libro', 'like', "%{$buscar}%")
                    ->orWhere('resumen_publicacion', 'like', "%{$buscar}%");
            }))
            ->orderBy('fecha_publicacion', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(6)
            ->withQueryString();

        // Publicaciones recientes de usuarios para representar contenido visible por la comunidad.
        $publicacionesRecientes = Publicacion::query()
            ->with('usuario')
            ->where('publicado_por', 'usuario')
            ->orderBy('fecha_publicacion', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('bibliotecaDAW.userViews.publicar', [
            'misPublicaciones' => $misPublicaciones,
            'publicacionesRecientes' => $publicacionesRecientes,
            'buscarPublicacion' => $buscar,
        ]);
    }

    /**
     * Guardar una publicación subida por el usuario autenticado.
     *
     * @param Request $request Datos del formulario y archivo adjunto.
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validamos campos del formulario y tipos de archivo permitidos.
        $validatedData = $request->validate([
            'nombre_libro' => ['required', 'string', 'max:255'],
            'titulo_publicacion' => ['required', 'string', 'max:255'],
            'resumen_publicacion' => ['required', 'string', 'max:500'],
            'archivo_publicacion' => ['required', 'file', 'mimes:pdf', 'max:20480'],
        ]);

        try {
            // Guardamos el archivo en disco público para su descarga posterior.
            $archivo = $request->file('archivo_publicacion');
            $archivoRuta = $archivo->store('publicaciones', 'public');

            // Registramos la publicación asociada al usuario autenticado.
            Publicacion::create([
                'titulo_publicacion' => $validatedData['titulo_publicacion'],
                'resumen_publicacion' => $validatedData['resumen_publicacion'],
                'nombre_libro' => $validatedData['nombre_libro'],
                'usuario_id' => (int) auth('web')->id(),
                'admin_id' => null,
                'publicado_por' => 'usuario',
                'archivo_original' => $archivo->getClientOriginalName(),
                'archivo_ruta' => $archivoRuta,
                'archivo_extension' => strtolower((string) $archivo->getClientOriginalExtension()),
                'archivo_size_bytes' => (int) $archivo->getSize(),
                'fecha_publicacion' => now(),
            ]);

            return redirect()->route('usuario.publicar')->with('success', 'Publicación enviada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('usuario.publicar')->with('error', 'No se pudo guardar la publicación: ' . $e->getMessage());
        }
    }

    /**
     * Descargar archivo de una publicación para visualización por otros usuarios.
     *
     * @param int $id ID de la publicación.
     * @return BinaryFileResponse|RedirectResponse
     */
    public function download(int $id): BinaryFileResponse|RedirectResponse
    {
        // Localizamos la publicación objetivo y comprobamos ruta de archivo.
        $publicacion = Publicacion::findOrFail($id);

        if (!Storage::disk('public')->exists($publicacion->archivo_ruta)) {
            return redirect()->route('usuario.publicar')->with('error', 'El archivo no está disponible actualmente.');
        }

        // Descargamos usando nombre original para mejorar experiencia del usuario.
        return response()->download(
            Storage::disk('public')->path($publicacion->archivo_ruta),
            $publicacion->archivo_original
        );
    }

    /**
     * Abrir archivo de publicación en el navegador (nueva pestaña).
     *
     * @param int $id ID de publicación.
     * @return BinaryFileResponse|RedirectResponse
     */
    public function view(int $id): BinaryFileResponse|RedirectResponse
    {
        // Localizamos publicación y validamos que el archivo exista en disco.
        $publicacion = Publicacion::findOrFail($id);

        if (!Storage::disk('public')->exists($publicacion->archivo_ruta)) {
            return redirect()->route('publicaciones.index')->with('error', 'El archivo no está disponible actualmente.');
        }

        // Entregamos el archivo en modo inline para que el navegador lo intente abrir directamente.
        return response()->file(
            Storage::disk('public')->path($publicacion->archivo_ruta),
            [
                'Content-Disposition' => 'inline; filename="' . $publicacion->archivo_original . '"',
            ]
        );
    }
}