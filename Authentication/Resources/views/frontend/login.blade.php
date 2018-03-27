@extends('cms::frontend/default/layouts/full')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('cms::cms.login')</div>
                    <div class="panel-body">
                        <form action="{{ route('frontend.authentication.loginStore') }}" class="form-horizontal" method="post">
                            {{ csrf_field() }}

                            <div class="form-group hidden">
                                <label for="name" class="col-md-4 control-label">Login With</label>
                                <div class="col-md-6">
                                    <a href="{{ url('login/facebook') }}" class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                                    <a href="{{ url('login/github') }}" class="btn btn-social-icon btn-github"><i class="fa fa-github"></i></a>
                                    <a href="{{ url('login/google') }}" class="btn btn-social-icon btn-google"><i class="fa fa-google"></i></a>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="email">@lang('validation.attributes.email')</label>
                                <div class="col-md-6">
                                    <input autofocus class="form-control" id="email" name="email" required type="email" value="{{ old('email') }}" />
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="password">@lang('validation.attributes.password')</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="password" name="password" required type="password" />
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input {{ old('remember') ? 'checked' : '' }} name="remember" type="checkbox" />@lang('cms::cms.remember_me')
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button class="btn btn-primary" type="submit">@lang('cms::cms.login')</button>
                                    <a class="btn btn-link" href="{{ route('frontend.authentication.passwordForgot') }}">@lang('cms::cms.forgot_password')?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
