<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Prestamos;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controlador para gestionar la sección de alquiler de libros de usuario.
 */
class AlquilerController extends Controller
{
    /**
     * Mostrar catálogo dinámico de libros alquilables con filtros.
     *
     * @param Request $request Parámetros de búsqueda y orden del listado.
     * @return View Vista de alquiler con resultados y resumen del usuario.
     */
    public function index(Request $request): View
    {
        // Validamos filtros permitidos para controlar valores de entrada y evitar consultas inválidas.
        $validatedData = $request->validate([
            'query' => ['nullable', 'string', 'max:120'],
            'genero' => ['nullable', 'string', 'max:120'],
            'formato' => ['nullable', 'string', 'in:todos,fisico,digital,ambos'],
            'orden' => ['nullable', 'string', 'in:reciente,antiguo,titulo_asc,titulo_desc'],
        ]);

        // Normalizamos valores para trabajar con defaults claros en la interfaz.
        $searchQuery = trim((string) ($validatedData['query'] ?? ''));
        $searchGenero = trim((string) ($validatedData['genero'] ?? ''));
        $searchFormato = trim((string) ($validatedData['formato'] ?? 'todos'));
        $searchOrden = trim((string) ($validatedData['orden'] ?? 'reciente'));

        // Obtenemos el usuario autenticado para recuperar su actividad de préstamos.
        $usuarioId = (int) auth('web')->id();

        // Construimos consulta de libros alquilables: disponibles, no perdidos y con opción de préstamo.
        $librosQuery = Libro::query()
            ->where('opcion_compra', 'prestamo')
            ->where('disponibilidad', 'disponible')
            ->where('perdido', false)
            ->when($searchQuery !== '', fn($query) => $query->where(function ($subQuery) use ($searchQuery): void {
                $subQuery->where('titulo', 'like', "%{$searchQuery}%")
                    ->orWhere('autor', 'like', "%{$searchQuery}%")
                    ->orWhere('isbn', 'like', "%{$searchQuery}%")
                    ->orWhere('genero', 'like', "%{$searchQuery}%");
            }))
            ->when($searchGenero !== '', fn($query) => $query->where('genero', 'like', "%{$searchGenero}%"));

        // Filtro de formato considerando que un libro en "ambos" sirve para físico y digital.
        if ($searchFormato === 'fisico' || $searchFormato === 'digital') {
            $librosQuery->where(function ($query) use ($searchFormato): void {
                $query->where('formato', $searchFormato)
                    ->orWhere('formato', 'ambos');
            });
        }

        if ($searchFormato === 'ambos') {
            $librosQuery->where('formato', 'ambos');
        }

        // Aplicamos orden seleccionado por el usuario.
        if ($searchOrden === 'antiguo') {
            $librosQuery->orderBy('created_at', 'asc');
        }

        if ($searchOrden === 'titulo_asc') {
            $librosQuery->orderBy('titulo', 'asc');
        }

        if ($searchOrden === 'titulo_desc') {
            $librosQuery->orderBy('titulo', 'desc');
        }

        if ($searchOrden === 'reciente') {
            $librosQuery->orderBy('created_at', 'desc');
        }

        // Paginamos catálogo para mantener tiempos de carga estables.
        $libros = $librosQuery->paginate(9)->withQueryString();

        // Recuperamos préstamos activos del usuario para mostrar contexto de su estado actual.
        $prestamosActivos = Prestamos::with('libro')
            ->where('usuario_id', $usuarioId)
            ->whereNull('fecha_devolucion_real')
            ->orderBy('fecha_prestamo', 'desc')
            ->get();

        // Recuperamos historial devuelto para reforzar la sección de actividad.
        $prestamosHistorial = Prestamos::with('libro')
            ->where('usuario_id', $usuarioId)
            ->whereNotNull('fecha_devolucion_real')
            ->orderBy('fecha_devolucion_real', 'desc')
            ->limit(6)
            ->get();

        // Traemos géneros disponibles del catálogo de alquiler para facilitar filtrado.
        $generosDisponibles = Libro::query()
            ->where('opcion_compra', 'prestamo')
            ->where('perdido', false)
            ->whereNotNull('genero')
            ->distinct()
            ->orderBy('genero', 'asc')
            ->pluck('genero');

        return view('bibliotecaDAW.userViews.alquilar', [
            'libros' => $libros,
            'prestamosActivos' => $prestamosActivos,
            'prestamosHistorial' => $prestamosHistorial,
            'generosDisponibles' => $generosDisponibles,
            'searchQuery' => $searchQuery,
            'searchGenero' => $searchGenero,
            'searchFormato' => $searchFormato,
            'searchOrden' => $searchOrden,
        ]);
    }

    /**
     * Registrar un nuevo préstamo para el usuario autenticado.
     *
     * @param Request $request Datos del formulario de alquiler.
     * @return RedirectResponse Redirección de vuelta con estado de la operación.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validamos datos mínimos del formulario para asegurar integridad.
        $validatedData = $request->validate([
            'libro_id' => ['required', 'integer', 'exists:libros,id'],
            'dias_prestamo' => ['required', 'integer', 'min:1', 'max:60'],
        ]);

        // Recuperamos usuario autenticado para asociar correctamente el préstamo.
        $usuarioId = (int) auth('web')->id();

        // Encapsulamos validaciones finales, creación y actualización para mantener coherencia ante concurrencia.
        $mensajeError = null;

        DB::transaction(function () use ($validatedData, $usuarioId, &$mensajeError): void {
            // Bloqueamos el libro para evitar dobles préstamos simultáneos del mismo ejemplar.
            $libro = Libro::query()
                ->where('id', (int) $validatedData['libro_id'])
                ->where('opcion_compra', 'prestamo')
                ->where('disponibilidad', 'disponible')
                ->where('perdido', false)
                ->lockForUpdate()
                ->first();

            // Si no está disponible, dejamos mensaje y salimos del flujo transaccional.
            if ($libro === null) {
                $mensajeError = 'El libro ya no está disponible para alquilar.';
                return;
            }

            // Comprobamos dentro de transacción si el usuario ya tiene préstamo activo de este libro.
            $yaTienePrestamoActivo = Prestamos::query()
                ->where('usuario_id', $usuarioId)
                ->where('libro_id', $libro->id)
                ->whereNull('fecha_devolucion_real')
                ->exists();

            if ($yaTienePrestamoActivo) {
                $mensajeError = 'Ya tienes este libro en préstamo activo.';
                return;
            }

            Prestamos::create([
                'libro_id' => $libro->id,
                'usuario_id' => $usuarioId,
                'fecha_prestamo' => now(),
                'fecha_devolucion_esperada' => now()->addDays((int) $validatedData['dias_prestamo']),
            ]);

            $libro->update([
                'disponibilidad' => 'prestado',
            ]);
        });

        // Si alguna validación de negocio falló, avisamos al usuario.
        if ($mensajeError !== null) {
            return redirect()->route('usuario.alquilar')->with('error', $mensajeError);
        }

        return redirect()->route('usuario.alquilar')->with('success', 'Préstamo registrado correctamente.');
    }
}