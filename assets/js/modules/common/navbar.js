$(document).ready(function(){
    $(".dropdown-trigger").dropdown();
});


$(document).ready(function newMessagesNotification(){
    $.ajax({
        url:"/ajax/message/get/new-messages",
        success: function(data) {
            let newMessagesNumber = data.newMessages.length;
            let label = 'Messages <span class="new badge purple">' + newMessagesNumber + '</span>';
            $('#messages').html(label);
        }
    });
});