{{-- pages/product_categories/left_product_categories --}}
<label>@lang('cms::cms.product_categories')</label>
<ul class="list-group">
    @foreach ($pages['product_categories']['left_product_categories'] as $productCategory)
        <li class="list-group-item">
            {{ $productCategory['tree_prefix'] }}
            <a data-pjax href="{{ $productCategory['href'] }}">{{ $productCategory['name'] }}</a>
        </li>
    @endforeach
</ul>
