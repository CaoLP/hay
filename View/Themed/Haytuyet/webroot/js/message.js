$(document).ready(function () {
    getCount();
    var running = false;
    $('#msg').popover({
        placement: 'bottom',
        html: true,
        content: function () {
            var div_id = "tmp-id-" + $.now();
            details_in_popup($(this).data('poload'), div_id);
            return '<div id="' + div_id + '"><div class="loading"><a class="btn spin" href="#">Loading</a></div></div>';
        }
    });
//    setInterval(function(){ getCount();}, 10000);
    function details_in_popup(link, div_id) {
        if (!running) {
            $.ajax({
                url: link,
                beforeSend: function () {
                    running = true;
                },
                success: function (response) {
                    $('.popover-content').html(response);
                    running = false;
                    getCount();
                }
            });
        }
    }
    function getCount(){
        $.ajax({
            url: countMSG,
            success: function (response) {
                $('#count-MSG').html(response);
            }
        });
    }
});
