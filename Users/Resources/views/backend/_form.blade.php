{{ csrf_field() }}
<div class="box">
    <div class="box-body">
        <div class="form-group">
            <label>@lang('validation.attributes.name') (*)</label>
            <input class="form-control input-sm" name="name" required type="text" value="{{ request()->old('name', $user->name) }}" />
            <i class="text-danger">{{ $errors->first('name') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.email') (*)</label>
            <input class="form-control input-sm" name="email" required type="email" value="{{ request()->old('email', $user->email) }}" />
            <i class="text-danger">{{ $errors->first('email') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.phone_number') (*)</label>
            <input class="form-control input-sm" name="phone_number" required type="tel" value="{{ request()->old('phone_number', $user->phone_number) }}" />
            <i class="text-danger">{{ $errors->first('phone_number') }}</i>
        </div>
        <div class="form-group">
            <label>
                @lang('validation.attributes.password')
                @if (! $user->id) (*) @endif
            </label>
            <input class="form-control input-sm" name="password" type="password" />
            <i class="text-danger">{{ $errors->first('password') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.access_token')</label>
            <input class="form-control input-sm" name="access_token" readonly type="text" value="{{ request()->old('access_token', $user->access_token) }}" />
            <i class="text-danger">{{ $errors->first('access_token') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.verified')</label>
            <select class="form-control input-sm" name="verified">
                @foreach($user->getVerifiedOptions() as $verifiedId => $verifiedName)
                    <option {{ request()->old('verified', $user->verified) === $verifiedId ? 'selected' : '' }} value="{{ $verifiedId }}">{{ $verifiedName }}</option>
                @endforeach
            </select>
            <i class="text-danger">{{ $errors->first('access_token') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.verification_code') (*)</label>
            <input class="form-control input-sm" name="verification_code" required type="text" value="{{ request()->old('verification_code', $user->verification_code) }}" />
            <i class="text-danger">{{ $errors->first('verification_code') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.date_of_birth') (*)</label>
            <input class="form-control datepicker input-sm" data-date-format="yyyy-mm-dd" name="date_of_birth" required type="text" value="{{ request()->old('date_of_birth', $user->date_of_birth) }}" />
            <i class="text-danger">{{ $errors->first('date_of_birth') }}</i>
        </div>
        <div class="form-group">
            <label>@lang('validation.attributes.address') (*)</label>
            <textarea class="form-control input-sm" name="address" required>{{ request()->old('address', $user->address) }}</textarea>
            <i class="text-danger">{{ $errors->first('address') }}</i>
        </div>

        @if (config('cms.users.store_id'))
            @can ('backend users store all')
                <div class="form-group">
                    <label>@lang('cms::cms.store')</label>
                    <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="store_id">
                        <option value="0"></option>
                        @foreach ($user->getStoreIdOptions() as $storeId => $storeName)
                            <option {{ $storeId == request()->old('store_id', $user->store_id) ? 'selected' : '' }} value="{{ $storeId }}">{{ $storeName }}</option>
                        @endforeach
                    </select>
                    <i class="text-danger">{{ $errors->first('store_id') }}</i>
                </div>
            @endcan
        @endif

        <div class="row">
            @if (config('cms.users.balance'))
                <div class="col-md-3" id="balance">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            @lang('validation.attributes.balance') (*)
                            @if ($user->id)
                                <a
                                    data-fancybox
                                    data-type="iframe"
                                    href="{{ route('backend.user-balance-histories.index', ['layout' => 'media_iframe', 'user_id' => $user->id]) }}"
                                >»</a>
                            @endif
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <input class="form-control input-sm text-right" name="balance" required type="number" value="{{ request()->old('balance', $user->balance) }}" />
                                <i class="text-danger">{{ $errors->first('balance') }}</i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (config('cms.users.game_token'))
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">@lang('validation.attributes.game_token') (*)</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <input class="form-control input-sm text-right" name="game_token" required type="number" value="{{ request()->old('game_token', $user->game_token) }}" />
                                <i class="text-danger">{{ $errors->first('game_token') }}</i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if (config('cms.user_addresses') && auth()->user()->can('backend user addresses') && $user->id)
            <div class="row" id="user_addresses">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('cms::cms.user_addresses')</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-original-title="Collapse" data-toggle="tooltip" data-widget="collapse" type="button">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th>@lang('validation.attributes.name')</th>
                                        <th>@lang('validation.attributes.address')</th>
                                        <th>@lang('validation.attributes.primary')</th>
                                        <th>
                                            <a class="btn btn-primary btn-xs" href="{{ route('backend.user-addresses.create', ['user_id' => $user->id]) }}"><i class="fa fa-plus"></i></a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($user->userAddresses as $i => $userAddress)
                                        <tr>
                                            <td>
                                                {{ $userAddress->name }}<br />
                                                {{ $userAddress->phone_number }}
                                            </td>
                                            <td>
                                                {{ $userAddress->address }}<br />
                                                {{ $userAddress->district_id }}, {{ optional($userAddress->regency)->name }}<br />
                                                {{ optional($userAddress->province)->name }}, {{ $userAddress->postal_code }}
                                            </td>
                                            <td align="center">
                                                @if ($userAddress->primary == '1')
                                                    <input checked disabled type="checkbox" value="1" />
                                                @endif
                                            </td>
                                            <td align="center">
                                                <a class="btn btn-primary btn-xs" href="{{ route('backend.user-addresses.edit', [$userAddress->id] + ['user_id' => $user->id]) }}"><i class="fa fa-pencil"></i></a>
                                                <a class="btn btn-danger btn-xs" href="{{ route('backend.user-addresses.delete', $userAddress->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td align="center" colspan="4">@lang('cms::cms.no_data')</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (config('cms.users.user_socialites') && auth()->user()->can('backend user socialites') && $user->id)
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('cms::cms.user_socialites')</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-original-title="Collapse" data-toggle="tooltip" data-widget="collapse" type="button">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th>@lang('validation.attributes.provider')</th>
                                        <th>@lang('validation.attributes.client_id')</th>
                                        <th>@lang('validation.attributes.code')</th>
                                        <th>@lang('validation.attributes.email')</th>
                                        <th>@lang('validation.attributes.username')</th>
                                        <th>@lang('validation.attributes.data')</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($user->userSocialites as $i => $userSocialite)
                                        <tr>
                                            <td>{{ $userSocialite->provider }}</td>
                                            <td>{{ $userSocialite->client_id }}</td>
                                            <td>{{ $userSocialite->code }}</td>
                                            <td>{{ $userSocialite->email }}</td>
                                            <td>{{ $userSocialite->username }}</td>
                                            <td>{{ $userSocialite->data }}</td>
                                            <td align="center">
                                                <a class="btn btn-danger btn-xs" href="{{ route('backend.user-socialites.delete', $userSocialite->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td align="center" colspan="7">@lang('cms::cms.no_data')</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            @can('backend roles')
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">@lang('cms::cms.roles')</div>
                        <div class="panel-body" style="max-height: 500px; overflow: auto;">
                            @forelse ($roles as $role)
                                <div class="checkbox">
                                    <label>
                                        <input
                                            @if (is_array(request()->old('roles')))
                                                {{ in_array($role->name, request()->old('roles')) ? 'checked' : '' }}
                                            @else
                                                {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                            @endif
                                            name="roles[]" type="checkbox" value="{{ $role->name }}"
                                        />
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @empty
                                @lang('cms::cms.no_data')
                            @endforelse
                        </div>
                    </div>
                </div>
            @endcan

            @can('backend permissions')
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">@lang('cms::cms.permissions')</div>
                        <div class="panel-body" style="max-height: 500px; overflow: auto;">
                            @if (count($permissions) > 1)
                                <table class="table table-bordered table-condensed">
                                    <tr>
                                        <th>@lang('cms::cms.role_permissions')</th>
                                        <th>@lang('cms::cms.overwrite_permissions')</th>
                                    </tr>
                                    @php ($user_permissions = $user->getDirectPermissions()->pluck('name')->toArray())
                                    @php ($user_roles = $user->getPermissionsViaRoles()->pluck('name')->toArray())
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label>
                                                        <input {{ in_array($permission->name, $user_roles) ? 'checked' : '' }} disabled type="checkbox" />
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="checkbox">
                                                    <label>
                                                        <input
                                                            @if (is_array(request()->old('permissions')))
                                                                {{ in_array($permission->name, request()->old('permissions')) ? 'checked' : '' }}
                                                            @else
                                                                {{ in_array($permission->name, $user_permissions) ? 'checked' : '' }}
                                                            @endif
                                                            name="permissions[]" type="checkbox" value="{{ $permission->name }}"
                                                        />
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                @lang('cms::cms.no_data')
                            @endif
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
    <div class="box-footer">
        <input class="btn btn-default btn-sm" type="submit" value="@lang('cms::cms.save')" />
    </div>
</div>
