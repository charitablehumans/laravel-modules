<li
    class="dd-item dd3-item"
    data-icon="{{ $data_icon }}"
    data-id="{{ $data_id }}"
    data-permission="{{ $data_permission }}"
    data-title="{{ $data_title }}"
    data-type="{{ $data_type }}"
    data-url="{{ $data_url }}"
>
    <div class="dd-handle dd3-handle">Drag</div>
    <div class="dd3-content">
        {{ $data_title }} - {{ $data_type }}
        <a class="menu_edit" data-target="#menu_modal" data-toggle="modal" role="button"><i class="fa fa-pencil"></i></a>
        <a class="menu_trash" role="button"><i class="fa fa-trash"></i></a>
    </div>

    @if (isset($item['children']) && is_array($item['children']))
        <ol class="dd-list">{!! $menu->generateAsHtmlBackendMenuForm($item['children']) !!}</ol>
    @endif
</li>
