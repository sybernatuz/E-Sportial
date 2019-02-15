$(function loadJobDetailOnClick() {
    let loading = $('#loading').data("prototype");
    $(document).on('click', '.job-item', function () {
        $.ajax({
                url: "/ajax/job/get/detail/" + $(this).attr('id'),
                beforeSend: function() {
                    let jobDetail = $('.job-detail');
                    jobDetail.find('.job-description').html(loading);
                    jobDetail.find(
                        '.job-detail-title, ' +
                        '.job-creator-name, ' +
                        '.job-location'
                    ).html('');
                    jobDetail.find('.circle').attr('src', '');
                },
                success: function(result) {
                    let jobDetail = $('.job-detail');
                    jobDetail.find('.job-description').html(result.description);
                    jobDetail.find('.job-detail-title').html(result.title);
                    let image = (result.user == null) ? result.organization.logoPath : result.user.avatar;
                    jobDetail.find('.circle').attr('src', image);
                    let name = (result.user == null) ? result.organization.name : result.user.username;
                    jobDetail.find('.job-creator-name').html(name);
                    jobDetail.find('.job-location').html(result.location);
                }
        });
    });
});
