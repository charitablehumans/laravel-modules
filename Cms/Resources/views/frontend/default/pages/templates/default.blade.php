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

    <div align="center">
        <a data-fancybox href="{{ \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file', true)) }}">
            <img alt="{{ $post->getPostmetaByKey('images')->getMedium()->name }}" class="img-responsive" src="{{ \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file_thumbnail', true)) }}" />
        </a>
    </div>
    <hr />

    <p class="lead">{{ $post->excerpt }}</p>
    <p>{!! $post->content !!}</p>
    <hr />
@endsection
