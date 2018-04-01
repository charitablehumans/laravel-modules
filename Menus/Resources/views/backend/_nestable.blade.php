<div class="box-body">
    <template class="hidden" id="menu_row_template">
        @component('menus::backend/_nestable_template', [
            'data_icon' => '',
            'data_id' => '$data_id',
            'data_permission' => '',
            'data_title' => '$data_title',
            'data_type' => '$data_type',
            'data_url' => '$data_url',
        ])

        @endcomponent
    </template>

    <div class="dd" id="nestable">
        <input name="termmetas[nestable]" type="hidden" value="{{ json_encode($term->getTermmetaNestable()) }}" />
        <ol class="dd-list">
            @php
            $nestable = $term->getTermmetaNestable();
            @endphp

            {!! $term->generateAsHtml($nestable) !!}
        </ol>
    </div>
</div>

<!-- Modal -->
@section('content_modal')
    <form id="menu_modal_form">
        <div aria-labelledby="menu_modal_label" class="modal fade" id="menu_modal" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="menu_modal_label"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="menu_modal_icon">@lang('cms::cms.icon')</label>
                            <input class="form-control" id="menu_modal_icon" type="text" />
                        </div>
                        <div class="form-group menu_modal_url_row">
                            <label for="menu_modal_url">@lang('validation.attributes.url')</label>
                            <input class="form-control" id="menu_modal_url" type="text" />
                        </div>
                        <div class="form-group">
                            <label>@lang('cms::cms.permission')</label>
                            <select class="form-control select2" data-allow-clear="true" data-placeholder="" data-width="100%" id="menu_modal_permission">
                                <option></option>
                                @foreach ($term->getPermissionIdOptions() as $permissionId => $permissionName)
                                    <option value="{{ $permissionId }}">{{ $permissionName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal" type="button">@lang('cms::cms.close')</button>
                        <button class="btn btn-success" type="submit">@lang('cms::cms.save')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
    $('#menu_form').submit(function () {
        var menu_nestable = $('#nestable').nestable('serialize');
        $('input[name="termmetas[nestable]"]').val(JSON.stringify(menu_nestable));
    });

    $('#nestable').nestable();
    var menu_edit;

    $(document).on('click', '.menu_edit', function () {
        var dd_item = $(this).closest('.dd-item');
        menu_edit = $(this);

        $('#menu_modal_label').html(dd_item.attr('data-title'));
        $('#menu_modal_icon').val(dd_item.attr('data-icon'));
        dd_item.attr('data-type') == 'custom_link' ? $('.menu_modal_url_row').show() : $('.menu_modal_url_row').hide();
        $('#menu_modal_url').val(dd_item.attr('data-url'));
        $('#menu_modal_permission').val(dd_item.attr('data-permission')).trigger('change');
    });

    $(document).on('click', '.menu_trash', function () { $(this).closest('.dd-item').remove(); });

    $('#menu_modal_form').submit(function (e) {
        e.preventDefault();
        var dd_item = menu_edit.closest('.dd-item');
        dd_item.attr('data-icon', $('#menu_modal_icon').val());
        dd_item.attr('data-url', $('#menu_modal_url').val());
        dd_item.attr('data-permission', $('#menu_modal_permission').val());
        $('#menu_modal').modal('hide');
    });
    </script>
@endpush
