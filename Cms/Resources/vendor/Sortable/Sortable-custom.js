function sortable_init()
{
    var sortables = document.querySelectorAll('.sortable-list-group');
    Array.prototype.forEach.call(sortables, function(element, index) {
        Sortable.create(element);
    });
}

$(document).ajaxSuccess(function() {
    sortable_init();
});

$(document).ready(function() {
    sortable_init();
});
