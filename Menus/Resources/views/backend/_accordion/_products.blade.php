<div class="panel panel-default">
    <div class="panel-heading" id="headingProducts" role="tab">
        <h4 class="panel-title">
            <a aria-controls="collapseProducts" aria-expanded="true" data-parent="#accordion" data-toggle="collapse" href="#collapseProducts" role="button">@lang('cms::cms.products')</a>
        </h4>
    </div>
    <div aria-labelledby="headingProducts" class="panel-collapse collapse" id="collapseProducts" role="tabpanel">
        <div class="panel-body">
            <div class="form-group">
                <select class="form-control select2" data-allow-clear="true" data-placeholder="" data-width="100%" id="product">
                    <option></option>
                    @foreach ($term->getProductIdOptions() as $productId => $productTitle)
                        <option value="{{ $productId }}">{{ $productTitle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-default btn-xs pull-right" id="product_add" type="button">@lang('cms::cms.add_to_menu')</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    $('#product_add').click(function () {
        var product = document.getElementById('product');

        if (product.value) { // 1. If has value
            var content = document.getElementById('menu_row_template').innerHTML
                .replace('$data_id', product.value)
                .replace('$data_title', product.options[product.selectedIndex].text)
                .replace('$data_title', product.options[product.selectedIndex].text)
                .replace('$data_type', 'product')
                .replace('$data_type', 'product');

            document.querySelectorAll('#nestable .dd-list')[0].innerHTML += content; // 2. Append content to menu nestable
            $(product).val(null).trigger('change'); // 3. Set null
        }
    });
    </script>
@endpush
