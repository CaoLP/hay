var running = false;
$(document).ready(function(){
    genImagecb(youtube_id);
    $(document).on('click','.youtube_radio',function(){
        if(!running)
        $.ajax({
            url:updateImg,
            data: {image:$(this).data('value')},
            beforeSend : function(){
                running = true;
            },
            success:function(data){
                running = false;
                if(data==1){
                    $('#cur_img').attr('src',$(this).data('value'));
                }
            }
        });
    });
})
function genImagecb(id) {
    var box = $('#youtube_img');
    box.html('');
    var radiobox = '';
    radiobox += '<div class="y-img">' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/0.jpg">' +
        '<img height="90" src="http://img.youtube.com/vi/' + id + '/0.jpg">' +
        '</a>' +
        '</div>';
    radiobox += '<div class="y-img">' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/default.jpg">' +
        '<img height="90" src="http://img.youtube.com/vi/' + id + '/default.jpg">' +
        '</a>' +
        '</div>';
    radiobox += '<div class="y-img">' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/hqdefault.jpg">' +
        '<img height="90" src="http://img.youtube.com/vi/' + id + '/hqdefault.jpg">' +
        '</a>' +
        '</div>';
    radiobox += '<div class="y-img">' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/mqdefault.jpg">' +
        '<img height="90" src="http://img.youtube.com/vi/' + id + '/mqdefault.jpg">' +
        '</a>'+
        '</div>';
    radiobox += '<div class="y-img">' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/sddefault.jpg">' +
        '<img height="90" src="http://img.youtube.com/vi/' + id + '/sddefault.jpg">' +
        '</label>' +
        '</div>';
    radiobox += '<div class="y-img">' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/maxresdefault.jpg">' +
        '<img height="90" src="http://img.youtube.com/vi/' + id + '/maxresdefault.jpg">' +
        '</a>' +
        '</div>';
    box.append(radiobox);
}