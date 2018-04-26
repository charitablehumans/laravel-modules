@if ($frontendHomeProductCategoriesFeatured)
    <div class="row">
        @foreach ($frontendHomeProductCategoriesFeatured as $customLink)
            <div class="col-md-6">
                <div class="media thumbnail">
                    <div class="media-left">
                        @foreach ($customLink['images_thumbnail_url'] as $imageThumbnailUrl)
                            <img class="media-object" src="{{ $imageThumbnailUrl }}" style="height: 64px; width: 64px;" />
                        @endforeach
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="{{ $customLink['url'] }}">{{ $customLink['title'] }}</a>
                        </h4>
                        {{ $customLink['excerpt'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <input name="frontendHomeProductCategoriesFeatured" type="hidden" value="No menu where slug = frontend-pages-home-product-categories-featured" />
@endif
