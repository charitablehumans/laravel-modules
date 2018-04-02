<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('validation.attributes.product_status')</label>
            <select class="form-control input-sm" id="post_product_status" name="post_products[status]">
                @foreach ($post->getPostProductStatusOptions() as $status => $statusName)
                    <option {{ $post->getPostProductStatus() == $status ? 'selected' : '' }} value="{{ $status }}">{{ $statusName }}</option>
                @endforeach
            </select>
            <i class="text-danger">{{ $errors->first('post_products[status]') }}</i>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('validation.attributes.stock') (*)</label>
            <input class="form-control input-sm text-right" id="post_product_stock" name="post_products[stock]" type="number" value="{{ $post->getPostProductStock() }}" />
            <i class="text-danger">{{ $errors->first('post_products[stock]') }}</i>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('validation.attributes.sell_price') (*)</label>
            <input class="form-control input-sm text-right" name="post_products[sell_price]" required type="number" value="{{ $post->getPostProductSellPrice() }}" />
            <i class="text-danger">{{ $errors->first('post_products[sell_price]') }}</i>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    $(document).on('change', '#post_product_status', function () {
        $(this).val() == 'always_available' ? $('#post_product_stock').parent().parent().hide() : $('#post_product_stock').parent().parent().show();
    });
    $('#post_product_status').change();
    </script>
@endpush
