$(document).ready(function(){
    $('select').formSelect();
});

$(function search() {
    $('.search').change(function () {
        $.ajax({
            url: "/ajax/event/search",
            data: {
                name: $('#search-bar-name').val(),
                location: $('#search-bar-location').val(),
                type: $('#events-type').val()
            },
            success: function (result) {
                $('.last-events').replaceWith(result);
            }
        })
    });
});