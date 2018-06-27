@extends('cms::frontend/default/layouts/full')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('cms::cms.profile')</div>
                    <div class="panel-body">
                        <form action="{{ route('frontend.users.profileUpdate') }}" class="form-horizontal" method="post">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="name">@lang('validation.attributes.name') (*)</label>
                                <div class="col-md-6">
                                    <input autofocus class="form-control" id="name" name="name" required type="text" value="{{ request()->old('name', $user->name) }}" />
                                    <i class="text-danger">{{ $errors->first('name') }}</i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="email">@lang('validation.attributes.email') (*)</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="email" name="email" required type="email" value="{{ request()->old('email', $user->email) }}" />
                                    <i class="text-danger">{{ $errors->first('email') }}</i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="phone_number">@lang('validation.attributes.phone_number') (*)</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="phone_number" name="phone_number" required type="tel" value="{{ request()->old('phone_number', $user->phone_number) }}" />
                                    <i class="text-danger">{{ $errors->first('phone_number') }}</i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="password">@lang('validation.attributes.password')</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="password" name="password" type="password" />
                                    <i class="text-danger">{{ $errors->first('password') }}</i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="date_of_birth">@lang('validation.attributes.date_of_birth') (*)</label>
                                <div class="col-md-6">
                                    <input autocomplete="off" class="form-control datepicker" data-date-format="yyyy-mm-dd" id="date_of_birth" name="date_of_birth" required type="text" value="{{ request()->old('date_of_birth', $user->date_of_birth) }}" />
                                    <i class="text-danger">{{ $errors->first('date_of_birth') }}</i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="address">@lang('validation.attributes.address') (*)</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="address" name="address" required>{{ request()->old('address', $user->address) }}</textarea>
                                    <i class="text-danger">{{ $errors->first('address') }}</i>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button class="btn btn-primary" type="submit">@lang('cms::cms.save')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
