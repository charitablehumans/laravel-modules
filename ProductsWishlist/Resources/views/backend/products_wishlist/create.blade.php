@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.create'))
@section('content_header', trans('cms::cms.create'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.products-wishlist.index', request()->query()) }}">@lang('cms::cms.products_wishlist')</a>
        </li>
        <li class="active">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.products-wishlist.store') }}" method="post">
        @include('productswishlist::backend/products_wishlist/_form')
    </form>
@endsection
