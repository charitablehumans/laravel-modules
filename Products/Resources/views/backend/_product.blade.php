<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('validation.attributes.product_status')</label>
            <select class="form-control input-sm" id="post_product_status" name="post_products[status]">
                @foreach ($post->getPostProductStatusOptions() as $status => $statusName)
                    <option {{ $status == $post->getPostProductStatus() ? 'selected' : '' }} value="{{ $status }}">{{ $statusName }}</option>
                @endforeach
            </select>
            <i class="text-danger">{{ $errors->first('post_products.status.') }}</i>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('validation.attributes.stock') (*)</label>
            <input class="form-control input-sm text-right" id="post_product_stock" name="post_products[stock]" type="number" value="{{ $post->getPostProductStock() }}" />
            <i class="text-danger">{{ $errors->first('post_products.stock') }}</i>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('validation.attributes.sell_price') (*)</label>
            <input class="form-control input-sm text-right" name="post_products[sell_price]" required type="number" value="{{ $post->getPostProductSellPrice() }}" />
            <i class="text-danger">{{ $errors->first('post_products.sell_price') }}</i>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('validation.attributes.special_sell_price')</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <input name="post_products[special_sell]" type="hidden" value="0" />
                    <input {{ $post->getPostProductSpecialSell() == '1' ? 'checked' : '' }} id="post_product_special_sell" name="post_products[special_sell]" type="checkbox" value="1">
                </span>
                <input class="form-control input-sm text-right" id="post_product_special_sell_price" name="post_products[special_sell_price]" required type="number" value="{{ $post->getPostProductSpecialSellPrice() }}" />
            </div>
            <i class="text-danger">{{ $errors->first('post_products.special_sell_price') }}</i>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('validation.attributes.weight') in Grams (*)</label>
            <input class="form-control input-sm text-right" name="post_products[weight]" required type="number" value="{{ $post->getPostProductWeight() }}" />
            <i class="text-danger">{{ $errors->first('post_products.weight') }}</i>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    $(document).on('change', '#post_product_status', function () {
        $(this).val() == 'always_available' ? $('#post_product_stock').parent().parent().hide() : $('#post_product_stock').parent().parent().show();
    });
    $('#post_product_status').change();
    $(document).on('change', '#post_product_special_sell', function () {
        $(this).is(':checked') ? $('#post_product_special_sell_price').attr('readonly', false) : $('#post_product_special_sell_price').attr('readonly', true);
    });
    $('#post_product_special_sell').change();
    </script>
@endpush
