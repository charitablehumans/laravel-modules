<div class="panel panel-default">
    <div class="panel-heading" id="headingCategories" role="tab">
        <h4 class="panel-title">
            <a aria-controls="collapseCategories" aria-expanded="false" data-parent="#accordion" data-toggle="collapse" href="#collapseCategories" role="button">@lang('cms::cms.categories')</a>
        </h4>
    </div>
    <div aria-labelledby="headingCategories" class="panel-collapse collapse" id="collapseCategories" role="tabpanel">
        <div class="panel-body">
            <div class="form-group">
                <div class="categories-container">
                    @foreach ($term->getCategoriesTree() as $tree)
                        <div class="checkbox">
                            {{ $tree['tree_prefix'] }}
                            <label>
                                <input data-name="{{ $tree['name'] }}" name="category[]" type="checkbox" value="{{ $tree['id'] }}" /> {{ $tree['name'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-default pull-right" id="category_add" type="button">@lang('cms::cms.add_to_menu')</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    $('#category_add').click(function () {
        var categories = $('input[name="category[]"]');

        $.each(categories, function (i, category) {
            if (category.checked) { // 1. If checked
                var content = document.getElementById('menu_row_template').innerHTML
                    .replace('$data_id', category.value)
                    .replace('$data_title', category.getAttribute('data-name'))
                    .replace('$data_title', category.getAttribute('data-name'))
                    .replace('$data_type', 'category')
                    .replace('$data_type', 'category');

                document.querySelectorAll('#nestable .dd-list')[0].innerHTML += content; // 2. Append content to menu nestable
                category.checked = false; // 3. Set uncheck
            }
        });
    });
    </script>
@endpush
