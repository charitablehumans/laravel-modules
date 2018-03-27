@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.update'))
@section('content_header', trans('cms::cms.update'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.roles.index', request()->query()) }}">@lang('cms::cms.roles')</a>
        </li>
        <li class="active">@lang('cms::cms.update')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.roles.update', $role->id) }}" method="post">
        {{ method_field('PUT') }}
        <input name="id" type="hidden" value="{{ $role->id }}" />
        @include('roles::backend/_form')
    </form>
@endsection
