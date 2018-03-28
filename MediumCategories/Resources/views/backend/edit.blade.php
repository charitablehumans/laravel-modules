@extends('backend.layouts.main')

@section('title', __('cms.edit'))
@section('content_header', __('cms.edit'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.medium-categories.index', request()->query()) }}">@lang('cms.medium_categories')</a>
        </li>
        <li class="active">@lang('cms.edit')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.medium-categories.update', $term->id) }}" method="post">
        {{ method_field('PUT') }}
        <input name="id" type="hidden" value="{{ $term->id }}" />
        @include('backend/medium_categories/_form')
    </form>
@endsection
