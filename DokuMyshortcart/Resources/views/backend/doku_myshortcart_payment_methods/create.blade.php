@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.create'))
@section('content_header', trans('cms::cms.create'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.doku-myshortcart-payment-methods.index', request()->query()) }}">@lang('cms::cms.payment_methods')</a>
        </li>
        <li class="active">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.doku-myshortcart-payment-methods.store') }}" method="post">
        @include('dokumyshortcart::backend/doku_myshortcart_payment_methods/_form')
    </form>
@endsection
