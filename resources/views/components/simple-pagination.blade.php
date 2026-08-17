@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="pagination">
        @if ($paginator->onFirstPage())
            <span class="pointer-events-none opacity-45" aria-disabled="true">
                <span>« Sebelumnya</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <span>« Sebelumnya</span>
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                <span>Selanjutnya »</span>
            </a>
        @else
            <span class="pointer-events-none opacity-45" aria-disabled="true">
                <span>Selanjutnya »</span>
            </span>
        @endif
    </nav>
@endif
