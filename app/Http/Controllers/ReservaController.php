<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Reserva;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador CRUD para la gestión de reservas/préstamos de libros.
 * Permite listar el historial completo, ver reservas activas,
 * crear nuevas reservas, marcar devoluciones y cancelar préstamos.
 */
class ReservaController extends Controller
{
    /**
     * Mostrar el historial completo de reservas (todas, filtrable por estado).
     * Incluye la opción de editar una reserva seleccionada con ?edit=ID.
     *
     * @param Request $request Petición HTTP con posibles filtros (estado, usuario, libro).
     * @return View Vista del historial con $reservas, $usuarios, $libros y $reservaEditar.
     */
    public function historial(Request $request): View
    {
        // Iniciamos la consulta base cargando las relaciones (evita N+1).
        $query = Reserva::with(['usuario', 'libro']);

        // Filtro por estado de la reserva.
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        // Filtro por nombre de usuario.
        if ($request->filled('usuario')) {
            $query->whereHas('usuario', fn($q) => $q->where('name', 'like', '%' . $request->input('usuario') . '%'));
        }

        // Filtro por título de libro.
        if ($request->filled('libro')) {
            $query->whereHas('libro', fn($q) => $q->where('titulo', 'like', '%' . $request->input('libro') . '%'));
        }

        // Ordenamos por fecha de reserva (más recientes primero).
        $reservas = $query->orderBy('fecha_reserva', 'desc')->get();

        // Cargamos usuarios y libros para los selects del formulario.
        $usuarios = Usuario::orderBy('name')->get();
        $libros = Libro::orderBy('titulo')->get();

        // Si viene ?edit=ID, cargamos esa reserva para el formulario de edición.
        $reservaEditar = null;
        if ($request->has('edit')) {
            $reservaEditar = Reserva::with(['usuario', 'libro'])->find($request->input('edit'));
        }

        return view('bibliotecaDAW.adminViews.GestionarUsuarios.historialReservas', [
            'reservas'      => $reservas,
            'usuarios'      => $usuarios,
            'libros'        => $libros,
            'reservaEditar' => $reservaEditar,
        ]);
    }

    /**
     * Mostrar solo las reservas activas (préstamos sin devolver).
     *
     * @param Request $request Petición HTTP con posibles filtros.
     * @return View Vista de reservas activas.
     */
    public function activas(Request $request): View
    {
        // Filtramos solo reservas con estado 'activa' o 'vencida' (pendientes de devolución).
        $query = Reserva::with(['usuario', 'libro'])
            ->whereIn('estado', ['activa', 'vencida']);

        // Filtro por nombre de usuario.
        if ($request->filled('usuario')) {
            $query->whereHas('usuario', fn($q) => $q->where('name', 'like', '%' . $request->input('usuario') . '%'));
        }

        $reservas = $query->orderBy('fecha_devolucion_prevista', 'asc')->get();

        return view('bibliotecaDAW.adminViews.GestionarUsuarios.reservasActivas', [
            'reservas' => $reservas,
        ]);
    }

    /**
     * Crear una nueva reserva/préstamo de libro.
     * Valida que el usuario y libro existan antes de guardar.
     *
     * @param Request $request Datos del formulario de creación.
     * @return RedirectResponse Redirección con mensaje flash.
     * @sideEffect Crea un registro en la tabla 'reservas'.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validamos los campos obligatorios del formulario.
        $request->validate([
            'usuario_id'                => 'required|exists:usuarios,id',
            'libro_id'                  => 'required|exists:libros,id',
            'fecha_reserva'             => 'required|date',
            'fecha_devolucion_prevista' => 'required|date|after_or_equal:fecha_reserva',
            'observaciones'             => 'nullable|string|max:500',
        ]);

        try {
            // Creamos la reserva con estado 'activa' por defecto.
            Reserva::create([
                'usuario_id'                => $request->input('usuario_id'),
                'libro_id'                  => $request->input('libro_id'),
                'fecha_reserva'             => $request->input('fecha_reserva'),
                'fecha_devolucion_prevista' => $request->input('fecha_devolucion_prevista'),
                'estado'                    => 'activa',
                'observaciones'             => $request->input('observaciones'),
            ]);

            return redirect()->route('admin.historialReservas')->with('success', 'Reserva creada correctamente.');

        } catch (\Exception $e) {
            return redirect()->route('admin.historialReservas')->with('error', 'Error al crear la reserva: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar una reserva existente (cambiar estado, fechas, observaciones).
     *
     * @param Request $request Datos del formulario de edición.
     * @param int $id Identificador de la reserva a actualizar.
     * @return RedirectResponse Redirección con mensaje flash.
     * @sideEffect Modifica un registro en la tabla 'reservas'.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'usuario_id'                => 'required|exists:usuarios,id',
            'libro_id'                  => 'required|exists:libros,id',
            'fecha_reserva'             => 'required|date',
            'fecha_devolucion_prevista' => 'required|date',
            'fecha_devolucion_real'     => 'nullable|date',
            'estado'                    => 'required|in:activa,devuelta,vencida,cancelada',
            'observaciones'             => 'nullable|string|max:500',
        ]);

        try {
            $reserva = Reserva::findOrFail($id);

            $reserva->update([
                'usuario_id'                => $request->input('usuario_id'),
                'libro_id'                  => $request->input('libro_id'),
                'fecha_reserva'             => $request->input('fecha_reserva'),
                'fecha_devolucion_prevista' => $request->input('fecha_devolucion_prevista'),
                'fecha_devolucion_real'     => $request->input('fecha_devolucion_real'),
                'estado'                    => $request->input('estado'),
                'observaciones'             => $request->input('observaciones'),
            ]);

            return redirect()->route('admin.historialReservas')->with('success', 'Reserva actualizada correctamente.');

        } catch (\Exception $e) {
            return redirect()->route('admin.historialReservas')->with('error', 'Error al actualizar la reserva: ' . $e->getMessage());
        }
    }

    /**
     * Marcar una reserva como devuelta (atajo rápido desde el listado).
     * Establece la fecha de devolución real como hoy y el estado como 'devuelta'.
     *
     * @param int $id Identificador de la reserva a marcar como devuelta.
     * @return RedirectResponse Redirección con mensaje flash.
     * @sideEffect Modifica el estado y fecha_devolucion_real del registro.
     */
    public function devolver(int $id): RedirectResponse
    {
        try {
            $reserva = Reserva::findOrFail($id);

            $reserva->update([
                'fecha_devolucion_real' => now()->toDateString(),
                'estado'                => 'devuelta',
            ]);

            return redirect()->back()->with('success', 'Libro marcado como devuelto.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al marcar la devolución: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar una reserva del historial.
     *
     * @param int $id Identificador de la reserva a eliminar.
     * @return RedirectResponse Redirección con mensaje flash.
     * @sideEffect Elimina un registro de la tabla 'reservas'.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $reserva = Reserva::findOrFail($id);
            $reserva->delete();

            return redirect()->route('admin.historialReservas')->with('success', 'Reserva eliminada correctamente.');

        } catch (\Exception $e) {
            return redirect()->route('admin.historialReservas')->with('error', 'Error al eliminar la reserva: ' . $e->getMessage());
        }
    }
}
