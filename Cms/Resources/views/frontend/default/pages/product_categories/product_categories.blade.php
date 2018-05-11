{{-- pages/product_categories/product_categories --}}
<label>@lang('cms::cms.product_categories')</label>
<div class="product_categories_container">
    <ul>
        {!! $pages['product_categories']['product_categories']['html'] !!}
    </ul>
</div>

@push('styles')
    <link href="{{ asset('bower/jstree/dist/themes/default/style.min.css') }}" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="{{ asset('bower/jstree/dist/jstree.min.js') }}"></script>
    <script>
    $('.product_categories_container').jstree();
    $('.product_categories_container').bind('select_node.jstree', function (e, data) {
        console.log(data.node);
        var href = data.node.data.jstree.a_attr.href;
        window.location.href = href;
    });
</script>
@endpush
