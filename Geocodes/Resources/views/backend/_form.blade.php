{{ csrf_field() }}
<div class="box">
    <div class="box-body">
        <div class="form-group">
            <label>@lang('validation.attributes.type') (*)</label>
            <select class="form-control" name="type">
                @foreach($geocode->getTypeOptions() as $type => $typeName)
                    <option {{ $type == request()->old('type', $geocode->type) }} value="{{ $type }}">{{ $typeName }}</option>
                @endforeach
            </select>
            <i class="text-danger">{{ $errors->first('type') }}</i>
        </div>
        @if (config('cms.geocodes.code'))
            <div class="form-group">
                <label>@lang('validation.attributes.code') (*)</label>
                <input class="form-control" name="code" required type="text" value="{{ request()->old('code', $geocode->code) }}" />
                <i class="text-danger">{{ $errors->first('code') }}</i>
            </div>
        @endif
        <div class="form-group">
            <label>@lang('validation.attributes.name') (*)</label>
            <input class="form-control" name="name" required type="text" value="{{ request()->old('name', $geocode->name) }}" />
            <i class="text-danger">{{ $errors->first('name') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.postal_code')</label>
            <input class="form-control" maxlength="10" name="postal_code" type="text" value="{{ request()->old('postal_code', $geocode->postal_code) }}" />
            <i class="text-danger">{{ $errors->first('postal_code') }}</i>
        </div>
        @if (config('cms.geocodes.latitude'))
            <div class="form-group">
                <label>@lang('validation.attributes.latitude')</label>
                <input class="form-control text-right" name="number" type="latitude" value="{{ request()->old('latitude', $geocode->latitude) }}" />
                <i class="text-danger">{{ $errors->first('latitude') }}</i>
            </div>
        @endif
        @if (config('cms.geocodes.longitude'))
            <div class="form-group">
                <label>@lang('validation.attributes.longitude')</label>
                <input class="form-control text-right" name="number" type="longitude" value="{{ request()->old('longitude', $geocode->longitude) }}" />
                <i class="text-danger">{{ $errors->first('longitude') }}</i>
            </div>
        @endif
        <div class="form-group">
            <label>@lang('validation.attributes.parent')</label>
            <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="parent_id">
                <option></option>
                @foreach ($geocode->getParentIdOptions() as $parentId => $parentName)
                    <option {{ $parentId == $geocode->id ? 'disabled' : '' }} {{ $parentId == request()->old('parent_id', $geocode->parent_id) ? 'selected' : '' }} value="{{ $parentId }}">{{ $parentName }}</option>
                @endforeach
            </select>
            <i class="text-danger">{{ $errors->first('parent_id') }}</i>
        </div>
        @if (config('cms.geocodes.rajaongkir_id'))
            <div class="form-group">
                <label>@lang('validation.attributes.rajaongkir_id')</label>
                <input class="form-control text-right" name="rajaongkir_id" type="number" value="{{ request()->old('rajaongkir_id', $geocode->rajaongkir_id) }}" />
                <i class="text-danger">{{ $errors->first('rajaongkir_id') }}</i>
            </div>
        @endif
    </div>
    <div class="box-footer">
        <input class="btn btn-default btn-sm" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
