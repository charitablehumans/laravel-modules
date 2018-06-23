{{ csrf_field() }}
<div class="box">
    <div class="box-body">
        <div class="form-group">
            <label>@lang('validation.attributes.type') (*)</label>
            <select class="form-control select2" data-allow-clear="true" data-placeholder="" data-tags="true" data-width="100%" name="type" required>
                <option value=""></option>
                @foreach ($option->getTypeOptions() as $type)
                    <option {{ $type == request()->old('type', $option->type) ? 'selected' : '' }} value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
            <i class="text-danger">{{ $errors->first('type') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.name') (*)</label>
            <input class="form-control" name="name" required type="text" value="{{ request()->old('name', $option->name) }}" />
            <i class="text-danger">{{ $errors->first('name') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.value')</label>
            @includeFirst(
                [
                    'backend/options/value/_'.$option->type,
                    'options::backend/options/value/_'.$option->type,
                    'options::backend/options/value/_textarea',
                ],
                $option
            )
            <i class="text-danger">{{ $errors->first('value') }}</i>
        </div>
    </div>
    <div class="box-footer">
        <input class="btn btn-success btn-xs" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
