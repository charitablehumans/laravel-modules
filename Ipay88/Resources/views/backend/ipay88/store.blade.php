@extends('cms::backend/layouts/media_iframe')

@section('content')
    <form action="{{ $ipay88Transaction->getEpaymentEntryUrl() }}" class="{{ request()->input('auto_submit') == '1' ? 'hidden' : '' }}" method="post">
        <div class="box">
            <div class="box-header hidden with-border"></div>
            <div class="box-body">
                <div class="form-group">
                    <label>MerchantCode</label>
                    <input class="form-control" name="MerchantCode" placeholder="ID00001" type="text" value="{{ request()->old('MerchantCode', $ipay88Transaction->MerchantCode) }}" />
                </div>
                <div class="form-group">
                    <label>PaymentId</label>
                    <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="PaymentId">
                        <option value=""></option>
                        @foreach ($ipay88Transaction->getPaymentMethodIdNameOptions() as $paymentMethodId => $paymentMethodName)
                            <option {{ $paymentMethodId == request()->old('PaymentId', $ipay88Transaction->PaymentId) ? 'selected' : '' }} value="{{ $paymentMethodId }}">{{ $paymentMethodName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>RefNo</label>
                    <input class="form-control" name="RefNo" placeholder="A00000001" type="text" value="{{ request()->old('RefNo', $ipay88Transaction->RefNo) }}" />
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <input class="form-control" name="Amount" placeholder="300000" type="text" value="{{ request()->old('Amount', $ipay88Transaction->Amount) }}" />
                </div>
                <div class="form-group">
                    <label>Currency</label>
                    <select class="form-control select2" name="Currency" data-placeholder="IDR" name="id">
                        @foreach ($ipay88Transaction->getCurrencyCurrencyDescription() as $currencyCode => $currencyDescription)
                            <option {{ $currencyCode == request()->old('Currency', $ipay88Transaction->Currency) ? 'selected' : '' }} value="{{ $currencyCode }}">{{ $currencyDescription }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>ProdDesc</label>
                    <input class="form-control" name="ProdDesc" placeholder="Photo Print" type="text" value="{{ request()->old('ProdDesc', $ipay88Transaction->transaction->type) }}" />
                </div>
                <div class="form-group">
                    <label>UserName</label>
                    <input class="form-control" name="UserName" placeholder="John Tan" type="text" value="{{ request()->old('UserName', $ipay88Transaction->UserName) }}" />
                </div>
                <div class="form-group">
                    <label>UserEmail</label>
                    <input class="form-control" name="UserEmail" placeholder="john@hotmail.com" type="text" value="{{ request()->old('UserEmail', $ipay88Transaction->UserEmail) }}" />
                </div>
                <div class="form-group">
                    <label>UserContact</label>
                    <input class="form-control" name="UserContact" placeholder="0126500100" type="text" value="{{ request()->old('UserContact', $ipay88Transaction->UserContact) }}" />
                </div>
                <div class="form-group">
                    <label>Remark</label>
                    <input class="form-control" name="Remark" type="text" value="{{ request()->old('Remark', $ipay88Transaction->Remark) }}" />
                </div>
                <div class="form-group">
                    <label>Lang</label>
                    <input class="form-control" name="Lang" placeholder="UTF-8" type="text" value="{{ request()->old('Lang', $ipay88Transaction->Lang) }}" />
                </div>
                <div class="form-group">
                    <label>Signature</label>
                    <input class="form-control" name="Signature" placeholder="Q/iIMzpjZCrhJ2Yt2dor1PaFEFI=" type="text" value="{{ request()->old('Signature', $ipay88Transaction->Signature) }}" />
                </div>
                <div class="form-group">
                    <label>ResponseURL</label>
                    <input class="form-control" name="ResponseURL" placeholder="http://www.abc.com/payment/response.asp" type="text" value="{{ request()->old('ResponseURL', $ipay88Transaction->ResponseURL) }}" />
                </div>
                <div class="form-group">
                    <label>BackendURL</label>
                    <input class="form-control" name="BackendURL" placeholder="http://www.abc.com/payment/backend_response.asp" type="text" value="{{ request()->old('BackendURL', $ipay88Transaction->BackendURL) }}" />
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <input name="auto_submit" type="hidden" value="{{ request()->input('auto_submit', 1) }}" />
                    <input class="btn btn-success" type="submit" value="@lang('cms::cms.save')" />
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
    if ($('[name=auto_submit]').val() == '1') {
        $('form').submit();
    }
    </script>
@endpush
