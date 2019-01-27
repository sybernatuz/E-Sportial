$(function changePage() {
    $(document).on('click', '.page', function () {
        $.ajax({
            url: "/ajax/job/search",
            data: {
                title: $('#search-bar-title').val(),
                location: $('#search-bar-location').val(),
                type: $('.disabled').attr('id'),
                page : this.id
            },
            success: function (result) {
                $('.last-jobs').replaceWith(result);
            }
        })
    });
});