<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador del panel de inventario de libros.
 *
 * Muestra todos los libros de la biblioteca con un resumen
 * y permite generar un informe PDF filtrado mediante impresión del navegador.
 */
class InventarioController extends Controller
{
    /**
     * Mostrar el inventario completo de libros con resumen.
     *
     * @return View Vista del inventario con métricas.
     */
    public function index(): View
    {
        // Obtenemos todos los libros ordenados por título.
        $libros = Libro::orderBy('titulo')->get();

        // Calculamos métricas de resumen para las cards informativas.
        $resumen = [
            'total' => $libros->count(),
            'disponibles' => $libros->where('disponibilidad', 'disponible')->count(),
            'prestados' => $libros->where('disponibilidad', 'prestado')->count(),
            'fisicos' => $libros->where('formato', 'fisico')->count(),
            'digitales' => $libros->where('formato', 'digital')->count(),
            'ejemplares_total' => $libros->sum('cantidad_ejemplares'),
        ];

        return view('bibliotecaDAW.adminViews.GestionarLibros.gestionarInventario', [
            'resumen' => $resumen,
        ]);
    }

    /**
     * Generar la vista de impresión PDF con filtros aplicados.
     *
     * Recibe parámetros GET opcionales para filtrar la consulta.
     * Abre una página limpia que auto-lanza window.print().
     *
     * @param Request $request Parámetros de filtro (todos opcionales).
     * @return View Vista de impresión con libros filtrados.
     *
     * Filtros disponibles:
     * - disponibilidad: 'disponible' | 'prestado'
     * - formato: 'fisico' | 'digital' | 'ambos'
     * - opcion_compra: 'compra' | 'prestamo'
     * - autor: búsqueda parcial por nombre de autor
     * - genero: búsqueda parcial por género
     * - editorial: búsqueda parcial por editorial
     * - titulo: búsqueda parcial por título
     * - anio_desde: año mínimo de publicación
     * - anio_hasta: año máximo de publicación
     * - limite: número máximo de resultados
     */
    public function generarPdf(Request $request): View
    {
        // Construimos la query aplicando cada filtro solo si se ha enviado.
        $query = Libro::orderBy('titulo');

        // Array para mostrar en el informe qué filtros se aplicaron.
        $filtrosAplicados = [];

        // Filtro por disponibilidad (select exacto).
        if ($request->filled('disponibilidad')) {
            $query->where('disponibilidad', $request->input('disponibilidad'));
            $filtrosAplicados[] = 'Disponibilidad: ' . ucfirst($request->input('disponibilidad'));
        }

        // Filtro por formato (select exacto).
        if ($request->filled('formato')) {
            $query->where('formato', $request->input('formato'));
            $filtrosAplicados[] = 'Formato: ' . ucfirst($request->input('formato'));
        }

        // Filtro por opción de compra (select exacto).
        if ($request->filled('opcion_compra')) {
            $query->where('opcion_compra', $request->input('opcion_compra'));
            $filtrosAplicados[] = 'Opción: ' . ($request->input('opcion_compra') === 'compra' ? 'Venta' : 'Préstamo');
        }

        // Filtro por autor (búsqueda parcial LIKE).
        if ($request->filled('autor')) {
            $query->where('autor', 'LIKE', '%' . $request->input('autor') . '%');
            $filtrosAplicados[] = 'Autor: ' . $request->input('autor');
        }

        // Filtro por género (búsqueda parcial LIKE).
        if ($request->filled('genero')) {
            $query->where('genero', 'LIKE', '%' . $request->input('genero') . '%');
            $filtrosAplicados[] = 'Género: ' . $request->input('genero');
        }

        // Filtro por editorial (búsqueda parcial LIKE).
        if ($request->filled('editorial')) {
            $query->where('editorial', 'LIKE', '%' . $request->input('editorial') . '%');
            $filtrosAplicados[] = 'Editorial: ' . $request->input('editorial');
        }

        // Filtro por título (búsqueda parcial LIKE).
        if ($request->filled('titulo')) {
            $query->where('titulo', 'LIKE', '%' . $request->input('titulo') . '%');
            $filtrosAplicados[] = 'Título: ' . $request->input('titulo');
        }

        // Filtro por rango de año: desde.
        if ($request->filled('anio_desde')) {
            $query->where('anio', '>=', (int) $request->input('anio_desde'));
            $filtrosAplicados[] = 'Año desde: ' . $request->input('anio_desde');
        }

        // Filtro por rango de año: hasta.
        if ($request->filled('anio_hasta')) {
            $query->where('anio', '<=', (int) $request->input('anio_hasta'));
            $filtrosAplicados[] = 'Año hasta: ' . $request->input('anio_hasta');
        }

        // Límite de resultados (si no se indica, se muestran todos).
        if ($request->filled('limite') && (int) $request->input('limite') > 0) {
            $query->limit((int) $request->input('limite'));
            $filtrosAplicados[] = 'Máximo: ' . $request->input('limite') . ' libros';
        }

        // Ejecutamos la consulta con los filtros acumulados.
        $libros = $query->get();

        return view('bibliotecaDAW.adminViews.GestionarLibros.inventarioPdf', [
            'libros' => $libros,
            'filtrosAplicados' => $filtrosAplicados,
        ]);
    }
}
