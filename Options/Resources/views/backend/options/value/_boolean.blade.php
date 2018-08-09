<select class="form-control select2" data-allow-clear="true" data-placeholder="" data-width="100%" name="value">
    @foreach ($option->getBooleanOptions() as $booleanKey => $booleanValue)
        <option {{ $booleanKey == request()->old('value', $option->value) ? 'selected' : '' }} value="{{ $booleanKey }}">{{ $booleanValue }}</option>
    @endforeach
</select>
