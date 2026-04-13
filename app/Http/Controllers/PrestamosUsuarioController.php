<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Prestamos;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Controlador para mostrar y filtrar los préstamos del usuario autenticado.
 */
class PrestamosUsuarioController extends Controller
{
    /**
     * Mostrar el listado de préstamos del usuario con filtros y orden.
     *
     * @param Request $request Datos GET de filtros y orden.
     * @return View Vista de préstamos del usuario.
     */
    public function index(Request $request): View
    {
        // Validamos filtros permitidos para evitar estados u órdenes no soportados.
        $validated = $request->validate([
            'estado' => 'nullable|string|in:todos,activos,devueltos,vencidos',
            'orden' => 'nullable|string|in:reciente,antiguo',
            'buscar' => 'nullable|string|max:120',
        ]);

        // Definimos valores por defecto para la pantalla inicial.
        $estado = (string) ($validated['estado'] ?? 'todos');
        $orden = (string) ($validated['orden'] ?? 'reciente');
        $buscar = trim((string) ($validated['buscar'] ?? ''));

        // Recuperamos el ID del usuario autenticado en el guard web.
        $usuarioId = (int) auth('web')->id();

        // Construimos la consulta base con relación del libro para evitar N+1 queries.
        $prestamosQuery = Prestamos::query()
            ->with('libro')
            ->where('usuario_id', $usuarioId);

        // Filtro de búsqueda por datos principales del libro.
        if ($buscar !== '') {
            $prestamosQuery->whereHas('libro', function ($query) use ($buscar): void {
                $query->where('titulo', 'like', "%{$buscar}%")
                    ->orWhere('autor', 'like', "%{$buscar}%")
                    ->orWhere('isbn', 'like', "%{$buscar}%")
                    ->orWhere('genero', 'like', "%{$buscar}%");
            });
        }

        // Filtros por estado del préstamo según fechas de devolución.
        if ($estado === 'activos') {
            $prestamosQuery->whereNull('fecha_devolucion_real');
        }

        if ($estado === 'devueltos') {
            $prestamosQuery->whereNotNull('fecha_devolucion_real');
        }

        if ($estado === 'vencidos') {
            $prestamosQuery->whereNull('fecha_devolucion_real')
                ->whereDate('fecha_devolucion_esperada', '<', now()->toDateString());
        }

        // Ordenamos por fecha de préstamo según preferencia del usuario.
        $direccionOrden = $orden === 'antiguo' ? 'asc' : 'desc';
        $prestamosQuery->orderBy('fecha_prestamo', $direccionOrden);

        // Paginamos resultados conservando los parámetros actuales.
        $prestamos = $prestamosQuery->paginate(8)->withQueryString();

        // Calculamos un resumen global del usuario para mostrar métricas rápidas.
        $resumenBase = Prestamos::query()->where('usuario_id', $usuarioId);
        $resumen = [
            'total' => (clone $resumenBase)->count(),
            'activos' => (clone $resumenBase)->whereNull('fecha_devolucion_real')->count(),
            'devueltos' => (clone $resumenBase)->whereNotNull('fecha_devolucion_real')->count(),
            'vencidos' => (clone $resumenBase)
                ->whereNull('fecha_devolucion_real')
                ->whereDate('fecha_devolucion_esperada', '<', now()->toDateString())
                ->count(),
        ];

        return view('bibliotecaDAW.userViews.prestamos', [
            'prestamos' => $prestamos,
            'estadoSeleccionado' => $estado,
            'ordenSeleccionado' => $orden,
            'buscarTexto' => $buscar,
            'resumen' => $resumen,
        ]);
    }
}