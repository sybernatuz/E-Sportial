const Routing = require('../../modules/common/router');

$(document).ready(function(){
    $(document).on('click', "#subscribe", function () {
        let userId = $(this).attr('data-user-id');
        $.ajax({
            url: Routing.generate("app_user_ajax_subscribe", {id: userId}),
            success: function (data) {
                let jsonData = JSON.parse(data);
                if (jsonData) {
                    renderUnsubscribeButton(userId);
                    refreshCounter(jsonData.counter);
                    refreshFollowersList(jsonData.followersHtml);
                }
            },
        });
    });

    $(document).on('click', "#unsubscribe", function () {
        let userId = $(this).attr('data-user-id');
        $.ajax({
            url: Routing.generate("app_user_ajax_unsubscribe" , {id: userId}),
            success: function (data) {
                let jsonData = JSON.parse(data);
                if (jsonData) {
                    renderSubscribeButton(userId);
                    refreshCounter(jsonData.counter);
                    refreshFollowersList(jsonData.followersHtml);
                }
            }
        });
    });
});

function renderSubscribeButton(userId) {
    $("#unsubscribe").replaceWith(
        "<a id='subscribe' data-user-id='"+ userId +"' class='waves-effect waves-light btn'><i class='material-icons left'>done</i>Subscribe</a>"
    );
}

function renderUnsubscribeButton(userId) {
    $("#subscribe").replaceWith(
        "<a id='unsubscribe' data-user-id='"+ userId +"' class='waves-effect waves-light btn'><i class='material-icons left'>close</i>unsubscribe</a>"
    );
}

function refreshCounter(counter) {
    $("#subscription-counter").text(counter);
}

function refreshFollowersList(followersHtml) {
    $("#followers-list").replaceWith(followersHtml);
    $('.modal').modal();
}
