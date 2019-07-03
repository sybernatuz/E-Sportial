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