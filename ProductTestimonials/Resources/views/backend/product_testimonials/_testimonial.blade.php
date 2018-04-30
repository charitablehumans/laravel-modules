<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>@lang('validation.attributes.rating')</label>
            <select class="form-control" name="rating">
                @foreach ($post->getPostTestimonial()->getRatingOptions() as $rating)
                    <option {{ $rating == $post->getPostTestimonial()->getRating() ? 'selected' : '' }} value="{{ $rating }}">{{ $rating }}</option>
                @endforeach
            </select>
            <i class="text-danger">{{ $errors->first('rating') }}</i>
        </div>
    </div>
</div>
