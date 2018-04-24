@extends('backend.layouts.main')

@section('title', trans('cms::cms.options'))
@section('content_header', trans('cms::cms.options'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.options')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <a class="btn btn-default btn-sm" href="{{ route('backend.options.create', request()->query()) }}">@lang('cms::cms.create')</a>
        </div>
        <div class="box-body table-responsive">
            <form action="{{ route('backend.options.index') }}" method="get">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-right" colspan="5">
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
                                            <option {{ request()->query('sort') == 'name:asc' ? 'selected' : '' }} value="name:asc">@lang('validation.attributes.name') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'name:desc' ? 'selected' : '' }} value="name:desc">@lang('validation.attributes.name') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'value:asc' ? 'selected' : '' }} value="value:asc">@lang('validation.attributes.value') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'value:desc' ? 'selected' : '' }} value="value:desc">@lang('validation.attributes.value') (Z-A)</option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th><input class="table_row_checkbox_all" type="checkbox" /></th>
                            <th>@lang('validation.attributes.type') <input class="form-control input-sm" name="type_like" type="text" value="{{ request()->query('type_like') }}" /></th>
                            <th>@lang('validation.attributes.name') <input class="form-control input-sm" name="name_like" type="text" value="{{ request()->query('name_like') }}" /></th>
                            <th>@lang('validation.attributes.value') <input class="form-control input-sm" name="value_like" type="text" value="{{ request()->query('value_like') }}" /></th>
                            <th>
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('backend.options.index') }}"><i class="fa fa-repeat"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($options as $i => $option)
                            <tr>
                                <td align="center"><input class="table_row_checkbox" name="action_id[]" type="checkbox" value="{{ $option->id }}" /></td>
                                <td>{{ $option->type }}</td>
                                <td>{{ $option->name }}</td>
                                <td>{{ $option->value }}</td>
                                <td align="center">
                                    <a class="btn btn-default btn-xs" href="{{ route('backend.options.edit', [$option->id] + request()->query()) }}"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('backend.options.delete', $option->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td align="center" colspan="5">@lang('cms::cms.no_data')</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <select class="input-sm" name="action">
                                    <option value="">@lang('cms::cms.action')</option>
                                    <option value="delete">@lang('cms::cms.delete')</option>
                                </select>
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-play-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="5">{{ $options->appends(request()->query())->links('cms::vendor/pagination/default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
