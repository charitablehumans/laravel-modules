$.pjax.defaults.timeout = 5000;

$(document).on('submit', 'form[data-pjax]', function(event) {
    event.preventDefault();
    $.pjax.submit(event, '.pjax-container', {
        scrollTo: false
    });
});

$(document).pjax('a[data-pjax]', '.pjax-container', {
    scrollTo: false
});
