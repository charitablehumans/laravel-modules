@extends('cms::frontend/default/layouts/full')

@section('content')
    <input name="post_id" type="hidden" value="{{ $post->id }}" />
    @include('cms::frontend/default/pages/home/carousel')
    @include('cms::frontend/default/pages/home/services')
    @include('cms::frontend/default/pages/home/products/new_arrival')
    @include('cms::frontend/default/pages/home/product_categories/featured')
    @include('cms::frontend/default/pages/home/product_testimonials/featured/carousel')
    @include('cms::frontend/default/pages/home/product_testimonials/latest/carousel')
    @include('cms::frontend/default/pages/home/popup')
@endsection
