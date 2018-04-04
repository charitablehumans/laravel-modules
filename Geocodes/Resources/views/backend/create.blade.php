@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.create'))
@section('content_header', trans('cms::cms.create'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.geocodes.index', request()->query()) }}">@lang('cms::cms.geocodes')</a>
        </li>
        <li class="active">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.geocodes.store') }}" method="post">
        @include('geocodes::backend/_form')
    </form>
@endsection
