const Routing = require('../../../../common/router');

$(document).ready(function() {
    let userId = $("#user-details").attr("data-user-id");
    // get tab content on click
    $("#stats-tab").on("click", function(event) {
        $.ajax({
            url: Routing.generate("app_user_ajax_stat_tab", {id: userId}),
            success: function (data) {
                $("#stats").empty().append(data);
                $('select').formSelect();
                getGameSelectedStats(userId);
            }
        });
    });

    $(document).on('change', "#select_game_user_game" ,function (event) {
       getGameSelectedStats(userId);
    });
});



function getGameSelectedStats(userId) {
    let gameIdSelected = $("#select_game_user_game").val();
    $.ajax({
        url: Routing.generate("app_user_ajax_game_stats", {userId: userId, gameId: gameIdSelected}),
        success: function (data) {
            console.log(data);
            $("#game-stats").empty().append(data);
        },
        error: function(data) {
            appendErrorMessage(data.responseJSON.error.message);
        }
    });
}

function appendErrorMessage(message) {
    $("#game-stats").empty().append(
        '<div class="row">' +
            '<div class="col s12 m12 l12 xl12 center">' +
                '<p>' + message  + '</p>' +
            '</div>' +
        '</div>'
    );
}