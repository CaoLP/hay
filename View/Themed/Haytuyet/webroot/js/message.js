$(document).ready(function(){
    $.ajax({
        url: countMSG,
        success: function(response){
            $('#count-MSG').html(response);
        }
    });
        $('#msg').popover({
            placement: 'bottom',
            html: true,
            content: function(){
                var div_id =  "tmp-id-" + $.now();
                return details_in_popup($(this).data('poload'), div_id);
            }
        });

        function details_in_popup(link, div_id){
            $.ajax({
                url: link,
                success: function(response){
                    $('#'+div_id).html(response);
                }
            });
            return '<div id="'+ div_id +'"><div class="loading"><a class="btn spin" href="#">Loading</a></div></div>';
        }
});
