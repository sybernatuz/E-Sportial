$(function search() {
    $('.search').change(function () {
        $.ajax({
            url: "/ajax/game/search",
            data: {
                name: $('#search-bar-name').val(),
            },
            success: function (result) {
                $('.games-list').replaceWith(result);
            }
        })
    });
});