@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.update'))
@section('content_header', trans('cms::cms.update'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.faqs.index', request()->query()) }}">@lang('cms::cms.faqs')</a>
        </li>
        <li class="active">@lang('cms::cms.update')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.faqs.update', $post->id) }}" method="post">
        {{ method_field('PUT') }}
        <input name="id" type="hidden" value="{{ $post->id }}" />
        @include('faqs::backend/_form')
    </form>
@endsection
