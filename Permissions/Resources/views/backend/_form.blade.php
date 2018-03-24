{{ csrf_field() }}
<div class="box">
    <div class="box-body">
        <div class="form-group">
            <label>@lang('validation.attributes.name') (*)</label>
            <input class="form-control input-sm" name="name" required type="text" value="{{ request()->old('name', $permission->name) }}" />
            <i class="text-danger">{{ $errors->first('name') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.guard_name') (*)</label>
            <input class="form-control input-sm" name="guard_name" readonly required type="text" value="{{ request()->old('guard_name', $permission->guard_name) }}" />
            <i class="text-danger">{{ $errors->first('guard_name') }}</i>
        </div>
    </div>
    <div class="box-footer">
        <input class="btn btn-default btn-sm" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
