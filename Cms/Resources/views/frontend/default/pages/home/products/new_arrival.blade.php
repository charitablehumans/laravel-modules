@if ($frontendPagesHomeProductsNewArrival)
    <div class="row">
        @foreach ($frontendPagesHomeProductsNewArrival as $i => $product)
            @php
            $mediumId = (integer) $product->getPostmetaValue('images');
            $medium = \Modules\Media\Models\Media::getPostById($mediumId);
            @endphp

            <div class="col-md-4 col-sm-6">
                <div class="thumbnail">
                    <img alt="{{ optional($medium)->name }}" src="{{ $post->getPostmetaValue('images', 'image_thumbnail_url') }}" style="height: 200px" />
                    <div align="center" class="caption">
                        <h3>
                            <a href="{{ route('frontend.products.show', $product->name) }}">{{ $product->title }}</a>
                        </h3>
                        <p>{{ config('cms.currency.symbol.left.default').number_format($product->postProduct->sell_price) }}</p>
                        <p>
                            <a class="btn btn-primary" href="#" role="button">Button</a>
                            <a class="btn btn-default" href="#" role="button">Button</a>
                        </p>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
    <hr />
@else
    <input name="frontendPagesHomeProductsNewArrival" type="hidden" value="No products" />
@endif
