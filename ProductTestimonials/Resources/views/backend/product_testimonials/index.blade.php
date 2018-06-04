@extends(request()->query('layout') ? 'cms::backend/layouts/'.request()->query('layout') : 'cms::backend/layouts/main')

@section('title', trans('cms::cms.product_testimonials'))
@section('content_header', trans('cms::cms.product_testimonials'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.product_testimonials')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <a class="btn btn-primary btn-sm" href="{{ route('backend.product-testimonials.create', request()->query()) }}">@lang('cms::cms.create')</a>
        </div>
        <div class="box-body table-responsive">
            <form action="{{ route('backend.product-testimonials.index') }}" method="get">
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
                                            <option {{ request()->query('sort') == 'author_name:asc' ? 'selected' : '' }} value="author_name:asc">@lang('validation.attributes.author') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'author_name:desc' ? 'selected' : '' }} value="author_name:desc">@lang('validation.attributes.author') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'parent_title:asc' ? 'selected' : '' }} value="parent_title:asc">@lang('validation.attributes.parent') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'parent_title:desc' ? 'selected' : '' }} value="parent_title:desc">@lang('validation.attributes.parent') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'content:asc' ? 'selected' : '' }} value="content:asc">@lang('validation.attributes.content') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'content:desc' ? 'selected' : '' }} value="content:desc">@lang('validation.attributes.content') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'post_testimonial_rating:asc' ? 'selected' : '' }} value="post_testimonial_rating:asc">@lang('validation.attributes.rating') (↓)</option>
                                            <option {{ request()->query('sort') == 'post_testimonial_rating:desc' ? 'selected' : '' }} value="post_testimonial_rating:desc">@lang('validation.attributes.rating') (↑)</option>
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
                            <th>
                                @lang('validation.attributes.author')
                                <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="author_id">
                                    <option></option>
                                    @foreach ($model->getAuthorIdOptions() as $authorId => $authorName)
                                        <option {{ $authorId == request()->query('author_id') ? 'selected' : '' }} value="{{ $authorId }}">{{ $authorName }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                @lang('validation.attributes.parent')
                                <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="parent_id">
                                    <option value=""></option>
                                    @foreach ($model->getParentIdTitleOptions() as $parentId => $parentTitle)
                                        <option {{ $parentId == request()->query('parent_id') ? 'selected' : '' }} value="{{ $parentId }}">{{ $parentTitle }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>@lang('validation.attributes.content') <input class="form-control" name="content_like" type="text" value="{{ request()->query('content_like') }}" /></th>
                            <th>
                                @lang('validation.attributes.rating')
                                <select class="form-control" name="post_testimonial_rating_operator">
                                    <option value="">=</option>
                                    <option {{ request()->query('post_testimonial_rating_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                    <option {{ request()->query('post_testimonial_rating_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                </select>
                                <input class="form-control text-right" name="post_testimonial_rating" type="number" value="{{ request()->query('post_testimonial_rating') }}" />
                            </th>
                            <th>
                                @lang('validation.attributes.status')
                                <select class="form-control" name="status">
                                    <option value=""></option>
                                    @foreach ($model->status_options as $statusId => $statusName)
                                        <option {{ $statusId == request()->query('status') ? 'selected' : '' }} value="{{ $statusId }}">{{ $statusName }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                @lang('validation.attributes.updated_at')
                                <input class="datepicker form-control" data-date-format="yyyy-mm-dd" name="updated_at_date" type="text" value="{{ request()->query('updated_at_date') }}" />
                            </th>
                            <th>
                                <button class="btn btn-success btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('backend.product-testimonials.index') }}"><i class="fa fa-repeat"></i></a>
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
                                            <a href="{{ route('backend.product-testimonials.edit', [$post->id] + ['locale' => $languageCode]) }}">
                                                <img src="{{ asset('images/flags/'.$languageCode.'.gif') }}" />
                                            </a>
                                        @else
                                            <a href="{{ route('backend.product-testimonials.edit', [$post->id] + ['locale' => $languageCode]) }}">
                                                <i class="fa fa-plus-square"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ optional($post->author)->name }}</td>
                                <td>{{ optional($post->parent)->title }}</td>
                                <td>{{ strip_tags($post->content) }}</td>
                                <td>{{ optional($post->postTestimonial)->rating }}</td>
                                <td>@lang('cms::cms.'.$post->status)</td>
                                <td>{{ $post->updated_at }}</td>
                                <td align="center">
                                    <a class="btn btn-primary btn-xs" href="{{ route('backend.product-testimonials.edit', [$post->id] + request()->query()) }}"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('backend.product-testimonials.trash', $post->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this')?')"><i class="fa fa-trash-o"></i></a>
                                    @can('backend product testimonials delete')
                                        <a class="btn btn-danger btn-xs" href="{{ route('backend.product-testimonials.delete', $post->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                    @endcan
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
                                    @foreach ($model->getStatusOptions() as $statusId => $statusName)
                                        <option value="{{ $statusId }}">{{ $statusName }}</option>
                                    @endforeach
                                    @can('backend pages delete')
                                        <option value="delete">@lang('cms::cms.delete')</option>
                                    @endcan
                                </select>
                                <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-play-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="9">{{ $posts->appends(request()->query())->links('cms::vendor/pagination/default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
