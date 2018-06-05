@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.posts_users'))
@section('content_header', trans('cms::cms.posts_users'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.posts_users')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <a class="btn btn-primary btn-sm" href="{{ route('backend.posts-users.create', request()->query()) }}">@lang('cms::cms.create')</a>
        </div>
        <div class="box-body table-responsive">
            <form action="{{ route('backend.posts-users.index') }}" method="get">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-right" colspan="6">
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
                                            <option {{ request()->query('sort') == 'post_title:asc' ? 'selected' : '' }} value="post_title:asc">@lang('validation.attributes.post_id') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'post_title:desc' ? 'selected' : '' }} value="post_title:desc">@lang('validation.attributes.post_id') (Z-A)</option>
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
                            <th>@lang('validation.attributes.type')</th>
                            <th>
                                @lang('validation.attributes.post_id')<br />
                                <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="post_id">
                                    <option value=""></option>
                                    @foreach ($model->getPostIdTitleOptions() as $postId => $postTitle)
                                        <option {{ $postId == request()->query('post_id') ? 'selected' : '' }} value="{{ $postId }}">{{ $postTitle }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                @lang('validation.attributes.user_id')<br />
                                <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="user_id">
                                    <option value=""></option>
                                    @foreach ($model->getUserIdEmailFilterOptions() as $userId => $userEmail)
                                        <option {{ $userId == request()->query('user_id') ? 'selected' : '' }} value="{{ $userId }}">{{ $userEmail }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                @lang('validation.attributes.updated_at')
                                <input class="datepicker form-control" data-date-format="yyyy-mm-dd" name="updated_at_date" type="text" value="{{ request()->query('updated_at_date') }}" />
                            </th>
                            <th>
                                <button class="btn btn-success btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('backend.posts-users.index') }}"><i class="fa fa-repeat"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $i => $post)
                            <tr>
                                <td align="center"><input class="table_row_checkbox" name="action_id[]" type="checkbox" value="{{ $post->id }}" /></td>
                                <td>{{ $post->type }}</td>
                                <td>{{ $post->post->title }}</td>
                                <td>{{ $post->user->email }}</td>
                                <td>{{ $post->updated_at }}</td>
                                <td align="center">
                                    <a class="btn btn-primary btn-xs" href="{{ route('backend.posts-users.edit', [$post->id] + request()->query()) }}"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('backend.posts-users.delete', $post->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td align="center" colspan="6">@lang('cms::cms.no_data')</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <select class="input-xs" name="action">
                                    <option value="">@lang('cms::cms.action')</option>
                                    <option value="delete">@lang('cms::cms.delete')</option>
                                </select>
                                <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-play-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="6">{{ $posts->appends(request()->query())->links('cms::vendor/pagination/default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
