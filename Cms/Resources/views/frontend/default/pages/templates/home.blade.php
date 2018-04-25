@extends('cms::frontend/default/layouts/full')

@section('content')
    <input name="post_id" type="hidden" value="{{ $post->id }}" />
    @include('cms::frontend/default/pages/home/carousel')
    @include('cms::frontend/default/pages/home/popup')
@endsection
