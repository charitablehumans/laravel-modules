@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.geocodes'))
@section('content_header', trans('cms::cms.geocodes'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.geocodes')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <a class="btn btn-primary btn-xs" href="{{ route('backend.geocodes.create', request()->input()) }}">@lang('cms::cms.create')</a>
            <a class="btn btn-danger btn-xs pull-right" href="{{ route('backend.geocodes.sync', request()->input()) }}">@lang('cms::cms.sync')</a>
        </div>
        <div class="box-body table-responsive">
            <form action="{{ route('backend.geocodes.index') }}" method="get">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-right" colspan="11">
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
                                            <option {{ request()->query('sort') == 'type:asc' ? 'selected' : '' }} value="type:asc">@lang('validation.attributes.type') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'type:desc' ? 'selected' : '' }} value="type:desc">@lang('validation.attributes.type') (Z-A)</option>
                                            @if (config('cms.geocodes.code'))
                                                <option {{ request()->query('sort') == 'code:asc' ? 'selected' : '' }} value="code:asc">@lang('validation.attributes.code') (A-Z)</option>
                                                <option {{ request()->query('sort') == 'code:desc' ? 'selected' : '' }} value="code:desc">@lang('validation.attributes.code') (Z-A)</option>
                                            @endif
                                            <option {{ request()->query('sort') == 'name:asc' ? 'selected' : '' }} value="name:asc">@lang('validation.attributes.name') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'name:desc' ? 'selected' : '' }} value="name:desc">@lang('validation.attributes.name') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'postal_code:asc' ? 'selected' : '' }} value="postal_code:asc">@lang('validation.attributes.postal_code') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'postal_code:desc' ? 'selected' : '' }} value="postal_code:desc">@lang('validation.attributes.postal_code') (Z-A)</option>
                                            @if (config('cms.geocodes.latitude'))
                                                <option {{ request()->query('sort') == 'latitude:asc' ? 'selected' : '' }} value="latitude:asc">@lang('validation.attributes.latitude') (↓)</option>
                                                <option {{ request()->query('sort') == 'latitude:desc' ? 'selected' : '' }} value="latitude:desc">@lang('validation.attributes.latitude') (↑)</option>
                                            @endif
                                            @if (config('cms.geocodes.longitude'))
                                                <option {{ request()->query('sort') == 'longitude:asc' ? 'selected' : '' }} value="longitude:asc">@lang('validation.attributes.longitude') (↓)</option>
                                                <option {{ request()->query('sort') == 'longitude:desc' ? 'selected' : '' }} value="longitude:desc">@lang('validation.attributes.longitude') (↑)</option>
                                            @endif
                                            @if (config('cms.geocodes.rajaongkir_id'))
                                                <option {{ request()->query('sort') == 'rajaongkir_id:asc' ? 'selected' : '' }} value="rajaongkir_id:asc">@lang('validation.attributes.rajaongkir_id') (↓)</option>
                                                <option {{ request()->query('sort') == 'rajaongkir_id:desc' ? 'selected' : '' }} value="rajaongkir_id:desc">@lang('validation.attributes.rajaongkir_id') (↑)</option>
                                            @endif
                                            <option {{ request()->query('sort') == 'updated_at:asc' ? 'selected' : '' }} value="updated_at:asc">@lang('validation.attributes.updated_at') (↓)</option>
                                            <option {{ request()->query('sort') == 'updated_at:desc' ? 'selected' : '' }} value="updated_at:desc">@lang('validation.attributes.updated_at') (↑)</option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th><input class="table_row_checkbox_all" type="checkbox" /></th>
                            <th>
                                @lang('validation.attributes.type')
                                <select class="form-control" name="type">
                                    <option value=""></option>
                                    @foreach ($model->getTypeOptions() as $type => $typeName)
                                        <option {{ $type == request()->query('type') ? 'selected' : '' }} value="{{ $type }}">{{ $typeName }}</option>
                                    @endforeach
                                </select>
                            </th>
                            @if (config('cms.geocodes.code'))
                                <th>@lang('validation.attributes.code') <input class="form-control" name="code_like" type="text" value="{{ request()->query('code_like') }}" /></th>
                            @endif
                            <th>@lang('validation.attributes.name') <input class="form-control" name="name_like" type="text" value="{{ request()->query('name_like') }}" /></th>
                            <th>@lang('validation.attributes.postal_code') <input class="form-control" name="postal_code_like" type="text" value="{{ request()->query('postal_code_like') }}" /></th>
                            @if (config('cms.geocodes.latitude'))
                                <th>
                                    @lang('validation.attributes.latitude')
                                    <select class="form-control input-sm" name="latitude_operator">
                                        <option value="">=</option>
                                        <option {{ request()->query('latitude_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                        <option {{ request()->query('latitude_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                    </select>
                                    <input class="form-control input-sm text-right" name="latitude" type="number" value="{{ request()->query('latitude') }}" />
                                </th>
                            @endif
                            @if (config('cms.geocodes.longitude'))
                                <th>
                                    @lang('validation.attributes.longitude')
                                    <select class="form-control input-sm" name="longitude_operator">
                                        <option value="">=</option>
                                        <option {{ request()->query('longitude_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                        <option {{ request()->query('longitude_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                    </select>
                                    <input class="form-control input-sm text-right" name="longitude" type="number" value="{{ request()->query('longitude') }}" />
                                </th>
                            @endif
                            <th>
                                @lang('validation.attributes.parent')<br />
                                <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="parent_id">
                                    <option></option>
                                    @foreach ($model->getParentIdOptions() as $parentId => $parentName)
                                        <option {{ request()->input('parent_id') == $parentId ? 'selected' : '' }} value="{{ $parentId }}">{{ $parentName }}</option>
                                    @endforeach
                                </select>
                            </th>
                            @if (config('cms.geocodes.rajaongkir_id'))
                                <th>
                                    @lang('validation.attributes.rajaongkir_id')<br />
                                    <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="rajaongkir_id">
                                        <option></option>
                                        @foreach ($model->getRajaongkirIdOptions() as $optionId => $optionName)
                                            <option {{ request()->input('rajaongkir_id') == $optionId ? 'selected' : '' }} value="{{ $optionId }}">{{ $optionName }}</option>
                                        @endforeach
                                    </select>
                                </th>
                            @endif
                            <th>
                                @lang('validation.attributes.updated_at')
                                <input autocomplete="off" class="datepicker form-control input-sm" data-date-format="yyyy-mm-dd" name="updated_at_date" type="text" value="{{ request()->query('updated_at_date') }}" />
                            </th>
                            <th>
                                <button class="btn btn-success btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('backend.geocodes.index') }}"><i class="fa fa-repeat"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($geocodes as $i => $geocode)
                            <tr>
                                <td align="center"><input class="table_row_checkbox" name="action_id[]" type="checkbox" value="{{ $geocode->id }}" /></td>
                                <td>@lang('cms::cms.'.$geocode->type)</td>
                                @if (config('cms.geocodes.code'))
                                    <td>{{ $geocode->code }}</td>
                                @endif
                                <td>{{ $geocode->name }}</td>
                                <td>{{ $geocode->postal_code }}</td>
                                @if (config('cms.geocodes.latitude'))
                                    <td align="right">{{ $geocode->latitude }}</td>
                                @endif
                                @if (config('cms.geocodes.longitude'))
                                    <td align="right">{{ $geocode->longitude }}</td>
                                @endif
                                <td>{{ $geocode->parent ? $geocode->parent->name : '' }}</td>
                                @if (config('cms.geocodes.rajaongkir_id'))
                                    <td align="right">{{ $geocode->rajaongkir_id }}</td>
                                @endif
                                <td>{{ $geocode->updated_at }}</td>
                                <td align="center">
                                    <a class="btn btn-primary btn-xs" href="{{ route('backend.geocodes.edit', [$geocode->id] + request()->query()) }}"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('backend.geocodes.delete', $geocode->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td align="center" colspan="11">@lang('cms::cms.no_data')</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="11">
                                <select class="input-xs" name="action">
                                    <option value="">@lang('cms::cms.action')</option>
                                    <option value="delete">@lang('cms::cms.delete')</option>
                                </select>
                                <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-play-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="11">{{ $geocodes->appends(request()->query())->links('cms::vendor/pagination/default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
