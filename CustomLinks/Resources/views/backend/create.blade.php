@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.create'))
@section('content_header', trans('cms::cms.create'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.custom-links.index', request()->query()) }}">@lang('cms::cms.custom_links')</a>
        </li>
        <li class="active">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.custom-links.store') }}" method="post">
        @include('customlinks::backend/_form')
    </form>
@endsection
