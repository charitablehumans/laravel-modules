<select class="form-control select2" data-allow-clear="true" data-placeholder="" data-width="100%" name="value">
    @foreach ($option->getAppEnvOptions() as $appEnvOptionKey => $appEnvOptionName)
        <option {{ $appEnvOptionKey == request()->old('value', $option->value) ? 'selected' : '' }} value="{{ $appEnvOptionKey }}">{{ $appEnvOptionName }}</option>
    @endforeach
</select>
