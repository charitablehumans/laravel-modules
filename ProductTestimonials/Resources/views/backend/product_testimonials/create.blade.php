@extends(request()->query('layout') ? 'cms::backend/layouts/'.request()->query('layout') : 'cms::backend/layouts/main')

@section('title', trans('cms::cms.create'))
@section('content_header', trans('cms::cms.create'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.product-testimonials.index', request()->query()) }}">@lang('cms::cms.product_testimonials')</a>
        </li>
        <li class="active">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.product-testimonials.store') }}" method="post">
        @include('producttestimonials::backend/product_testimonials/_form')
    </form>
@endsection
