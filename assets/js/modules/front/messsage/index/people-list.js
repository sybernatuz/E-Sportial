let List = require('list.js');
let searchFilter = {
    options: { valueNames: ['name'] },
    init: function() {
        let userList = new List('people-list', this.options);
        let noItems = $('<li id="no-items-found">No items found</li>');

        userList.on('updated', function(list) {
            if (list.matchingItems.length === 0) {
                $(list.list).append(noItems);
            } else {
                noItems.detach();
            }
        });
    }
};
searchFilter.init();

$(document).on('click', '.transmitter', function () {
    let id = $(this).attr('id');
    changeActiveDiscussion(id);
    refreshChat(id);

});

$(document).on('click', '.add', function () {
    const loading = $('#loading').data("prototype");
    $.ajax({
        url: "/ajax/message/get/new-form",
        beforeSend: function() {
            let chat = $('.chat');
            chat.find('.chat-history').html(loading);
        },
        success: function(data) {
            let chat = $('.chat');
            chat.replaceWith(data);
        }
    });
    changeActiveDiscussion(id);
    refreshChat(id);

});

function changeActiveDiscussion(id) {
    $('li.active').removeClass("active");
    $('#' + id).addClass("active");
}

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
            scrollChatToTheBottom();
        }
    });
}

function scrollChatToTheBottom() {
    let chatHistory = $('.chat-history');
    chatHistory.animate({
        scrollTop: chatHistory.get(0).scrollHeight
    }, 2000);
}

