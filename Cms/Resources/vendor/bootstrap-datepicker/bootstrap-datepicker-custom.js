function datepicker_init()
{
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true
    });
}

$(document).ajaxSuccess(function() {
    datepicker_init();
});

$(document).ready(function() {
    datepicker_init();
});
