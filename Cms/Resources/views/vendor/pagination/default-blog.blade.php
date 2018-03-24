@if ($paginator->hasPages())
    <ul class="pager">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())

        @else
            <li class="previous">
                <a href="{{ $paginator->previousPageUrl() }}" rel="@lang('cms.previous')">&larr; @lang('cms.newer')</a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="next">
                <a href="{{ $paginator->nextPageUrl() }}" rel="@lang('cms.next')">@lang('cms.older') &rarr;</a>
            </li>
        @endif
    </ul>
@endif
