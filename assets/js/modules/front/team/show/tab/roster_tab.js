const Routing = require('../../../../common/router');

$(document).ready(function() {
    let teamId = $("#team-details").attr("data-team-id");
    // get tab content on click
    $("#rosters-tab").on("click", function(event) {
        if(!$("#rosters-list").length) {
            $.ajax({
                url: Routing.generate("app_team_ajax_roster_tab", {id: teamId}),
                success: function (data) {
                    $("#rosters").empty().append(data);
                    $('select').formSelect();
                }
            });
        }
    });

    $(document).on("click", ".remove-member-from-roster", function (event) {
        let userId = $(this).attr("data-user-id");
        let rosterId = $(this).attr("data-roster-id");
        $.ajax({
            url: Routing.generate("app_team_ajax_remove_roster_member", {id: rosterId, userId: userId}),
            method: 'POST',
            success: function (data) {
                $("#roster-" + rosterId).replaceWith(data);
            }
        });
    });

    $(document).on("click", ".remove-roster", function (event) {
        let rosterId = $(this).attr("data-roster-id");
        $.ajax({
            url: Routing.generate("app_team_ajax_remove_roster", {id: rosterId}),
            method: 'POST',
            success: function (data) {
                $("#roster-cards").replaceWith(data);
            }
        });
    });

    $(document).on("submit", "#create-roster-form", function (event) {
        event.preventDefault();
        $.ajax({
            url: Routing.generate("app_team_ajax_roster_tab", {id: teamId}),
            method: 'POST',
            data: $("#create-roster-form").serialize(),
            success: function (data) {
                $("#rosters").empty().append(data);
                $("#create_roster_name").attr('value', '');
                $('select').formSelect();
            }
        });
        return false;
    });


    $(document).on("submit", "#add-user-roster-form", function (event) {
        event.preventDefault();
        $.ajax({
            url: Routing.generate("app_team_ajax_roster_tab", {id: teamId}),
            method: 'POST',
            data: $("#add-user-roster-form").serialize(),
            success: function (data) {
                $("#rosters").empty().append(data);
                $("#add_user_to_roster_username").attr('value', '');
                $('select').formSelect();
            }
        });
        return false;
    });
});