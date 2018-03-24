@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        <li>
            <a>@lang('cms::cms.page')</a>
            <input class="form-control text-right" name="page" style="float: left; width: 60px;" type="number" value="{{ $paginator->currentPage() }}" />
            <a>{{ strtolower(trans('cms::cms.of')) }} {{ $paginator->lastPage() }}</a>
        </li>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
