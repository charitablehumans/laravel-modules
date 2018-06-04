@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.tags'))
@section('content_header', trans('cms::cms.tags'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.tags')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <a class="btn btn-default btn-sm" href="{{ route('backend.tags.create', request()->query()) }}">@lang('cms::cms.create')</a>
        </div>
        <div class="box-body table-responsive">
            <form action="{{ route('backend.tags.index') }}" method="get">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-right" colspan="7">
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
                                            <option {{ request()->query('sort') == 'slug:asc' ? 'selected' : '' }} value="slug:asc">@lang('validation.attributes.slug') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'slug:desc' ? 'selected' : '' }} value="slug:desc">@lang('validation.attributes.slug') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'description:asc' ? 'selected' : '' }} value="description:asc">@lang('validation.attributes.description') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'description:desc' ? 'selected' : '' }} value="description:desc">@lang('validation.attributes.description') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'count:asc' ? 'selected' : '' }} value="count:asc">@lang('validation.attributes.count') (↓)</option>
                                            <option {{ request()->query('sort') == 'count:desc' ? 'selected' : '' }} value="count:desc">@lang('validation.attributes.count') (↑)</option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th><input class="table_row_checkbox_all" type="checkbox" /></th>
                            <th>@lang('validation.attributes.locale')</th>
                            <th>@lang('validation.attributes.name') <input class="form-control input-sm" name="name_like" type="text" value="{{ request()->query('name_like') }}" /></th>
                            <th>@lang('validation.attributes.slug') <input class="form-control input-sm" name="slug_like" type="text" value="{{ request()->query('slug_like') }}" /></th>
                            <th>@lang('validation.attributes.description') <input class="form-control input-sm" name="description_like" type="text" value="{{ request()->query('description_like') }}" /></th>
                            <th>
                                @lang('validation.attributes.count')
                                <select class="form-control input-sm" name="count_operator">
                                    <option value="">=</option>
                                    <option {{ request()->query('count_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                    <option {{ request()->query('count_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                </select>
                                <input class="form-control input-sm text-right" name="count" type="number" value="{{ request()->query('count') }}" />
                            </th>
                            <th>
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('backend.tags.index') }}"><i class="fa fa-repeat"></i></a>
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
                                            <a href="{{ route('backend.tags.edit', [$term->id] + ['locale' => $languageCode]) }}">
                                                <img src="{{ asset('images/flags/'.$languageCode.'.gif') }}" />
                                            </a>
                                        @else
                                            <a href="{{ route('backend.tags.edit', [$term->id] + ['locale' => $languageCode]) }}">
                                                <i class="fa fa-plus-square"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $term->name }}</td>
                                <td>{{ $term->slug }}</td>
                                <td>{{ $term->description }}</td>
                                <td align="right">{{ $term->count }}</td>
                                <td align="center">
                                    <a class="btn btn-default btn-xs" href="{{ route('backend.tags.edit', [$term->id] + request()->query()) }}"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('backend.tags.delete', $term->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td align="center" colspan="7">@lang('cms::cms.no_data')</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <select class="input-xs" name="action">
                                    <option value="">@lang('cms::cms.action')</option>
                                    <option value="delete">@lang('cms::cms.delete')</option>
                                </select>
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-play-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="7">{{ $terms->appends(request()->query())->links('cms::vendor/pagination/default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
