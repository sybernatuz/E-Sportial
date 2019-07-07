$('.join').click(function () {
    const loading = $('#loading').data("prototype");
    $.ajax({
        url: "/ajax/event/join/" + $(this).attr('id'),
        beforeSend: function () {
            $('.join').html(loading);
        },
        success: function (data) {
            if (data === true) {
                $('.join').html('<i class="material-icons">done</i>');
                location.reload();
            }
            else
                $('.join').html('<i class="material-icons">clear</i>');
        }
    });
});