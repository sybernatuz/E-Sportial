$(document).ready(function(){
    $('select').formSelect();
});

$(function search() {
    let loading = $('#loading').data("prototype");
    $('.search').change(function () {
        $.ajax({
            url: "/ajax/event/search",
            data: {
                name: $('#search-bar-name').val(),
                location: $('#search-bar-location').val(),
                type: $('#events-type').val()
            },
            beforeSend: function() {
                $('.last-events').html(loading);
            },
            success: function (result) {
                $('.last-events').replaceWith(result);
            }
        })
    });
});