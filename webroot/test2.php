<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript">
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
                if (evt.origin.indexOf('haytuyet.com')) {
                    if(evt.data == 'ok') alert('okela');
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
</head>
<body>
<iframe src="testpage.php"></iframe>
</body>
</html>