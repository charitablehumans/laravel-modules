@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.create'))
@section('content_header', trans('cms::cms.create'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>iPay88</li>
        <li class="active">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('ipay88.backend.ipay88.store') }}" method="post">
        {{ csrf_field() }}
        <div class="box">
            <div class="box-header hidden with-border"></div>
            <div class="box-body">
                <div class="form-group">
                    <label>@lang('validation.attributes.transaction_id')</label>
                    <select class="form-control select2" data-allow-clear="true" data-placeholder="Select" name="id" required>
                        <option value=""></option>
                        @foreach ($transactions as $transaction)
                            <option value="{{ $transaction->id }}">{{ $transaction->id }}</option>
                        @endforeach
                    </select>
                    <i class="text-danger">{{ $errors->first('id') }}</i>
                </div>
                <div class="form-group">
                    <label>PaymentId</label>
                    <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="PaymentId">
                        <option value=""></option>
                        @foreach ($ipay88Transactions->getPaymentMethodIdNameOptions() as $paymentMethodId => $paymentMethodName)
                            <option value="{{ $paymentMethodId }}">{{ $paymentMethodName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>@lang('cms::cms.auto_submit')</label>
                    <select class="form-control select2" name="auto_submit">
                        <option value="0">@lang('cms::cms.no')</option>
                        <option value="1">@lang('cms::cms.yes')</option>
                    </select>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <input class="btn btn-success" type="submit" value="@lang('cms::cms.save')" />
                </div>
            </div>
        </div>
    </form>
@endsection
