const loading = $('#loading').data("prototype");

$(function loadJobDetailOnClick() {
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
                    jobDetail.find('.apply').css('display', 'none');
                    jobDetail.find('#avatar').css('display', 'none');
                },
                success: function(data) {
                    let jobDetail = $('.job-detail');
                    jobDetail.find('.job-description').html(data.description);
                    jobDetail.find('.job-detail-title').html(data.title);
                    let image = (data.user == null) ? data.organization.logoPath : data.user.avatar;
                    jobDetail.find('#avatar').attr('src', image);
                    jobDetail.find('#avatar').css('display', '');
                    let name = (data.user == null) ? data.organization.name : data.user.username;
                    jobDetail.find('.job-creator-name').html(name);
                    jobDetail.find('.job-location').html(data.location);
                    jobDetail.find('.apply').attr('id', data.id);
                    let labelApplyButton = data.applied ? '<i class="material-icons">done</i>' : 'apply';
                    jobDetail.find('.apply').html(labelApplyButton);
                    jobDetail.find('.apply').css('display', '');
                }
        });
    });
});


