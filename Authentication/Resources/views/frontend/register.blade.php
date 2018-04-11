@extends('cms::frontend/default/layouts/full')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('cms::cms.register')</div>
                    <div class="panel-body">
                        <form action="{{ route('frontend.authentication.registerStore') }}" class="form-horizontal" method="post">
                            {{ csrf_field() }}

                            <div class="form-group hidden">
                                <label for="name" class="col-md-4 control-label">Login With</label>
                                <div class="col-md-6">
                                    <a href="{{ route('frontend.authentication.loginSocial', 'facebook') }}" class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                                    <a href="{{ route('frontend.authentication.loginSocial', 'github') }}" class="btn btn-social-icon btn-github"><i class="fa fa-github"></i></a>
                                    <a href="{{ route('frontend.authentication.loginSocial', 'google') }}" class="btn btn-social-icon btn-google"><i class="fa fa-google"></i></a>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="name">@lang('validation.attributes.name') (*)</label>
                                <div class="col-md-6">
                                    <input autofocus class="form-control" id="name" name="name" required type="text" value="{{ old('name') }}" />
                                    <i class="text-danger">{{ $errors->first('name') }}</i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="email">@lang('validation.attributes.email') (*)</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="email" name="email" required type="email" value="{{ old('email') }}" />
                                    <i class="text-danger">{{ $errors->first('email') }}</i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="email">@lang('validation.attributes.phone_number') (*)</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="phone_number" name="phone_number" required type="tel" value="{{ old('phone_number') }}" />
                                    <i class="text-danger">{{ $errors->first('phone_number') }}</i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="email">@lang('validation.attributes.password') (*)</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="password" name="password" required type="password" value="{{ old('password') }}" />
                                    <i class="text-danger">{{ $errors->first('password') }}</i>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button class="btn btn-primary" type="submit">@lang('cms::cms.register')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
