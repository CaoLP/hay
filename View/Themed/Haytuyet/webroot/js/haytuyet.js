$(document).ready(function () {
    var wHeight = $('#block-11').height();
    if (typeof clipHot != 'undefined')
        $.ajax({
            url: clipHot,
            beforeSend: function () {
                $('#hot-loading').show();
            },
            success: function (data) {
                $('#hot-loading').hide();
                $('#hot-clip').html(data);
                wHeight = $('#block-11').height() - 600;
            }
        });
    if (typeof topView != 'undefined')
        $.ajax({
            url: topView,
            beforeSend: function () {
                $('#top-loading').show();
            },
            success: function (data) {
                $('#top-loading').hide();
                $('#top-like').html(data);
            }
        });
    if (typeof updateView != 'undefined')
        $.ajax({
            url: updateView + '/' + pid + '?url=' + link
        });
    $('.video-modal').on('shown.bs.modal', function () {
        $('#video-iframe').attr('src', videoLink);
        var comments = $(document).find('#fb-comment-box').html();
        $('#target-comments').html(comments);
    });
    $('.video-modal').on('hidden.bs.modal', function () {
        $('#video-iframe').attr('src', '');
    });
    if ($('#scrollable-ads').length != 0) {
        $(window).scroll(function () {
            if ($(window).width() > 990) {
                var scroll = $(window).scrollTop();
                if (scroll >= wHeight) {
                    $('#scrollable-ads').addClass('fixed-ads');
                    $('#scrollable-ads').css('width', $('#block-11').width());
                } else {
                    $('#scrollable-ads').removeClass('fixed-ads');
                    $('#scrollable-ads').css('width', '');
                }
            }
        });
    }
    if($('.play-btn').length !=0){
        fixCenter();
    }
    $(window).resize(function(){
        fixCenter();
    });
    function fixCenter(){
        var parentHeight = $('#view-video img').height();
        var parentWidth = $('#view-video img').width();
        var childHeight = $('.play-btn').height();
        var childWidth = $('.play-btn').width();
        var centerHeight = (parentHeight/2) - (childHeight/2);
        var centerWidth = (parentWidth/2) - (childWidth/2);
        $('.play-btn').css('top', centerHeight);
        $('.play-btn').css('left', centerWidth);
        $('.play-btn').show();
    }
});