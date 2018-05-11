<div class="panel panel-default">
    <div class="panel-heading" id="headingProductCategories" role="tab">
        <h4 class="panel-title">
            <a aria-controls="collapseProductCategories" aria-expanded="false" data-parent="#accordion" data-toggle="collapse" href="#collapseProductCategories" role="button">@lang('cms::cms.product_categories')</a>
        </h4>
    </div>
    <div aria-labelledby="headingProductCategories" class="panel-collapse collapse" id="collapseProductCategories" role="tabpanel">
        <div class="panel-body">
            <div class="form-group">
                <div class="categories-container">
                    @foreach ($term->getProductCategoriesTree() as $tree)
                        <div class="checkbox">
                            {{ $tree['tree_prefix'] }}
                            <label>
                                <input data-name="{{ $tree['name'] }}" name="product_category[]" type="checkbox" value="{{ $tree['id'] }}" /> {{ $tree['name'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-default pull-right" id="product_category_add" type="button">@lang('cms::cms.add_to_menu')</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    $('#product_category_add').click(function () {
        var product_categories = $('input[name="product_category[]"]');

        $.each(product_categories, function (i, product_category) {
            if (product_category.checked) { // 1. If checked
                var content = document.getElementById('menu_row_template').innerHTML
                    .replace('$data_id', product_category.value)
                    .replace('$data_title', product_category.getAttribute('data-name'))
                    .replace('$data_title', product_category.getAttribute('data-name'))
                    .replace('$data_type', 'product_category')
                    .replace('$data_type', 'product_category');

                document.querySelectorAll('#nestable .dd-list')[0].innerHTML += content; // 2. Append content to menu nestable
                product_category.checked = false; // 3. Set uncheck
            }
        });
    });
    </script>
@endpush
