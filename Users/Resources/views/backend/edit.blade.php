@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.update'))
@section('content_header', trans('cms::cms.update'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.users.index', request()->query()) }}">@lang('cms::cms.users')</a>
        </li>
        <li class="active">@lang('cms::cms.update')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.users.update', $user->id) }}" method="post">
        {{ method_field('PUT') }}
        <input name="id" type="hidden" value="{{ $user->id }}" />
        @include('users::backend/_form')
    </form>
@endsection
