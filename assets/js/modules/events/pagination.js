$(function changePage() {
    $(document).on('click', '.page', function () {
        sendAjax(this, this.id);
    });
});

$(function plusOnePage() {
    $(document).on('click', '.plus-page', function () {
        let page = parseInt($('.page.active').attr('id')) + 1;
        sendAjax(this, page);
    });
});

$(function minusOnePage() {
    $(document).on('click', '.minus-page', function () {
        let page = parseInt($('.page.active').attr('id')) -1;
        sendAjax(this, page);
    });
});

function sendAjax(event, page) {
    if ($(event).hasClass('disabled'))
        return;

    $.ajax({
        url: "/ajax/event/search",
        data: {
            name: $('#search-bar-name').val(),
            location: $('#search-bar-location').val(),
            type: $('#events-type').val(),
            page : page
        },
        success: function (result) {
            $('.last-events').replaceWith(result);
        }
    })
}
