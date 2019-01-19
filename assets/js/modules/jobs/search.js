$(function loadChangeCategory() {
    $('.job-category').click(function () {
        setDisable($(this).attr('id'));
        $.ajax({
            url: "/ajax/job/search",
            data: {
                title: $('#search-bar-title').val(),
                location: $('#search-bar-location').val(),
                type: $(this).attr('id')
            },
            success: function (result) {
                $('.last-jobs').replaceWith(result);
            }
        })
    });
});

function setDisable(id) {
    $('#' + id).addClass('disabled');
    let otherButtonId = (id === 'work') ? 'coaching' : 'work';
    $('#' + otherButtonId).removeClass('disabled');
}

$(function search() {
    $('#search-bar-title, #search-bar-location').change(function () {
        $.ajax({
            url: "/ajax/job/search",
            data: {
                title: $('#search-bar-title').val(),
                location: $('#search-bar-location').val(),
                type: $('.disabled').attr('id')
            },
            success: function (result) {
                $('.last-jobs').replaceWith(result);
            }
        })
    });
});

