@extends(request()->query('layout') ? 'cms::backend/layouts/'.request()->query('layout') : 'cms::backend/layouts/main')

@section('title', trans('cms::cms.edit'))
@section('content_header', trans('cms::cms.edit'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.product-testimonials.index', request()->query()) }}">@lang('cms::cms.product_testimonials')</a>
        </li>
        <li class="active">@lang('cms::cms.edit')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.product-testimonials.update', $post->id) }}" method="post">
        {{ method_field('PUT') }}
        <input name="id" type="hidden" value="{{ $post->id }}" />
        @include('producttestimonials::backend/product_testimonials/_form')
    </form>
@endsection
