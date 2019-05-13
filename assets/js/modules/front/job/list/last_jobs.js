$(function loadJobDetail() {

    $(document).on('click', '.job-item', function () {
        let id = $(this).attr('id');
        getJobDetail(id);
    });

    $(document).ready(function () {
        let id = $(".last-jobs li").first().attr('id');
        getJobDetail(id);
    });

    function getJobDetail(id) {
        const loading = $('#loading').data("prototype");
        $.ajax({
            url: "/ajax/job/get/detail/" + id,
            beforeSend: function() {
                let jobDetail = $('.job-detail');
                jobDetail.find('.job-description').html(loading);
                jobDetail.find(
                    '.job-detail-title, ' +
                    '.job-creator-name, ' +
                    '.job-location'
                ).html('');
                jobDetail.find('.apply').css('display', 'none');
                jobDetail.find('#avatar').css('display', 'none');
            },
            success: function(data) {
                let jobDetail = $('.job-detail');
                jobDetail.html(data);
            }
        });
    }
});


