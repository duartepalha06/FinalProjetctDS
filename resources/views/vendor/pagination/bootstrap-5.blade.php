@if ($paginator->hasPages())
    <div style="text-align: center; margin-top: 20px;">
        <p class="small text-muted" style="margin-bottom: 15px;">
            Mostrando <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
            até <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
            de <span class="fw-semibold">{{ $paginator->total() }}</span>
            resultados
        </p>

        <div>
            @if (!$paginator->onFirstPage())
                <a href="{{ $paginator->previousPageUrl() }}" style="padding: 5px 10px; margin-right: 10px; text-decoration: none; color: #0d6efd; border: 1px solid #dee2e6; border-radius: 4px; display: inline-block;">Anterior</a>
            @else
                <span style="padding: 5px 10px; margin-right: 10px; color: #ccc; border: 1px solid #dee2e6; border-radius: 4px; display: inline-block;">Anterior</span>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" style="padding: 5px 10px; text-decoration: none; color: #0d6efd; border: 1px solid #dee2e6; border-radius: 4px; display: inline-block;">Próximo</a>
            @else
                <span style="padding: 5px 10px; color: #ccc; border: 1px solid #dee2e6; border-radius: 4px; display: inline-block;">Próximo</span>
            @endif
        </div>
    </div>
@endif
