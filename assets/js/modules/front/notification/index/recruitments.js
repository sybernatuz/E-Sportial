const Routing = require('../../../common/router');

$(document).ready(function() {
    $("#accept-recruitment").on("click", function(event) {
        let recruitmentId = $(this).attr("data-recruitment-id");
        let organizationId = $(this).attr("data-organization-id");
        $.ajax({
            url: Routing.generate("app_notification_ajax_accept_recruitment", {id: recruitmentId, organizationId: organizationId}),
            success: function (data) {
                if(data)
                    $("#recruitment-notifications").replaceWith(data);


            }
        });
    });

    $("#refuse-recruitment").on("click", function(event) {
        let recruitmentId = $(this).attr("data-recruitment-id");
        $.ajax({
            url: Routing.generate("app_notification_ajax_refuse_recruitment", {id: recruitmentId}),
            success: function (data) {
                if(data)
                    $("#recruitment-notifications").replaceWith(data);
            }
        });
    });
});