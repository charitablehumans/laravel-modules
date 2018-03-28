@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.edit'))
@section('content_header', trans('cms::cms.edit'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.users.index') }}">@lang('cms::cms.users')</a>
        </li>
        <li>
            <a href="{{ route('backend.users.edit', [$user->id, '#user_addresses']) }}">@lang('cms::cms.user')</a>
        </li>
        <li class="active">@lang('cms::cms.edit')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.user-addresses.update', $userAddress->id) }}" method="post">
        {{ method_field('PUT') }}
        @include('useraddresses::backend/_form')
    </form>
@endsection
