const Routing = require('../../../../common/router');

$(document).ready(function() {
    let teamId = $("#team-details").attr("data-team-id");
    renderMemberTab(teamId);
    $("#members-tab").on("click", function(event) {
        renderMemberTab(teamId);
    });

    $(document).on("click", ".card-member", function(event) {
        let userId = $(this).attr("data-user-id")
        $.ajax({
            url: Routing.generate("app_team_ajax_member_show", {id: userId}),
            success: function (data) {
                $("#member-details").replaceWith(data);
            }
        });
    });

    $(document).on("click", ".remove-user", function(event) {
        let userId = $(this).attr("data-user-id");
        let teamId = $(this).attr("data-team-id");
        $.ajax({
            url: Routing.generate("app_team_ajax_remove_member", {id: teamId, userId: userId}),
            success: function (data) {
                $("#member-list").replaceWith(data);
            }
        });
    });
});

function renderMemberTab(teamId) {
    if(!$("#member-list").length) {
        $.ajax({
            url: Routing.generate("app_team_ajax_member_tab", {id: teamId}),
            success: function (data) {
                $("#members").empty().append(data);
            }
        });
    }
}