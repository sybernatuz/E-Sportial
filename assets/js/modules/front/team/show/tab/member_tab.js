const Routing = require('../../../../common/router');

$(document).ready(function() {
    let teamId = $("#team-details").attr("data-team-id");
    $("#members-tab").on("click", function(event) {
        if(!$("#member-list").length) {
            $.ajax({
                url: Routing.generate("app_team_ajax_member_tab", {id: teamId}),
                success: function (data) {
                    $("#members").append(data);
                }
            });
        }
    });
});