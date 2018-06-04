@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.users'))
@section('content_header', trans('cms::cms.users'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.users')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <a class="btn btn-default btn-sm" href="{{ route('backend.users.create', request()->input()) }}">@lang('cms::cms.create')</a>
        </div>
        <div class="box-body table-responsive">
            <form action="{{ route('backend.users.index') }}" method="get">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-right" colspan="9">
                                <div class="form-inline">
                                    <div class="form-group">
                                        @lang('cms::cms.per_page')
                                        <select class="input-sm" name="limit">
                                            <option {{ request()->query('limit') == '10' ? 'selected' : '' }} value="10">10</option>
                                            <option {{ request()->query('limit') == '25' ? 'selected' : '' }} value="25">25</option>
                                            <option {{ request()->query('limit') == '50' ? 'selected' : '' }} value="50">50</option>
                                            <option {{ request()->query('limit') == '100' ? 'selected' : '' }} value="100">100</option>
                                        </select>
                                        @lang('cms::cms.sort')
                                        <select class="input-sm" name="sort">
                                            <option {{ request()->query('sort') == 'name:asc' ? 'selected' : '' }} value="name:asc">@lang('validation.attributes.name') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'name:desc' ? 'selected' : '' }} value="name:desc">@lang('validation.attributes.name') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'email:asc' ? 'selected' : '' }} value="email:asc">@lang('validation.attributes.email') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'email:desc' ? 'selected' : '' }} value="email:desc">@lang('validation.attributes.email') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'verified:asc' ? 'selected' : '' }} value="verified:asc">@lang('validation.attributes.verified') (↓)</option>
                                            <option {{ request()->query('sort') == 'verified:desc' ? 'selected' : '' }} value="verified:desc">@lang('validation.attributes.verified') (↑)</option>
                                            @if (config('cms.users.store_id'))
                                                @can ('backend users store all')
                                                    <option {{ request()->query('sort') == 'store_name:asc' ? 'selected' : '' }} value="store_name:asc">@lang('cms::cms.store_name') (↓)</option>
                                                    <option {{ request()->query('sort') == 'store_name:desc' ? 'selected' : '' }} value="store_name:desc">@lang('cms::cms.store_name') (↑)</option>
                                                @endcan
                                            @endif
                                            @if (config('cms.users.balance'))
                                                <option {{ request()->query('sort') == 'balance:asc' ? 'selected' : '' }} value="balance:asc">@lang('cms::cms.balance') (↓)</option>
                                                <option {{ request()->query('sort') == 'balance:desc' ? 'selected' : '' }} value="balance:desc">@lang('cms::cms.balance') (↑)</option>
                                            @endif
                                            @if (config('cms.users.game_token'))
                                                <option {{ request()->query('sort') == 'game_token:asc' ? 'selected' : '' }} value="game_token:asc">@lang('validation.attributes.game_token') (↓)</option>
                                                <option {{ request()->query('sort') == 'game_token:desc' ? 'selected' : '' }} value="game_token:desc">@lang('validation.attributes.game_token') (↑)</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th><input class="table_row_checkbox_all" type="checkbox" /></th>
                            <th>@lang('validation.attributes.name') <input class="form-control" name="name" type="text" value="{{ request()->query('name') }}" /></th>
                            <th>@lang('validation.attributes.email') <input class="form-control" name="email" type="text" value="{{ request()->query('email') }}" /></th>
                            <th>
                                @lang('validation.attributes.verified')
                                <select class="form-control" name="verified">
                                    <option value=""></option>
                                    @foreach ($model->getVerifiedOptions() as $verifiedId => $verifiedName)
                                        <option {{ (string) $verifiedId == request()->query('verified') ? 'selected' : '' }} value="{{ $verifiedId }}">{{ $verifiedName }}</option>
                                    @endforeach
                                </select>
                            </th>
                            @if (config('cms.users.store_id'))
                                @can ('backend users store all')
                                    <th>
                                        @lang('cms::cms.store')
                                        <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="store_id">
                                            <option value=""></option>
                                            @foreach ($model->getStoreIdNameOptions() as $storeId => $storeName)
                                                <option {{ (string) $storeId == request()->query('store_id') ? 'selected' : '' }} value="{{ $storeId }}">{{ $storeName }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                @endcan
                            @endif
                            @if (config('cms.users.balance'))
                                <th>
                                    @lang('cms::cms.balance')
                                    <select class="form-control" name="balance_amount_operator">
                                        <option value="">=</option>
                                        <option {{ request()->query('balance_amount_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                        <option {{ request()->query('balance_amount_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                    </select>
                                    <input class="form-control text-right" name="balance_amount" type="number" value="{{ request()->query('balance_amount') }}" />
                                </th>
                            @endif
                            @if (config('cms.users.game_token'))
                                <th>
                                    @lang('validation.attributes.game_token')
                                    <select class="form-control" name="game_token_operator">
                                        <option value="">=</option>
                                        <option {{ request()->query('game_token_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                        <option {{ request()->query('game_token_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                    </select>
                                    <input class="form-control text-right" name="game_token" type="number" value="{{ request()->query('game_token') }}" />
                                </th>
                            @endif
                            @can('backend roles')
                                <th>
                                    @lang('cms::cms.roles')
                                    <select class="form-control" name="role_id">
                                        <option value=""></option>
                                        @foreach ($role->getNameOptionsAttribute() as $key => $role)
                                            <option {{ $key == request()->query('role_id') ? 'selected' : '' }} value="{{ $key }}">{{ $role }}</option>
                                        @endforeach
                                    </select>
                                </th>
                            @endcan
                            <th>
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('backend.users.index') }}"><i class="fa fa-repeat"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $i => $user)
                            <tr>
                                <td align="center"><input class="table_row_checkbox" name="action_id[]" type="checkbox" value="{{ $user->id }}" /></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->getVerifiedName() }}</td>
                                @if (config('cms.users.store_id'))
                                    @can ('backend users store all')
                                        <td>{{ optional($user->store)->name }}</td>
                                    @endcan
                                @endif
                                @if (config('cms.users.balance'))
                                    <td align="right">{{ number_format($user->balance) }}</td>
                                @endif
                                @if (config('cms.users.game_token'))
                                    <td align="right">{{ number_format($user->game_token) }}</td>
                                @endif
                                @can('backend roles')
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <a href="{{ route('backend.roles.edit', $role->id) }}">{{ $role->name }}</a>
                                            <br />
                                        @endforeach
                                    </td>
                                @endcan
                                <td align="center">
                                    <a class="btn btn-default btn-xs" href="{{ route('backend.users.edit', [$user->id] + request()->query()) }}"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('backend.users.delete', $user->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td align="center" colspan="9">@lang('cms::cms.no_data')</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9">
                                <select class="input-xs" name="action">
                                    <option value="">@lang('cms::cms.action')</option>
                                    <option value="delete">@lang('cms::cms.delete')</option>
                                </select>
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-play-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="9">{{ $users->appends(request()->query())->links('cms::vendor.pagination.default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
