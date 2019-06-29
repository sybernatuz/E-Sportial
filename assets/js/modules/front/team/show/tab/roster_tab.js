const Routing = require('../../../../common/router');

$(document).ready(function() {
    let userId = $("#user-details").attr("data-user-id");
    // get tab content on click
    $("#games-tab").on("click", function(event) {
        if(!$("#user-profile-games").length) {
            $.ajax({
                url: Routing.generate("app_user_ajax_game_tab", {id: userId}),
                success: function (data) {
                    $("#games").append(data);
                    $('select').formSelect();
                }
            });
        }
    });

    $(document).on("submit", "#add-game-form" ,function(event) {
        event.preventDefault();
        $.ajax({
            url: Routing.generate("app_user_ajax_game_tab", {id: userId}),
            method: 'POST',
            data: $("#add-game-form").serialize(),
            success: function (data) {
                $("#user-profile-games").empty().append(data);
            }
        });
    });

});