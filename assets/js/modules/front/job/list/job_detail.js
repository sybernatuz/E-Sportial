$(function applyToJob() {
    const loading = $('#loading').data("prototype");
    $(document).on('click', '.apply', function () {
        $.ajax({
            url: "/ajax/job/apply/" + $(this).attr('id'),
            beforeSend: function () {
                $('.job-detail').find('.apply').html(loading);
            },
            success: function (data) {
                if (data === true)
                    $('.job-detail').find('.apply').html('<i class="material-icons">done</i>');
                else
                    $('.job-detail').find('.apply').html('<i class="material-icons">clear</i>');
            }
        });
    });
});