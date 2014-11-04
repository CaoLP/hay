$(document).ready(function(){
    $.ajax({
        url:clipHot,
        beforeSend:function(){
            $('#hot-loading').show();
        },
        success: function(data){
            $('#hot-loading').hide();
            $('#hot-clip').html(data);
        }
    });
    $.ajax({
        url:topView,
        beforeSend:function(){
            $('#top-loading').show();
        },
        success: function(data){
            $('#top-loading').hide();
            $('#top-like').html(data);
        }
    });
});