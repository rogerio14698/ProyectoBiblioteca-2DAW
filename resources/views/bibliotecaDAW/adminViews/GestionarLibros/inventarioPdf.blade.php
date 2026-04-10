{{--
    Vista de impresión para el informe PDF de inventario.
    Se abre en una pestaña nueva y auto-lanza window.print().
    Sin layout, sin nav, sin imágenes: solo datos limpios.
--}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Inventario - Biblioteca DAW</title>
    <style>
        /* Estilos mínimos para impresión limpia */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            font-size: 11px;
            color: #222;
            padding: 20px 30px;
            line-height: 1.5;
        }

        /* --- Cabecera del informe --- */
        .informeHeader {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .informeHeader h1 {
            font-size: 18px;
            margin-bottom: 4px;
        }

        .informeHeader p {
            font-size: 11px;
            color: #555;
        }

        /* --- Filtros aplicados --- */
        .informeFiltros {
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 14px;
            margin-bottom: 16px;
            font-size: 10px;
            color: #444;
        }

        .informeFiltros strong {
            color: #222;
        }

        /* --- Resumen rápido --- */
        .informeResumen {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 16px;
            padding: 8px 0;
            border-bottom: 1px solid #ccc;
        }

        .informeResumen span {
            font-size: 10px;
        }

        .informeResumen strong {
            font-size: 12px;
        }

        /* --- Tabla de datos --- */
        .informeTabla {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        .informeTabla th,
        .informeTabla td {
            border: 1px solid #ccc;
            padding: 5px 8px;
            text-align: left;
            font-size: 10px;
        }

        .informeTabla th {
            background: #eee;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.3px;
        }

        .informeTabla tbody tr:nth-child(even) {
            background: #fafafa;
        }

        /* --- Pie del informe --- */
        .informeFooter {
            text-align: center;
            font-size: 9px;
            color: #888;
            border-top: 1px solid #ccc;
            padding-top: 8px;
            margin-top: 16px;
        }

        /* Al imprimir: márgenes mínimos */
        @media print {
            body {
                padding: 10px;
            }

            .informeFiltros {
                background: #f5f5f5 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .informeTabla th {
                background: #eee !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    {{-- Cabecera del informe --}}
    <header class="informeHeader">
        <h1>Informe de Inventario - Biblioteca DAW</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i') }} | Total de libros en informe: {{ $libros->count() }}</p>
    </header>

    {{-- Filtros aplicados (si hay alguno) --}}
    @if (!empty($filtrosAplicados))
        <section class="informeFiltros">
            <strong>Filtros aplicados:</strong>
            {{ implode(' | ', $filtrosAplicados) }}
        </section>
    @endif

    {{-- Resumen rápido de los resultados filtrados --}}
    <section class="informeResumen">
        <span>Total: <strong>{{ $libros->count() }}</strong></span>
        <span>Disponibles: <strong>{{ $libros->where('disponibilidad', 'disponible')->count() }}</strong></span>
        <span>Prestados: <strong>{{ $libros->where('disponibilidad', 'prestado')->count() }}</strong></span>
        <span>Ejemplares: <strong>{{ $libros->sum('cantidad_ejemplares') }}</strong></span>
    </section>

    {{-- Tabla con los datos de cada libro --}}
    @if ($libros->isEmpty())
        <p>No se encontraron libros con los filtros seleccionados.</p>
    @else
        <table class="informeTabla">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Género</th>
                    <th>Año</th>
                    <th>Editorial</th>
                    <th>ISBN</th>
                    <th>Disponibilidad</th>
                    <th>Formato</th>
                    <th>Opción</th>
                    <th>Ejemplares</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($libros as $index => $libro)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $libro->titulo }}</td>
                        <td>{{ $libro->autor }}</td>
                        <td>{{ $libro->genero }}</td>
                        <td>{{ $libro->anio }}</td>
                        <td>{{ $libro->editorial }}</td>
                        <td>{{ $libro->isbn }}</td>
                        <td>{{ ucfirst($libro->disponibilidad) }}</td>
                        <td>{{ ucfirst($libro->formato) }}</td>
                        <td>{{ $libro->opcion_compra === 'compra' ? 'Venta' : 'Préstamo' }}</td>
                        <td>{{ $libro->cantidad_ejemplares }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Pie del informe --}}
    <footer class="informeFooter">
        Biblioteca DAW &mdash; Informe generado automáticamente &mdash; {{ now()->format('d/m/Y H:i') }}
    </footer>

    {{-- Auto-lanzar el diálogo de impresión al cargar la página --}}
    <script>
        // Esperamos a que se renderice el contenido y lanzamos la impresión.
        window.addEventListener('DOMContentLoaded', () => {
            window.print();
        });
    </script>
</body>
</html>
