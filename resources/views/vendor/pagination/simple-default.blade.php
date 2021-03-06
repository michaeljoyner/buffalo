<ul class="pagination">
    <!-- Previous Page Link -->
    @if ($paginator->onFirstPage())
        <li class="disabled"><span>PREV</span></li>
    @else
        <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">PREV</a></li>
    @endif

    <!-- Next Page Link -->
    @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">NEXT</a></li>
    @else
        <li class="disabled"><span>NEXT</span></li>
    @endif
</ul>
