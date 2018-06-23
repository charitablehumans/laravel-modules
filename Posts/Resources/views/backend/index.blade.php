@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.posts'))
@section('content_header', trans('cms::cms.posts'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.posts')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <a class="btn btn-primary btn-xs" href="{{ route('backend.posts.create', request()->query()) }}">@lang('cms::cms.create')</a>
        </div>
        <div class="box-body table-responsive">
            <form action="{{ route('backend.posts.index') }}" method="get">
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
                                            <option {{ request()->query('sort') == 'title:asc' ? 'selected' : '' }} value="title:asc">@lang('validation.attributes.title') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'title:desc' ? 'selected' : '' }} value="title:desc">@lang('validation.attributes.title') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'author_name:asc' ? 'selected' : '' }} value="author_name:asc">@lang('validation.attributes.author') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'author_name:desc' ? 'selected' : '' }} value="author_name:desc">@lang('validation.attributes.author') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'status:asc' ? 'selected' : '' }} value="status:asc">@lang('validation.attributes.status') (↓)</option>
                                            <option {{ request()->query('sort') == 'status:desc' ? 'selected' : '' }} value="status:desc">@lang('validation.attributes.status') (↑)</option>
                                            <option {{ request()->query('sort') == 'updated_at:asc' ? 'selected' : '' }} value="updated_at:asc">@lang('validation.attributes.updated_at') (↓)</option>
                                            <option {{ request()->query('sort') == 'updated_at:desc' ? 'selected' : '' }} value="updated_at:desc">@lang('validation.attributes.updated_at') (↑)</option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th><input class="table_row_checkbox_all" type="checkbox" /></th>
                            <th>@lang('validation.attributes.locale')</th>
                            <th>@lang('validation.attributes.title') <input class="form-control input-sm" name="title_like" type="text" value="{{ request()->query('title_like') }}" /></th>
                            <th>
                                @lang('validation.attributes.author')
                                <select class="form-control input-sm" name="author_id">
                                    <option value=""></option>
                                    @foreach ($model->getAuthorIdOptions() as $authorId => $authorName)
                                        <option {{ $authorId == request()->query('author_id') ? 'selected' : '' }} value="{{ $authorId }}">{{ $authorName }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                @lang('cms::cms.categories')
                                <select class="form-control input-sm" name="category_id">
                                    <option value=""></option>
                                    @foreach ($model->getCategoryIdOptions() as $categoryId => $categoryName)
                                        <option {{ $categoryId == request()->input('category_id') ? 'selected' : '' }} value="{{ $categoryId }}">{{ $categoryName }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                @lang('validation.attributes.status')
                                <select class="form-control input-sm" name="status">
                                    <option value=""></option>
                                    @foreach ($model->status_options as $statusId => $statusName)
                                        <option {{ $statusId == request()->query('status') ? 'selected' : '' }} value="{{ $statusId }}">{{ $statusName }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                @lang('validation.attributes.updated_at')
                                <input class="datepicker form-control input-sm" data-date-format="yyyy-mm-dd" name="updated_at_date" type="text" value="{{ request()->query('updated_at_date') }}" />
                            </th>
                            <th>
                                <button class="btn btn-success btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('backend.posts.index') }}"><i class="fa fa-repeat"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $i => $post)
                            <tr>
                                <td align="center"><input class="table_row_checkbox" name="action_id[]" type="checkbox" value="{{ $post->id }}" /></td>
                                <td>
                                    @foreach (config('app.languages') as $languageCode => $languageName)
                                        @if ($post->hasTranslation($languageCode))
                                            <a href="{{ route('backend.posts.edit', [$post->id] + ['locale' => $languageCode]) }}">
                                                <img src="{{ asset('images/flags/'.$languageCode.'.gif') }}" />
                                            </a>
                                        @else
                                            <a href="{{ route('backend.posts.edit', [$post->id] + ['locale' => $languageCode]) }}">
                                                <i class="fa fa-plus-square"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->author->name }}</td>
                                <td>
                                    @if ($categories = $post->getPostmetaByKey('categories')->getCategories())
                                        <ol>
                                            @foreach ($categories as $category)
                                                <li>
                                                    <a href="{{ route('backend.categories.edit', [$category->id]) }}">{{ $category->name }}</a><br />
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                                <td>@lang('cms::cms.'.$post->status)</td>
                                <td>{{ $post->updated_at }}</td>
                                <td align="center">
                                    <a class="btn btn-primary btn-xs" href="{{ route('backend.posts.edit', [$post->id] + request()->query()) }}"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('backend.posts.trash', $post->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this')?')"><i class="fa fa-trash-o"></i></a>
                                    @can('backend posts delete')
                                        <a class="btn btn-danger btn-xs" href="{{ route('backend.posts.delete', $post->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                    @endcan
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
                                    @foreach ($model->getStatusOptions() as $statusId => $statusName)
                                        <option value="{{ $statusId }}">{{ $statusName }}</option>
                                    @endforeach
                                    @can('backend posts delete')
                                        <option value="delete">@lang('cms::cms.delete')</option>
                                    @endcan
                                </select>
                                <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-play-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="8">{{ $posts->appends(request()->query())->links('cms::vendor/pagination/default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
