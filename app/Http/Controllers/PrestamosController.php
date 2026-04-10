<?php

namespace App\Http\Controllers;

use App\Models\Prestamos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrestamosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        // Traemos préstamos donde la fecha de devolución real es nula
        $prestamosActivos = Prestamos::with(['libro', 'usuario'])
            ->whereNull('fecha_devolucion_real')
            ->orderBy('fecha_prestamo', 'desc')
            ->get();

        return view('bibliotecaDAW.adminViews.GestionarLibros.gestionarLibrosPrestados', [
            'prestamosActivos' => $prestamosActivos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function gestionarPrestamos()
    {
        // Traemos los préstamos que NO tienen fecha de devolución real (están activos)
        $prestamosActivos = Prestamos::with(['libro', 'usuario'])
            ->whereNull('fecha_devolucion_real')
            ->get();

        return view('bibliotecaDAW.adminViews.GestionarPrestamos.index', compact('prestamosActivos'));
    }
    public function registrarDevolucion($id)
    {
        $prestamo = Prestamos::findOrFail($id);
        $prestamo->update(['fecha_devolucion_real' => now()]);

        // Importante: Actualizar la disponibilidad en la tabla de libros
        $prestamo->libro->update(['disponibilidad' => 'disponible']);

        return redirect()->back()->with('success', 'Devolución registrada correctamente.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestamos $prestamos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestamos $prestamos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $prestamo = Prestamos::findOrFail($id);
            
            // 1. Marcar fecha de devolución
            $prestamo->update([
                'fecha_devolucion_real' => now()
            ]);

            // 2. Cambiar disponibilidad del libro a 'disponible'
            // Esto asume que tienes la relación 'libro' en el modelo Prestamo
            $prestamo->libro->update([
                'disponibilidad' => 'disponible'
            ]);

            return redirect()->route('admin.librosPrestados')
                ->with('success', 'Libro devuelto correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.librosPrestados')
                ->with('error', 'Error al procesar la devolución.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestamos $prestamos)
    {
        //
    }
}
