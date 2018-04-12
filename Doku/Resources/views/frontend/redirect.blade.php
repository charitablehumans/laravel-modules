@extends('cms::frontend/default/layouts/full')

@section('title', trans('cms::cms.payment_success'))
@section('content_header', trans('cms::cms.payment_success'))

@section('content')
    <div class="jumbotron">
        <h1>@lang('cms::cms.payment_success')</h1>
        <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p>
            <a class="btn btn-lg btn-success" href="#" role="button">Sign up today</a>
        </p>
    </div>
@endsection
