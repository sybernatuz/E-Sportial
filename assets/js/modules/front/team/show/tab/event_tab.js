
$(document).ready(function() {
    let teamId = $("#team-details").attr("data-team-id");
    $("#event-tab").click(function() {
        if(!$("#event-list").length) {
            $.ajax({
                url: "/ajax/team/" + teamId + "/events",
                success: function (data) {
                    $("#events").append(data);
                }
            });
        }
    });

});