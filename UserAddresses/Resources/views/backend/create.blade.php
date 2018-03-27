@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.create'))
@section('content_header', trans('cms::cms.create'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.users.index') }}">@lang('cms::cms.users')</a>
        </li>
        <li>
            <a href="{{ route('backend.users.edit', [$user->id, '#user_addresses']) }}">@lang('cms::cms.user')</a>
        </li>
        <li class="active">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.user-addresses.store') }}" method="post">
        @include('useraddresses::backend/_form')
    </form>
@endsection
