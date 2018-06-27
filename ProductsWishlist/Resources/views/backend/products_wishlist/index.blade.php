@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.products_wishlist'))
@section('content_header', trans('cms::cms.products_wishlist'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.products_wishlist')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <a class="btn btn-primary btn-sm" href="{{ route('backend.products-wishlist.create', request()->query()) }}">@lang('cms::cms.create')</a>
        </div>
        <div class="box-body table-responsive">
            <form action="{{ route('backend.products-wishlist.index') }}" method="get">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-right" colspan="5">
                                <div class="form-inline">
                                    <div class="form-group">
                                        @lang('cms::cms.per_page')
                                        <select class="input-xs" name="limit">
                                            <option {{ request()->query('limit') == '10' ? 'selected' : '' }} value="10">10</option>
                                            <option {{ request()->query('limit') == '25' ? 'selected' : '' }} value="25">25</option>
                                            <option {{ request()->query('limit') == '50' ? 'selected' : '' }} value="50">50</option>
                                            <option {{ request()->query('limit') == '100' ? 'selected' : '' }} value="100">100</option>
                                        </select>
                                        @lang('cms::cms.sort')
                                        <select class="input-xs" name="sort">
                                            <option {{ request()->query('sort') == 'post_title:asc' ? 'selected' : '' }} value="post_title:asc">@lang('cms::cms.product') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'post_title:desc' ? 'selected' : '' }} value="post_title:desc">@lang('cms::cms.product') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'user_email:asc' ? 'selected' : '' }} value="user_email:asc">@lang('validation.attributes.user_id') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'user_email:desc' ? 'selected' : '' }} value="user_email:desc">@lang('validation.attributes.user_id') (Z-A)</option>
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
                                @lang('cms::cms.product')<br />
                                <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="post_id">
                                    <option value=""></option>
                                    @foreach ($model->getPostIdTitleOptions() as $postId => $postTitle)
                                        <option {{ $postId == request()->query('post_id') ? 'selected' : '' }} value="{{ $postId }}">{{ $postTitle }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                @lang('cms::cms.user')<br />
                                <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="user_id">
                                    <option value=""></option>
                                    @foreach ($model->getUserIdEmailFilterOptions() as $userId => $userEmail)
                                        <option {{ $userId == request()->query('user_id') ? 'selected' : '' }} value="{{ $userId }}">{{ $userEmail }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                @lang('validation.attributes.updated_at')
                                <input autocomplete="off" class="datepicker form-control" data-date-format="yyyy-mm-dd" name="updated_at_date" type="text" value="{{ request()->query('updated_at_date') }}" />
                            </th>
                            <th>
                                <button class="btn btn-success btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('backend.products-wishlist.index') }}"><i class="fa fa-repeat"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $i => $post)
                            <tr>
                                <td align="center"><input class="table_row_checkbox" name="action_id[]" type="checkbox" value="{{ $post->id }}" /></td>
                                <td>{{ $post->product->title }}</td>
                                <td>{{ $post->user->email }}</td>
                                <td>{{ $post->updated_at }}</td>
                                <td align="center">
                                    <a class="btn btn-primary btn-xs" href="{{ route('backend.products-wishlist.edit', [$post->id] + request()->query()) }}"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('backend.products-wishlist.delete', $post->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td align="center" colspan="5">@lang('cms::cms.no_data')</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <select class="input-xs" name="action">
                                    <option value="">@lang('cms::cms.action')</option>
                                    <option value="delete">@lang('cms::cms.delete')</option>
                                </select>
                                <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-play-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="5">{{ $posts->appends(request()->query())->links('cms::vendor/pagination/default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
