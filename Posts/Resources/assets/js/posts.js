$('[name="postmetas[template]"]').on('change', function() {
    if (url = $(this).attr('data-url-ajax'))
    {
        $.ajax({
            data: { template: $(this).val() },
            url: url,
            success: function(html) {
                $('#postmetas_template_div').html(html);
            }
        });
    }
});
