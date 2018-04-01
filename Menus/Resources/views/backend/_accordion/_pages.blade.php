<div class="panel panel-default">
    <div class="panel-heading" id="headingPages" role="tab">
        <h4 class="panel-title">
            <a aria-controls="collapsePages" aria-expanded="true" data-parent="#accordion" data-toggle="collapse" href="#collapsePages" role="button">@lang('cms::cms.pages')</a>
        </h4>
    </div>
    <div aria-labelledby="headingPages" class="panel-collapse collapse" id="collapsePages" role="tabpanel">
        <div class="panel-body">
            <div class="form-group">
                <select class="form-control select2" data-allow-clear="true" data-placeholder="" data-width="100%" id="page">
                    <option></option>
                    @foreach ($term->getPageIdOptions() as $pageId => $pageTitle)
                        <option value="{{ $pageId }}">{{ $pageTitle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-default pull-right" id="page_add" type="button">@lang('cms::cms.add_to_menu')</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    $('#page_add').click(function () {
        var page = document.getElementById('page');

        if (page.value) { // 1. If has value
            var content = document.getElementById('menu_row_template').innerHTML
                .replace('$data_id', page.value)
                .replace('$data_title', page.options[page.selectedIndex].text)
                .replace('$data_title', page.options[page.selectedIndex].text)
                .replace('$data_type', 'page')
                .replace('$data_type', 'page');

            document.querySelectorAll('#nestable .dd-list')[0].innerHTML += content; // 2. Append content to menu nestable
            $(page).val(null).trigger('change'); // 3. Set null
        }
    });
    </script>
@endpush
