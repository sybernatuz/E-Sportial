$(function loadJobDetailOnClick() {
    let loading = $('#loading').data("prototype");
    $(document).on('click', '.job-item', function () {
        $.ajax({
                url: "/ajax/job/get/detail/" + $(this).attr('id'),
                beforeSend: function() {
                    $('.job-detail').html(loading);
                },
                success: function(result) {
                    $('.job-detail').replaceWith(result);
                }
        });
    });
});
