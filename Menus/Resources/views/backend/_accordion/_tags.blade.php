<div class="panel panel-default">
    <div class="panel-heading" id="headingTags" role="tab">
        <h4 class="panel-title">
            <a aria-controls="collapseTags" aria-expanded="false" data-parent="#accordion" data-toggle="collapse" href="#collapseTags" role="button">@lang('cms::cms.tags')</a>
        </h4>
    </div>
    <div aria-labelledby="headingTags" class="panel-collapse collapse" id="collapseTags" role="tabpanel">
        <div class="panel-body">
            <div class="form-group">
                <select class="form-control select2" data-allow-clear="true" data-placeholder="" data-width="100%" id="tag">
                    <option></option>
                    @foreach ($term->getTagIdNameOptions() as $tagId => $tagName)
                        <option value="{{ $tagId }}">{{ $tagName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-default btn-xs pull-right" id="tag_add" type="button">@lang('cms::cms.add_to_menu')</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    $('#tag_add').click(function () {
        var tag = document.getElementById('tag');

        if (tag.value) { // 1. If has value
            var content = document.getElementById('menu_row_template').innerHTML
                .replace('$data_id', tag.value)
                .replace('$data_title', tag.options[tag.selectedIndex].text)
                .replace('$data_title', tag.options[tag.selectedIndex].text)
                .replace('$data_type', 'tag')
                .replace('$data_type', 'tag');

            document.querySelectorAll('#nestable .dd-list')[0].innerHTML += content; // 2. Append content to menu nestable
            $(tag).val(null).trigger('change'); // 3. Set null
        }
    });
    </script>
@endpush
