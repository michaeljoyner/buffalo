@if($paginator->hasPages())
    <div class="pagination-container">
        {!! $paginator->links() !!}
    </div>
@endif