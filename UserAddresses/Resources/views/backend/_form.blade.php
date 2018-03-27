{{ csrf_field() }}
<div class="box">
    <div class="box-body">
        <input name="user_id" type="hidden" value="{{ $user->id }}" />
        <div class="form-group">
            <label>@lang('validation.attributes.name') (*)</label>
            <input class="form-control input-sm" name="name" required type="text" value="{{ request()->old('name', $userAddress->name) }}" />
            <i class="text-danger">{{ $errors->first('name') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.phone_number') (*)</label>
            <input class="form-control input-sm" name="phone_number" required type="tel" value="{{ request()->old('phone_number', $userAddress->phone_number) }}" />
            <i class="text-danger">{{ $errors->first('phone_number') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.province_id') (*)</label>
            <input class="form-control input-sm" name="province_id" required type="number" value="{{ request()->old('province_id', $userAddress->province_id) }}" />
            <i class="text-danger">{{ $errors->first('province_id') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.regency_id') (*)</label>
            <input class="form-control input-sm" name="regency_id" required type="number" value="{{ request()->old('regency_id', $userAddress->regency_id) }}" />
            <i class="text-danger">{{ $errors->first('regency_id') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.district_id') (*)</label>
            <input class="form-control input-sm" name="district_id" required type="number" value="{{ request()->old('district_id', $userAddress->district_id) }}" />
            <i class="text-danger">{{ $errors->first('district_id') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.postal_code') (*)</label>
            <input class="form-control input-sm" maxlength="10" name="postal_code" required type="text" value="{{ request()->old('postal_code', $userAddress->postal_code) }}" />
            <i class="text-danger">{{ $errors->first('postal_code') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.address') (*)</label>
            <textarea class="form-control input-sm" name="address" required>{{ request()->old('address', $userAddress->address) }}</textarea>
            <i class="text-danger">{{ $errors->first('address') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.primary') (*)</label>
            <input {{ request()->old('primary', $userAddress->primary) == '1' ? 'checked' : '' }} name="primary" type="checkbox" value="1" />
            <i class="text-danger">{{ $errors->first('primary') }}</i>
        </div>
    </div>
    <div class="box-footer">
        <input class="btn btn-default btn-sm" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
