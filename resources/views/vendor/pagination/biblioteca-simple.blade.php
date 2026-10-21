@if ($paginator->hasPages())
    <nav class="paginacion" aria-label="Paginación">
        <p class="paginacion__resumen">Página {{ $paginator->currentPage() }}</p>
        <ul>
            @if ($paginator->onFirstPage())
                <li><span aria-disabled="true">Anterior</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">Anterior</a></li>
            @endif
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente</a></li>
            @else
                <li><span aria-disabled="true">Siguiente</span></li>
            @endif
        </ul>
    </nav>
@endif