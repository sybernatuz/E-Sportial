$(document).ready(function(){
    $(document).on('click', "#subscribe", function () {
        let userId = $(this).attr('data-user-id');
        $.ajax({
            url: "/ajax/user/" + userId + "/subscribe",
            success: function (data) {
                let jsonData = JSON.parse(data);
                if (jsonData.state === true) {
                    $("#subscribe").replaceWith(
                        "<a id='unsubscribe' data-user-id='"+ userId +"' class='waves-effect waves-light btn'><i class='material-icons left'>clear</i>Unsubscribe</a>"
                    );
                    $("#subscription-counter").text(jsonData.counter);
                }
            }
        });
    });

    $(document).on('click', "#unsubscribe", function () {
        let userId = $(this).attr('data-user-id');
        $.ajax({
            url: "/ajax/user/" + userId + "/unsubscribe",
            success: function (data) {
                let jsonData = JSON.parse(data);
                if (jsonData.state === true) {
                    $("#unsubscribe").replaceWith(
                        "<a id='subscribe' data-user-id='"+ userId +"' class='waves-effect waves-light btn'><i class='material-icons left'>done</i>Subscribe</a>"
                    );
                    $("#subscription-counter").text(jsonData.counter);
                }
            }

        });
    });
});
