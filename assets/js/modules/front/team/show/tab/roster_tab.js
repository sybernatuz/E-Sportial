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

    $(document).on("submit", "#add-user-roster-form", function (event) {
        event.preventDefault();
            alert('add user');
        return false;
    });

    $(document).on("submit", "#create-roster-form", function (event) {
        event.preventDefault();
        alert('create roster');
        return false;
    });
});