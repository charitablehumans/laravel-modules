@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.edit'))
@section('content_header', trans('cms::cms.edit'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.tags.index', request()->query()) }}">@lang('cms::cms.tags')</a>
        </li>
        <li class="active">@lang('cms::cms.edit')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.tags.update', $term->id) }}" method="post">
        {{ method_field('PUT') }}
        <input name="id" type="hidden" value="{{ $term->id }}" />
        @include('tags::backend/_form')
    </form>
@endsection
