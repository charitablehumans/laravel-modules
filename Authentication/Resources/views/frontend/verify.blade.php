@extends('cms::frontend/layouts/full')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('cms::cms.verify')</div>
                    <div class="panel-body">
                        <form action="{{ route('frontend.authentication.verifyStore') }}" class="form-horizontal" method="post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="email">@lang('validation.attributes.email') (*)</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="email" name="email" readonly type="email" value="{{ $user->email }}" />
                                    <i class="text-danger">{{ $errors->first('email') }}</i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="verification_code">@lang('validation.attributes.verification_code') (*)</label>
                                <div class="col-md-6">
                                    <input autofocus class="form-control" id="verification_code" maxlength="6" minlength="6" name="verification_code" required type="text" value="{{ old('verification_code') }}" />
                                    <i class="text-danger">{{ $errors->first('verification_code') }}</i>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button class="btn btn-primary" type="submit">@lang('cms::cms.verify')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
