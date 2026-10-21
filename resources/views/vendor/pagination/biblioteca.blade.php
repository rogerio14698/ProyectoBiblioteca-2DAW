@if ($paginator->hasPages())
    <nav class="paginacion" aria-label="Paginación">
        <p class="paginacion__resumen">
            Mostrando {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} de {{ $paginator->total() }}
        </p>
        <ul>
            @if ($paginator->onFirstPage())
                <li><span aria-disabled="true"><i class="bi bi-arrow-left" aria-hidden="true"></i><span class="visually-hidden">Anterior</span></span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="bi bi-arrow-left" aria-hidden="true"></i><span class="visually-hidden">Anterior</span></a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span aria-disabled="true">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span aria-current="page">{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}" aria-label="Página {{ $page }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="bi bi-arrow-right" aria-hidden="true"></i><span class="visually-hidden">Siguiente</span></a></li>
            @else
                <li><span aria-disabled="true"><i class="bi bi-arrow-right" aria-hidden="true"></i><span class="visually-hidden">Siguiente</span></span></li>
            @endif
        </ul>
    </nav>
@endif