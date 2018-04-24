@extends('cms::backend.layouts.main')

@section('title', trans('cms::cms.update'))
@section('content_header', trans('cms::cms.update'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.options.index', request()->query()) }}">@lang('cms::cms.options')</a>
        </li>
        <li class="active">@lang('cms::cms.update')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.options.update', $option->id) }}" method="post">
        {{ method_field('PUT') }}
        <input name="id" type="hidden" value="{{ $option->id }}" />
        @include('options::backend/options/_form')
    </form>
@endsection
