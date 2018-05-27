$(document).on('change', 'select.provinces', function () {
    $.ajax({
        url: document.querySelector('meta[name="api.geocodes.regencies.index"]').content,
        headers: {
            'Access-Token': document.querySelector('meta[name=access_token]').content
        },
        data: { parent_id: $(this).val() },
        success: function (response) {
            $('select.regencies option:not(:first)').remove();
            $.each(response.data, function(key, regency) {
                $('select.regencies').append('<option value="'+regency.id+'">'+regency.name+'</option>');
            });

            $('select.regencies_rajaongkir option:not(:first)').remove();
            $.each(response.data, function(key, regency) {
                $('select.regencies_rajaongkir').append('<option value="'+regency.id+'">'+regency.rajaongkir_id+'</option>');
            });
        },
    });
});

$(document).on('click', '.table_row_checkbox', function () {
    var checked = true;
    $('.table_row_checkbox').each(function () {
        var self = $(this);
        if (self.is(':checked')) { self.closest('tr').addClass('info'); }
        else { self.closest('tr').removeClass('info'); checked = false; }
        $('.table_row_checkbox_all').prop('checked', checked);
    });
});

$(document).on('click', '.table_row_checkbox_all', function () {
    var self = $(this);
    if (self.is(':checked')) { self.closest('table').find('tbody tr').addClass('info').find('.table_row_checkbox').prop('checked', true); }
    else { self.closest('table').find('tbody tr').removeClass('info').find('.table_row_checkbox').prop('checked', false); }
});

$(document).on('click', '.template_close', function () { $(this).closest('li').remove(); });
