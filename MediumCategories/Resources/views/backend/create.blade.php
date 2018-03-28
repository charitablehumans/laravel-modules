@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.create'))
@section('content_header', trans('cms::cms.create'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.medium-categories.index', request()->query()) }}">@lang('cms::cms.medium_categories')</a>
        </li>
        <li class="active">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.medium-categories.store') }}" method="post">
        @include('mediumcategories::backend/_form')
    </form>
@endsection
