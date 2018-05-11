{{-- pages/product_categories/breadcrumb --}}
<ol class="breadcrumb">
    <li>
        <a href="{{ route('frontend.product-categories.index') }}">@lang('cms::cms.product_categories')</a>
    </li>
    @foreach ($pages['product_categories']['breadcrumb'] as $breadcrumb)
        <li>
            <a href="{{ $breadcrumb['href'] }}">{{ $breadcrumb['name'] }}</a>
        </li>
    @endforeach
</ol>
