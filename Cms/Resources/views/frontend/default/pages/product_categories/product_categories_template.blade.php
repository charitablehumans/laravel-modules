<li data-jstree='{ "a_attr": { "href": "{{ $url }}" }, "icon": false, "opened": true }'>
    <a href="{{ $url }}">{{ $title }}</a>

    @if (isset($children) && is_array($children))
        <ul>{!! $composer->generateHtml($children) !!}</ul>
    @endif
</li>
