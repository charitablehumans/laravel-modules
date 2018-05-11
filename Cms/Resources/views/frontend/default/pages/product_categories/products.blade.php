{{-- pages/product_categories/products --}}
<form data-pjax action="{{ route('frontend.product-categories.index', $pages['product_categories']['slugs']) }}" method="get">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <select class="input-sm" name="limit">
                    @foreach (config('cms.products.frontend.limit_options') as $limit)
                        <option {{ $limit == request()->query('limit') ? 'selected' : '' }} value="{{ $limit }}">{{ $limit }}</option>
                    @endforeach
                </select>
            </div>
            <div class="pull-right">
                @lang('cms::cms.sort')
                <select class="input-sm" name="sort">
                    <option value="">@lang('cms::cms.default')</option>
                    @if (config('cms.products.product_testimonials.rating_average'))
                        <option {{ request()->query('sort') == 'post_testimonial_rating_average:desc' ? 'selected' : '' }} value="post_testimonial_rating_average:desc">@lang('validation.attributes.rating')</option>
                    @endif
                    <option {{ request()->query('sort') == 'post_product_sell_price:asc' ? 'selected' : '' }} value="post_product_sell_price:asc">@lang('cms::cms.cheapest')</option>
                    <option {{ request()->query('sort') == 'post_product_sell_price:desc' ? 'selected' : '' }} value="post_product_sell_price:desc">@lang('cms::cms.most_expensive')</option>
                    <option {{ request()->query('sort') == 'title:asc' ? 'selected' : '' }} value="title:asc">@lang('validation.attributes.name') (A-Z)</option>
                    <option {{ request()->query('sort') == 'title:desc' ? 'selected' : '' }} value="title:desc">@lang('validation.attributes.name') (Z-A)</option>
                    <option {{ request()->query('sort') == 'updated_at:desc' ? 'selected' : '' }} value="updated_at:desc">@lang('cms::cms.newest')</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        @forelse ($pages['product_categories']['products']['lists'] as $product)
            <div class="col-md-4">
                <input type="hidden" value="{{ $product['id'] }}" />
                <div class="thumbnail">
                    <img alt="{{ $product['thumbnail']['img']['alt'] }}" src="{{ $product['thumbnail']['img']['src'] }}" />
                    <div class="caption">
                        <h4 align="center">
                            <a href="{{ $product['href'] }}">{{ $product['title'] }}</a>
                        </h4>
                    </div>
                    <div class="caption">{{ $product['sell_price_text'] }}</div>
                    <div class="caption">
                        <p>
                            @foreach ($product['ratings'] as $rating)
                                <span class="glyphicon {{ $product['rating_average'] > $rating ? 'glyphicon-star' : 'glyphicon-star-empty' }}"></span>
                            @endforeach
                            ({{ $product['rating_count'] }})
                        </p>
                    </div>
                </div>
            </div>
        @empty
            No products.
        @endforelse
    </div>
    <div class="row">
        <div class="col-md-12">
            <div align="center">{{ $pages['product_categories']['products']['pagination'] }}</div>
        </div>
    </div>
</form>

@push('scripts')
    <script>
    $('select[name=limit], select[name=sort]').on('change', function () {
        $(this).closest('form').submit();
    });
    </script>
@endpush
