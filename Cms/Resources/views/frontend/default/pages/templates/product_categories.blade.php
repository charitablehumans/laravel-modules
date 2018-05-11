@extends('cms::frontend/default/layouts/full')

@section('breadcrumb')
    <div class="row">
        <div class="col-md-12">@include('cms::frontend/default/pages/product_categories/breadcrumb')</div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">@include('cms::frontend/default/pages/product_categories/product_categories')</div>
        <div class="col-md-9">@include('cms::frontend/default/pages/product_categories/products')</div>
    </div>
@endsection
