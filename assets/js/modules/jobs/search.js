$(function loadChangeCategory() {
    $('.job-category').click(function () {
        let type = $(this).attr('id');
        setDisable($(this).attr('id'));
        sendAjax(type);
    });
});

function setDisable(type) {
    $('.disabled').removeClass('disabled');
    $('#' + type).addClass('disabled');
}

$(function search() {
    $('#search-bar-title, #search-bar-location').change(function () {
        let type = $('.disabled').attr('id');
        sendAjax(type);
    });
});

function sendAjax(type) {
    $.ajax({
        url: "/ajax/job/search",
        data: {
            title: $('#search-bar-title').val(),
            location: $('#search-bar-location').val(),
            type: type
        },
        success: function (result) {
            $('.last-jobs').replaceWith(result);
        }
    });
}

