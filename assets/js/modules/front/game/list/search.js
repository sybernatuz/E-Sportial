$(function search() {
    let loading = $('#loading').data("prototype");
    $('.search').change(function () {
        $.ajax({
            url: "/ajax/game/search",
            data: {
                name: $('#search-bar-name').val(),
            },
            beforeSend: function() {
                $('.games-list').html(loading);
            },
            success: function (result) {
                $('.games-list').replaceWith(result);
            }
        })
    });
});