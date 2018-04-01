<div class="panel panel-default">
    <div class="panel-heading" id="headingCustomLinks" role="tab">
        <h4 class="panel-title">
            <a aria-controls="collapseCustomLinks" aria-expanded="true" data-parent="#accordion" data-toggle="collapse" href="#collapseCustomLinks" role="button">@lang('cms::cms.custom_links')</a>
        </h4>
    </div>
    <div aria-labelledby="headingCustomLinks" class="panel-collapse collapse" id="collapseCustomLinks" role="tabpanel">
        <div class="panel-body">
            <div class="form-group">
                <select class="form-control select2" data-allow-clear="true" data-placeholder="" data-width="100%" id="custom_link">
                    <option></option>
                    @foreach ($term->getCustomLinkIdOptions() as $customLinkId => $customLinkTitle)
                        <option value="{{ $customLinkId }}">{{ $customLinkTitle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-default pull-right" id="custom_link_add" type="button">@lang('cms::cms.add_to_menu')</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    $('#custom_link_add').click(function () {
        var custom_link = document.getElementById('custom_link');

        if (custom_link.value) { // 1. If has value
            var content = document.getElementById('menu_row_template').innerHTML
                .replace('$data_id', custom_link.value)
                .replace('$data_title', custom_link.options[custom_link.selectedIndex].text)
                .replace('$data_title', custom_link.options[custom_link.selectedIndex].text)
                .replace('$data_type', 'custom_link')
                .replace('$data_type', 'custom_link')
                .replace('$data_url', '');

            document.querySelectorAll('#nestable .dd-list')[0].innerHTML += content; // 2. Append content to menu nestable
            $(custom_link).val(null).trigger('change'); // 3. Set null
        }
    });
    </script>
@endpush
