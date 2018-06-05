@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.create'))
@section('content_header', trans('cms::cms.create'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.posts-users.index', request()->query()) }}">@lang('cms::cms.posts_users')</a>
        </li>
        <li class="active">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.posts-users.store') }}" method="post">
        @include('postsusers::backend/posts_users/_form')
    </form>
@endsection
