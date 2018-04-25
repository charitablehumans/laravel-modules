@extends('cms::frontend/default/layouts/main')

@section('title', $post->title)

@section('content')
    <input name="post_id" type="hidden" value="{{ $post->id }}" />

    <h2>{{ $post->title }}</h2>
    <p class="lead">
        {{ strtolower(trans('cms::cms.by')) }}
        <a href="{{ route('frontend.users.show', ['email' => $post->author->email]) }}">{{ $post->author->name }}</a>
    </p>
    <p>
        <i aria-hidden="true" class="fa fa-clock-o"></i>
        @lang('cms::cms.posted_on')
        {{ (new \Carbon\Carbon($post->updated_at))->format('d M Y H:i') }}
    </p>
    <hr />

    @php
    $mediumId = $post->getPostmetaValue('images');
    $medium = \Modules\Media\Models\Media::getPostById($mediumId);
    @endphp

    <div align="center">
        <a data-fancybox href="{{ $post->getPostmetaValue('images', 'image_url') }}">
            <img alt="{{ optional($medium)->name }}" class="img-responsive" src="{{ $post->getPostmetaValue('images', 'image_thumbnail_url') }}" />
        </a>
    </div>
    <hr />

    <p class="lead">{{ $post->excerpt }}</p>
    <p>{!! $post->content !!}</p>
    <hr />
@endsection
