<div class="d-flex justify-content-between align-items-center position-relative mt-3">
    <div class="text-muted small">
        Menampilkan {{ $paginator->firstItem() ?? 0 }} - {{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }} data
    </div>

    <nav>
        <ul class="pagination pagination-sm shadow-sm">
            @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">«</span></li>
            @else
            <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" class="page-link">«</a></li>
            @endif

            @foreach ($elements as $element)
            @if (is_string($element))
            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
            <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
            @endif
            @endforeach
            @endif
            @endforeach

            @if ($paginator->hasMorePages())
            <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="page-link">»</a></li>
            @else
            <li class="page-item disabled"><span class="page-link">»</span></li>
            @endif
        </ul>
    </nav>
</div>