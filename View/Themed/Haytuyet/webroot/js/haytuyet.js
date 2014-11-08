var players = new Array();
var counta=10;
var countb=10;
var countera;
var counterb;
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
    if (typeof postNew != 'undefined')
        $.ajax({
            url: postNew,
            beforeSend: function () {
                $('#new-loading').show();
            },
            success: function (data) {
                $('#new-loading').hide();
                $('#new-posts').html(data);
            }
        });
    if (typeof updateView != 'undefined')
        $.ajax({
            url: updateView + '/' + pid + '?url=' + link
        });
    $('.video-modal').on('shown.bs.modal', function () {
        players['video-iframe'].playVideo();
//        $('#video-iframe').attr('src', videoLink);
        var comments = $(document).find('#fb-comment-box').html();
        $('#target-comments').html(comments);
    });
    $('.video-modal').on('hidden.bs.modal', function () {
        players['video-iframe'].pauseVideo();
        counta = countb = 10;
        clearInterval(countera);
        clearInterval(counterb);
//        $('#video-iframe').attr('src', '');
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
    formatBodySize();
    fixCenterXSomeDiv('#player1','#video-share-a');
    fixCenterXSomeDiv('#video-iframe','#video-share-b');
    $(window).resize(function(){
        fixCenter();
        fixCenterXSomeDiv('#player1','#video-share-a');
        fixCenterXSomeDiv('#video-iframe','#video-share-b');
        formatBodySize();
    });

    $('.badge-facebook-share').on('click',function(){
        var url = $(this).data('share');
        FB.ui({
            method: 'feed',
            href: url
        }, function(response){});
    });
    $('.badge-twitter-share').on('click',function(){
        var url = $(this).data('share');
        var title = $(this).data('title');
        window.open('http://twitter.com/share?url='+url+';text='+title+';size=l&amp;count=none','_blank')
    });


    $('#video-play').on('click',function(){
        var state = $('#state');
        //var player = document.getElementById('video-iframe');

    });

    function fixCenter(){
        var parentHeight = $('#view-video').height();
        var parentWidth = $('#view-video').width();
        var childHeight = $('.play-btn').height();
        var childWidth = $('.play-btn').width();
        var centerHeight = (parentHeight/2) - (childHeight/2);
        var centerWidth = (parentWidth/2) - (childWidth/2);
        $('.play-btn').css('top', centerHeight);
        $('.play-btn').css('left', centerWidth);
        $('.play-btn').show();
    }

});
$(document).load(function(){
    //formatBodySize();
});
function formatBodySize(){
    $('.node-body').each(function(){
        var img = $(this).find('.img-content');
        var bodyWidth = $(this).width();
        var imgHeight = img.height();
        var bodyHeight = bodyWidth * 0.546099291;
        var imgMargin = bodyWidth * 0.09929078;
        img.css('margin-top',imgMargin);
        $(this).css('height',bodyHeight);
    });
}
function fixCenterXSomeDiv(parent,child){
    var parentWidth = $(parent).width();
    var childWidth = $(child).width();
    var centerWidth = (parentWidth/2) - (childWidth/2);
    $(child).css('left', centerWidth);
}

function onYouTubeIframeAPIReady() {
    $(".ytplayer").each(function() {
        var State = this.getAttribute('data-stateEvent');
        players[this.id]= new YT.Player(this.id, {
            events: {
                'onStateChange': State
            }
        });
    });
}

function State1(state) {
    fixCenterXSomeDiv('#player1','#video-share-a');
    switch (state.data){
        case 0:
            $('#video-share-a').show();
            $('#top-center-a').show();
            countera=setInterval(timera, 1000);
            break;
        case 1:
            $('#top-center-a').hide();
            $('#video-share-a').hide();
            counta = countb = 10;
            clearInterval(countera);
            clearInterval(counterb);
            break;
        case 2:
            $('#video-share-a').show();
            break;
    }
}
function State2(state) {
    fixCenterXSomeDiv('#video-iframe','#video-share-b');
    switch (state.data){
        case 0:
            $('#video-share-b').show();
            $('#top-center-b').show();
            counterb=setInterval(timerb, 1000);
            break;
        case 1:
            $('#top-center-b').hide();
            $('#video-share-b').hide();
            counta = countb = 10;
            clearInterval(countera);
            clearInterval(counterb);
            break;
        case 2:
            $('#video-share-b').show();
            break;
    }
}

function timera()
{
    counta=counta-1;
    if (counta <= 0)
    {
        clearInterval(countera);
        var nextPost = $('#bt-next').attr('href');
        window.open(nextPost,'_self');
        return;
    }
    document.getElementById("timer-a").innerHTML=counta ; // watch for spelling
}
function timerb()
{
    countb=countb-1;
    if (countb <= 0)
    {
        clearInterval(counterb);
        var nextPost = $('#bt-next').attr('href');
        window.open(nextPost,'_self');
        return;
    }
    document.getElementById("timer-b").innerHTML=countb ; // watch for spelling
}