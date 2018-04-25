@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.create'))
@section('content_header', trans('cms::cms.create'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.product-categories.index', request()->query()) }}">@lang('cms::cms.product_categories')</a>
        </li>
        <li class="active">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.product-categories.store') }}" method="post">
        @include('productcategories::backend/product_categories/_form')
    </form>
@endsection
