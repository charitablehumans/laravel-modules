@if ($frontendPagesHomeServices)
    <div class="row">
        @foreach ($frontendPagesHomeServices as $frontendPagesHomeService)
            <div class="col-md-{{ 12 / count($frontendPagesHomeServices) }}">
                <div class="media thumbnail">
                    <div class="media-left">
                        <img alt="{{ $frontendPagesHomeService['title'] }}" class="media-object" src="{{ $frontendPagesHomeService['image_thumbnail_url'] }}" style="height: 64px; width: 64px;" />
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">{{ $frontendPagesHomeService['title'] }}</h4>
                        {{ $frontendPagesHomeService['excerpt'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <hr />
@else
    <input name="frontendPagesHomeServices" type="hidden" value="No menu where slug = frontend-home-services" />
@endif
