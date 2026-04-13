<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Prestamos;
use App\Models\Libro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrestamosController extends Controller
{
    /**
     * Muestra el listado de prestamos activos (sin fecha de devolucion real).
     *
     * @return \Illuminate\View\View Vista con los prestamos pendientes de devolucion.
     */
    public function index(): \Illuminate\View\View
    {
        // Traemos prestamos donde la fecha de devolucion real es nula.
        $prestamosActivos = Prestamos::with(['libro', 'usuario'])
            ->whereNull('fecha_devolucion_real')
            ->orderBy('fecha_prestamo', 'desc')
            ->get();

        return view('bibliotecaDAW.adminViews.GestionarLibros.gestionarLibrosPrestados', [
            'prestamosActivos' => $prestamosActivos
        ]);
    }

    /**
     * Registra la devolucion de un prestamo activo.
     * Marca la fecha de devolucion real y cambia la disponibilidad del libro.
     *
     * @param Request $request Datos de la peticion HTTP.
     * @param string  $id      ID del prestamo a devolver.
     * @return \Illuminate\Http\RedirectResponse Redireccion con mensaje de exito o error.
     * @sideEffect Actualiza fecha_devolucion_real en tabla prestamos.
     * @sideEffect Cambia disponibilidad a 'disponible' en tabla libros.
     */
    public function update(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        try {
            // Buscamos el prestamo por ID o lanzamos 404.
            $prestamo = Prestamos::findOrFail($id);

            // Marcamos la fecha de devolucion con la fecha actual.
            $prestamo->update([
                'fecha_devolucion_real' => now()
            ]);

            // Liberamos el libro para que pueda volver a prestarse.
            $prestamo->libro->update([
                'disponibilidad' => 'disponible'
            ]);

            return redirect()->route('admin.librosPrestados')
                ->with('success', 'Libro devuelto correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.librosPrestados')
                ->with('error', 'Error al procesar la devolucion.');
        }
    }

    /**
     * Marca un libro prestado como perdido.
     * Registra la devolucion del prestamo y marca el libro como perdido en la tabla libros.
     *
     * @param string $id ID del prestamo cuyo libro se marca como perdido.
     * @return \Illuminate\Http\RedirectResponse Redireccion a libros perdidos con mensaje.
     * @sideEffect Actualiza fecha_devolucion_real en tabla prestamos.
     * @sideEffect Marca perdido=true y motivo_baja en tabla libros.
     */
    public function marcarPerdido(string $id): \Illuminate\Http\RedirectResponse
    {
        try {
            // Buscamos el prestamo con su libro asociado.
            $prestamo = Prestamos::with('libro')->findOrFail($id);

            // Cerramos el prestamo marcando la devolucion.
            $prestamo->update([
                'fecha_devolucion_real' => now()
            ]);

            // Marcamos el libro como perdido con motivo automatico.
            $prestamo->libro->update([
                'perdido' => true,
                'motivo_baja' => 'Marcado como perdido desde prestamos activos',
                'disponibilidad' => 'prestado',
            ]);

            return redirect()->route('admin.librosPerdidos')
                ->with('success', 'Libro "' . $prestamo->libro->titulo . '" marcado como perdido.');
        } catch (\Exception $e) {
            return redirect()->route('admin.librosPrestados')
                ->with('error', 'Error al marcar el libro como perdido.');
        }
    }
}
