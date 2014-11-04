/**
 * Nodes
 *
 * for NodesController
 */
var Nodes = {};

/**
 * functions to execute when document is ready
 *
 * only for NodesController
 *
 * @return void
 */
Nodes.documentReady = function () {
    Nodes.filter();
}

/**
 * Submits form for filtering Nodes
 *
 * @return void
 */
Nodes.filter = function () {
    $('.nodes div.actions a.filter').click(function () {
        $('.nodes div.filter').slideToggle();
        return false;
    });

    $('#FilterAddForm div.submit input').click(function () {
        $('#FilterAddForm').submit();
        return false;
    });

    $('#FilterAdminIndexForm').submit(function () {
        var filter = '';
        var q = '';

        // type
        if ($('#FilterType').val() != '') {
            filter += 'type:' + $('#FilterType').val() + ';';
        }

        // status
        if ($('#FilterStatus').val() != '') {
            filter += 'status:' + $('#FilterStatus').val() + ';';
        }

        // promoted
        if ($('#FilterPromote').val() != '') {
            filter += 'promote:' + $('#FilterPromote').val() + ';';
        }

        //query string
        if ($('#FilterQ').val() != '') {
            q = $('#FilterQ').val();
        }
        var loadUrl = Croogo.basePath + 'admin/nodes/nodes/index/';
        if (filter != '') {
            loadUrl += 'filter:' + filter;
        }
        if (q != '') {
            if (filter == '') {
                loadUrl += 'q:' + q;
            } else {
                loadUrl += '/q:' + q;
            }
        }

        window.location = loadUrl;
        return false;
    });
}

/**
 * Create slugs based on title field
 *
 * @return void
 */
Nodes.slug = function () {
    $("#NodeTitle").slug({
        slug: 'slug',
        hide: false
    });
}
Nodes.videoImage = function () {
    $('.youtube_clip').on('change', function () {
        var video_id = $(this).val();
        if ($(this).val().indexOf('watch?v=') > -1) {
            video_id = $(this).val().split('v=')[1];
            var ampersandPosition = video_id.indexOf('&');
            if (ampersandPosition != -1) {
                video_id = video_id.substring(0, ampersandPosition);
            }
        }
        if (video_id)
            Node.genImagecb(video_id);

        $(this).val(video_id);
    });
    $('#youtube_img').on('click', '.youtube_radio', function () {
            var val = $(this).data('value'); // retrieve the value
            $('.image').text(val);
    });

}
Node.genImagecb = function (id) {
    var box = $('#youtube_img');
    box.html('');
    var radiobox = '';
    radiobox += '<div class="radio">' +
        '<label>' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/0.jpg">Select</a>' +
        '<a href="http://img.youtube.com/vi/' + id + '/0.jpg" class="thickbox" rel="gallery"><img src="http://img.youtube.com/vi/' + id + '/0.jpg"></a>' +
        '</label>' +
        '</div>';
    radiobox += '<div class="radio">' +
        '<label>' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/1.jpg">Select</a>' +
        '<a href="http://img.youtube.com/vi/' + id + '/1.jpg" class="thickbox" rel="gallery"><img src="http://img.youtube.com/vi/' + id + '/1.jpg"></a>' +
        '</label>' +
        '</div>';
    radiobox += '<div class="radio">' +
        '<label>' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/2.jpg">Select</a>' +
        '<a href="http://img.youtube.com/vi/' + id + '/2.jpg" class="thickbox" rel="gallery"><img src="http://img.youtube.com/vi/' + id + '/2.jpg"></a>' +
        '</label>' +
        '</div>';
    radiobox += '<div class="radio">' +
        '<label>' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/3.jpg">Select</a>' +
        '<a href="http://img.youtube.com/vi/' + id + '/3.jpg" class="thickbox" rel="gallery"><img src="http://img.youtube.com/vi/' + id + '/3.jpg"></a>' +
        '</label>' +
        '</div>';
    radiobox += '<div class="radio">' +
        '<label>' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/default.jpg">Select</a>' +
        '<a href="http://img.youtube.com/vi/' + id + '/default.jpg" class="thickbox" rel="gallery"><img src="http://img.youtube.com/vi/' + id + '/default.jpg"></a>' +
        '</label>' +
        '</div>';
    radiobox += '<div class="radio">' +
        '<label>' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/hqdefault.jpg">Select</a>' +
        '<a href="http://img.youtube.com/vi/' + id + '/hqdefault.jpg" class="thickbox" rel="gallery"><img src="http://img.youtube.com/vi/' + id + '/hqdefault.jpg"></a>' +
        '</label>' +
        '</div>';
    radiobox += '<div class="radio">' +
        '<label>' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/mqdefault.jpg">Select</a>' +
        '<a href="http://img.youtube.com/vi/' + id + '/mqdefault.jpg" class="thickbox" rel="gallery"><img src="http://img.youtube.com/vi/' + id + '/mqdefault.jpg"></a>' +
        '</label>' +
        '</div>';
    radiobox += '<div class="radio">' +
        '<label>' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/sddefault.jpg">Select</a>' +
        '<a href="http://img.youtube.com/vi/' + id + '/sddefault.jpg" class="thickbox" rel="gallery"><img src="http://img.youtube.com/vi/' + id + '/sddefault.jpg"></a>' +
        '</label>' +
        '</div>';
    radiobox += '<div class="radio">' +
        '<label>' +
        '<a href="javascript:;;" class="youtube_radio" data-value="http://img.youtube.com/vi/' + id + '/maxresdefault.jpg">Select</a>' +
        '<a href="http://img.youtube.com/vi/' + id + '/maxresdefault.jpg" class="thickbox" rel="gallery"><img src="http://img.youtube.com/vi/' + id + '/maxresdefault.jpg"></a>' +
        '</label>' +
        '</div>';
    box.append(radiobox);
    tb_init('a.thickbox');

}

Nodes.confirmProcess = function (confirmMessage) {
    var action = $('#NodeAction :selected');
    if (action.val() == '') {
        confirmMessage = 'Please select an action';
    }
    if (confirmMessage == undefined) {
        confirmMessage = 'Are you sure?';
    } else {
        confirmMessage = confirmMessage.replace(/\%s/, action.text());
    }
    if (confirm(confirmMessage)) {
        action.get(0).form.submit();
    }
    return false;
}
/**
 * Change Type
 *
 * @return void
 */
Nodes.changetype = function () {
    $(".ajax-type").on('change', function () {
        var id = $(this).data('nodeid');
        var type = $(this).val();
        var url = '/admin/nodes/nodes/changeType/' + id + '/' + type;
        if (type != '')
            $.post(url, function (data) {

            });
    });
}
/**
 * document ready
 *
 * @return void
 */
$(document).ready(function () {
    if (Croogo.params.controller == 'nodes') {
        Nodes.documentReady();
        if (Croogo.params.action == 'admin_add') {
            Nodes.slug();
            Nodes.videoImage();
        }
        if (Croogo.params.action == 'admin_edit') {
            Nodes.videoImage();
            $('.youtube_clip').change();
        }
        Nodes.changetype();
    }

    Admin.toggleRowSelection('#NodeCheckAll');
});
