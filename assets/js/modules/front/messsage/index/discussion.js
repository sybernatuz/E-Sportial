$(document).ready(function () {
    $('ul.list li:first').addClass("active");
    scrollChatToTheBottom();
});

$(document).on('click', '.send-button', function () {
    let id = $('.chat-header').attr('id');
    insertMessage(id);
    scrollChatToTheBottom();
});

$(document).on('click', '.refresh', function () {
    let id = $('.chat-header').attr('id');
    refreshChat(id);
    scrollChatToTheBottom();
});

function refreshChat(id) {
    const loading = $('#loading').data("prototype");
    $.ajax({
        url: "/ajax/message/get/discussion/" + id,
        beforeSend: function() {
            let chat = $('.chat');
            chat.find('.chat-history').html(loading);
        },
        success: function(data) {
            let chat = $('.chat');
            chat.replaceWith(data);
        }
    });
}

function insertMessage(id) {
    let content = $('#message-to-send').val();
    $.ajax({
        url: "/ajax/message/insert",
        method: "POST",
        data:{
            content: content,
            discussion: id
        },
        success: function() {
            refreshChat(id);
        }
    });
}

function scrollChatToTheBottom() {
    let chatHistory = $('.chat-history');
    chatHistory.animate({
        scrollTop: chatHistory.get(0).scrollHeight
    }, 2000);
}