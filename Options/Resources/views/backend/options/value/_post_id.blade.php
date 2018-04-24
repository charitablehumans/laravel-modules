<select class="form-control select2" data-allow-clear="true" data-placeholder="" data-width="100%" name="value">
    <option value=""></option>
    @foreach ($option->getPosts() as $post)
        <option {{ $post->id == request()->old('value', $option->value) ? 'selected' : '' }} value="{{ $post->id }}">{{ $post->title }}</option>
    @endforeach
</select>
