@if($paginator->hasPages())
    <div class="pagination-holder">
        {!! $paginator->links() !!}
    </div>
@endif