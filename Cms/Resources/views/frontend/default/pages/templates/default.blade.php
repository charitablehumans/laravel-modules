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
    $imageId = collect($post->getPostmetaImagesId())->first();
    $medium = \Modules\Media\Models\Media::find($imageId);
    @endphp

    <!-- Preview Image -->
    <div align="center">
        <a data-fancybox href="{{ $medium ? Storage::url($medium->getPostmetaAttachedFile()) : 'http://placehold.it/900x300' }}" target="_blank">
            <img alt="{{ $medium ? $medium->name : '' }}" class="img-responsive" src="{{ $medium ? Storage::url($medium->getPostmetaAttachedFileThumbnail()) : 'http://placehold.it/900x300' }}" />
        </a>
        <a data-fancybox href="{{ $post->getPostmetaValue('attached_file', 'image_url') }}">
            <img alt="{{ $medium ? $medium->name : '' }}" class="img-responsive" src="{{ $post->getPostmetaValue('attached_file', 'image_thumbnail_url') }}" />
        </a>
    </div>
    <hr />

    <p class="lead">{{ $post->excerpt }}</p>
    <p>{!! $post->content !!}</p>
    <hr />
@endsection
