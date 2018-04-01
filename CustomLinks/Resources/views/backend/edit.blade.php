@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.edit'))
@section('content_header', trans('cms::cms.edit'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.custom-links.index', request()->query()) }}">@lang('cms::cms.custom_links')</a>
        </li>
        <li class="active">@lang('cms::cms.edit')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.custom-links.update', $post->id) }}" method="post">
        {{ method_field('PUT') }}
        <input name="id" type="hidden" value="{{ $post->id }}" />
        @include('customlinks::backend/_form')
    </form>
@endsection
