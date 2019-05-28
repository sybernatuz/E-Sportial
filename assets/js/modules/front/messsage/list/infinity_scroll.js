$(document).scroll(function() {
    if (!isScrolledIntoView($('.preloader-wrapper')))
        return;

    let temp = $(this);
    if(temp.data('requestMessagePaginationRunning'))
        return;

    let nextPage = parseInt($('#pagination').val()) + 1;
    temp.data('requestMessagePaginationRunning', true);
    $.ajax({
        type: 'GET',
        url: '/ajax/message/pagination',
        data: { page: nextPage },
        success: function(data) {
            if($.trim(data)){
                $('#messages-list').append(data);
                $('#page').val(nextPage);
            } else {
                $(".preloader-wrapper").remove();
            }
            temp.data('requestMessagePaginationRunning', false);
        }
    });
});

function isScrolledIntoView(elem){
    if (elem === undefined || $(elem).offset() === undefined)
        return false;

    let $elem = $(elem);
    let $window = $(window);

    let docViewTop = $window.scrollTop();
    let docViewBottom = docViewTop + $window.height();

    let elemTop = $elem.offset().top;
    let elemBottom = elemTop + $elem.height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}