<div class="panel panel-default">
    <div class="panel-heading" id="headingPaymentChannels" role="tab">
        <h4 class="panel-title">
            <a aria-controls="collapsePaymentChannels" aria-expanded="true" data-parent="#accordion" data-toggle="collapse" href="#collapsePaymentChannels" role="button">@lang('cms::cms.payment_channels')</a>
        </h4>
    </div>
    <div aria-labelledby="headingPaymentChannels" class="panel-collapse collapse" id="collapsePaymentChannels" role="tabpanel">
        <div class="panel-body">
            <div class="form-group">
                <select class="form-control select2" data-allow-clear="true" data-placeholder="" data-width="100%" id="payment_channel">
                    <option></option>
                    @foreach ($term->getDokuMyshortcartPaymentMethodIdOptions() as $paymentChannelId => $paymentChannelTitle)
                        <option value="{{ $paymentChannelId }}">{{ $paymentChannelTitle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-default btn-xs pull-right" id="payment_channel_add" type="button">@lang('cms::cms.add_to_menu')</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    $('#payment_channel_add').click(function () {
        var payment_channel = document.getElementById('payment_channel');

        if (payment_channel.value) { // 1. If has value
            var content = document.getElementById('menu_row_template').innerHTML
                .replace('$data_id', payment_channel.value)
                .replace('$data_title', payment_channel.options[payment_channel.selectedIndex].text)
                .replace('$data_title', payment_channel.options[payment_channel.selectedIndex].text)
                .replace('$data_type', 'payment_channel')
                .replace('$data_type', 'payment_channel');

            document.querySelectorAll('#nestable .dd-list')[0].innerHTML += content; // 2. Append content to menu nestable
            $(payment_channel).val(null).trigger('change'); // 3. Set null
        }
    });
    </script>
@endpush
