@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.edit'))
@section('content_header', trans('cms::cms.edit'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.doku-myshortcart-payment-methods.index', request()->query()) }}">@lang('cms::cms.payment_methods')</a>
        </li>
        <li class="active">@lang('cms::cms.edit')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.doku-myshortcart-payment-methods.update', $post->id) }}" method="post">
        {{ method_field('PUT') }}
        <input name="id" type="hidden" value="{{ $post->id }}" />
        @include('dokumyshortcart::backend/doku_myshortcart_payment_methods/_form')
    </form>
@endsection
