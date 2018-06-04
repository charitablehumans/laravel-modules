@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.menus'))
@section('content_header', trans('cms::cms.menus'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.menus')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <a class="btn btn-default btn-sm" href="{{ route('backend.menus.create', request()->query()) }}">@lang('cms::cms.create')</a>
        </div>
        <div class="box-body table-responsive">
            <form action="{{ route('backend.menus.index') }}" method="get">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-right" colspan="8">
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
                                            <option {{ request()->query('sort') == 'description:asc' ? 'selected' : '' }} value="description:asc">@lang('validation.attributes.description') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'description:desc' ? 'selected' : '' }} value="description:desc">@lang('validation.attributes.description') (Z-A)</option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th><input class="table_row_checkbox_all" type="checkbox" /></th>
                            <th>@lang('validation.attributes.locale')</th>
                            <th>@lang('validation.attributes.name') <input class="form-control input-sm" name="name" type="text" value="{{ request()->query('name') }}" /></th>
                            <th>@lang('validation.attributes.description') <input class="form-control input-sm" name="description" type="text" value="{{ request()->query('description') }}" /></th>
                            <th>
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('backend.menus.index') }}"><i class="fa fa-repeat"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($terms as $i => $term)
                            <tr>
                                <td align="center"><input class="table_row_checkbox" name="action_id[]" type="checkbox" value="{{ $term->id }}" /></td>
                                <td>
                                    @foreach (config('app.languages') as $languageCode => $languageName)
                                        @if ($term->hasTranslation($languageCode))
                                            <a href="{{ route('backend.menus.edit', [$term->id] + ['locale' => $languageCode]) }}">
                                                <img src="{{ asset('images/flags/'.$languageCode.'.gif') }}" />
                                            </a>
                                        @else
                                            <a href="{{ route('backend.menus.edit', [$term->id] + ['locale' => $languageCode]) }}">
                                                <i class="fa fa-plus-square"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $term->name }}</td>
                                <td>{{ $term->description }}</td>
                                <td align="center">
                                    <a class="btn btn-default btn-xs" href="{{ route('backend.menus.edit', [$term->id] + request()->query()) }}"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('backend.menus.delete', $term->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td align="center" colspan="8">@lang('cms::cms.no_data')</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                <select class="input-xs" name="action">
                                    <option value="">@lang('cms::cms.action')</option>
                                    <option value="delete">@lang('cms::cms.delete')</option>
                                </select>
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-play-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="8">{{ $terms->appends(request()->query())->links('cms::vendor/pagination/default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
