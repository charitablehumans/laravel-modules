@if (
    empty($item['permission']) ||
    (auth()->check() && auth()->user()->hasPermissionTo($item['permission']))
)
    <li
        @if (isset($item['children']) && is_array($item['children']))
            class="dropdown"
        @endif
    >
        @if (isset($item['children']) && is_array($item['children']) && count($item['children']) > 0)
            <a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">{{ $data_title }} <span class="caret"></span></a>
            <ul class="dropdown-menu">{!! $menu->generateAsHtmlFrontendDefaultTop($item['children']) !!}</ul>
        @else
            <a href="{{ $data_url }}">
                <i class="{{ $data_icon }}"></i> <span>{{ $data_title }}</span>
            </a>
        @endif
    </li>
@endif
