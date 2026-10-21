<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contacto;
use App\Models\Evento;
use App\Models\Libro;
use App\Models\Noticias;
use App\Models\Pago;
use App\Models\Prestamos;
use App\Models\Usuario;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $inicioMes = now()->startOfMonth();
        $inicioMesSiguiente = $inicioMes->copy()->addMonth();
        $pagosDelMes = Pago::query()
            ->where('estado', 'pagado')
            ->where('pagado_at', '>=', $inicioMes)
            ->where('pagado_at', '<', $inicioMesSiguiente);

        $ingresosMes = (int) (clone $pagosDelMes)->sum('importe');
        $sumasPorConcepto = (clone $pagosDelMes)
            ->selectRaw('concepto, SUM(importe) AS total')
            ->groupBy('concepto')
            ->pluck('total', 'concepto');
        $conceptos = [
            'compra_libro' => 'Libro',
            'entrada_evento' => 'Evento',
            'multa' => 'Multa',
            'cuota_socio' => 'Cuota',
        ];
        $mayorConcepto = max(1, (int) $sumasPorConcepto->max());
        $ingresosPorConcepto = collect($conceptos)->map(function (string $etiqueta, string $concepto) use ($sumasPorConcepto, $mayorConcepto) {
            $importe = (int) ($sumasPorConcepto[$concepto] ?? 0);

            return [
                'etiqueta' => $etiqueta,
                'importe' => $importe,
                'euros' => number_format($importe / 100, 2, ',', '.') . ' €',
                'porcentaje' => (int) round(($importe / $mayorConcepto) * 100),
            ];
        });

        $mensajes = Contacto::verificados()->latest()->paginate(8);
        $ultimosPagos = Pago::with('usuario')->latest()->limit(5)->get();
        $librosDisponibles = Libro::where('disponibilidad', 'disponible')->count();
        $eventosProximos = Evento::where('fecha_hora', '>', now())->count();
        $usuariosRegistrados = Usuario::count();
        $totalNoticias = Noticias::count();
        $prestamosActivos = Prestamos::whereNull('fecha_devolucion_real')->count();
        $multasPendientes = Prestamos::where('multa', '>', 0)->where('multa_pagada', false)->count();

        return view('bibliotecaDAW.adminViews.administrador', compact(
            'mensajes', 'ultimosPagos', 'ingresosMes', 'ingresosPorConcepto',
            'librosDisponibles', 'eventosProximos', 'usuariosRegistrados', 'totalNoticias',
            'prestamosActivos', 'multasPendientes'
        ));
    }
}
