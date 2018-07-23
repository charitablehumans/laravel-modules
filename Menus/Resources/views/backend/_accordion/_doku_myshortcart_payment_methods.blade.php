<div class="panel panel-default">
    <div class="panel-heading" id="headingDokuMyshortcartPaymentMethods" role="tab">
        <h4 class="panel-title">
            <a aria-controls="collapseDokuMyshortcartPaymentMethods" aria-expanded="true" data-parent="#accordion" data-toggle="collapse" href="#collapseDokuMyshortcartPaymentMethods" role="button">
                {{ config('dokumyshortcart.name') }}
                @lang('cms::cms.payment_methods')
            </a>
        </h4>
    </div>
    <div aria-labelledby="headingDokuMyshortcartPaymentMethods" class="panel-collapse collapse" id="collapseDokuMyshortcartPaymentMethods" role="tabpanel">
        <div class="panel-body">
            <div class="form-group">
                <select class="form-control select2" data-allow-clear="true" data-placeholder="" data-width="100%" id="doku_myshortcart_payment_method">
                    <option></option>
                    @foreach ($term->getDokuMyshortcartPaymentMethodIdOptions() as $dokuMyshortcartPaymentMethodId => $dokuMyshortcartPaymentMethodTitle)
                        <option value="{{ $dokuMyshortcartPaymentMethodId }}">{{ $dokuMyshortcartPaymentMethodTitle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-default btn-xs pull-right" id="doku_myshortcart_payment_method_add" type="button">@lang('cms::cms.add_to_menu')</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    $('#doku_myshortcart_payment_method_add').click(function () {
        var doku_myshortcart_payment_method = document.getElementById('doku_myshortcart_payment_method');

        if (doku_myshortcart_payment_method.value) { // 1. If has value
            var content = document.getElementById('menu_row_template').innerHTML
                .replace('$data_id', doku_myshortcart_payment_method.value)
                .replace('$data_title', doku_myshortcart_payment_method.options[doku_myshortcart_payment_method.selectedIndex].text)
                .replace('$data_title', doku_myshortcart_payment_method.options[doku_myshortcart_payment_method.selectedIndex].text)
                .replace('$data_type', 'doku_myshortcart_payment_method')
                .replace('$data_type', 'doku_myshortcart_payment_method');

            document.querySelectorAll('#nestable .dd-list')[0].innerHTML += content; // 2. Append content to menu nestable
            $(doku_myshortcart_payment_method).val(null).trigger('change'); // 3. Set null
        }
    });
    </script>
@endpush
