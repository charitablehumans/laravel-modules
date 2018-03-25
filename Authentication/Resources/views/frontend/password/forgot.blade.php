@extends('cms::frontend/layouts/full')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('cms::cms.forgot_password')</div>
                    <div class="panel-body">
                        <form action="{{ route('frontend.authentication.passwordForgot') }}" class="form-horizontal" method="post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="email">@lang('validation.attributes.email') (*)</label>
                                <div class="col-md-6">
                                    <input autofocus class="form-control" id="email" name="email" required type="email" value="{{ old('email') }}" />
                                    <i class="text-danger">{{ $errors->first('email') }}</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button class="btn btn-primary" type="submit">@lang('cms::cms.send_password_reset_link')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
