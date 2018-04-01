@if (
    empty($item['permission']) ||
    (auth()->check() && auth()->user()->hasPermissionTo($item['permission']))
)
    <li
        @if (isset($item['children']) && is_array($item['children']))
            class="treeview"
        @endif
    >
        <a href="{{ $data_url }}">
            <i class="{{ $data_icon }}"></i> <span>{{ $data_title }}</span>
            @if (isset($item['children']) && is_array($item['children']))
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            @endif
        </a>
        @if (isset($item['children']) && is_array($item['children']) && count($item['children']) > 0)
            <ul class="treeview-menu">{!! $menu->generateAsHtmlBackendMaster($item['children']) !!}</ul>
        @endif
    </li>
@endif
