@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.edit'))
@section('content_header', trans('cms::cms.edit'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.posts-users.index', request()->query()) }}">@lang('cms::cms.posts_users')</a>
        </li>
        <li class="active">@lang('cms::cms.edit')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.posts-users.update', $model->id) }}" method="post">
        {{ method_field('PUT') }}
        <input name="id" type="hidden" value="{{ $model->id }}" />
        @include('postsusers::backend/posts_users/_form')
    </form>
@endsection
