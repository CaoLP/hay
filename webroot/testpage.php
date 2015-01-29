<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script language="javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript">
        function po() {
            parent.postMessage("ok", "*");
        }
        function SendMessage() {
            var win = document.getElementById("ifrmChild").contentWindow;
            if (win == null || !window['postMessage'])
                console.log("oh crap");
            else
                win.postMessage("hello", "*");
        }
        function ReceiveMessage(evt) {
            var message;
            if (false) {
                message = 'You ("' + evt.origin + '") are not worthy';
            }
            else {
//            if(evt.origin == 'http://kenhlmht.com'){
                if (evt.data.indexOf('resize.iframe&width=450&height=363') > -1) {
                    po();
                }
            }
            if (message) {
                var ta = document.getElementById("taRecvMessage");
                if (ta == null)
                    console.log(message);
                else
                    document.getElementById("taRecvMessage").innerHTML = message;
            }
            //evt.source.postMessage("thanks, got it ;)", event.origin);
        } // End Function ReceiveMessage

        if (!window['postMessage'])
            console.log("oh crap");
        else {
            if (window.addEventListener) {
                window.addEventListener("message", ReceiveMessage, false);
            }
            else {
                window.attachEvent("onmessage", ReceiveMessage);
            }
        }
    </script>
    <script type="text/javascript">
        $(function () {
            fix_center();
            $(window).resize(function() {
                fix_center();
            });
        });
        function fix_center(){
            var w = $(window).width();
            var h = $(window).height();
            var i_w = $('#bb').width();
            var i_h = $('#bb').height();

            var i2_w = $('#aa').width();
            var i2_h = $('#aa').height();

            var i_x = 0;
            var i_y = 0;
            var i2_x = 0;
            var i2_y = 0;

            i_x = w/2 - i_w/2;
            i_y = h/2 - i_h/2;

            i2_x = w/2 - i2_w/2;
            i2_y = h/2 - i2_h/2;

            $('#bb').css({
                left: i_x,
                top: i_y
            });
            $('#aa').css({
                left: i2_x,
                top: i2_y
            });
        }
    </script>
</head>
<body>
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: '462179947218302',
            xfbml: true,
            version: 'v2.2'
        });
        FB.Event.subscribe('edge.create',
            function (response) {
                alert('You liked the URL: ' + response);
            }
        );
        var finished_rendering = function () {

        }

// In your onload handler
        FB.Event.subscribe('xfbml.render', finished_rendering);
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<div id="aa" style="position: absolute;top:42%;left: 44%;width: 68px;height: 68px; z-index: 10; pointer-events: none"><img src="/img/playbtn.png" alt="" style="cursor: pointer;width: 68px;"></div>
<div id="bb" style="width: 50px; height: 20px;position: absolute; left: 46%;top: 43%;">
    <div style="width: 22px; height: 20px; position: absolute;z-index: 10"></div>
    <div class="fb-like" data-href="https://www.facebook.com/haytuyetcom" data-layout="button" data-action="like"
         data-show-faces="false" data-share="false"></div>
</div>
</body>
</html>