@extends('backend.layouts.main')

@section('title', trans('cms::cms.create'))
@section('content_header', trans('cms::cms.create'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.options.index', request()->query()) }}">@lang('cms::cms.options')</a>
        </li>
        <li class="active">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.options.store') }}" method="post">
        @include('options::backend/options/_form')
    </form>
@endsection
