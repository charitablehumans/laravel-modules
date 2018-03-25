@extends('cms::frontend/layouts/full')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('cms::cms.reset_password')</div>
                    <div class="panel-body">
                        <form action="{{ route('frontend.authentication.passwordResetStore') }}" class="form-horizontal" method="post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="email">@lang('validation.attributes.email')</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="email" name="email" readonly required type="email" value="{{ $user->email }}" />
                                    <i class="text-danger">{{ $errors->first('email') }}</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="verification_code">@lang('validation.attributes.verification_code')</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="verification_code" name="verification_code" readonly required type="verification_code" value="{{ $user->verification_code }}" />
                                    <i class="text-danger">{{ $errors->first('verification_code') }}</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">@lang('validation.attributes.password') (*)</label>
                                <div class="col-md-6">
                                    <input autofocus class="form-control" id="password" name="password" required type="password" />
                                    <i class="text-danger">{{ $errors->first('password') }}</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="password_confirmation">@lang('validation.attributes.password_confirmation') (*)</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="password_confirmation" name="password_confirmation" required type="password" />
                                    <i class="text-danger">{{ $errors->first('password_confirmation') }}</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button class="btn btn-primary" type="submit">@lang('cms::cms.reset_password')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
