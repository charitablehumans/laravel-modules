@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.create'))
@section('content_header', trans('cms::cms.create'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.menus.index', request()->query()) }}">@lang('cms::cms.menus')</a>
        </li>
        <li class="active">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.menus.store') }}" id="menu_form" method="post">
        @include('menus::backend/_form')
    </form>
@endsection
