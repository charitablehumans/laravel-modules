@extends(request()->query('layout') ? 'backend.layouts.'.request()->query('layout') : 'backend.layouts.main')

@section('title', trans('cms::cms.media'))
@section('content_header', trans('cms::cms.media'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.media')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <a class="btn btn-default btn-sm" href="{{ route('backend.media.create', request()->query()) }}">@lang('cms::cms.create')</a>
        </div>
        <div class="box-body table-responsive">
            <form action="{{ route('backend.media.index') }}" method="get">
                @if (request()->query('layout') == 'media_iframe')
                    <input name="fancybox_to" type="hidden" value="{{ request()->query('fancybox_to') }}" />
                    <input name="layout" type="hidden" value="{{ request()->query('layout') }}" />
                    <input name="mime_type_like" type="hidden" value="{{ request()->query('mime_type_like') }}" />
                @endif

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
                                            <option {{ request()->query('sort') == 'title:asc' ? 'selected' : '' }} value="title:asc">@lang('validation.attributes.name') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'title:desc' ? 'selected' : '' }} value="title:desc">@lang('validation.attributes.name') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'mime_type:asc' ? 'selected' : '' }} value="mime_type:asc">@lang('validation.attributes.mime_type') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'mime_type:desc' ? 'selected' : '' }} value="mime_type:desc">@lang('validation.attributes.mime_type') (Z-A)</option>
                                            @can('backend media trash')
                                                <option {{ request()->query('sort') == 'status:asc' ? 'selected' : '' }} value="status:asc">@lang('validation.attributes.status') (↓)</option>
                                                <option {{ request()->query('sort') == 'status:desc' ? 'selected' : '' }} value="status:desc">@lang('validation.attributes.status') (↑)</option>
                                            @endcan
                                            <option {{ request()->query('sort') == 'updated_at:asc' ? 'selected' : '' }} value="updated_at:asc">@lang('validation.attributes.updated_at') (↓)</option>
                                            <option {{ request()->query('sort') == 'updated_at:desc' ? 'selected' : '' }} value="updated_at:desc">@lang('validation.attributes.updated_at') (↑)</option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th><input class="table_row_checkbox_all" type="checkbox" /></th>
                            <th></th>
                            <th>@lang('validation.attributes.locale')</th>
                            <th>@lang('validation.attributes.name') <input class="form-control input-sm" name="title" type="text" value="{{ request()->query('title') }}" /></th>
                            <th>
                                @lang('validation.attributes.mime_type')
                                <select class="form-control input-sm" name="mime_type">
                                    <option value=""></option>
                                    @foreach ($model->getMimeTypeOptionsAttribute() as $key => $option)
                                        <option {{ $key == request()->query('mime_type') ? 'selected' : '' }} value="{{ $key }}">{{ $option }}</option>
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
                            @can('backend media trash')
                                <th>
                                    @lang('validation.attributes.status')
                                    <select class="form-control input-sm" name="status">
                                        <option value=""></option>
                                        @foreach ($model->getStatusOptionsAttribute() as $key => $option)
                                            <option {{ $key == request()->query('status') ? 'selected' : '' }} value="{{ $key }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </th>
                            @endcan
                            <th>@lang('validation.attributes.updated_at') <input class="datepicker form-control input-sm" data-date-format="yyyy-mm-dd" name="updated_at_date" type="text" value="{{ request()->query('updated_at_date') }}" /></th>
                            <th>
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a
                                    class="btn btn-default btn-xs"
                                    href="{{ route('backend.media.index', array_except(request()->query(), ['page', 'limit', 'sort', 'title', 'mime_type', 'category_id', 'updated_at_date'])) }}"
                                ><i class="fa fa-repeat"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $i => $post)
                            <tr>
                                <td align="center"><input class="table_row_checkbox" name="action_id[]" type="checkbox" value="{{ $post->id }}" /></td>
                                <td>
                                    <a
                                    @if (in_array($post->mime_type, $post->mimeTypeImages)) data-fancybox="group" @endif
                                        href="{{ Storage::url($post->getPostmetaAttachedFile()) }}" target="_blank"
                                        >
                                        <img class="media-object" src="{{ Storage::url($post->getPostmetaAttachedFileThumbnail()) }}" style="height: 32px; width: 32px;" />
                                    </a>
                                </td>
                                <td>
                                    @foreach (config('app.languages') as $languageCode => $languageName)
                                        @if ($post->hasTranslation($languageCode))
                                            <a href="{{ route('backend.media.edit', [$post->id] + ['locale' => $languageCode] + request()->query()) }}">
                                                <img src="{{ asset('images/flags/'.$languageCode.'.gif') }}" />
                                            </a>
                                        @else
                                            <a href="{{ route('backend.media.edit', [$post->id] + ['locale' => $languageCode] + request()->query()) }}">
                                                <i class="fa fa-plus-square"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->mime_type }}</td>
                                <td>
                                    @php
                                    $categories = \Modules\MediumCategories\Models\MediumCategories::search(['id_in' => $post->getPostmetaCategoriesId(), 'sort' => 'name:asc'])->get();
                                    @endphp

                                    @if ($categories)
                                        <ol>
                                            @foreach ($categories as $category)
                                                <li>
                                                    <a href="{{ route('backend.medium-categories.edit', [$category->id]) }}">{{ $category->name }}</a><br />
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                                @can('backend media trash')
                                    <td>@lang('cms::cms.'.$post->status)</td>
                                @endcan
                                <td>{{ $post->updated_at }}</td>
                                <td align="center">
                                    <a class="btn btn-default btn-xs" href="{{ route('backend.media.edit', ['id' => $post->id] + request()->query()) }}"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('backend.media.trash', $post->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this')?')"><i class="fa fa-trash-o"></i></a>
                                    @can('backend media delete')
                                        <a class="btn btn-danger btn-xs" href="{{ route('backend.media.delete', $post->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                    @endcan
                                    @if (request()->query('layout') == 'media_iframe')
                                        <button
                                            class="btn btn-success btn-xs media_choose"
                                            data-attached_file="{{ Storage::url($post->getPostmetaAttachedFile()) }}"
                                            data-attached_file_thumbnail="{{ Storage::url($post->getPostmetaAttachedFileThumbnail()) }}"
                                            data-fancybox_to="{{ request()->query('fancybox_to') }}"
                                            data-media_id="{{ $post->id }}"
                                            data-success-message="@lang('cms::cms.added')"
                                            type="button"
                                        >@lang('cms::cms.choose')</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td align="center" colspan="9">@lang('cms::cms.no_data')</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9">
                                <select class="input-sm" name="action">
                                    <option value="">@lang('cms::cms.action')</option>
                                    @can('backend media trash')
                                        <option value="publish">@lang('cms::cms.publish')</option>
                                    @endcan
                                    <option value="trash">@lang('cms::cms.trash')</option>
                                    @can('backend media delete')
                                        <option value="delete">@lang('cms::cms.delete')</option>
                                    @endcan
                                </select>
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-play-circle"></i></button>
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
